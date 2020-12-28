<?php
$linkk = "";
		
		if(isset($_GET['pagina']) && $_GET['pagina'] == "public"){
			$linkk = "public";
		}else
			$linkk = "b-painel/inicial.php?b-pagina=conteudo";
//paginacao
define("TOTAL",5);
if(isset($_GET['pp'])){
	$pagina = (int)$_GET['pp'];
}else{
	$pagina = 1;
}

$celectAll = $connect->query("SELECT * FROM etec_pagina");

$contagemdeLinhas = $celectAll->rowCount();
$numP = ceil($contagemdeLinhas / TOTAL);
if($pagina > $numP){
	$pagina = 1;
}
				
if($pagina <= 0){
	$pagina = 1;
}
$inicio = $pagina - 1;
$inicio = $inicio * TOTAL;
//Paginacao\\

$query = $connect->query("SELECT * FROM etec_pagina LIMIT $inicio,".TOTAL);

if($query->rowCount() > 0){
	while($obj_p = $query->fetch(PDO::FETCH_OBJ)){
		$paginas->pagina_dados($obj_p->pa_codigo,$raiz);
		echo "<fieldset>
			<legend>{$paginas->titulo}</legend>
			<strong>Autor: </strong>{$paginas->criacao}<br />
			<strong>Utimo editor: </strong>{$paginas->editor}<br />
			<strong>Data de criação: </strong>{$paginas->data}<br />
			<strong>Utima Atualização: </strong>{$paginas->edicao}<br />
			";
			if(isset($_SESSION['etec_login']) && isset($_SESSION['etec_pass'])){
				if($userDado->pri >= 9){
				echo "
				<a href='{$raiz}b-painel/inicial.php?b-pagina=conteudo&paginas={$obj_p->pa_codigo}'><input class='btn_editar' style='display:block;margin-top:10px;float:right;' type='submit' value='Editar'/></a>";
				}
			}
			echo "
			<a href='{$raiz}public&pg={$obj_p->pa_codigo}'><input class='btn_view' style='display:block;margin-top:10px;float:right;' type='submit' value='Visualizar'/></a>
		</fieldset>";
	}
}
//paginacao
	
		$anterior = $pagina - 1;
		$proximo = $pagina + 1;
		if($contagemdeLinhas == 1)
			$frescura = "Registro";
		else
			$frescura = "Registros";
			
		echo "<center>$pagina - $numP&nbsp;($contagemdeLinhas $frescura)<br />";
		if($anterior > 0){
			echo "<strong><a href='{$raiz}$linkk&pp=$anterior' style='color:#000;'>ANTERIOR</a></strong>";
		}
		
		if($pagina == 2){
			$valueMax = $pagina+3;
		}else if($pagina >= 3){
			$valueMax = $pagina+2;
		}else{
			$valueMax = $pagina + 4;
		}
		$pagina2 = $pagina;
				
		if($pagina2 == $numP){
			$valueMin = $pagina2 - 4;
		}else if($pagina2 == $numP-1){
			$valueMin = $pagina2 - 3;
		}else{
			$valueMin = $pagina2-2;
		}
		
		for($i=$valueMin; $i<=$pagina-1; $i++){
			if($i > 0){
				if($pagina == $i){
					echo "&nbsp;<strong style='color:red;'>$i</strong>&nbsp;";
				}else{
					echo "&nbsp;<strong><a href='{$raiz}$linkk&pp=$i' style='color:#000;'>$i</a></strong>&nbsp;";
				}
			}
		}
		
		for($i = $pagina; $i<=$valueMax; $i++){
			if($numP >= $i && $numP > 1){
				if($pagina == $i){
					echo "&nbsp;<strong style='color:red;'>$i</strong>&nbsp;";
				}else{
					echo "&nbsp;<strong><a href='{$raiz}$linkk&pp=$i' style='color:#000;'>$i</a></strong>&nbsp;";
				}
			}
		}
		
		if($proximo <= $numP){
			echo "<strong><a href='{$raiz}$linkk&pp=$proximo' style='color:#000;'>PROXIMO</a></strong>";
		}
		//dados paginacao\\
?>