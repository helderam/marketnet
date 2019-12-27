<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        // Se não existir cria a categoria RAIZ
        $category = Category::find(1);
        if (empty($category)) {
            $category = new Category();
            $category->id = 1;
            $category->name = "RAIZ";
            $category->description = "CATEGORIA RAIZ CRIADA AUTOMATICAMENTE";
            $category->level = 0;
            $category->category_id = 0;
            $category->save();
        }
    }

    public function index()
    {
        #var_dump(session('back'));
        // Obtem quantidade de registros, coluna de ordenação e ordem 
        list($records, $column, $order) = simpleParameters('id');

        $category_id = session('selected_id') ?? 0;

        // Campos de filtragem
        $name = simpleFilter('name', 'Nome');

        // Seleciona os registros, filtra e ordena
        $registros = Category::orderBy($column, $order);
        $registros->where('category_id', $category_id); #->toSql(); dd($registros);
        if ($name) $registros->whereRaw('lower(name) like ?', strtolower("%{$name}%")); # Desconsidera case
        $categories = $registros->paginate($records);

        // Retorna para a view
        return view('config.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();

        // Retorna para a view
        return view('config.categories-edit', compact('category'));
    }

    /**
     * Category a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Category::$rules);

        $category = new Category();
        $data = $request->all();
        $data['category_id'] = session('selected_id');
        $insert = $category->Create($data);

        // Verifica se inseriu com sucesso
        if ($insert)
            return redirect()
                ->route('categories.index')
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
        // Obtem Category
        $category = Category::Find($id);
        #dd($category->level);
        session(['selected_id' => $category->id]);
        session(['selected_name' => $category->name]);
        session(['selected_level' => $category->level]);
        if ($category->category_id) {
            session(['back' => '/categories/' . $category->category_id]);
        } else {
            session(['back' => null]);
        }

        #$x = route('categories.show', ['id' => 1]);        dd($x);
        // Redireciona para controlador de ZipCodes por Loja
        return redirect()
            ->route('categories.index')
            ->with('success', "Categoria $category->name selecionada");
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
        $category = Category::Find($id);

        // Retorna para a view
        return view('config.categories-edit', compact('category'));
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
        $request->validate(Category::$rules);

        $category = Category::find($id);
        $update = $category->Update($request->all());

        // Verifica se alterou com sucesso
        if ($update)
            return redirect()
                ->route('categories.index')
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
