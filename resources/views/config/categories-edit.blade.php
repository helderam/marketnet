@extends('adminlte::page')

@section('title', 'Categorias')

@section('content')

<!-- MOSTRA MENSAGEM E ERROS -->
{!! simpleMessage($errors) !!}
{!! simpleFormHead($category->id) !!}


<!-- FORMULARIO -->
@if ( isset($category->id) )
{!! Form::model($category, ['route' => ['categories.update', $category->id], 'class' => 'form']) !!}
{!! Form::hidden('_method', 'PUT') !!}
@else
{!! Form::open(['route' => 'categories.store']) !!}
@endif
<div class="card card-body">
  <div class="row">
    <!--  PRIMEIRA COLUNA -->
    <div class="col">

      <!-- ID -->
      <div class="form-group row">
        {!! Form::label('id', 'ID:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('id', old('id', $category->id), ['placeholder' => 'ID', 'class' => 'form-control form-control-sm', 'readonly']) !!}
        </div>
      </div>

      <!-- NOME -->
      <div class="form-group row">
        {!! Form::label('name', 'Categoria:', ['class' => 'col-sm-3 col-form-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('name', old('name', $category->name), ['placeholder' => 'Nome do categorya', 'class' => 'form-control form-control-sm']) !!}
        </div>
      </div>

      <!-- DESCRIÇÂO -->
      <div class="form-group row">
        <div class="col-sm-3">
          <label for="description" class="col-form-label">Descrição</label>
        </div>
        <div class="col-sm-5">
          <div class="input-group">
            <textarea class="form-control form-control-sm" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
          </div>
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
            <input type="datetime-local" class="form-control form-control-sm" id="created_at" name="created_at" readonly value="{{ old('created_at', $category->created_at ? $category->created_at->format('Y-m-d\TH:i:s') : '') }}">
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
            <input type="datetime-local" class="form-control form-control-sm" id="updated_at" name="updated_at" readonly value="{{ old('updated_at', $category->updated_at ? $category->updated_at->format('Y-m-d\TH:i:s') : '') }}">
          </div>
        </div>
      </div>

      <!-- SLUG -->
      <div class="form-group row">
        <div class="col-sm-3">
          <label for="slug" class="col-form-label">Slug</label>
        </div>
        <div class="col-sm-5">
          <div class="input-group">
            <input type="text" class="form-control form-control-sm" id="slug" name="slug" value="{{ old('slug', $category->slug) }}">
          </div>
        </div>
      </div>

      <!-- NIVEL -->
      <div class="form-group row">
        <div class="col-sm-3">
          <label for="level" class="col-form-label">Nível</label>
        </div>
        <div class="col-sm-5">
          <div class="input-group">
            <input type="text" class="form-control form-control-sm" id="level" name="level" readonly value="{{ session('selected_level')+1 }}">
          </div>
        </div>
      </div>


    </div>

  </div> <!-- row -->

  <!-- BOTÕES -->
  <?php echo simpleFormButtons(route('categories.index')) ?>

</div> <!-- card -->


{!! Form::close() !!}
@stop
