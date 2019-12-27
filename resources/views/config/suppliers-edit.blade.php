@extends('adminlte::page')

@section('title', 'Usuários')

@section('content')

<!-- MOSTRA MENSAGEM E ERROS -->
{!! simpleMessage($errors) !!}
{!! simpleFormHead($supplier->id) !!}


<!-- FORMULARIO -->
@if ( isset($supplier->id) )
{!! Form::model($supplier, ['route' => ['suppliers.update', $supplier->id], 'class' => 'form']) !!}
{!! Form::hidden('_method', 'PUT') !!}
@else
{!! Form::open(['route' => 'suppliers.store']) !!}
@endif
<div class="card card-body">
  <div class="row">
    <!--  PRIMEIRA COLUNA -->
    <div class="col">

      <!-- ID -->
      <div class="form-group row">
        {!! Form::label('id', 'ID:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('id', old('id', $supplier->id), ['placeholder' => 'ID', 'class' => 'form-control form-control-sm', 'readonly']) !!}
        </div>
      </div>

      <!-- NOME -->
      <div class="form-group row">
        {!! Form::label('name', 'Nome Fornecedor:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('name', old('name', $supplier->name), ['placeholder' => 'Nome do Fornecedor', 'class' => 'form-control form-control-sm']) !!}
        </div>
      </div>


      <!-- CODE CNPJ -->
      <div class="form-group row">
        {!! Form::label('code', 'Código Único CNPJ:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-3">
          {!! Form::text('code', old('code', $supplier->code), ['placeholder' => 'CNPJ', 'class' => 'form-control form-control-sm']) !!}
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
            <input type="datetime-local" class="form-control form-control-sm" id="created_at" name="created_at" readonly value="{{ old('created_at', $supplier->created_at ? $supplier->created_at->format('Y-m-d\TH:i:s') : '') }}">
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
            <input type="datetime-local" class="form-control form-control-sm" id="updated_at" name="updated_at" readonly value="{{ old('updated_at', $supplier->updated_at ? $supplier->updated_at->format('Y-m-d\TH:i:s') : '') }}">
          </div>
        </div>
      </div>

    </div>

  </div> <!-- row -->

  <!-- BOTÕES -->
  <?php echo simpleFormButtons(route('suppliers.index')) ?>

</div> <!-- card -->
{!! Form::close() !!}
@stop