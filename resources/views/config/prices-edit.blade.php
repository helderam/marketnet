@extends('adminlte::page')

@section('title', 'Preços')

@section('content')

<!-- MOSTRA MENSAGEM E ERROS -->
{!! simpleMessage($errors) !!}
{!! simpleFormHead($price->id) !!}

<!-- FORMULARIO -->
@if ( isset($price->id) )
{!! Form::model($price, ['route' => ['prices.update', $price->id], 'class' => 'form']) !!}
{!! Form::hidden('_method', 'PUT') !!}
@else
{!! Form::open(['route' => 'prices.store']) !!}
@endif
<div class="card card-body">
  <div class="row">
    <!--  PRIMEIRA COLUNA -->
    <div class="col">

      <!-- ID -->
      <div class="form-group row">
        {!! Form::label('id', 'ID:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('id', old('id', $price->id), ['placeholder' => 'ID', 'class' => 'form-control form-control-sm', 'readonly']) !!}
        </div>
      </div>

      <!-- NOME -->
      <div class="form-group row">
        {!! Form::label('name', 'Produto:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('name', old('name', $price->product->name), ['placeholder' => 'Descrição', 'class' => 'form-control form-control-sm', 'readonly']) !!}
        </div>
      </div>

      <!-- ESTOQUE -->
      <div class="form-group row">
        {!! Form::label('price', 'Preço:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('price', old('price', $price->price), ['placeholder' => 'Quantidade Estoque', 'class' => 'form-control form-control-sm']) !!}
        </div>
      </div>

    </div>

    <!-- SEGUNDA COLUNA -->
    <div class="col">

      <!-- SKU -->
      <div class="form-group row">
        {!! Form::label('sku', 'SKU:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-4">
          {!! Form::text('sku', old('sku', $price->product->sku), ['placeholder' => 'Descrição', 'class' => 'form-control form-control-sm', 'readonly']) !!}
        </div>
      </div>

      <!-- QTD EMBAL -->
      <div class="form-group row">
        {!! Form::label('quantity_packing', 'Quantidade Embalagem:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('quantity_packing', old('quantity_packing', $price->quantity_packing), ['placeholder' => 'Qtd', 'class' => 'form-control form-control-sm']) !!}
        </div>
      </div>

      <!-- EMBALAGEM -->
      <div class="form-group row">
        {!! Form::label('packing', 'Embalagem:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('packing', old('packing', $price->packing), ['placeholder' => 'CX', 'class' => 'form-control form-control-sm']) !!}
        </div>
      </div>

    </div>

  </div> <!-- row -->

  <!-- BOTÕES -->
  <?php echo simpleFormButtons(route('prices.index')) ?>

</div> <!-- card -->


{!! Form::close() !!}
@stop
