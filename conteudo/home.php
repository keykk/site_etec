<?php
//paginacao
define("TOTAL",5);
if(isset($_GET['integra'])){
	$pagina = (int)$_GET['integra'];
}else{
	$pagina = 1;
}

	$celectAll = $connnect->query("SELECT * FROM etec_integra WHERE in_data_on <= NOW() AND in_data_off > NOW()");
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

	$query = $connnect->query("SELECT * FROM etec_integra WHERE in_data_on <= NOW() AND in_data_off > NOW() ORDER BY in_data_on DESC LIMIT $inicio,".TOTAL);
	
	if($query->rowCount() > 0){
		while($obj_news = $query->fetch(PDO::FETCH_OBJ)){
			$noticias->noticia_unica($obj_news->in_codigo);
			echo "<fieldset>";
			echo "<legend>{$noticias->titulo}</legend>";
			echo $noticias->conteudo;
			
			echo "<hr>
			<strong>De: </strong> {$noticias->data_on} <strong>Até: </strong> {$noticias->data_off}
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
			echo "<strong><a href='{$raiz}index.php?integra=$anterior' style='color:#000;'>ANTERIOR</a></strong>";
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
					echo "&nbsp;<strong><a href='{$raiz}index.php?integra=$i' style='color:#000;'>$i</a></strong>&nbsp;";
				}
			}
		}
		
		for($i = $pagina; $i<=$valueMax; $i++){
			if($numP >= $i && $numP > 1){
				if($pagina == $i){
					echo "&nbsp;<strong style='color:red;'>$i</strong>&nbsp;";
				}else{
					echo "&nbsp;<strong><a href='{$raiz}index.php?integra=$i' style='color:#000;'>$i</a></strong>&nbsp;";
				}
			}
		}
		
		if($proximo <= $numP){
			echo "<strong><a href='{$raiz}index.php?integra=$proximo' style='color:#000;'>PROXIMO</a></strong>";
		}
		//dados paginacao\\
?>