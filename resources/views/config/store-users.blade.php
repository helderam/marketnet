@extends('adminlte::page')

@section('title', 'Usuários Autorizados')

@section('content')

<!-- MOSTRA MENSAGEM -->
<?php echo simpleMessage() ?>


<!-- LINHA TITULO, PESQUISA/BUSCA E NOVO REGISTRO -->
<form action="/product-categories" method="get">

  <?php echo simpleHeadTable(); ?>

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
              <input class="form-control form-control-sm" id="name" name="name" value="{{ simpleFilter('name')}}" placeholder="Nome">
            </div>
          </div>

        </div>

       <!-- FILTRO - SEGUNDA COLUNA -->
        <div class="col">

          <!-- FILTRO POR SKU -->
          <div class="form-group row">
            <label for="sku" class="col-sm-3 col-form-label">SKU</label>
            <div class="col-sm-4">
              <input class="form-control form-control-sm" id="sku" name="sku" value="{{simpleFilter('sku')}}" placeholder="SKU">
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
                <th> <?php echo simpleColumn('user_name', 'NOME') ?></th>
                <th> <?php echo simpleColumn('active', 'ATIVO') ?></th>
                <th> <?php echo simpleColumn('created_at', 'CRIAÇÂO') ?></th>
                <th> AÇÔES </th>
              </tr>
            </thead>

            <tbody>
              @foreach($storeUsers as $storeUser)
              <tr>
                <td>{{$storeUser->id}}</td>
                <td>{{$storeUser->user_name}}</td>
                <td>{{$storeUser->active}}</td>
                <td>{{simpleDateFormat($storeUser->created_at)}}</td>
                <!-- BOTÕES DE AÇÃO -->
                <td>
                  <?php
                  echo simpleAction(
                    $storeUser->active == 'S' ? 'Desativar' : 'Ativar',
                    'store-users.active',
                    $storeUser->active == 'S' ? 'danger' : 'success',
                    $storeUser->active == 'S' ? 'fa-lock-open' : 'fa-lock',
                    $storeUser->id
                  );
                  ?>
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
          <?php echo simpleFootTable($storeUsers) ?>
          <!-- FIM - RODAPE -->

        </div>
      </div>
    </div>
  </div>
</form>
@stop