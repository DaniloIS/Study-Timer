<?php
	include('protect.php');
		protect();
		
	include_once("conexao/conexao.php");
	session_start();
	$codigo = $_SESSION['cd_usuario'];
	$nome = $_SESSION['nm_usuario'];
	$login = $_SESSION['nm_login'];
	$email = $_SESSION['nm_email'];
	
	$rs = $con -> query(" select * from tb_usuario where cd_usuario = '$codigo';");
	
	$row= $rs -> fetch(PDO::FETCH_OBJ);
	$_SESSION['cd_senha'] = $row->cd_senha;
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
      Conta
    ============================-->
    <section id="speakers-details" class="wow fadeIn">
      <div class="container" style="max-width:350px;">
        <div class="section-header">
          <h2>Conta</h2>
        </div>

        <div >
		   <label for="nome">Nome</label>
            <input readonly="true" type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $nome;?>" required />
			<label for="login">Login</label>
			<input readonly="true" type="text" class="form-control" name="login" placeholder="Login" value="<?php echo $login;?>" required />
			<label for="usuario">E-mail</label>
			<input readonly="true" type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $email;?>" required />
			<label for="senha">Senha</label>
			<input readonly="true" type="password" class="form-control" name="senha" placeholder="Senha" value="<?php echo $_SESSION['cd_senha'];?>" required />
			<br />
			<center>
			<a href="alterar_usuario.php"  name='Alterar' value='Alterar' class='btn btn-success' />Alterar</a>
		  <a href="excluir_usuario.php"  name='Excluir' value='Excluir' class='btn btn-danger' />Excluir</a>
            </center>
        </div>
          
        </div>
      </div>

    </section>

  </main>


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