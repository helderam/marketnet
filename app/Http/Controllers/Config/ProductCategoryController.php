<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ProductCategory;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
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
        $registros = DB::table('product_categories')
        ->leftJoin('products', 'products.id', '=', 'product_categories.product_id')
        ->leftJoin('categories', 'categories.id', '=', 'product_categories.category_id')
        ->where('product_categories.category_id', $selected_id)
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'products.sku as product_sku',
                'categories.name',
                'product_categories.id',
                'product_categories.created_at',
                'product_categories.active'
            )
            ->orderBy($column, $order);
        #->toSql(); dd($registros);

        if ($name) $registros->whereRaw('lower(products.name) like ?', strtolower("%{$name}%")); # Desconsidera case
        if ($sku) $registros->where('products.sku', 'like', "%{$sku}%"); # Desconsidera case
        $productCategories = $registros->paginate($records);

        // Retorna para a view
        return view('config.product-categories', compact('productCategories'));
    }

     /**
     * Change usar status Produto Ativo ou Inativo
     *
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        $productCategory = ProductCategory::FindOrFail($id);
        #dd($productCategory);
        if ($productCategory) {
            $productCategory->active = $productCategory->active == 'S' ? 'N' : 'S';
            $productCategory->save();
            return redirect()->route('product-categories.index')->with('message', 'Produto ajustado!');
        }
    }


}
