@extends('adminlte::page')

@section('title', 'CEPs')

@section('content')

<!-- MOSTRA MENSAGEM E ERROS -->
{!! simpleMessage($errors) !!}
{!! simpleFormHead($zipcode->id) !!}


<!-- FORMULARIO -->
@if ( isset($zipcode->id) )
{!! Form::model($zipcode, ['route' => ['zipcodes.update', $zipcode->id], 'class' => 'form']) !!}
{!! Form::hidden('_method', 'PUT') !!}
@else
{!! Form::open(['route' => 'zipcodes.store']) !!}
@endif
<div class="card card-body">
  <div class="row">
    <!--  PRIMEIRA COLUNA -->
    <div class="col">

      <!-- ID -->
      <div class="form-group row">
        {!! Form::label('id', 'ID:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('id', old('id', $zipcode->id), ['placeholder' => 'ID', 'class' => 'form-control form-control-sm', 'readonly']) !!}
        </div>
      </div>

      <!-- NOME -->
      <div class="form-group row">
        {!! Form::label('name', 'Nome Faixa:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('name', old('name', $zipcode->name), ['placeholder' => 'Nome do zipcodea', 'class' => 'form-control form-control-sm']) !!}
        </div>
      </div>

      <!-- ZIPCODE BEGIN -->
      <div class="form-group row">
        {!! Form::label('zipcode_begin', 'Faixa CEP Inicial:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('zipcode_begin', old('zipcode_begin', $zipcode->zipcode_begin), ['placeholder' => '00000000', 'class' => 'form-control form-control-sm']) !!}
        </div>
      </div>

      <!-- ZIPCODE END -->
      <div class="form-group row">
        {!! Form::label('zipcode_end', 'Faixa CEP Inicial:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('zipcode_end', old('zipcode_end', $zipcode->zipcode_end), ['placeholder' => '00000000', 'class' => 'form-control form-control-sm']) !!}
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
            <input type="datetime-local" class="form-control form-control-sm" id="created_at" name="created_at" readonly value="{{ old('created_at', $zipcode->created_at ? $zipcode->created_at->format('Y-m-d\TH:i:s') : '') }}">
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
            <input type="datetime-local" class="form-control form-control-sm" id="updated_at" name="updated_at" readonly value="{{ old('updated_at', $zipcode->updated_at ? $zipcode->updated_at->format('Y-m-d\TH:i:s') : '') }}">
          </div>
        </div>
      </div>

      <!-- ATIVO? -->
      <div class="form-group row">
        {!! Form::label('active', 'Ativo ?:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('active', old('active', $zipcode->active), ['placeholder' => 'S/N', 'class' => 'form-control form-control-sm']) !!}
        </div>
      </div>


    </div>

  </div> <!-- row -->

  <!-- BOTÕES -->
  <?php echo simpleFormButtons(route('zipcodes.index')) ?>

</div> <!-- card -->


{!! Form::close() !!}
@stop
