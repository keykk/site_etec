<?php
	function integra_ca($categoria,$raiz,$raiz2){
		if(!isset($connnect))
			$connnect = Conexao::getInstance();
		$id_ca = (int)$categoria;
		
		if($id_ca > 0){
			$query = $connnect->query("SELECT * FROM etec_categoria WHERE ca_codigo = $id_ca");
			
			if($query->rowCount() == 1){
				//paginacao
				define("TOTAL",10);
				if(isset($_GET['pg'])){
					$pagina = (int)$_GET['pg'];
				}else{
					$pagina = 1;
				}
				
				$celectAll = $connnect->query("SELECT * FROM etec_integra WHERE in_categoria = $id_ca");
				
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
				
				$query2 = $connnect->query("SELECT * FROM etec_integra WHERE in_categoria = $id_ca LIMIT $inicio,".TOTAL);
				
				if($query2->rowCount() > 0){
					while($obj = $query2->fetch(PDO::FETCH_OBJ)){
						$titulo = $obj->in_titulo;
						if(strlen($obj->in_titulo) > 44)
							$titulo = substr($obj->in_titulo, 0, 44)."...";
					
						echo "<a href='{$raiz2}noticias&news={$obj->in_codigo}' title='{$obj->in_titulo}'>{$titulo}</a>";
						
						echo "<a href='{$raiz2}/b-painel/inicial.php?b-pagina=integra&noticia={$obj->in_codigo}'><input type='submit' class='btn_editar' value='Editar' style='float:right;'/></a><br />";
						
					}
					
					//pag
					$anterior = $pagina - 1;
					$proximo = $pagina + 1;
					if($contagemdeLinhas <= 1)
						$frescura = "Registro";
					else
						$frescura = "Registros";
						
					echo "<center>$pagina - $numP&nbsp;($contagemdeLinhas $frescura)<br />";
					if($anterior > 0){
						echo "<strong><a href='{$raiz}&pg=$anterior' style='color:#000;'>ANTERIOR</a></strong>";
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
								echo "&nbsp;<strong><a href='{$raiz}&pg=$i' style='color:#000;'>$i</a></strong>&nbsp;";
							}
						}
					}
					
					for($i = $pagina; $i<=$valueMax; $i++){
						if($numP >= $i && $numP > 1){
							if($pagina == $i){
								echo "&nbsp;<strong style='color:red;'>$i</strong>&nbsp;";
							}else{
								echo "&nbsp;<strong><a href='{$raiz}&pg=$i' style='color:#000;'>$i</a></strong>&nbsp;";
							}
						}
					}
					
					if($proximo <= $numP){
						echo "<strong><a href='{$raiz}&pg=$proximo' style='color:#000;'>PROXIMO</a></strong>";
					}
					//pag
				}else
					echo "Nenhuma noticia encontrada";
				
			}
			
		}
	
	}
?>