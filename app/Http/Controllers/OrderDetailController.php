<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function store(Request $request, Order $order)
    {
        $meal = Meal::find($request->meal_id);

        if (!$meal) {
            return response()->json(['error' => 'Meal not found'], 404);
        }

        $request->validate([
            'meal_id' => 'required|exists:meals,id',
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $meal->quantityAvailable($order->reservation->from)],
        ]);

        $orderDetail = $order->details()->create([
            'meal_id' => $request->meal_id,
            'quantity' => $request->quantity,
            'amount_to_pay' => $request->quantity * $meal->priceAfterDiscount(),
        ]);

        return response()->json($orderDetail, 201);
    }

    public function update(Request $request, OrderDetail $orderDetail)
    {
        $meal = Meal::find($orderDetail->meal_id);

        if (!$meal) {
            return response()->json(['error' => 'Meal not found'], 404);
        }

        $request->validate([
            'quantity' => ['integer', 'min:1', "max:" . $meal->quantityAvailable($orderDetail->order->reservation->from)],
        ]);

        $orderDetail->update([
            'quantity' => $request->quantity,
            'amount_to_pay' => $request->quantity * $meal->priceAfterDiscount(),
        ]);

        return response()->json($orderDetail);
    }

    public function destroy(OrderDetail $orderDetail)
    {
        $orderDetail->delete();

        return response()->json(null, 204);
    }
}
