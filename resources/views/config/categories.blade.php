@extends('adminlte::page')

@section('title', 'Categorias')

@section('content')

<!-- MOSTRA MENSAGEM -->
<?php echo simpleMessage() ?>


<!-- LINHA TITULO, PESQUISA/BUSCA E NOVO REGISTRO -->
<form action="/categories" method="get">

  <?php echo simpleHeadTable(route('categories.create')); ?>

  <!-- CAMPOS PARA FILTRAGEM -->
  <div class="collapse" id="filtros">
    <div class="card card-body">

      <div class="row">

        <!-- FILTRO - PRIMEIRA COLUNA -->
        <div class="col">
          <!-- FILTRO POR NOME -->
          <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">Nome</label>
            <div class="col-sm-9">
              <input class="form-control form-control-sm" id="name" name="name" value="{{session('name')}}" placeholder="Nome">
            </div>
          </div>
        </div>

      </div>
        <!-- BOTÂO APLICAR FILTRAR -->
        <?php echo simpleApplyFilters() ?>

    </div>
  </div>
  <!-- FIM CAMPOS PARA FILTRAGEM -->


  <!-- TABELA PRINCIPAL DE REGISTROS -->
  <div class="row">
    <div class="col-12">

      <div class="card">
        <div class="card-body">

          <table class="bg-white table table-striped table-hover nowrap rounded table-striped table-sm" cellspacing="0">
            <thead>
              <tr>
                <th> <?php echo simpleColumn('id', 'ID') ?></th>
                <th> <?php echo simpleColumn('name', 'NOME') ?></th>
                <th> <?php echo simpleColumn('level', 'NÌVEL') ?></th>
                <th> <?php echo simpleColumn('slug', 'SLUG') ?></th>
                <th> <?php echo simpleColumn('created_at', 'CRIAÇÂO') ?></th>
                <th> AÇÔES </th>
              </tr>
            </thead>

            <tbody>
              @foreach($categories as $category)
              <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->level}}</td>
                <td>{{$category->slug}}</td>
                <td>{{simpleDateFormat($category->created_at)}}</td>
                <!-- BOTÕES DE AÇÃO -->
                <td>
                  <?php echo simpleAction('EDITAR', 'categories.edit', 'info', 'fa-edit', $category->id); ?>
                  <?php echo simpleAction('SUBCATEGORIAS', 'categories.show', 'info', 'fa-map', $category->id); ?>
                </td>
              </tr>
              @endforeach
              </body>

              <!-- TFOOT - IMPORTANTE PARA MELHORAR VISUAL -->
            <tfoot>
              <tr>
                <th colspan="100"></th>
              </tr>
            </tfoot>
          </table>

          <!-- RODAPE NAVEGADOR DE PAGINAS -->
          <?php echo simpleFootTable($categories) ?>
          <!-- FIM - RODAPE -->

        </div>
      </div>
    </div>
  </div>
</form>
@stop