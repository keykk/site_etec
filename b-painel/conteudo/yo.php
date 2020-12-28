<?php
if(isset($_GET['action'])){
	
	if($_GET['action'] == "minhapagina"){
		include_once("../php/minhapagina.php");
	}else
		include_once("../php/mydados.php");
}
?>