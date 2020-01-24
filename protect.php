<?php
	if(!function_exists("protect")){
		
		function protect(){
			
			if(!isset($_SESSION))
				session_start();
			
			if(!isset($_SESSION['cd_usuario']) || !is_numeric($_SESSION['cd_usuario'])){
				header("Location: index.php");
			}
		}
	}
?>