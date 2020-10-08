<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Row;
use App\Http\Requests\StoreRow;

class RowController extends Controller
{
    public function __construct()
    {
        // 認証が必要
        $this->middleware('auth');
    }

    public function index()
    {
        return Row::all();

    }

    public function store(StoreRow $request)
    {
        $row = new Row();
        $row->boat_name = $request->get('boat_name');
        $row->date_time = $request->get('date_time');
        $row->user_id = Auth::user()->id;

        $row->save();


    }


}
