<?php
session_start();
include_once("../../cnf/config.php");
if(isset($_POST['id']) && isset($_SESSION['etec_login'])){
	$cod = (int) $_POST['id'];
	$query = $connnect->query("SELECT * FROM etec_privilegio WHERE p_codigo = $cod");
	if($query->rowCount() == 1){
		$objdesc = $query->fetch(PDO::FETCH_OBJ);
		echo $objdesc->p_etc;
	}
}else if(isset($_POST['group']) && isset($_SESSION['etec_login'])){
	$key = (int) $_POST['group'];
	
	$query = $connnect->query("SELECT * FROM etec_grupo g JOIN etec_privilegio p ON g.g_privilegio = p.p_codigo WHERE g.g_codigo = $key");
	
	if($query->rowCount() == 1){
		$objgrupo = $query->fetch(PDO::FETCH_OBJ);
		
		echo $objgrupo->p_etc;
		
	}else
		echo "Grupo selecionado invalido";
}
?>