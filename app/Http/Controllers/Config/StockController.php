<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Stock;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #var_dump(session('back'));
        // Obtem quantidade de registros, coluna de ordenação e ordem 
        list($records, $column, $order) = simpleParameters('id');

        $selected_id = session('selected_id');
        if (empty($selected_id)) return redirect()->route('home');

        // Campos de filtragem
        $name = simpleFilter('name', 'Nome');
        $sku = simpleFilter('sku', 'SKU');

        // Seleciona os registros, filtra e ordena
        $registros = DB::table('stocks')
            ->leftJoin('products', 'products.id', '=', 'stocks.product_id')
            ->where('store_id', $selected_id)
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'products.sku as product_sku',
                'stocks.id',
                'stocks.stock',
                'stocks.active',
                'stocks.created_at'
            )
            ->orderBy($column, $order);
        #->toSql(); dd($registros);

        if ($name) $registros->whereRaw('lower(products.name) like ?', strtolower("%{$name}%")); # Desconsidera case
        if ($sku) $registros->where('products.sku', 'like', "%{$sku}%"); # Desconsidera case
        $stocks = $registros->paginate($records);

        // Retorna para a view
        return view('config.stocks', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
