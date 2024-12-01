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
        //
    }

    public function show(Meal $meal)
    {
        //
    }

    public function update(Request $request, Meal $meal)
    {
        //
    }

    public function destroy(Meal $meal)
    {
        //
    }
}
