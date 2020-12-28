<?php
	if(isset($_GET['action'])){
		
		if($_GET['action'] == "on" || $_GET['action'] == "off"){
				echo "
					<fieldset>
						<legend>Busca avançada</legend>
						<form method='post' action=''>
							<input type='text' placeholder='buscar paginas' name='advanced' class='caixaText'/>
							<input type='submit' value='buscar' style='float:right'/>
						</form>
					</fieldset>
				";
			$advanced = "";
			if(isset($_POST['advanced'])){
				$advanced = trataValor($_POST['advanced']);
			}
			//paginacao
			define("TOTAL",5);
			if(isset($_GET['pg'])){
				$pagina = (int)$_GET['pg'];
			}else{
				$pagina = 1;
			}
			
			if($_GET['action'] == "on"){
				$celectAll = $connnect->prepare("SELECT * FROM etec_integra WHERE in_data_on <= NOW() AND in_data_off > NOW() AND in_titulo LIKE '%?%'");
			}else if($_GET['action'] == "off"){
				$celectAll = $connnect->prepare("SELECT * FROM etec_integra WHERE in_data_off < NOW() OR in_data_on > NOW() AND in_titulo LIKE '%?%'");
			}
			
			$celectAll->execute(array($advanced));
			
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
			if($_GET['action'] == "on"){
				$query = $connnect->prepare("SELECT * FROM etec_integra WHERE in_data_on <= NOW() AND in_data_off > NOW() AND in_titulo LIKE '%?%' LIMIT $inicio,".TOTAL);
			}else if($_GET['action'] == "off"){
				$query = $connnect->prepare("SELECT * FROM etec_integra WHERE in_data_off < NOW() OR in_data_on > NOW() AND in_titulo LIKE '%?%' LIMIT $inicio,".TOTAL);
			}
			
			$query->execute(array($advanced));
			
			if($query->rowCount() > 0){
			
				while($obj = $query->fetch(PDO::FETCH_OBJ)){
					$noticias->noticia_unica($obj->in_codigo);
					echo "<fieldset>
						<legend>{$noticias->titulo}</legend>
						<strong>Data de criação: </strong>{$noticias->data}<br />
						<strong>Data de Ativação: </strong>{$noticias->data_on}<br />
						<strong>Data de desativação: </strong>{$noticias->data_off}<br />
						<strong>Autor: </strong>{$noticias->autoria}<br />
						<strong>Utimo Editor: </strong>{$noticias->editor}<br />
						<strong>Utima edição: </strong>{$noticias->data_edicao}<br />
					";
						$categorias->categoria_unica($noticias->categoria);
					echo "
						<strong>Categoria: </strong>{$categorias->titulo}
						<a href='?b-pagina={$_GET['b-pagina']}&noticia={$noticias->codigo}'><input type='submit' class='btn_editar' value='Editar' style='float:right;display:block'/></a>
					</fieldset>
					";
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
				echo "<strong><a href='{$raiz}b-painel/inicial.php?b-pagina=integra&noticia={$_GET['noticia']}&action={$_GET['action']}&pg=$anterior' style='color:#000;'>ANTERIOR</a></strong>";
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
						echo "&nbsp;<strong><a href='{$raiz}b-painel/inicial.php?b-pagina=integra&noticia={$_GET['noticia']}&action={$_GET['action']}&pg=$i' style='color:#000;'>$i</a></strong>&nbsp;";
					}
				}
			}
			
			for($i = $pagina; $i<=$valueMax; $i++){
				if($numP >= $i && $numP > 1){
					if($pagina == $i){
						echo "&nbsp;<strong style='color:red;'>$i</strong>&nbsp;";
					}else{
						echo "&nbsp;<strong><a href='{$raiz}b-painel/inicial.php?b-pagina=integra&noticia={$_GET['noticia']}&action={$_GET['action']}&pg=$i' style='color:#000;'>$i</a></strong>&nbsp;";
					}
				}
			}
			
			if($proximo <= $numP){
				echo "<strong><a href='{$raiz}b-painel/inicial.php?b-pagina=integra&noticia={$_GET['noticia']}&action={$_GET['action']}&pg=$proximo' style='color:#000;'>PROXIMO</a></strong>";
			}
		//dados paginacao\\
		}
	}else
		include_once("../php/errorpag.php");

?>