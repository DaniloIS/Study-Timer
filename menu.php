<!--==========================
    Header
  ============================-->
  <header id="header" class="header-fixed">
    <div class="container">

      <div id="logo" class="pull-left">
        <!-- Uncomment below if you prefer to use a text logo -->
        <!-- <h1><a href="#main">C<span>o</span>nf</a></h1>-->
        <a href="index.php#intro" class="scrollto"><img src="img/logo.png" alt="" title=""></a>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="index.php#intro"><i class="fa fa-home" aria-hidden="true"></i>&nbsp Home</a></li>
          <!--<li><a href="index.php#about"><i class="fa fa-calendar-check-o" aria-hidden="true"></i>&nbsp Tarefa</a></li>
          <li><a href="index.php#speakers">Speakers</a></li>-->
          <li><a href="index.php#schedule"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp  Cronograma</a></li>
          <!--<li><a href="index.php#venue">Venue</a></li>
          <li><a href="index.php#hotels">Hotels</a></li>
          <li><a href="index.php#gallery">Gallery</a></li>
          <li><a href="index.php#supporters">supporters</a></li>>-->
          <li><a href="index.php#contact"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp Contato</a></li>
          <?php if(isset($_SESSION['log'])){ ?>
				<div class="d-flex">
				  <div class="btn-group">
					<button type="button" class="btn-dropdown dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
					  <?php echo $_SESSION['nm_login']; ?>
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
					  <a class="dropdown-item" href="conta.php"><i class="fa fa-user" aria-hidden="true"></i>&nbsp Conta</a>
					  <a class="dropdown-item" href="status.php"><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp Status</a>
					  <a class="dropdown-item" href="sair.php"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp Sair</a>
					</div>
				  </div>
				</div>
			<?php }else{ ?>
			<li class="buy-tickets"><a href="#" data-toggle="modal" data-target="#login-modal" data-ticket-type="premium-access">Login/Cadastro</a></li>
			<?php } ?>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->