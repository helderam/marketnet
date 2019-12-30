<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Price;
use App\Store;

class PriceController extends Controller
{
     /**
     * Inclui registros para estoques - DESATIVEI - NÂO FAZ SENTIDO - Tem opção de incluir
    public function __construct()
    {
        $stores = Store::all();
        // Para cada loja, verifica se falta registro.
        foreach ($stores as $store) {
            $products = DB::table('products')
            ->select('products.id', 'products.name')
            ->leftJoin('prices', function ($join) use ($store) {
                $join->on('products.id', '=', 'prices.product_id')->where('prices.store_id', '=', $store->id);
            })
            ->whereNull('prices.store_id')
            ->get();

            // Busca todos produtos e insere na tabela de associação os que estão faltando
            foreach ($products as $product) {
                $stock = new Price();
                $stock->product_id = $product->id;
                $stock->store_id = $store->id;
                #$stock->active = 'N';
                $stock->price = 0;
                $stock->quantity_packing = 0;
                $stock->packing = 'CX';
                $stock->save();
            }
        }
    }
    */

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

        // Campos de filtragem
        $name = simpleFilter('name', 'Nome');
        $sku = simpleFilter('sku', 'SKU');
        $active = simpleFilter('active', 'Ativo');
        $store_id = simpleFilter('store_id', 'Loja');

        // Seleciona os registros, filtra e ordena
        $registros = DB::table('prices')
            ->leftJoin('products', 'products.id', '=', 'prices.product_id')
            ->leftJoin('stores', 'stores.id', '=', 'prices.store_id')
            ->whereIn('store_id', $store_ids)
            ->select(
                'stores.id as store_id',
                'stores.name as store_name',
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
        if ($store_id) $registros->where('prices.store_id', $store_id); 
        $prices = $registros->paginate($records);

        // Retorna para a view
        return view('config.prices', compact('prices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $price = new Price();

        // Retorna para a view
        return view('config.prices-edit', compact('price'));
    }

    /**
     * Price a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Price::$rules);

        $price = new Price();
        $data = $request->all();
        $insert = $price->Create($data);

        // Verifica se inseriu com sucesso
        if ($insert)
            return redirect()
                ->route('prices.index')
                ->with('success', 'Registro inserido com sucesso!');

        // Verifica se houve erro e passa uma session flash success (sessão temporária)
        return redirect()
            ->back()
            ->with('error', 'Falha ao inserir');
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
