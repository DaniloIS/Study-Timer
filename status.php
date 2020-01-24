<?php
	session_start();
	include('protect.php');
		protect();
	
	include_once("conexao/conexao.php"); 
	
	
	$codigo = $_SESSION['cd_usuario'];
	
	$semana = $con -> query("select tb_materia.nm_materia, date_format(dt_registro_tempo, '%d/%m/%Y') as dt_registro_tempo, hr_registro_tempo, hr_tempo, qt_pomodoro FROM tb_registro_tempo JOIN tb_usuario ON tb_registro_tempo.cd_usuario = $codigo and tb_usuario.cd_usuario = $codigo join tb_materia on tb_materia.cd_materia = tb_registro_tempo.cd_materia where dt_registro_tempo >= (curdate()-7) and dt_registro_tempo <= (curdate())
	union
	select tb_outra_materia.nm_outra_materia, date_format(dt_registro_tempo, '%d/%m/%Y') as dt_registro_tempo, hr_registro_tempo, hr_tempo, qt_pomodoro FROM tb_registro_tempo JOIN tb_usuario ON tb_registro_tempo.cd_usuario = $codigo and tb_usuario.cd_usuario = $codigo join tb_outra_materia on tb_outra_materia.cd_outra_materia = tb_registro_tempo.cd_outra_materia and dt_registro_tempo >= (curdate()-7) and dt_registro_tempo <= (curdate()) order by day(dt_registro_tempo) desc , month(dt_registro_tempo) desc;");
	
	$mes = $con -> query("select tb_materia.nm_materia, date_format(dt_registro_tempo, '%d/%m/%Y') as dt_registro_tempo, hr_registro_tempo, hr_tempo, qt_pomodoro FROM tb_registro_tempo JOIN tb_usuario ON tb_registro_tempo.cd_usuario = $codigo and tb_usuario.cd_usuario = $codigo join tb_materia on tb_materia.cd_materia = tb_registro_tempo.cd_materia where month(tb_registro_tempo.dt_registro_tempo) = month(curdate())
	union
	select tb_outra_materia.nm_outra_materia, date_format(dt_registro_tempo, '%d/%m/%Y') as dt_registro_tempo, hr_registro_tempo, hr_tempo, qt_pomodoro FROM tb_registro_tempo JOIN tb_usuario ON tb_registro_tempo.cd_usuario = $codigo and tb_usuario.cd_usuario = $codigo join tb_outra_materia on tb_outra_materia.cd_outra_materia = tb_registro_tempo.cd_outra_materia and month(tb_registro_tempo.dt_registro_tempo) = month(curdate()) order by day(dt_registro_tempo) desc , month(dt_registro_tempo) desc;");
	
	$geral = $con -> query("select tb_materia.nm_materia, date_format(dt_registro_tempo, '%d/%m/%Y') as dt_registro_tempo, hr_registro_tempo, hr_tempo, qt_pomodoro FROM tb_registro_tempo JOIN tb_usuario ON tb_registro_tempo.cd_usuario = $codigo and tb_usuario.cd_usuario = $codigo join tb_materia on tb_materia.cd_materia = tb_registro_tempo.cd_materia
	union
	select tb_outra_materia.nm_outra_materia, date_format(dt_registro_tempo, '%d/%m/%Y') as dt_registro_tempo, hr_registro_tempo, hr_tempo, qt_pomodoro FROM tb_registro_tempo JOIN tb_usuario ON tb_registro_tempo.cd_usuario = $codigo and tb_usuario.cd_usuario = $codigo join tb_outra_materia on tb_outra_materia.cd_outra_materia = tb_registro_tempo.cd_outra_materia order by day(dt_registro_tempo) , month(dt_registro_tempo) desc;");
?>
<html lang="pt_br">
<head>
  <meta charset="utf-8">
  <title>Study Timer</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/icon.png" rel="icon">
  <link href="img/icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/venobox/venobox.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">

</head>

<body>

  <?php include_once('menu.php'); ?>

  <main id="main" class="main-page">
<!--==========================
	Status Section
============================-->
<section id="status" class="section-with-bg">
	<div class="container wow fadeInUp">
		<div class="section-header">
			<h2>Status</h2>
			<p>Aqui está o seu histórico de atividades</p>
		</div>

		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" href="#semana" role="tab" data-toggle="tab">Semana</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#mes" role="tab" data-toggle="tab">Mês</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#geral" role="tab" data-toggle="tab">Geral</a>
			</li>
		</ul>

		<div class="tab-content row justify-content-center">

			<!-- Status Semana -->
			<div role="tabpanel" class="col-lg-9 tab-pane fade show active" id="semana">
				<div class="limiter">
					<div class="container-table100">
						<div class="wrap-table100">
							<div class="table100">
								<table>
									<thead>
										<tr class="table100-head">
											<th class="column1">Data</th>
											<th class="column2">Hora</th>
											<th class="column3">Tempo</th>
											<th class="column4">Pomodoro</th>
											<th class="column5">Materia</th>
										</tr>
									</thead>
									<tbody>
										<?php
											while($listSemana= $semana -> fetch(PDO::FETCH_OBJ)){
										?>
											<tr>
												<td class="column1"><?php echo $listSemana->dt_registro_tempo; ?>&nbsp </td>
												<td class="column2"><?php echo $listSemana->hr_registro_tempo; ?>&nbsp </td>
												<td class="column3"><?php echo $listSemana->hr_tempo; ?>&nbsp </td>
												<td class="column4"><?php echo $listSemana->qt_pomodoro; ?>&nbsp </td>
												<td class="column5"><?php echo utf8_encode($listSemana->nm_materia); ?>&nbsp </td>
											</tr>
										<?php
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Status Semana -->

			<!-- Status Mês -->
			<div role="tabpanel" class="col-lg-9  tab-pane fade" id="mes">
				<div class="limiter">
					<div class="container-table100">
						<div class="wrap-table100">
							<div class="table100">
								<table>
									<thead>
										<tr class="table100-head">
											<th class="column1">Data</th>
											<th class="column2">Hora</th>
											<th class="column3">Tempo</th>
											<th class="column4">Pomodoro</th>
											<th class="column5">Materia</th>
										</tr>
									</thead>
									<tbody>
										<?php
											while($listMes= $mes -> fetch(PDO::FETCH_OBJ)){
										?>
											<tr>
												<td class="column1"><?php echo $listMes->dt_registro_tempo; ?>&nbsp </td>
												<td class="column2"><?php echo $listMes->hr_registro_tempo; ?>&nbsp </td>
												<td class="column3"><?php echo $listMes->hr_tempo; ?>&nbsp </td>
												<td class="column4"><?php echo $listMes->qt_pomodoro; ?>&nbsp </td>
												<td class="column5"><?php echo utf8_encode($listMes->nm_materia); ?>&nbsp </td>
											</tr>
										<?php
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Status Mês -->

			<!-- Status Geral -->
			<div role="tabpanel" class="col-lg-9  tab-pane fade" id="geral">
				<div class="limiter">
					<div class="container-table100">
						<div class="wrap-table100">
							<div class="table100">
								<table>
									<thead>
										<tr class="table100-head">
											<th class="column1">Data</th>
											<th class="column2">Hora</th>
											<th class="column3">Tempo</th>
											<th class="column4">Pomodoro</th>
											<th class="column5">Materia</th>
										</tr>
									</thead>
									<tbody>
										<?php
											while($listGeral= $geral -> fetch(PDO::FETCH_OBJ)){
										?>
											<tr>
												<td class="column1"><?php echo $listGeral->dt_registro_tempo; ?>&nbsp </td>
												<td class="column2"><?php echo $listGeral->hr_registro_tempo; ?>&nbsp </td>
												<td class="column3"><?php echo $listGeral->hr_tempo; ?>&nbsp </td>
												<td class="column4"><?php echo $listGeral->qt_pomodoro; ?>&nbsp </td>
												<td class="column5"><?php echo utf8_encode($listGeral->nm_materia); ?>&nbsp </td>
											</tr>
										<?php
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Status Geral -->
			
		
		</div>
</section>
<?php include_once('footer.php'); ?>

  <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/jquery/jquery-migrate.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/superfish/hoverIntent.js"></script>
  <script src="lib/superfish/superfish.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/venobox/venobox.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>

  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>
</body>

</html>