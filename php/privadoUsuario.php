<?php
$apelido = trataValor(urldecode($_GET['usuario']));

if(preg_match("/^\w.{3,80}$/", $apelido)){
	$selecionaPagina = $connnect->prepare("SELECT * FROM etec_usuario WHERE u_apelido = ?");
	$selecionaPagina->execute(array($apelido));
	
	if($selecionaPagina->rowCount() == 1){
		$paginaObjeto = $selecionaPagina->fetch(PDO::FETCH_OBJ);
		echo $paginaObjeto->u_pagina;
		echo "<br /><p align='right'><i>{$paginaObjeto->u_nome}</i></p>";
	}
}
?>