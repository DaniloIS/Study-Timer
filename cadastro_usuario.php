<?php
	session_start();
	include_once("conexao/conexao.php");
	
	$btnCad = $_POST["btnCad"];
	if ($btnCad){
		$nome = $_POST["nome"];
		$login = $_POST["login"];
		$email = $_POST["email"];
		$senha = $_POST["senha"];
		$confirmaSenha = $_POST["confirmaSenha"];
		if((!empty($login)) or (!empty($email)) or (!empty($senha)) or (!empty($confirmaSenha))){
			if($senha == $confirmaSenha){
				
				$cad = $con -> query("call sp_cadastroUsuario('$nome', '$login', '$email', '$senha');");
				
	
				$row= $cad -> fetch(PDO::FETCH_OBJ);
				
				if(!empty($row->erro)){
					$_SESSION['erro'] = utf8_encode($row->erro);
					header ("Location: index.php");
				}else{
					$_SESSION['msg'] = utf8_encode($row->msg);
					$_SESSION['login'] = $login;
					$_SESSION['senha'] = $senha;
					header ("Location: valida_login.php");
				}
				
			}
			else{
				$_SESSION['erro'] = "As senhas não são iguais!";
				header ("location: index.php");
			}
		}else{
			$_SESSION['erro'] = "Por favor preencha todos os campos corretamente";
			header("Location: index.php");
		}
	}else{
		$_SESSION['erro'] = "Página não encontrada";
		header ("Location: index.php");
	}
?>