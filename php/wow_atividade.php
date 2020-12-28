
<?php
	if(isset($_GET['action'])){
		if($_GET['action'] == "ativos" || $_GET['action'] == "inativos"){
			
			echo "
				<fieldset>
					<legend>Busca por Sliders</legend>
					<form method='post' action=''>
						<input type='text' placeholder='busca por titulo' name='advanced' class='caixaText'/>
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
			
			if($_GET['action'] == "ativos"){
				$celectAll = $connnect->query("SELECT * FROM etec_wowslide WHERE w_ativacao <= NOW() AND w_desativacao > NOW() AND w_titulo LIKE '%$advanced%'");
			}else{
				$celectAll = $connnect->query("SELECT * FROM etec_wowslide WHERE w_desativacao < NOW() OR w_ativacao > NOW() AND w_titulo LIKE '%$advanced%'");
			}
			
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
			
			if($_GET['action'] == "ativos"){
				$query = $connnect->query("SELECT * FROM etec_wowslide WHERE w_ativacao <= NOW() AND w_desativacao > NOW() AND w_titulo LIKE '%$advanced%' LIMIT $inicio,".TOTAL);
			}else{
				$query = $connnect->query("SELECT * FROM etec_wowslide WHERE w_desativacao < NOW() OR w_ativacao > NOW() AND w_titulo LIKE '%$advanced%' LIMIT $inicio,".TOTAL);
			}
			
			if($query->rowCount() > 0){
				while($obj = $query->fetch(PDO::FETCH_OBJ)){
					$wowslider->wowslider($obj->w_codigo);
					$mala->usr_mala($obj->w_autor);
					echo "
						<fieldset>
							<legend>{$wowslider->titulo}</legend>
							<strong>Autor: </strong>{$mala->nome}<br />
							<strong>Data de cadastro: </strong>{$wowslider->data}<br />
							<strong>de: </strong>{$wowslider->ativo}
							<strong>até: </strong>{$wowslider->desativo}<br />
							<strong>Link anexado: </strong>{$wowslider->link}<br />
							";
							$huehue = "";
							if((int)$obj->w_editor > 0){
							$mala2->usr_mala($obj->w_editor);
							$huehue = $mala2->nome;
							}
							echo "
							<strong>Utimo Editor: </strong>{$huehue}
							<strong></strong>
							
							<a href='?b-pagina={$_GET['b-pagina']}&action={$wowslider->codigo}'><input type='submit' value='editar' class='btn_editar' style='float:right;'/></a>
							
							<a href='{$raiz}configslider.php?arquivo={$wowslider->slide}&largura=960&altura=360' target='_blank'><input type='submit' value='visualizar' class='btn_view' style='float:right;'/></a>
						
						</fieldset>
					";
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
					echo "<strong><a href='?b-pagina={$_GET['b-pagina']}&action={$_GET['action']}&pg=$anterior' style='color:#000;'>ANTERIOR</a></strong>";
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
							echo "&nbsp;<strong><a href='?b-pagina={$_GET['b-pagina']}&action={$_GET['action']}&pg=$i' style='color:#000;'>$i</a></strong>&nbsp;";
						}
					}
				}
				
				for($i = $pagina; $i<=$valueMax; $i++){
					if($numP >= $i && $numP > 1){
						if($pagina == $i){
							echo "&nbsp;<strong style='color:red;'>$i</strong>&nbsp;";
						}else{
							echo "&nbsp;<strong><a href='?b-pagina={$_GET['b-pagina']}&action={$_GET['action']}&pg=$i' style='color:#000;'>$i</a></strong>&nbsp;";
						}
					}
				}
				
				if($proximo <= $numP){
					echo "<strong><a href='?b-pagina={$_GET['b-pagina']}&action={$_GET['action']}&pg=$proximo' style='color:#000;'>PROXIMO</a></strong>";
				}
				//dados paginacao\\
			}
		}
	}
?>