<?php

namespace App\Http\Controllers;

use App\Models\WaitingList;
use Illuminate\Http\Request;

class WaitingListController extends Controller
{
    public function index()
    {
        if (request()->has('table_id')) {
            return WaitingList::where('table_id', request('table_id'))->get();
        }

        if (request()->has('customer_id')) {
            return WaitingList::where('customer_id', request('customer_id'))->get();
        }

        return WaitingList::paginate(15);
    }

    public function show(WaitingList $waitingList)
    {
        return response()->json($waitingList->with('table', 'customer')->find($waitingList->id));
    }
}
