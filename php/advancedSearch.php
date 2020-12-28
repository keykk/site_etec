<style>
table tr td, table tr th{
border:1px solid black;
}
</style>
<?php
	if(isset($_GET['advancedsearch'])){
		$advanced = trataValor($_GET['advancedsearch']);
		
		if(preg_match("/^\w.{1,60}$/",$advanced)){
			echo "<fieldset>
			<legend>Pesquisando por: $advanced</legend>
			";
			$usuario = "SELECT * FROM etec_usuario WHERE u_apelido LIKE '%$advanced%'";
			$noticia = "SELECT * FROM etec_integra WHERE in_data_on <= NOW() AND in_data_off > NOW() AND in_titulo LIKE '%$advanced%'";
			$statement = "";
			define("TOTAL22",10);
			$get = "";
			for($i = 1; $i <= 2; $i++){
				if($i == 1){
					$statement = $usuario;
					$get = "usr";
				}else{
					$statement = $noticia;
					$get = "nws";
				}
				//paginacao
				
		
				if(isset($_GET[$get])){
					$pagina = (int)$_GET[$get];
				}else{
					$pagina = 1;
				}
				
				$celectAll = $connnect->query($statement) or die (SqlErro($connnect->ErrorInfo()[2]));
				
				$contagemdeLinhas = $celectAll->rowCount();
				$numP = ceil($contagemdeLinhas / TOTAL22);
				if($pagina > $numP){
					$pagina = 1;
				}
						
				if($pagina <= 0){
					$pagina = 1;
				}
				$inicio = $pagina - 1;
				$inicio = $inicio * TOTAL22;
				//Paginacao\\
				
				$seleciona = $connnect->query($statement."LIMIT $inicio,".TOTAL22);
				
				if($seleciona->rowCount() > 0){
					if($i == 1){
						echo $seleciona->rowCount()." Usuarios
					<table align='center' style='border:1px solid black;border-collapse:collapse;clear:both;width:100%;'>
					<tr>
						<th>Apelido</th>
						<th>Nome</th>
						<th>Email</th>
						<th>Data de Registro</th>
					</tr>
					
					";
					}else{
						echo $seleciona->rowCount()." Noticias
					<table align='center' style='border:1px solid black;border-collapse:collapse;clear:both;width:100%;'>
					<tr>
						<th>Titulo</th>
						<th>Autor</th>
						<th>Editor</th>
						<th>Categoria</th>
					</tr>
					
					";
					}
					while($obj_ad = $seleciona->fetch(PDO::FETCH_OBJ)){
						if($i == 1){
						$nasc = date("d-m-Y",strtotime($obj_ad->u_datanasc));
						$link = htmlentities(urlencode($obj_ad->u_apelido));
						$apelido = Encurtatitulo2($obj_ad->u_apelido);
						$nome = Encurtatitulo2($obj_ad->u_nome);
						$email = Encurtatitulo2($obj_ad->u_email);
							echo "
						<tr>
							<td><a href='{$raiz}privado&usuario=$link' style='color:red;'>{$apelido}</a></td>
							<td>{$nome}</td>
							<td>{$email}</td>
							<td>$nasc</td>
						</tr>
						";
						}else{
							$titulo = Encurtatitulo2($obj_ad->in_titulo);
							$autor = Encurtatitulo2($obj_ad->in_autoria);
							$editor = Encurtatitulo2($obj_ad->in_editor);
							$categorias->categoria_unica($obj_ad->in_categoria);
							echo "
						<tr>
							<td><a href='{$raiz}noticias&news={$obj_ad->in_codigo}' style='color:red;'>{$titulo}</a></td>
							<td>{$autor}</td>
							<td>{$editor}</td>
							<td>{$categorias->titulo}</td>
						</tr>
						";
						}
					}
					
						echo "</table>";
					
					//paginacao
					$anterior = $pagina - 1;
					$proximo = $pagina + 1;
					if($contagemdeLinhas > 1)
						$frescura = "Registros";
					else
						$frescura = "Registro";
						
					echo "<center>$pagina - $numP&nbsp;($contagemdeLinhas $frescura)<br />";
					if($anterior > 0){
						echo "<strong><a href='{$raiz}index.php?advancedsearch={$_GET['advancedsearch']}&{$get}=$anterior' style='color:#000;'>ANTERIOR</a></strong>";
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
					
					for($i2=$valueMin; $i2<=$pagina-1; $i2++){
						if($i2 > 0){
							if($pagina == $i2){
								echo "&nbsp;<strong style='color:red;'>$i2</strong>&nbsp;";
							}else{
								echo "&nbsp;<strong><a href='{$raiz}index.php?advancedsearch={$_GET['advancedsearch']}&{$get}=$i2' style='color:#000;'>$i2</a></strong>&nbsp;";
							}
						}
					}
					
					for($i2 = $pagina; $i2<=$valueMax; $i2++){
						if($numP >= $i2 && $numP > 1){
							if($pagina == $i2){
								echo "&nbsp;<strong style='color:red;'>$i2</strong>&nbsp;";
							}else{
								echo "&nbsp;<strong><a href='{$raiz}index.php?advancedsearch={$_GET['advancedsearch']}&{$get}=$i2' style='color:#000;'>$i2</a></strong>&nbsp;";
							}
						}
					}
					
					if($proximo <= $numP){
						echo "<strong><a href='{$raiz}index.php?advancedsearch={$_GET['advancedsearch']}&{$get}=$proximo' style='color:#000;'>PROXIMO</a></strong>";
					}
					echo "<hr>";
					//dados paginacao\\
				}else
					echo "...";
			}
			
			echo "</fieldset>";
		}
	}
?>