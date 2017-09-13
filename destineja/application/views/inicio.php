<?php
defined('BASEPATH') OR exit('No direct script access allowed'); //teste
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>

<html lang="pt-br">
	
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/css.css') ?>">
		<title><?php echo $titulo; ?></title>
	</head>

	<body>
		
		<div class="container-fluid">
			<center>
				<div class="row">
					<div class="col-sm-12">
						<div style="width:230px; margin:0 auto;"><img width="230px" src="<?php echo base_url('assets/img/destinejalogo.png') ?>"/></div><br/>
						<h1>Efetue seu cadastro:</h1><br/>
						<a href="<?php echo site_url('destineja/gerador') ?>"><button type="button" class="btn btn-success btn-lg">Gerador de Resíduo</button><br/><br/></a>
						<a href="<?php echo site_url('destineja/coletor') ?>"><button type="button" class="btn btn-success btn-lg">Coletor de Resíduo</button></a>
					</div>
				</div>
			</center>
		</div>
	
	</body>

	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>

</html>	