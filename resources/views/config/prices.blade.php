@extends('adminlte::page')

@section('title', 'Preços')

@section('content')

<!-- MOSTRA MENSAGEM -->
<?php echo simpleMessage() ?>


<!-- LINHA TITULO, PESQUISA/BUSCA E NOVO REGISTRO -->
<form action="/prices" method="get">

  <?php echo simpleHeadTable(route('prices.create')); ?>

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
        </div>

        <div class="col">
          <!-- LOJA -->
          <div class="form-group row">
            <label for="store_id" class="col-sm-3 col-form-label">Loja</label>
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
                <th> <?php echo simpleColumn('quantity_packing', 'QTD EMBAL') ?></th>
                <th> <?php echo simpleColumn('packing', 'EMBALAGEM') ?></th>
                <th> <?php echo simpleColumn('price', 'PREÇO') ?></th>
                <th> <?php echo simpleColumn('store_name', 'LOJA') ?></th>
                <th> <?php echo simpleColumn('created_at', 'CRIAÇÂO') ?></th>
                <th> AÇÔES </th>
              </tr>
            </thead>

            <tbody>
              @foreach($prices as $price)
              <tr>
                <td>{{$price->id}}</td>
                <td>{{$price->product_sku}}</td>
                <td>{{$price->product_name}}</td>
                <td>{{$price->quantity_packing}}</td>
                <td>{{$price->packing}}</td>
                <td>{{$price->price}}</td>
                <td>{{$price->store_name}}</td>
                <td>{{simpleDateFormat($price->created_at)}}</td>
                <!-- BOTÕES DE AÇÃO -->
                <td>
                  <?php echo simpleAction('EDITAR', 'prices.edit', 'info', 'fa-edit', $price->id); ?>
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
          <?php echo simpleFootTable($prices) ?>
          <!-- FIM - RODAPE -->

        </div>
      </div>
    </div>
  </div>
</form>
@stop