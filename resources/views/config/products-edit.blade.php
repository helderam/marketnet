@extends('adminlte::page')

@section('title', 'Usuários')

@section('content')

<!-- MOSTRA MENSAGEM E ERROS -->
{!! simpleMessage($errors) !!}
{!! simpleFormHead($product->id) !!}


<!-- FORMULARIO -->
@if ( isset($product->id) )
{!! Form::model($product, ['route' => ['products.update', $product->id], 'class' => 'form']) !!}
{!! Form::hidden('_method', 'PUT') !!}
@else
{!! Form::open(['route' => 'products.store']) !!}
@endif
<div class="card card-body">
  <div class="row">
    <!--  PRIMEIRA COLUNA -->
    <div class="col">

      <!-- ID -->
      <div class="form-group row">
        {!! Form::label('id', 'ID:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('id', old('id', $product->id), ['placeholder' => 'ID', 'class' => 'form-control form-control-sm', 'readonly']) !!}
        </div>
      </div>

      <!-- NOME -->
      <div class="form-group row">
        {!! Form::label('name', 'Nome Produto:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('name', old('name', $product->name), ['placeholder' => 'Nome do Producta', 'class' => 'form-control form-control-sm']) !!}
        </div>
      </div>

      <!-- SLUG -->
      <div class="form-group row">
        {!! Form::label('slug', 'Slug:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('slug', old('slug', $product->slug), ['placeholder' => 'Slug', 'class' => 'form-control form-control-sm']) !!}
        </div>
      </div>

      <!-- MOSTRAR NO MENU -->
      <div class="form-group row">
        {!! Form::label('sku', 'Código Único SKU:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-3">
          {!! Form::text('sku', old('sku', $product->sku), ['placeholder' => 'SKU', 'class' => 'form-control form-control-sm']) !!}
        </div>
      </div>
    </div>

    <!-- SEGUNDA COLUNA -->
    <div class="col">

      <!-- DATA DE CRIAÇÂO -->
      <div class="form-group row">
        <div class="col-sm-3">
          <label for="created_at" class="col-form-label">Criado em</label>
        </div>
        <div class="col-sm-5">
          <div class="input-group">
            <i class="fa fa-calendar-alt fa-2x"></i>
            <input type="datetime-local" class="form-control form-control-sm" id="created_at" name="created_at" readonly value="{{ old('created_at', $product->created_at ? $product->created_at->format('Y-m-d\TH:i:s') : '') }}">
          </div>
        </div>
      </div>

      <!-- DATA DE ALTERAÇÂO -->
      <div class="form-group row">
        <div class="col-sm-3">
          <label for="updated_at" class="col-form-label">Alterado em</label>
        </div>
        <div class="col-sm-5">
          <div class="input-group">
            <i class="fa fa-calendar-alt fa-2x"></i>
            <input type="datetime-local" class="form-control form-control-sm" id="updated_at" name="updated_at" readonly value="{{ old('updated_at', $product->updated_at ? $product->updated_at->format('Y-m-d\TH:i:s') : '') }}">
          </div>
        </div>
      </div>

      <!-- DESCRIÇÂO -->
      <div class="form-group row">
        <div class="col-sm-3">
          <label for="description" class="col-form-label">Descrição</label>
        </div>
        <div class="col-sm-5">
          <div class="input-group">
            <textarea class="form-control form-control-sm" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
          </div>
        </div>
      </div>

      <!-- FORNECEDOR -->
      <div class="form-group row">
        <div class="col-sm-3">
          <label for="supplier" class="col-form-label">Fornecedor:</label>
        </div>
        <div class="col-sm-5">
          <div class="input-group">
          <select name="supplier_id" class="form-control form-control-sm" id="supplier">
            <?php 
            echo simpleSelect(
              old('supplier_id', $product->supplier_id), # ID atual
              \App\Supplier::orderBy('name')->pluck('id', 'name') # Fornecedores
              ) 
              ?>
          </select>
          </div>
        </div>
      </div>

    </div>

  </div> <!-- row -->

  <!-- BOTÕES -->
  <?php echo simpleFormButtons(route('products.index')) ?>

</div> <!-- card -->
{!! Form::close() !!}
@stop