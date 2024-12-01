<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderDetailController extends Controller
{
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'meal_id' => 'required|exists:meals,id',
            'quantity' => ['required', 'integer', 'min:1', Rule::max(Meal::find($request->meal_id)->quantityAvailable($order->reservation->from))],
        ]);

        $order->details()->create([
            'meal_id' => $request->meal_id,
            'quantity' => $request->quantity,
            'amount_to_pay' => $request->quantity * $order->meal->priceAfterDiscount(),
        ]);

        return response()->json($order, 201);
    }

    public function update(Request $request, OrderDetail $orderDetail)
    {
        $request->validate([
            'quantity' => ['integer', 'min:1', Rule::max(Meal::find($orderDetail->meal_id)->quantityAvailable($orderDetail->order->reservation->from))],
        ]);

        $orderDetail->update([
            'quantity' => $request->quantity,
            'amount_to_pay' => $request->quantity * $orderDetail->order->meal->priceAfterDiscount(),
        ]);

        return response()->json($orderDetail);
    }

    public function destroy(OrderDetail $orderDetail)
    {
        $orderDetail->delete();

        return response()->json(null, 204);
    }
}
