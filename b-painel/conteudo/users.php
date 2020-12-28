<?php
if($userDado->pri >= 10){
if(isset($_GET['action']) && $_GET['action'] == "criar"){
include_once("../php/criacao_usuario.php");
}
}else
	echo "Acesso Negado";
?>