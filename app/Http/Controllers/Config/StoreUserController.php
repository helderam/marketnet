<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\StoreUser;

class StoreUserController extends Controller
{
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
        $registros = DB::table('store_users')
            ->where('store_users.store_id', $selected_id)
            ->leftJoin('users', 'users.id', '=', 'store_users.user_id')
            ->where('store_users.store_id', $selected_id)
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                'store_users.id',
                'store_users.created_at',
                'store_users.active'
            )
            ->orderBy($column, $order);
        #->toSql(); dd($registros); 
        if ($name) $registros->whereRaw('lower(users.name) like ?', strtolower("%{$name}%")); # Desconsidera case
        $storeUsers = $registros->paginate($records);

        // Retorna para a view
        return view('config.store-users', compact('storeUsers'));
    }

    /**
     * Change usar status Produto Ativo ou Inativo
     *
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        $storeUser = StoreUser::FindOrFail($id);
        #dd($storeUser);
        if ($storeUser) {
            $storeUser->active = $storeUser->active == 'S' ? 'N' : 'S';
            $storeUser->save();
            return redirect()->route('store-users.index')->with('message', 'Usuário autorizado!');
        }
    }
}
