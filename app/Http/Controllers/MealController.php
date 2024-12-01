<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index(Request $request)
    {
        $meals = $request->has('date') ?
            Meal::all()->filter(function ($meal) use ($request) {
                $quantity = $meal->quantityAvailable($request->date);
                $meal->quantity = $quantity;
                return $quantity > 0;
            })
            : Meal::all();

        return response()->json($meals);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0|max:100',
            'quantity' => 'required|integer|min:0',
        ]);

        $meal = Meal::create($request->all());

        return response()->json($meal, 201);
    }

    public function show(Meal $meal)
    {
        return response()->json($meal);
    }

    public function update(Request $request, Meal $meal)
    {
        $request->validate([
            'name' => 'string',
            'price' => 'numeric|min:0',
            'discount' => 'numeric|min:0|max:100',
            'quantity' => 'integer|min:0',
        ]);

        $meal->update($request->all());

        return response()->json($meal);
    }

    public function destroy(Meal $meal)
    {
        $meal->delete();

        return response()->json(null, 204);
    }
}
