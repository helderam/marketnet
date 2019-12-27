<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Supplier;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
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
        #dd($column);
        // Campos de filtragem
        $name = simpleFilter('name', 'Nome');

        // Seleciona os registros, filtra e ordena
        $registros = Supplier::orderBy($column, $order);
        if ($name) $registros->whereRaw('lower(name) like ?', strtolower("%{$name}%")); # Desconsidera case
        $suppliers = $registros->paginate($records);

        // Retorna para a view
        return view('config.suppliers', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = new Supplier();

        // Retorna para a view
        return view('config.suppliers-edit', compact('supplier'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Supplier::$rules);

        // Valida se e-mail ja existe (único)
        if (Supplier::where('code', $request->code)->count())
            throw \Illuminate\Validation\ValidationException::withMessages(['code' => ['CNPJ já existente']]);

        $supplier = new Supplier();
        $insert = $supplier->Create($request->all());

        // Verifica se inseriu com sucesso
        if ($insert)
            return redirect()
                ->route('suppliers.index')
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
        $supplier = Supplier::Find($id);

        // Retorna para a view
        return view('config.suppliers-edit', compact('supplier'));
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
        $request->validate(Supplier::$rules);

        // Valida se rota ja existe (único)
        if (DB::table('suppliers')
            ->where('code', $request->code)
            ->where('id', '!=', $id)->count()
        )
            throw \Illuminate\Validation\ValidationException::withMessages(['code' => ['CNPJ já existente']]);

        $supplier = Supplier::find($id);
        $update = $supplier->Update($request->all());

        // Verifica se alterou com sucesso
        if ($update)
            return redirect()
                ->route('suppliers.index')
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
