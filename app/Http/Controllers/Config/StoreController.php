<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Store;
use App\Stock;
use App\Product;

class StoreController extends Controller
{
    public function index()
    {
        #var_dump(session()->all());
        // Obtem quantidade de registros, coluna de ordenação e ordem 
        list($records, $column, $order) = simpleParameters('id');

        // Campos de filtragem
        $name = simpleFilter('name', 'Nome');

        // Seleciona os registros, filtra e ordena
        $registros = Store::orderBy($column, $order);
        if ($name) $registros->whereRaw('lower(name) like ?', strtolower("%{$name}%")); # Desconsidera case
        $stores = $registros->paginate($records);

        // Retorna para a view
        return view('config.stores', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $store = new Store();

        // Retorna para a view
        return view('config.stores-edit', compact('store'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Store::$rules);

        $store = new Store();
        $insert = $store->Create($request->all());

        // Verifica se inseriu com sucesso
        if ($insert)
            return redirect()
                ->route('stores.index')
                ->with('success', 'Registro inserido com sucesso!');

        // Verifica se houve erro e passa uma session flash success (sessão temporária)
        return redirect()
            ->back()
            ->with('error', 'Falha ao inserir');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Obtem Store
        $store = Store::Find($id);

        // Redireciona para controlador de ZipCodes por Loja
        return redirect()
            ->route('zipcodes.index')
            ->with('route_back', route('stores.index'))
            ->with('id', $store->id)
            ->with('name', $store->name)
            ->with('success', "Loja $store->name selecionada");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function select($id)
    {
        // Obtem Loja
        $store = Store::Find($id);
        // Obtem todos registros já associados ao loja/estoque
        $registros = Stock::where('store_id', $store->id)->get();
        // Cria array com os produtos ja associados
        $stocks = [];
        foreach ($registros as $registro) {
            $stocks[$registro->product_id] = $registro;
        }
        // Busca todos produtos e insere na tabela de associação os que estão faltando
        $products = Product::all();
        foreach ($products as $product) {
            if (empty($stocks[$product->id])) {
                $stock = new Stock();
                $stock->product_id = $product->id;
                $stock->store_id = $id;
                $stock->active = 'N';
                $stock->stock = 0;
                $stock->save();
            }
        }
        // Redireciona para controlador de produtos por grupo
        return redirect()
            ->route('stocks.index')
            ->with('route_back', route('stores.index')) # botão de retorno para lojas
            ->with('id', $store->id)
            ->with('name', $store->name)
            ->with('success', "Grupo $store->name selecionado");
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
        $store = Store::Find($id);

        // Retorna para a view
        return view('config.stores-edit', compact('store'));
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
        $request->validate(Store::$rules);

        $store = Store::find($id);
        $update = $store->Update($request->all());

        // Verifica se alterou com sucesso
        if ($update)
            return redirect()
                ->route('stores.index')
                ->with('success', 'Registro alterado com sucesso!');

        // Verifica se houve erro e passa uma session flash success (sessão temporária)
        return redirect()
            ->back()
            ->with('error', 'Falha ao alterar');
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
