<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\DataTables\CashiersalesDataTable;
use App\Models\Transaction;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Drawer;

class CashierController extends Controller
{

    public function create(CashiersalesDataTable $dataTable)
    {
        $today = now()->format('Y-m-d');
        $today_cashier_sales = Transaction::where('user_id', Auth::user()->id)
            ->whereDate('created_at', $today)
            ->sum('grandtotal');
        //  return view('cashier.cashier',compact(['today_cashier_sales']));
        return $dataTable->render('cashier.cashier', compact(['today_cashier_sales']));
    }

    public function show($id)
    {}

    //load cashier today sales datatable
    public function todaycashiersalesdata()
    {
        $today = now()->format('Y-m-d');
        $today_transactions = Transaction::whereDate('created_at', $today)
            ->where('user_id', Auth::user()->id);

        return Datatables::eloquent($today_transactions)
            ->addIndexColumn()
            ->editColumn('created_at', function ($x) {
                return [
                    'display' => e($x->created_at->format('d/m/Y g:i A')),
                    'timestamp' => \Carbon\Carbon::parse($x->created_at->timestamp),
                ];
            })
            ->editColumn('discount', function ($j) {return app('currency') . "" . number_format($j->discount, 2);})
            ->editColumn('subtotal', function ($j) {return app('currency') . "" . number_format($j->subtotal, 2);})
            ->editColumn('grandtotal', function ($j) {return app('currency') . "" . number_format($j->grandtotal, 2);})
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
            })
            ->toJson();

    }

    //load cashier sales history for the datatable
    public function saleshistory(Request $request)
    {
        $total_sales  = Transaction::select(DB::raw('SUM(grandtotal) as total_sales'))
                            ->where('user_id',Auth::user()->id)
                            ->get();

        $cashier_history = Transaction::select('payment_mode', DB::raw('SUM(grandtotal) as total_amount'))
                            ->where('user_id',Auth::user()->id)
                            ->groupBy('payment_mode')
                            ->get();
        return view('partials.cashierhistory', compact(['cashier_history','total_sales']));
    }

    //load cashiers history for datatable

    public function cashierhistorydata(Request $request)
    {

        $data = Transaction::where('user_id', Auth::user()->id); //->get();

        return Datatables::eloquent($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($x) {
                return [
                    'display' => e($x->created_at->format('d/m/Y g:i A')),
                    'timestamp' => \Carbon\Carbon::parse($x->created_at->timestamp),
                ];
            })
            ->editColumn('discount', function ($j) {return app('currency') . "" . number_format($j->discount, 2);})
            ->editColumn('subtotal', function ($j) {return app('currency') . "" . number_format($j->subtotal, 2);})
            ->editColumn('grandtotal', function ($j) {return app('currency') . "" . number_format($j->grandtotal, 2);})
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
            })
            ->toJson();
        //  ->make(true);

    }

// close cashier drawer
    public function close_drawer(Request $request)
    {
        $drawer_data = $request->all();
        $drawer = new Drawer();
        $drawer->user_id = Auth::user()->id;
        $drawer->opening_balance = $drawer_data['opening_balance'];
        $drawer->cash_float = $drawer_data['cash_float'];
        $drawer->today_sales = str_replace(',','',$drawer_data['todaysales_amount']);
        $drawer->expected_amount = str_replace(',','',$drawer_data['expected_drawer_amount']);
        $drawer->counted_amount = $drawer_data['counted_drawer_amount'];
        $drawer->remark = $drawer_data['remark'];
        $drawer->cash_balance = str_replace(',','',$drawer_data['cash_balance']);

        $status = $drawer->save();

        if(!$status){
            return response()->json(['status'=>'error','message'=>'Unexpected error occured. Please try again.'],500);
        }
        return response()->json(['status'=>'success','message'=>'Drawer closed successfully.'],200);
    }

    //fetch drawer histrory data for datatable

    public function drawerhistorydata(){
        $drawer_data = Drawer::where('user_id',Auth::user()->id)
                                ->orderBy('created_at','desc');

        return DataTables::eloquent($drawer_data)
                ->editColumn('created_at', function ($x) {
                     return [
                            'display' => e($x->created_at->format('d/m/Y g:i A')),
                            'timestamp' => \Carbon\Carbon::parse($x->created_at->timestamp),
                         ];
                })
                 ->editColumn('opening_balance', function ($j) {return app('currency') . "" . number_format($j->opening_balance, 2);})
                 ->editColumn('cash_float', function ($j) {return app('currency') . "" . number_format($j->cash_float, 2);})
                 ->editColumn('today_sales', function ($j) {return app('currency') . "" . number_format($j->today_sales, 2);})
                 ->editColumn('expected_amount', function ($j) {return app('currency') . "" . number_format($j->expected_amount, 2);})
                 ->editColumn('counted_amount', function ($j) {return app('currency') . "" . number_format($j->counted_amount, 2);})
                 ->editColumn('cash_balance', function ($j) {return app('currency') . "" . number_format($j->cash_balance, 2);})
                 ->toJson();
    }

    public function test()
    {
        return view('cashier.cashiertest');
    }

}
