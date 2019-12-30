<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Stock;
use App\Store;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Inclui registros para estoques
     */
    public function __construct()
    {
        $stores = Store::all();
        // Para cada loja, verifica se falta registro.
        foreach ($stores as $store) {
            $products = DB::table('products')
            ->select('products.id', 'products.name')
            ->leftJoin('stocks', function ($join) use ($store) {
                $join->on('products.id', '=', 'stocks.product_id')->where('stocks.store_id', '=', $store->id);
            })
            ->whereNull('stocks.store_id')
            ->get();

            // Busca todos produtos e insere na tabela de associação os que estão faltando
            foreach ($products as $product) {
                $stock = new Stock();
                $stock->product_id = $product->id;
                $stock->store_id = $store->id;
                $stock->active = 'N';
                $stock->stock = 0;
                $stock->save();
            }
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #var_dump(session('descriptions'));
        // Obtem quantidade de registros, coluna de ordenação e ordem 
        list($records, $column, $order) = simpleParameters('id');

        // Lojas autorizadas
        $store_ids = session('store_ids');
        if (empty($store_ids)) return redirect()->route('home');
        #dd($store_ids);
        #DB::enableQueryLog();
        #$x = \App\Store::orderBy('name')->whereIn('id', $store_ids)->pluck('id', 'name'); # session('store_ids'));
        #dd(DB::getQueryLog());

        // Campos de filtragem
        $name = simpleFilter('name', 'Nome');
        $sku = simpleFilter('sku', 'SKU');
        $active = simpleFilter('active', 'Ativo');
        $store_id = simpleFilter('store_id', 'Loja');

        // Seleciona os registros, filtra e ordena
        $registros = DB::table('stocks')
            ->leftJoin('products', 'products.id', '=', 'stocks.product_id')
            ->leftJoin('stores', 'stores.id', '=', 'stocks.store_id')
            ->whereIn('store_id', $store_ids)
            ->select(
                'stores.id as store_id',
                'stores.name as store_name',
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
        if ($sku) $registros->where('products.sku', 'like', "%{$sku}%");
        if ($active) $registros->where('stocks.active', $active);
        if ($store_id) $registros->where('stocks.store_id', $store_id);
        $stocks = $registros->paginate($records);

        // Retorna para a view
        return view('config.stocks', compact('stocks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // Obtem usuario
        $stock = Stock::Find($id);

        // Retorna para a view
        return view('config.stocks-edit', compact('stock'));
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
        $request->validate(Stock::$rules);

        $stock = Stock::find($id);
        $update = $stock->Update($request->all());

        // Verifica se alterou com sucesso
        if ($update)
            return redirect()
                ->route('stocks.index')
                ->with('success', 'Registro alterado com sucesso!');

        // Verifica se houve erro e passa uma session flash success (sessão temporária)
        return redirect()
            ->back()
            ->with('error', 'Falha ao alterar');
    }




    /**
     * Change usar status Produto Ativo ou Inativo
     *
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        $stock = Stock::FindOrFail($id);
        #dd($stock);
        if ($stock) {
            $stock->active = $stock->active == 'S' ? 'N' : 'S';
            $stock->save();
            return redirect()->route('stocks.index')->with('message', 'Produto ajustado!');
        }
    }
}
