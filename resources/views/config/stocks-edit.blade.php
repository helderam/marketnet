@extends('adminlte::page')

@section('title', 'Estoque')

@section('content')

<!-- MOSTRA MENSAGEM E ERROS -->
{!! simpleMessage($errors) !!}
{!! simpleFormHead($stock->id) !!}

<!-- FORMULARIO -->
@if ( isset($stock->id) )
{!! Form::model($stock, ['route' => ['stocks.update', $stock->id], 'class' => 'form']) !!}
{!! Form::hidden('_method', 'PUT') !!}
@else
{!! Form::open(['route' => 'stocks.store']) !!}
@endif
<div class="card card-body">
  <div class="row">
    <!--  PRIMEIRA COLUNA -->
    <div class="col">

      <!-- ID -->
      <div class="form-group row">
        {!! Form::label('id', 'ID:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('id', old('id', $stock->id), ['placeholder' => 'ID', 'class' => 'form-control form-control-sm', 'readonly']) !!}
        </div>
      </div>

      <!-- NOME -->
      <div class="form-group row">
        {!! Form::label('name', 'Produto:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('name', old('name', $stock->product->name), ['placeholder' => 'Descrição', 'class' => 'form-control form-control-sm', 'readonly']) !!}
        </div>
      </div>

      <!-- ESTOQUE -->
      <div class="form-group row">
        {!! Form::label('stock', 'Estoque:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('stock', old('stock', $stock->stock), ['placeholder' => 'Quantidade Estoque', 'class' => 'form-control form-control-sm']) !!}
        </div>
      </div>

    </div>

    <!-- SEGUNDA COLUNA -->
    <div class="col">

      <!-- SKU -->
      <div class="form-group row">
        {!! Form::label('sku', 'SKU:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-4">
          {!! Form::text('sku', old('sku', $stock->product->sku), ['placeholder' => 'Descrição', 'class' => 'form-control form-control-sm', 'readonly']) !!}
        </div>
      </div>

      <!-- ATIVO ? -->
      <div class="form-group row">
        {!! Form::label('active', 'Ativo ?:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('active', old('active', $stock->active), ['placeholder' => 'S/N', 'class' => 'form-control form-control-sm']) !!}
        </div>
      </div>

    </div>

  </div> <!-- row -->

  <!-- BOTÕES -->
  <?php echo simpleFormButtons(route('stocks.index')) ?>

</div> <!-- card -->


{!! Form::close() !!}
@stop
