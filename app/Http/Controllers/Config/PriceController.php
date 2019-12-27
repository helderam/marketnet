<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Price;

class PriceController extends Controller
{
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

        $selected_id = session('selected_id');
        if (empty($selected_id)) return redirect()->route('home');

        // Campos de filtragem
        $name = simpleFilter('name', 'Nome');
        $sku = simpleFilter('sku', 'SKU');
        $active = simpleFilter('active', 'Ativo');

        // Seleciona os registros, filtra e ordena
        $registros = DB::table('prices')
            ->leftJoin('products', 'products.id', '=', 'prices.product_id')
            ->where('store_id', $selected_id)
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'products.sku as product_sku',
                'prices.id',
                'prices.price',
                'prices.quantity_packing',
                'prices.packing',
                'prices.created_at'
            )
            ->orderBy($column, $order);
        #->toSql(); dd($registros);

        if ($name) $registros->whereRaw('lower(products.name) like ?', strtolower("%{$name}%")); # Desconsidera case
        if ($sku) $registros->where('products.sku', 'like', "%{$sku}%"); 
        if ($active) $registros->where('prices.active', $active); 
        $prices = $registros->paginate($records);

        // Retorna para a view
        return view('config.prices', compact('prices'));
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
        $price = Price::Find($id);

        // Retorna para a view
        return view('config.prices-edit', compact('price'));
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
        $request->validate(Price::$rules);

        $price = Price::find($id);
        $update = $price->Update($request->all());

        // Verifica se alterou com sucesso
        if ($update)
            return redirect()
                ->route('prices.index')
                ->with('success', 'Registro alterado com sucesso!');

        // Verifica se houve erro e passa uma session flash success (sessão temporária)
        return redirect()
            ->back()
            ->with('error', 'Falha ao alterar');
    }

}
