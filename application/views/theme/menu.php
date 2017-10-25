
<ul class="navbar-nav navbar-sidenav menu-vertical-principal" id="exampleAccordion">

    <li class="nav-item menu-v-painelempresa <?php echo ($this->uri->segment(1) == '' ? 'active' : ''); ?>" data-toggle="tooltip" data-placement="right" title="Painel Administrativo">
        <a class="nav-link" href="<?php echo site_url('painelempresa'); ?>" >
            <i class="fa fa-fw fa-dashboard"></i> <span class="nav-link-text">Painel</span>
        </a>
    </li>
    <li class="nav-item menu-v-chamado" data-toggle="tooltip" data-placement="right" title="Novo Chamado">
        <a class="nav-link" href="#">
            <i class="fa fa-fw fa-file-text-o"></i> <span class="nav-link-text">Novo Chamado</span>
        </a>
    </li>
    
    
    <li class="nav-item menu-v-demandas" data-toggle="tooltip" data-placement="right" title="Demandas">
        <a class="nav-link" href="<?php echo site_url('demanda/lista_demandas'); ?>">
            <i class="fa fa-fw fa-list"></i> <span class="nav-link-text">Demandas</span>
        </a>
    </li>
    
    <!--
    <li class="nav-item menu-v-configuracoes" data-toggle="tooltip" data-placement="right" title="Configuracoes">
        <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseConfiguracoes" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-wrench"></i><span class="nav-link-text">Configurações</span>
        </a>
        <ul class="sidenav-second-level collapse" id="collapseConfiguracoes">
            <li><a href="#">Status de Demandas</a></li>
            <li><a href="#">Ramos de Negócio</a></li>
            <li><a href="#">Alertas</a></li>

        </ul>
    </li>
    
    
    <li class="nav-item menu-v-usuarios" data-toggle="tooltip" data-placement="right" title="Usuários">
        <a class="nav-link" href="<?php echo site_url('usuarios'); ?>" >
            <i class="fa fa-fw fa-user"></i><span class="nav-link-text">Usuários</span>
        </a>
    </li>
    
    -->
</ul>



<ul class="navbar-nav sidenav-toggler">
    <li class="nav-item">
        <a class="nav-link text-center" id="sidenavToggler" rel="menu-vertital-cliente" >
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
        <span class="badge badge-pill badge-primary">12 Mensagens</span>
      </span>
      <span class="new-indicator text-primary d-none d-lg-block">
        <i class="fa fa-fw fa-circle"></i>
        <span class="number">12</span>
      </span>
    </a>
    <div class="dropdown-menu" aria-labelledby="messagesDropdown">
      <h6 class="dropdown-header">Novas Mensagens:</h6>
    <?php for ($msg = 0; $msg <= 4; $msg++) { ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <strong>Fulano <?php echo $msg ?></strong>
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
      <span class="d-lg-none">Alertas
        <span class="badge badge-pill badge-warning">6 Demandas</span>
      </span>
      <span class="new-indicator text-warning d-none d-lg-block">
        <i class="fa fa-fw fa-circle"></i>
        <span class="number">6</span>
      </span>
    </a>
    
    <div class="dropdown-menu" aria-labelledby="alertsDropdown">
      <h6 class="dropdown-header">Novas demendas:</h6>
    <?php for ($msg = 0; $msg <= 4; $msg++) { ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <strong>Demanda Nº <?php echo $msg ?></strong>
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
  

  
    <a class="nav-link dropdown-toggle mr-lg-2" href="" >
      
    -->


    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle mr-lg-2" href="#" id="alertsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-user"></i> <?php echo $this->session->userdata['empresa']['razao_social']; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="alertsDropdown" style="background-color: #f3e97a;">
            <a class="dropdown-item" href="<?php echo site_url('cadastro'); ?>">
                <strong>Editar Cadastro</strong>
                <div class="dropdown-message small">Clique para fazer alterações no seu cadastro.</div>
            </a>
        </div>
    </li>




    <li class="nav-item">
        <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i> Sair
        </a>
    </li>
</ul>