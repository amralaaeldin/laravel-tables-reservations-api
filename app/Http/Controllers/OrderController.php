<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Order;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::paginate(15));
    }

    public function store(Request $request)
    {
        $reservation = Reservation::find($request->reservation_id);

        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found'], 404);
        }

        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'waiter_id' => 'required|exists:users,id',
            'paid' => 'required|numeric|min:0',
            'meal_id' => 'required|exists:meals,id',
            'quantity' => ['required', 'integer', 'min:1', Rule::max(Meal::find($request->meal_id)->quantityAvailable($reservation->from))],
        ]);

        $order = $reservation->order;
        if (!$order) {
            $order = Order::create([
                'reservation_id' => $reservation->id,
                'waiter_id' => $request->waiter_id,
                'paid' => $request->paid,
            ]);
        }

        $order->details()->create([
            'meal_id' => $request->meal_id,
            'quantity' => $request->quantity,
            'amount_to_pay' => $request->quantity * Meal::find($request->meal_id)->priceAfterDiscount(),
        ]);

        return response()->json($order, 201);
    }

    public function show(Order $order)
    {
        return response()->json($order->with('details')->find($order->id));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'waiter_id' => 'exists:users,id',
            'paid' => 'numeric|min:0',
        ]);

        $order->update($request->all());

        return response()->json($order);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json(null, 204);
    }
}
