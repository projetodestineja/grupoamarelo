<ul class="navbar-nav navbar-sidenav menu-vertical-principal" id="exampleAccordion">

    <li class="nav-item menu-v-painel <?php echo ($this->uri->segment(1)==''?'active':''); ?>" data-toggle="tooltip" data-placement="right" title="Painel Administrativo">
        <a class="nav-link" href="<?php echo site_url('painel'); ?>" >
          <i class="fa fa-fw fa-dashboard"></i> <span class="nav-link-text">Painel</span>
        </a>
    </li>

    <li class="nav-item menu-v-empresa" data-toggle="tooltip" data-placement="right" title="Painel Administrativo">
        <a class="nav-link" href="<?php echo site_url('empresa'); ?>" >
          <i class="fa fa-fw fa-building"></i> <span class="nav-link-text">Empresas</span>
        </a>
    </li>

    <!--
    <li class="nav-item menu-v-empresas" data-toggle="tooltip" data-placement="right" title="Empresas">
        <a class="nav-link nav-link-collapse collapsed " data-toggle="collapse" href="#collapseEmpresas" data-parent="#exampleAccordion">
          <i class="fa fa-fw fa-building"></i> <span class="nav-link-text">Empresas</span>
        </a>
        <ul class="sidenav-second-level collapse" id="collapseEmpresas">
          <li><a href="<php echo site_url('empresa'); ?>">Cadastros</a></li>
        </ul>
    </li>-->

	<li class="nav-item menu-v-demandas" data-toggle="tooltip" data-placement="right" title="Demandas">
        <a class="nav-link" href="<?php echo site_url('demandas'); ?>" >
          <i class="fa fa-fw fa-list"></i> <span class="nav-link-text">Demandas</span>
        </a>
     </li>
    
	 <li class="nav-item menu-v-config menu-v-cidades menu-v-demandas_status menu-v-areas_atuacao" data-toggle="tooltip" data-placement="right" title="Configurações" >
        <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseConfiguracoes" data-parent="#exampleAccordion">
          <i class="fa fa-fw fa-wrench"></i><span class="nav-link-text">Configurações</span>
        </a>
        <ul class="sidenav-second-level collapse" id="collapseConfiguracoes">
          <li><a href="<?php echo site_url('demandas_status'); ?>" >Status de Demandas</a></li>
          <li><a href="<?php echo site_url('areas_atuacao'); ?>" >Áreas de Atuação</a></li>
          <li><a href="<?php echo site_url('config'); ?>" >Config SMTP/E-mail Alertas</a></li>
          <li><a href="<?php echo site_url('cidades'); ?>" >Cidades Cadastro</a></li>
        </ul>
      </li>
      
      <li class="nav-item menu-v-mensagens" data-toggle="tooltip" data-placement="right" title="Mensagens">
        <a class="nav-link" href="<?php echo site_url('mensagens'); ?>">
            <i class="fa fa-fw fa-commenting"></i> <span class="nav-link-text">Mensagens</span>
        </a>
      </li>
    
      <li class="nav-item menu-v-relatorio" data-toggle="tooltip" data-placement="right" title="Relatórios">
        <a class="nav-link" href="<?php echo site_url('relatorio'); ?>" >
          <i class="fa fa-fw fa-download"></i><span class="nav-link-text">Relatórios</span>
        </a>
      </li>
      	
      <li class="nav-item menu-v-usuarios" data-toggle="tooltip" data-placement="right" title="Usuários">
        <a class="nav-link" href="<?php echo site_url('usuarios'); ?>" >
          <i class="fa fa-fw fa-user"></i><span class="nav-link-text">Usuários</span>
        </a>
      </li>
	</ul>



    <ul class="navbar-nav sidenav-toggler">
      <li class="nav-item">
        <a class="nav-link text-center" id="sidenavToggler" rel="menu-vertital-painel" >
          <i class="fa fa-fw fa-angle-left"></i>
        </a>
      </li>
    </ul>




    <ul class="navbar-nav ml-auto">
      <!--
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle mr-lg-2" href="#" id="messagesDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-fw fa-envelope"></i>
          <span class="d-lg-none">Mensagens
            <span class="badge badge-pill badge-primary">12 novas</span>
          </span>
          <span class="new-indicator text-primary d-none d-lg-block">
            <i class="fa fa-fw fa-circle"></i>
            <span class="number">12</span>
          </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="messagesDropdown">
          <h6 class="dropdown-header">Novas Mensagens:</h6>
          <?php for($msg=0;$msg<=4;$msg++){?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <strong>Fulano <?php echo $msg?></strong>
            <span class="small float-right text-muted">11:21h</span>
            <div class="dropdown-message small">Eu sou uma mensagem de teste!</div>
          </a>
         <?php } ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item small" href="#">
            Ver Todas Mensagens
          </a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle mr-lg-2" href="#" id="alertsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-fw fa-bell"></i>
          <span class="d-lg-none">Demandas
            <span class="badge badge-pill badge-warning">6 Demandas</span>
          </span>
          <span class="new-indicator text-warning d-none d-lg-block">
            <i class="fa fa-fw fa-circle"></i>
            <span class="number">6</span>
          </span>
        </a>

        <div class="dropdown-menu" aria-labelledby="alertsDropdown">
          <h6 class="dropdown-header">Novas demendas:</h6>
          <?php for($msg=0;$msg<=4;$msg++){?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <strong>Demanda Nº <?php echo $msg?></strong>
            <span class="small float-right text-muted">11:21h</span>
            <div class="dropdown-message small">Eu sou uma mensagem de teste!</div>
          </a>
         <?php } ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item small" href="#">
            Ver Todas Demandas
          </a>
        </div>
      </li>
	  -->

      <li class="nav-item" >
        <a class="nav-link  mr-lg-2" href="<?php echo site_url('usuarios'); ?>" >
          <i class="fa fa-fw fa-user"></i> <?php echo $this->session->userdata['user']['nome']; ?>
        </a>
      </li>


      <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Sair
          </a>
      </li>
    </ul>
