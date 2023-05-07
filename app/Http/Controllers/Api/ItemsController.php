<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Http\traits\responseTrait;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{
    use responseTrait;

    public function index()
    {
        try {
            return $this->response(200, 'data retrieved', ItemResource::collection(Item::all()));
        } catch (\Exception $e) {
            return $this->response(500, $e->getMessage(), $e->getTrace(), true);
        }
    }

    public function show($id)
    {
        try {
            $item = Item::find($id);
            if (!$item) {
                return $this->response(400, 'Item Not found', [], true);
            }
            return $this->response(200, 'data retrieved', new ItemResource($item));
        } catch (\Exception $e) {
            return $this->response(500, $e->getMessage(), $e->getTrace(), true);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'name' => 'required|unique:items,name',
                'price' => 'required|numeric',
                'seller' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->response(400, 'item not saved', $validator->errors(), true);
            }
            $item = Item::firstOrCreate($request->input());
            return $this->response(200, 'data retrieved', new ItemResource($item));

        } catch (\Exception $e) {
            return $this->response(500, $e->getMessage(), $e->getTrace(), true);
        }
    }

    public function statistics()
    {
        try {
            $begin_month = new \DateTime('first day of this month');
            $begin_month->setTime(0, 0, 0);
            $current_month = Item::with([])->whereDate('created_at', '>=', $begin_month)
                ->whereDate('created_at', '<=', (new \DateTime()))->sum('price');
            $average = Item::all()->sum('price') / Item::all()->count();
            return $this->response(200, 'data retrieved',
                ['current_month_total_prices' => $current_month, 'average_price_of_all_items' => $average]);

        } catch (\Exception $e) {
            return $this->response(500, $e->getMessage(), $e->getTrace(), true);
        }
    }
}
