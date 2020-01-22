<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Acrescentei classes
use App\Product;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {
        // Seleciona os registros, filtra e ordena
        $registros = Product::orderBy('id', 'desc');
        $products = $registros->paginate(10);

        // Retorna para a view
        return view('front', compact('products'));
    }

    public function single($slug)
	{
		$product = Product::whereSlug($slug)->first();

		return view('single', compact('product'));
	}
}
