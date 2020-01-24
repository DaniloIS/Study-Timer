<?php
	session_start();
	include('protect.php');
		protect();
	
	
	include_once("conexao/conexao.php");
	$codigo = $_SESSION['cd_usuario'];
	$cdPlan = $_POST['cdPlan'];
	
	$delTarefa = $con -> query("delete from tb_planejamento where cd_usuario = $codigo and cd_planejamento = $cdPlan;");
	
?>
<script>location.href='index.php';</script>