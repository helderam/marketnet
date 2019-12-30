@extends('adminlte::page')

@section('title', 'Estoques')

@section('content')

<!-- MOSTRA MENSAGEM -->
<?php echo simpleMessage() ?>


<!-- LINHA TITULO, PESQUISA/BUSCA E NOVO REGISTRO -->
<form action="/stocks" method="get">

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
              <input class="form-control form-control-sm" id="name" name="name" value="{{ simpleFilter('name') }}" placeholder="Nome">
            </div>
          </div>

        </div>

       <!-- FILTRO - SEGUNDA COLUNA -->
        <div class="col">

          <!-- FILTRO POR SKU -->
          <div class="form-group row">
            <label for="sku" class="col-sm-3 col-form-label">SKU</label>
            <div class="col-sm-4">
              <input class="form-control form-control-sm" id="sku" name="sku" value="{{ simpleFilter('sku') }}" placeholder="SKU">
            </div>
          </div>

        </div>

      </div>

      <div class="row">

        <!-- FILTRO - PRIMEIRA COLUNA -->
        <div class="col">
          <!-- FILTRO POR ATIVO -->
          <div class="form-group row">
            <label for="active" class="col-sm-3 col-form-label">Ativo</label>
            <div class="col-sm-2">
            <?php echo simpleSelect('active', simpleFilter('active'), ['Sim'=>'S','Não'=>'N'] ) ?>
            </div>
          </div>
        </div>

        <div class="col">
          <!-- LOJA -->
          <div class="form-group row">
            <label for="store_id" class="col-sm-3 col-form-label">SKU</label>
            <div class="col-sm-4">
            <?php
                 echo simpleSelect('store_id', simpleFilter('store_id'),
                 \App\Store::orderBy('name')->whereIn('id', session('store_ids'))->pluck('id', 'name') # So lojas autorizadas
                 );
            ?>
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
                <th> <?php echo simpleColumn('product_sku', 'SKU') ?></th>
                <th> <?php echo simpleColumn('product_name', 'NOME') ?></th>
                <th> <?php echo simpleColumn('stock', 'ESTOQUE') ?></th>
                <th> <?php echo simpleColumn('active', 'ATIVO') ?></th>
                <th> <?php echo simpleColumn('store_name', 'LOJA') ?></th>
                <th> <?php echo simpleColumn('created_at', 'CRIAÇÂO') ?></th>
                <th> AÇÔES </th>
              </tr>
            </thead>

            <tbody>
              @foreach($stocks as $stock)
              <tr>
                <td>{{$stock->id}}</td>
                <td>{{$stock->product_sku}}</td>
                <td>{{$stock->product_name}}</td>
                <td>{{$stock->stock}}</td>
                <td>{{$stock->active}}</td>
                <td>{{$stock->store_name}}</td>
                <td>{{simpleDateFormat($stock->created_at)}}</td>
                <!-- BOTÕES DE AÇÃO -->
                <td>
                  <?php echo simpleAction('EDITAR', 'stocks.edit', 'info', 'fa-edit', $stock->id); ?>
                  <?php
                  echo simpleAction(
                    $stock->active == 'S' ? 'Desativar' : 'Ativar',
                    'stocks.active',
                    $stock->active == 'S' ? 'danger' : 'success',
                    $stock->active == 'S' ? 'fa-lock-open' : 'fa-lock',
                    $stock->id
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
          <?php echo simpleFootTable($stocks) ?>
          <!-- FIM - RODAPE -->

        </div>
      </div>
    </div>
  </div>
</form>
@stop