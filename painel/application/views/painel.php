    
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">
                  <?php echo $total_geradoras+$total_geradoras_coletoras; ?> Geradoras e <br> <?php echo $total_coletoras+$total_geradoras_coletoras; ?> Coletoras cadastradas
                </div>
              </div>
              <a href="<?php echo site_url('empresa'); ?>" class="card-footer text-white clearfix small z-1">
                <span class="float-left">Ver empresas</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-fw fa-shopping-cart"></i>
                </div>
                <div class="mr-5">
                  <?php echo $total_demandas; ?> Demandas cadastradas
                </div>
              </div>
              <a href="<?php echo site_url('demandas'); ?>" class="card-footer text-white clearfix small z-1">
                <span class="float-left">Ver demandas</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-fw fa-list"></i>
                </div>
                <div class="mr-5">
                  X Propostas recebidas
                </div>
              </div>
              <a href="#" class="card-footer text-white clearfix small z-1">
                <span class="float-left">Ver propostas</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-fw fa-support"></i>
                </div>
                <div class="mr-5">
                  <?php echo $demandas_aguardando; ?> Demandas aguardando liberação
                </div>
              </div>
              <a href="#" class="card-footer text-white clearfix small z-1">
                <span class="float-left"><?php echo $empresas_bloqueadas; ?> empresas bloqueadas  </span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
        </div>

        <!-- Area Chart Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-area-chart"></i>
            Novos Cadastros
          </div>
          <div class="card-body">
            <canvas id="myAreaChart" width="100%" height="30"></canvas>
          </div>
          <div class="card-footer small text-muted">
           Última atualização 10/09/17 11:59h
          </div>
        </div>

        <div class="row">

          <div class="col-lg-8">

            <!-- Example Bar Chart Card -->
            <div class="card mb-3">
              <div class="card-header">
                <i class="fa fa-bar-chart"></i>
                Painel Financeiro
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-8 my-auto">
                    <canvas id="myBarChart" width="100" height="50"></canvas>
                  </div>
                  <div class="col-sm-4 text-center my-auto">
                    <div class="h4 mb-0 text-primary">R$ 20.000,00</div>
                    <div class="small text-muted">Previsão</div>
                    <hr>
                    <div class="h4 mb-0 text-warning">R$ 50.000,00</div>
                    <div class="small text-muted">Em Andamento</div>
                    <hr>
                    <div class="h4 mb-0 text-success">R$ 150.000,00</div>
                    <div class="small text-muted">Concluido</div>
                  </div>
                </div>
              </div>
              <div class="card-footer small text-muted">
                Última atualização 02/10/17 11:59h
              </div>
            </div>

            <!-- Card Columns Example Social Feed -->
            <div class="mb-0 mt-4">
              <i class="fa fa-newspaper-o"></i>
              Últimas Demandas</div>
            <hr class="mt-2">
            <div class="card-columns">

              <!-- Example Social Card -->
              <div class="card mb-3">
                <a href="#">
                  <img class="card-img-top img-fluid w-100" src="https://unsplash.it/700/450?image=610" alt="">
                </a>
                <div class="card-body">
                  <h6 class="card-title mb-1">
                    <a href="#">João da Silva LTDA</a>
                  </h6>
                  <p class="card-text small">Remover Poluição da Praia
                  </p>
                </div>
                <hr class="my-0">
                <!--<div class="card-body py-2 small">
                  <a class="mr-3 d-inline-block" href="#">
                    <i class="fa fa-fw fa-thumbs-up"></i>
                    Like
                  </a>
                  <a class="mr-3 d-inline-block" href="#">
                    <i class="fa fa-fw fa-comment"></i>
                    Comment
                  </a>
                  <a class="d-inline-block" href="#">
                    <i class="fa fa-fw fa-share"></i>
                    Share
                  </a>
                </div>
                <hr class="my-0">-->
                <div class="card-body small bg-faded">
                  <div class="media">
                    <img class="d-flex mr-3" src="https://placehold.it/45x45" alt="">
                    <div class="media-body">
                      <h6 class="mt-0 mb-1">
                        <a href="#">Destine Já</a>
                      </h6>
                      Não atendemos esse tipo de demanda.
                      <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                          <a href="#">Responder</a>
                        </li>
                      </ul>
                      <div class="media mt-3">
                        <a class="d-flex pr-3" href="#">
                          <img src="https://placehold.it/45x45" alt="">
                        </a>
                        <div class="media-body">
                          <h6 class="mt-0 mb-1">
                            <a href="#">João da Silva LTDA</a>
                          </h6>
                          Onde consigo resolver isso?
                          <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                              <a href="#">Responder</a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer small text-muted">
                  Publicado a 32 minutos
                </div>
              </div>

              <!-- Example Social Card -->
              <div class="card mb-3">
                <a href="#">
                  <img class="card-img-top img-fluid w-100" src="https://unsplash.it/700/450?image=180" alt="">
                </a>
                <div class="card-body">
                  <h6 class="card-title mb-1">
                    <a href="#">Empresa do Manuel</a>
                  </h6>
                  <p class="card-text small">Computadores quebrados...
                  </p>
                </div>
                <hr class="my-0">
                <div class="card-body py-2 small">
                 
                  <a class="mr-3 d-inline-block" href="#">
                    <i class="fa fa-fw fa-comment"></i>
                    Comentar
                  </a>
                  
                </div>
                <hr class="my-0">
                <div class="card-body small bg-faded">
                  <div class="media">
                    <img class="d-flex mr-3" src="https://placehold.it/45x45" alt="">
                    <div class="media-body">
                      <h6 class="mt-0 mb-1">
                        <a href="#">Destine Já</a>
                      </h6>
                      Remova o telefone visivel na foto
                      <ul class="list-inline mb-0">
                       
                       
                        <li class="list-inline-item">
                          <a href="#">Responder</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-footer small text-muted">
                 Publicado a 50 minutos
                </div>
              </div>

              <!-- Example Social Card -->
              <div class="card mb-3">
                <a href="#">
                  <img class="card-img-top img-fluid w-100" src="https://unsplash.it/700/450?image=281" alt="">
                </a>
                <div class="card-body">
                  <h6 class="card-title mb-1">
                    <a href="#">Lorenge Construtora LTDA</a>
                  </h6>
                  <p class="card-text small">Recolher entulho!</p>
                </div>
                <hr class="my-0">
                <div class="card-body py-2 small">
                  <a class="mr-3 d-inline-block" href="#">
                    <i class="fa fa-fw fa-comment"></i>
                    Comentar
                  </a>
                </div>
                <div class="card-footer small text-muted">
                  Publicado em 1 de Agosto de 2017
                </div>
              </div>

              <!-- Example Social Card -->
              <div class="card mb-3">
                <a href="#">
                  <img class="card-img-top img-fluid w-100" src="https://unsplash.it/700/450?image=185" alt="">
                </a>
                <div class="card-body">
                  <h6 class="card-title mb-1">
                    <a href="#">João da Silva LTDA</a>
                  </h6>
                  <p class="card-text small">Capinar no deserto...
                  </p>
                </div>
                <hr class="my-0">
                <div class="card-body py-2 small">
                  <a class="mr-3 d-inline-block" href="#">
                    <i class="fa fa-fw fa-comment"></i>
                    Comentar
                  </a>
                </div>
                <hr class="my-0">
                <div class="card-body small bg-faded">
                  <div class="media">
                    <img class="d-flex mr-3" src="https://placehold.it/45x45" alt="">
                    <div class="media-body">
                      <h6 class="mt-0 mb-1">
                        <a href="#">Destine Já</a>
                      </h6>
                      Proibido fazer piadas
                      <ul class="list-inline mb-0">
                       
                        <li class="list-inline-item">
                          ·
                        </li>
                        <li class="list-inline-item">
                          <a href="#">Responder</a>
                        </li>
                      </ul>
                      <div class="media mt-3">
                        <a class="d-flex pr-3" href="#">
                          <img src="https://placehold.it/45x45" alt="">
                        </a>
                        <div class="media-body">
                          <h6 class="mt-0 mb-1">
                            <a href="#">João da Silva LTDA</a>
                          </h6>
                          kkkkkk
                          <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                              <a href="#">Responder</a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer small text-muted">
                 Atualizado em 15/05/17 15:00h
                </div>
              </div>

            </div>
            <!-- /Card Columns -->

          </div>

          <div class="col-lg-4">
          
          
            <!-- Example Pie Chart Card -->
            <div class="card mb-3">
              <div class="card-header">
                <i class="fa fa-pie-chart"></i>
                Demandas Recebidas
              </div>
              <div class="card-body">
                <canvas id="myPieChart" width="100%" height="100"></canvas>
              </div>
              <div class="card-footer small text-muted">
                Última atualização 08/09/17 11:59h
              </div>
            </div>
            
            
            
            <!-- Example Notifications Card -->
            <div class="card mb-3">
              <div class="card-header">
                <i class="fa fa-bell-o"></i>
                 Últimas Atividades
              </div>
              <div class="list-group list-group-flush small">
                <a href="#" class="list-group-item list-group-item-action">
                  <div class="media">
                    <img class="d-flex mr-3 rounded-circle" src="https://placehold.it/45x45" alt="">
                    <div class="media-body">
                      <strong>João da Silva LTDA</strong>
                      Fechou uma demanda com 
                      <strong>João da Silva LTDA</strong>.
                      <div class="text-muted smaller">15:43h</div>
                    </div>
                  </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                  <div class="media">
                    <img class="d-flex mr-3 rounded-circle" src="https://placehold.it/45x45" alt="">
                    <div class="media-body">
                      <strong>Samantha King</strong>
                      Enviou uma mensagem para destine já
                      <div class="text-muted smaller">14:00h</div>
                    </div>
                  </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                  <div class="media">
                    <img class="d-flex mr-3 rounded-circle" src="https://placehold.it/45x45" alt="">
                    <div class="media-body">
                      <strong>Lorenge Construtora LTDA</strong>
                      Reve uma imagem bloqueada pelo administrador
                      <strong>Beach</strong>.
                      <div class="text-muted smaller">11:55h</div>
                    </div>
                  </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                  <div class="media">
                    <img class="d-flex mr-3 rounded-circle" src="https://placehold.it/45x45" alt="">
                    <div class="media-body">
                      <i class="fa fa-code-fork"></i>
                      <strong>Mônica Silva</strong>
                     Efetuou login no painel
                  
                      <div class="text-muted smaller">10/09/17 15:00h</div>
                    </div>
                  </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                 Ver Mais Atividades
                </a>
              </div>
              <div class="card-footer small text-muted">
                Última atualização 18:00h
              </div>
            </div>
          </div>
        </div>

       