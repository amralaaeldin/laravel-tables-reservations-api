<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class TableController extends Controller
{
    public function index()
    {
        //
    }

    public function indexAvailable(Request $request)
    {
        $request->validate([
            'capacity' => 'required|integer|min:1',
            'from' => 'required|date_format:Y-m-d H:i:s',
            'to' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $table = new Table();
        return $table->scopeAvailable($request->capacity, $request->from, $request->to)
            ->select('id', 'capacity')->get();
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Table $table)
    {
        //
    }

    public function update(Request $request, Table $table)
    {
        //
    }

    public function destroy(Table $table)
    {
        //
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'from' => 'required|date_format:Y-m-d H:i:s',
            'to' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $isAvailable = Table::where('id', $request->table_id)
            ->first()
            ->isAvailable($request->from, $request->to);

        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable ? 'Table is available' : 'Table is not available',
        ]);
    }
}
