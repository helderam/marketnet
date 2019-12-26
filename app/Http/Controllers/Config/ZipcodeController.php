<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Zipcode;
use Illuminate\Support\Facades\DB;

class ZipcodeController extends Controller
{
    private $selected_id;

    function __construct()
    {
    #    // Recupera o loja selecionado na sessão
    #    $this->selected_id = session('selected_id');
    #    dd($this->selected_id);    NAO FUNCIONA SESSAO AQUI
    #    if (empty($this->selected_id)) return redirect()->route('home');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtem quantidade de registros, coluna de ordenação e ordem 
        list($records, $column, $order) = simpleParameters('active', 'desc');

        // Recupera o loja selecionado na sessão
        $selected_id = session('selected_id');
        #var_dump(session()->all()); dd($selected_id);
        if (empty($selected_id)) return redirect()->route('home');

        // Campos de filtragem
        $name = simpleFilter('name', 'Nome');

        // Seleciona os registros, filtra e ordena
        $registros = DB::table('zipcodes')
            ->where('zipcodes.store_id', $selected_id)
            ->orderBy($column, $order);
            #->toSql(); dd($registros); 
        if ($name) $registros->whereRaw('lower(zipcodes.name) like ?', strtolower("%{$name}%")); # Desconsidera case
        $zipcodes = $registros->paginate($records);

        // Retorna para a view
        return view('config.zipcodes', compact('zipcodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zipcode = new Zipcode();

        // Retorna para a view
        return view('config.zipcodes-edit', compact('zipcode'));
    }

    /**
     * Zipcode a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valida dados do formulario
        $request->validate(Zipcode::$rules);

        // Recupera o loja selecionado na sessão
        $selected_id = session('selected_id');
        if (empty($selected_id)) return redirect()->route('home');

        $registro = $request->all();
        $registro['store_id'] = $selected_id;
        #dd($registro);

        $zipcode = new Zipcode();
        $insert = $zipcode->Create($registro);

        // Verifica se inseriu com sucesso
        if ($insert)
            return redirect()
                ->route('zipcodes.index')
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
        // Obtem Zipcode
        $zipcode = Zipcode::Find($id);

        // Redireciona para controlador de ZipCodes por Loja
        return redirect()
            ->route('zipcodes.index')
            ->with('route_back', route('zipcodes.index'))
            ->with('id', $zipcode->id)
            ->with('name', $zipcode->name)
            ->with('success', "Loja $zipcode->name selecionada");
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
        $zipcode = Zipcode::Find($id);

        // Retorna para a view
        return view('config.zipcodes-edit', compact('zipcode'));
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
        $request->validate(Zipcode::$rules);

        $zipcode = Zipcode::find($id);
        $update = $zipcode->Update($request->all());

        // Verifica se alterou com sucesso
        if ($update)
            return redirect()
                ->route('zipcodes.index')
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
