<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
        <?php if($_SESSION['tipo'] == 0){?>
        	<li class="nav-item {{ request()->is('dashboard-admin') ? 'active' : '' }}">
                <a class="nav-item-hold" href="/dashboard-admin">
                    <span class="icon-sidebar icon-dashboard"></span>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>
		<?php }else{?>
            <li class="nav-item {{ request()->is('dashboard-cliente') ? 'active' : '' }}">
                <a class="nav-item-hold" href="/dashboard-cliente">
                    <span class="icon-sidebar icon-dashboard"></span>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>
         <?php }?>
         <?php if($_SESSION['tipo'] == 1){?>
         <li class="nav-item {{ request()->is('projeto') ? 'active' : '' }}" >
                <a class="nav-item-hold" href="/projeto">
                <span class="icon-sidebar icon-projetos"></span>
                    <span class="nav-text">Projetos</span>
                </a>
                <div class="triangle"></div>
            </li>
         <?php }?>
         <?php if($_SESSION['tipo'] == 0){?>
            <li class="nav-item {{ request()->is('projeto') ? 'active' : '' }}" data-item="empresas">
                <a class="nav-item-hold" href="/projetos">
                <span class="icon-sidebar icon-projetos"></span>
                    <span class="nav-text">Projetos</span>
                </a>
                <div class="triangle"></div>
            </li>


                <li class="nav-item {{ request()->is('categorias') ? 'active' : '' }}">
                <a class="nav-item-hold" href="/categorias">
                <span class="icon-sidebar icon-categorias"></span>
                    <span class="nav-text">Categorias</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('dados') ? 'active' : '' }}" data-item="dados">
                <a class="nav-item-hold" href="#">
                <span class="icon-sidebar icon-usuarios"></span>
                    <span class="nav-text">Dados</span>
                </a>
                <div class="triangle"></div>
            </li>
            <?php } ?>
            <li class="nav-item {{ request()->is('minha-conta') ? 'active' : '' }}">
                <a class="nav-item-hold" href="/minha-conta/<?php echo $_SESSION['id'];?>">
                <span class="icon-sidebar icon-minhaconta"></span>
                    <span class="nav-text">Minha Conta</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>

    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <!-- Submenu Dashboards -->
        <ul class="childNav" data-parent="empresas">
            <li class="nav-item ">
                <a class="" href="/projeto">
                    <i class="nav-icon i-Receipt-4"></i>
                    <span class="item-name">Listagem de Projetos</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/projeto/novo" class="{{ Route::currentRouteName()=='normal' ? 'open' : '' }}">
                    <i class="nav-icon  i-Add-Window"></i>
                    <span class="item-name"> Novo Projeto</span>
                </a>
            </li>
        </ul>


        <!-- Submenu Dashboards -->
        <ul class="childNav" data-parent="dados">
            <li class="nav-item ">
                <a class="" href="/dados/clientes">
                    <i class="nav-icon i-Business-Man"></i>
                    <span class="item-name">Usuários</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/dados/projetos" class="{{ Route::currentRouteName()=='normal' ? 'open' : '' }}">
                    <i class="nav-icon i-Post-Office"></i>
                    <span class="item-name">Projetos</span>
                </a>
            </li>
        </ul>


    </div>
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->
