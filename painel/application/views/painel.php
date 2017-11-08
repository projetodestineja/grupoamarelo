<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>    
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
            Cadastros de Empresas <?php echo date('Y'); ?>
          </div>
          <div class="card-body">
            <canvas id="grafico_geral" width="100%" height="30"></canvas>
          </div>
          <div class="card-footer small text-muted">
           Análise da base de dados Destine Já. <?php echo date('d/m/Y'); ?>
          </div>
        </div>

        
        
        
        
<script>
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var ctx = document.getElementById("grafico_geral");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    datasets: [{
      label: "Geradoras",
      lineTension: 0.1,
      backgroundColor: "rgba(2,117,216,0)",
      borderColor: "rgba(2,117,0,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,0,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,0,1)",
      pointHitRadius: 20,
      pointBorderWidth: 2,
      data: [<?php echo $gjan;?>, <?php echo $gfev;?>, <?php echo $gmar;?>, <?php echo $gabr;?>, <?php echo $gmai;?>, <?php echo $gjun;?>, <?php echo $gjul;?>, <?php echo $gago;?>, <?php echo $gset;?>, <?php echo $gout;?>, <?php echo $gnov;?>, <?php echo $gdez;?>],
    },
    {
      label: "Coletoras",
      lineTension: 0.1,
      backgroundColor: "rgba(200,117,10,0)",
      borderColor: "rgba(200,117,10,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(200,117,10,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(200,117,10,1)",
      pointHitRadius: 20,
      pointBorderWidth: 2,
      data: [<?php echo $cjan;?>, <?php echo $cfev;?>, <?php echo $cmar;?>, <?php echo $cabr;?>, <?php echo $cmai;?>, <?php echo $cjun;?>, <?php echo $cjul;?>, <?php echo $cago;?>, <?php echo $cset;?>, <?php echo $cout;?>, <?php echo $cnov;?>, <?php echo $cdez;?>],
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
          max: <?php echo $limite_chart; ?>,
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


new Chart(document.getElementById("line-chart"), {
  type: 'line',
  data: {
    labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
    datasets: [{ 
        data: [86,114,106,106,107,111,133,221,783,2478],
        label: "Africa",
        borderColor: "#3e95cd",
        fill: false
      }, { 
        data: [282,350,411,502,635,809,947,1402,3700,5267],
        label: "Asia",
        borderColor: "#8e5ea2",
        fill: false
      }, { 
        data: [168,170,178,190,203,276,408,547,675,734],
        label: "Europe",
        borderColor: "#3cba9f",
        fill: false
      }, { 
        data: [40,20,10,16,24,38,74,167,508,784],
        label: "Latin America",
        borderColor: "#e8c3b9",
        fill: false
      }, { 
        data: [6,3,2,2,7,26,82,172,312,433],
        label: "North America",
        borderColor: "#c45850",
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: true,
      text: 'World population per region (in millions)'
    }
  }
});
</script>        
       