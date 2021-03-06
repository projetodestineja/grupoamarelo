<script src="<?php echo base_url('assets/pluguins/chart.js/Chart.min.js'); ?>"></script>  





        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">
                  <?php echo $total_geradoras+$total_geradoras_coletoras; ?> <a href="<?php echo site_url('empresa/index/1'); ?>"> Geradoras </a> e <br> <?php echo $total_coletoras+$total_geradoras_coletoras; ?> <a href="<?php echo site_url('empresa/index/2'); ?>">Coletoras </a> cadastradas 
                </div>
              </div>
              <a href="<?php echo site_url('empresa'); ?>" class="card-footer text-white clearfix small z-1">
                <span class="float-left">Ver todas as empresas</span>
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
              <div class="card text-white bg-warning o-hidden h-100" style="background-color: orange">
              <div class="card-body" style="background-color: orange">
                <div class="card-body-icon" style="background-color: orange">
                  <i class="fa fa-fw fa-list"></i>
                </div>
                <div class="mr-5" style="background-color: orange">
                  <?php echo $propostas_recebidas; ?> Propostas recebidas
                </div>
              </div>
              <a href="#" class="card-footer text-white clearfix small z-1" style="background-color: orange">
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
                  <?php echo $empresas_bloqueadas; ?> Empresas bloqueadas
                </div>
              </div>
              <a href="#" class="card-footer text-white clearfix small z-1">
                <span class="float-left"> Ver empresas bloqueadas </span>
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
            Cadastros de Empresas <?php echo date('Y'); ?>
          </div>
          <div class="card-body">
            <canvas id="chart_empresas" width="100%" height="30"></canvas>
          </div>
          <div class="card-footer small text-muted">
           Análise da base de dados Destine Já. <?php echo date('d/m/Y'); ?>
          </div>
        </div>
        
        <!-- Area Chart Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-area-chart"></i>
            Cadastros de Demandas <?php echo date('Y'); ?>
          </div>
          <div class="card-body">
            <canvas id="chart_demandas" width="100%" height="30"></canvas>
          </div>
          <div class="card-footer small text-muted">
           Análise da base de dados Destine Já. <?php echo date('d/m/Y'); ?>
          </div>
        </div>

        
        
        
        
<script>
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var ctx = document.getElementById("chart_empresas");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    datasets: [
    {
      label: "Geradoras",
      data: [<?php echo $gjan;?>, <?php echo $gfev;?>, <?php echo $gmar;?>, <?php echo $gabr;?>, <?php echo $gmai;?>, <?php echo $gjun;?>, <?php echo $gjul;?>, <?php echo $gago;?>, <?php echo $gset;?>, <?php echo $gout;?>, <?php echo $gnov;?>, <?php echo $gdez;?>],
      backgroundColor: "rgba(65,105,225,1)"
    },
    {
      label: "Coletoras",
      data: [<?php echo $cjan;?>, <?php echo $cfev;?>, <?php echo $cmar;?>, <?php echo $cabr;?>, <?php echo $cmai;?>, <?php echo $cjun;?>, <?php echo $cjul;?>, <?php echo $cago;?>, <?php echo $cset;?>, <?php echo $cout;?>, <?php echo $cnov;?>, <?php echo $cdez;?>],
      backgroundColor: "rgba(255,140,0,1)"
    }
    ],
  },
  
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: <?php echo $limite_chart_empresas; ?>,
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: true
    }
  }
});



var ctx = document.getElementById("chart_demandas");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    datasets: [{
      label: "Demandas",
      data: [<?php echo $djan;?>, <?php echo $dfev;?>, <?php echo $dmar;?>, <?php echo $dabr;?>, <?php echo $dmai;?>, <?php echo $djun;?>, <?php echo $djul;?>, <?php echo $dago;?>, <?php echo $dset;?>, <?php echo $dout;?>, <?php echo $dnov;?>, <?php echo $ddez;?>],
      backgroundColor: "rgba(34,139,34,1)",
    },
    {
      label: "Propostas",
      data: [<?php echo $pjan;?>, <?php echo $pfev;?>, <?php echo $pmar;?>, <?php echo $pabr;?>, <?php echo $pmai;?>, <?php echo $pjun;?>, <?php echo $pjul;?>, <?php echo $pago;?>, <?php echo $pset;?>, <?php echo $pout;?>, <?php echo $pnov;?>, <?php echo $pdez;?>],
       backgroundColor: "rgba(200,0,0,1)",
    }
    ],
  },
  
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: <?php echo $limite_chart_demandas; ?>,
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: true
    }
  }
});

</script>        
       