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
        $this->middleware('auth')->except(['index']);
    }

    public function index()
    {
        $rows = Row::with(['owner'])->get();

        return $rows;
    }

    public function store(StoreRow $request)
    {
        $row = new Row();
        $row->user_id = Auth::user()->id;
        $row->date_time = $request->get('date_time');
        $row->boat_name = $request->get('boat_name');
        $row->on_the_water = $request->get('on_the_water');
        $row->off_the_water = $request->get('off_the_water');
        $row->lower_limit_area = $request->get('lower_limit_area');
        $row->upper_limit_area = $request->get('upper_limit_area');
        $row->others = $request->get('others');

        $row->save();
    }


}
