    <ul class="navbar-nav navbar-sidenav menu-vertical-principal" id="exampleAccordion">
         
        <li class="nav-item menu-v-painel <?php echo ($this->uri->segment(1)==''?'active':''); ?>" data-toggle="tooltip" data-placement="right" title="Painel Administrativo">
            <a class="nav-link" href="<?php echo site_url('painel'); ?>" >
              <i class="fa fa-fw fa-dashboard"></i> <span class="nav-link-text">Painel</span>
            </a>
        </li>
        <li class="nav-item menu-v-empresas" data-toggle="tooltip" data-placement="right" title="Empresas">
            <a class="nav-link nav-link-collapse collapsed " data-toggle="collapse" href="#collapseEmpresas" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-building"></i> <span class="nav-link-text">Empresas</span>
            </a>
            <ul class="sidenav-second-level collapse" id="collapseEmpresas">
              <li><a href="static-nav.html">Geradoras</a></li>
              <li><a href="#">Coletoras</a></li>
              <li><a href="#">Consultores</a></li>
            </ul>
        </li>
	<li class="nav-item menu-v-demandas" data-toggle="tooltip" data-placement="right" title="Demandas">
            <a class="nav-link" href="#">
              <i class="fa fa-fw fa-list"></i> <span class="nav-link-text">Demandas</span>
            </a>
        </li>
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
    </ul>
        
        
        
        <ul class="navbar-nav sidenav-toggler">
          <li class="nav-item">
            <a class="nav-link text-center" id="sidenavToggler" rel="menu-vertital-painel" >
              <i class="fa fa-fw fa-angle-left"></i>
            </a>
          </li>
        </ul>
        
        
        
        
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle mr-lg-2" href="#" id="messagesDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-fw fa-envelope"></i>
              <span class="d-lg-none">Messages
                <span class="badge badge-pill badge-primary">12 New</span>
              </span>
              <span class="new-indicator text-primary d-none d-lg-block">
                <i class="fa fa-fw fa-circle"></i>
                <span class="number">12</span>
              </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="messagesDropdown">
              <h6 class="dropdown-header">New Messages:</h6>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <strong>David Miller</strong>
                <span class="small float-right text-muted">11:21 AM</span>
                <div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <strong>Jane Smith</strong>
                <span class="small float-right text-muted">11:21 AM</span>
                <div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00 instead of 4:00. Thanks!</div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <strong>John Doe</strong>
                <span class="small float-right text-muted">11:21 AM</span>
                <div class="dropdown-message small">I've sent the final files over to you for review. When you're able to sign off of them let me know and we can discuss distribution.</div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item small" href="#">
                View all messages
              </a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle mr-lg-2" href="#" id="alertsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-fw fa-bell"></i>
              <span class="d-lg-none">Alerts
                <span class="badge badge-pill badge-warning">6 New</span>
              </span>
              <span class="new-indicator text-warning d-none d-lg-block">
                <i class="fa fa-fw fa-circle"></i>
                <span class="number">6</span>
              </span>
            </a>
            
            <div class="dropdown-menu" aria-labelledby="alertsDropdown">
              <h6 class="dropdown-header">New Alerts:</h6>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <span class="text-success">
                  <strong>
                    <i class="fa fa-long-arrow-up"></i>
                    Status Update</strong>
                </span>
                <span class="small float-right text-muted">11:21 AM</span>
                <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <span class="text-danger">
                  <strong>
                    <i class="fa fa-long-arrow-down"></i>
                    Status Update</strong>
                </span>
                <span class="small float-right text-muted">11:21 AM</span>
                <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <span class="text-success">
                  <strong>
                    <i class="fa fa-long-arrow-up"></i>
                    Status Update</strong>
                </span>
                <span class="small float-right text-muted">11:21 AM</span>
                <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item small" href="#">
                View all alerts
              </a>
            </div>
          </li>
          
         
          <li class="nav-item" >
            <a class="nav-link dropdown-toggle mr-lg-2" href="<?php echo site_url('usuarios'); ?>" >
              <i class="fa fa-fw fa-user"></i>
            </a>
          </li>
          
          
          <li class="nav-item">
              <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
              	<i class="fa fa-fw fa-sign-out"></i>Sair
              </a>
          </li>
        </ul>