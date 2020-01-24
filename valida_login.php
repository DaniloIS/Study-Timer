<?php
	session_start();
	include('protect.php');
		protect();
	
	
	include_once('conexao/conexao.php');
	if(isset($_SESSION['login']) && isset($_SESSION['senha'])){
		$login = $_SESSION['login'];
		$senha = $_SESSION['senha'];
		
		$log = $con -> query("call sp_loginUsuario('$login', '$senha');");
				
				
				
		$row= $log -> fetch(PDO::FETCH_OBJ);
		
		if(!empty($row->erro)){
			echo "<script>alert'".$row->erro."';</script>";
		}else{
			
			$_SESSION['cd_usuario'] = $row->cd_usuario;
			$_SESSION['nm_usuario'] = $row->nm_usuario;
			$_SESSION['nm_login'] = $row->nm_login;
			$_SESSION['nm_email'] = $row->nm_email;
			$_SESSION['log'] = 'ativo';		
			
			unset($_SESSION['login']);
			unset($_SESSION['senha']);
			
			header("location:index.php");
		}
	}else{
		$btnLogin = $_POST["btnLogin"];
		if ($btnLogin){
			$login = $_POST["login"];
			$senha = $_POST["senha"];
			if((!empty($login)) and (!empty($senha))){
				
				$log = $con -> query("call sp_loginUsuario('$login', '$senha');");
				
				
				
				$row= $log -> fetch(PDO::FETCH_OBJ);
				
				if(!empty($row->erro)){
					$_SESSION['erro'] = utf8_encode($row->erro);
				}else{
					
					$_SESSION['cd_usuario'] = $row->cd_usuario;
					$_SESSION['nm_usuario'] = $row->nm_usuario;
					$_SESSION['nm_login'] = $row->nm_login;
					$_SESSION['nm_email'] = $row->nm_email;
					$_SESSION['log'] = 'ativo';		
					
					header("location:notificacao.php");
				}
				
			}else{
				$_SESSION['erro'] = "Usuário e senha incorreto!";
				header("Location: index.php");
			}
		}else{
			$_SESSION['erro'] = "Página não encontrada";
			header ("Location: index.php");
		}
	}
?>
