<?php
	include_once("conexao/conexao.php");
	session_start();
	$codigo = $_SESSION['cd_usuario'];
	$nome = $_SESSION['nm_usuario'];
	$login = $_SESSION['nm_login'];
	$email = $_SESSION['nm_email'];
	$senha = $_SESSION['cd_senha'];
	
	if(isset($_POST['ok'])){
	
		$nome = $_POST['nome'];
		$novoLogin = $_POST['login'];
		$novoEmail = $_POST['email'];
		$senha = $_POST['senha'];
	
		$rs = $con -> query("call sp_alteraUsuario($codigo, '$nome', '$login', '$novoLogin', '$email', '$novoEmail', '$senha');");
		
		$row= $rs -> fetch(PDO::FETCH_OBJ);
		
		if(!empty($row->erro)){
			echo $row->erro;
		}else{
			
			$_SESSION['nm_usuario'] = $nome;
			$_SESSION['nm_login'] = $novoLogin;
			$_SESSION['nm_email'] = $novoEmail;
			$_SESSION['cd_senha'] = $senha;
			?><script>location.href='index.php';</script><?php
		}
	}
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

  <!-- =======================================================
    Theme Name: TheEvent
    Theme URL: https://bootstrapmade.com/theevent-conference-event-bootstrap-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
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
		  <p>Alterar</p>
        </div>

        <div>
		  <form action="" method="POST" class="form-signin">
		   <label for="nome">Nome</label>
            <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $nome;?>" required />
			<label for="login">Login</label>
			<input type="text" class="form-control" name="login" placeholder="Login" value="<?php echo $login;?>" required />
			<label for="usuario">E-mail</label>
			<input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $email;?>" required />
			<label for="senha">Senha</label>
			<input type="password" class="form-control" name="senha" placeholder="Senha" value="<?php echo $_SESSION['cd_senha'];?>" required />
			<br />
			<center>
			<input name="ok" value="Enviar" type="submit" class='btn btn-success'>
			<a href="conta.php" class='btn btn-danger' style="colot:#fff">Cancelar</a>
			</center>
			</form>
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