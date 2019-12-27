<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #var_dump(session()->all());
        // Obtem quantidade de registros, coluna de ordenação e ordem 
        list($records, $column, $order) = simpleParameters('id');

        // Campos de filtragem
        $name = simpleFilter('name', 'Nome');

        // Seleciona os registros, filtra e ordena
        $registros = Product::orderBy($column, $order);
        if ($name) $registros->whereRaw('lower(name) like ?', strtolower("%{$name}%")); # Desconsidera case
        $products = $registros->paginate($records);

        // Retorna para a view
        return view('config.products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product();

        // Retorna para a view
        return view('config.products-edit', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        #dd($request->all());
        $request->validate(Product::$rules);

        // Valida se e-mail ja existe (único)
        if (Product::where('sku', $request->sku)->count())
            throw \Illuminate\Validation\ValidationException::withMessages(['sku' => ['SKU já existente']]);

        $product = new Product();
        $insert = $product->Create($request->all());

        // Verifica se inseriu com sucesso
        if ($insert)
            return redirect()
                ->route('products.index')
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
        $product = Product::Find($id);

        // Retorna para a view
        return view('config.products-edit', compact('product'));
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
        $request->validate(Product::$rules);

        // Valida se rota ja existe (único)
        if (DB::table('products')
            ->where('sku', $request->sku)
            ->where('id', '!=', $id)->count()
        )
            throw \Illuminate\Validation\ValidationException::withMessages(['sku' => ['SKU já existente']]);

        $product = Product::find($id);
        $update = $product->Update($request->all());

        // Verifica se alterou com sucesso
        if ($update)
            return redirect()
                ->route('products.index')
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
