<!-- COPIEI INFRACOMMERCE -->

<div class="topBar default--top">
            <div class="container top-bar">
                <div class="row">
                    <ul class="conteudo-topbar col-6 d-flex">
                        <li name="Unilever" class="d-flex topBarItem">
                        <a href="https://www.vilanova.com.br/Loja/Unilever/503">
                        <img class="img-topbar" src="https://images-vilanova.ifcshop.com.br/topbar/198_20191218113930.jpg" alt="Unilever" />
                        </a>
                        </li>
                    </ul>

                    <div class="top-header col-6">
                        <i class="fa fa-user-circle-o text-grey open-login"></i> <a id="open-login" href="#" class="open-modal ml-0" data-toggle="modal" data-target="#login-cadastro">Faça seu <u>Login</u> |</a>
                        <a id="open-register" href="#" class="open-modal" data-toggle="modal" data-target="#login-cadastro"><u>Cadastre-se</u> |</a>
                        <a id="open-venda-assistida" href="/VendaAssistida" class="open-modal mr-3"><u>Venda Assistida</u></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-conteudo">
            <nav id="container-logo-busca"
                class="d-none d-lg-flex container justify-content-between">
                <div class="col-md-2 header-logo">
                    <div class="logo navbar-brand pl-0 pr-0 mr-0">
                        <a href="https://www.vilanova.com.br" class="logo-link">
                            <img id="logo-principal" class="img-fluid" alt="Vila Nova" src="https://images-vilanova.ifcshop.com.br/site/vilanova/header/logo-vila-nova-header.svg">
                        </a>
                    </div>
                </div>

                <div class="col-md-8 col-lg-7 search-box-nav default">
                    <form action="/Busca/Resultado" method="get" class="form-busca-principal">
                        <input class="input-busca" autocomplete="off" placeholder="Pesquisar" type="text" name="q"/>
                        <input placeholder="tipo" type="text" class="d-none" name="avancado" value="true">
                        <button type="submit" class="btn-buscar">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                    <div class="resultado-busca-sugerida" style="flex: 1">
                        <div class="container-busca-sugerida">
                            <div class="header-busca-sugerida">
                                <p class="titulo-produtos-sugeridos">Produtos sugeridos</p>
                            </div>
                            <div class="resultados"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 col-lg-3 text-right pl-0 pr-0 pb-3">
                                        <div class="widget-cart">
                        <a id="carrinho-nav" href="/Carrinho" class="m-1 cart">
                            <span class="position-relative">
                                <span class="icone-carrinho-header"></span>
                            </span>
                            <div class="resume-cart">
                                <span class="valor-compra">Valor da compra</span>
                                <span class="valor-carrinho vlr-carrinho js-nav-cart-total font-weight-bold">
                                    R$ 0,00                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        </div>
<!-- COPIEI INFRACOMMERCE -->
