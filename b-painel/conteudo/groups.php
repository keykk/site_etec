<script>
function hrefe(loc){
	location.href = loc;
}
</script>
<?php
if($userDado->pri >= 10){
if(isset($_GET['action']) && $_GET['action'] == "criar"){
	include_once("../php/criacao_grupos.php");
}else if(isset($_GET['action']) && (int)$_GET['action'] > 0){
	include_once("../php/altera_grupo.php");
}else if(isset($_GET['action']) && $_GET['action'] == "todos"){
	include_once("../php/detalhado_grupos.php");
}
}else
	echo "Acesso Negado";
?>