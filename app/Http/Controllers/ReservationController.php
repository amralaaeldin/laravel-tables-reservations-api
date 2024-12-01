<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Table;
use App\Models\WaitingList;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'customer_id' => 'required|exists:users,id',
            'from' => 'required|date_format:Y-m-d H:i',
            'to' => 'required|date_format:Y-m-d H:i|after:from',
        ]);

        $table = Table::find($request->table_id);
        if (!$table->isAvailable($request->from, $request->to)) {
            WaitingList::create([
                'table_id' => $request->table_id,
                'customer_id' => $request->customer_id,
                'from' => $request->from,
                'to' => $request->to,
            ]);

            return response()->json(['message' => 'Table not available, Added to waiting list'], 400);
        }

        $reservation = Reservation::create([
            'table_id' => $request->table_id,
            'customer_id' => $request->customer_id,
            'from' => $request->from,
            'to' => $request->to,
        ]);

        return response()->json($reservation, 201);
    }

    public function show(Reservation $reservation)
    {
        //
    }

    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    public function destroy(Reservation $reservation)
    {
        //
    }

    public function checkout(Reservation $reservation)
    {
        $total = $reservation->order->totalBeforeDiscount();
        $totalAfterDiscount = $reservation->order->totalAmountToPay();
        $due = $reservation->order->totalAmountDue();

        $checkout = [
            'table' => $reservation->table->id,
            'customer' => $reservation->customer->name,
            'total' => $total,
            'discount' => $total - $totalAfterDiscount,
            'total_after_discount' => $totalAfterDiscount,
            'paid' => $totalAfterDiscount - $due,
            'due' => $due,
            'from' => $reservation->from,
            'to' => $reservation->to,
            'meals' => $reservation->order->details->map(function ($order) {
                return [
                    'meal' => $order->meal->name,
                    'quantity' => $order->quantity,
                    'price' => $order->meal->price,
                ];
            }),
        ];

        return response()->json($checkout, 200);
    }
}
