<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'FrontController@index')->name('home');
Route::get('/product/{slug}', 'FrontController@single')->name('product.single');
Route::get('/cart', 'FrontController@index')->name('cart.index');

Route::get('/licence_validate/{id}', 'Admin\LicenceController@licence_validate')->name('licences.validate');

Auth::routes();

/*
Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');
*/

Route::group(['middleware' => 'auth'], function () {
    // Cadastro de Usuários
    Route::resources([
        'users' => 'Admin\UserController',
    ]);
    Route::get('/users/admin/{id}', 'Admin\UserController@admin')->name('users.admin');
    Route::get('/perfil', 'Admin\UserController@perfil')->name('perfil');
    Route::put('/perfil-update', 'Admin\UserController@perfil_update')->name('perfil-update');

    // Cadastro de programas
    Route::resources([
        'programs' => 'Admin\ProgramController',
    ]);

    // Cadastro de grupos
    Route::resources([
        'groups' => 'Admin\GroupController',
    ]);

    // Cadastro de usuários no grupo
    Route::resources([
        'group-users' => 'Admin\GroupUserController',
    ]);

    // Cadastro de programas no grupo
    Route::resources([
        'group-programs' => 'Admin\GroupProgramController',
    ]);

    // Licenças
    Route::resources([
        'licences' => 'Admin\LicenceController',
    ]);

    // Lojas
    Route::resources([
        'stores' => 'Config\StoreController',
    ]);
    Route::get('/stores/select/{id}', 'Config\StoreController@select')->name('stores.select');
    Route::get('/stores/prices/{id}', 'Config\StoreController@prices')->name('stores.prices');
    Route::get('/stores/users/{id}', 'Config\StoreController@users')->name('stores.users');

    // Lojas
    Route::resources([
        'zipcodes' => 'Config\ZipcodeController',
    ]);

    // Categorias
    Route::resources([
        'categories' => 'Config\CategoryController',
    ]);
    Route::get('/categories/select/{id}', 'Config\CategoryController@select')->name('categories.select');

    // Fornecedores
    Route::resources([
        'suppliers' => 'Config\SupplierController',
    ]);

    // Produtos
    Route::resources([
        'products' => 'Config\ProductController',
    ]);

    // Produtos Categorias
    Route::resources([
        'product-categories' => 'Config\ProductCategoryController',
    ]);
    Route::get('/product-categories/active/{id}', 'Config\ProductCategoryController@active')->name('product-categories.active');

    // Estoques
    Route::resources([
        'stocks' => 'Config\StockController',
    ]);
    Route::get('/stocks/active/{id}', 'Config\StockController@active')->name('stocks.active');

    // Preços
    Route::resources([
        'prices' => 'Config\PriceController',
    ]);

    // Lojas com usuários autorizados
    Route::resources([
        'store-users' => 'Config\StoreUserController',
    ]);
    Route::get('/store-users/active/{id}', 'Config\StoreUserController@active')->name('store-users.active');

});
