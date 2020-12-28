<?php
if(isset($_GET['usuario'])){
	include_once("php/privadoUsuario.php");
}else{
	include_once("php/privadoPesquisa.php");
}
?>