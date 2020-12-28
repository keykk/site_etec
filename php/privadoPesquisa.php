<style>
table tr td, table tr th{
border:1px solid black;
}
</style>
<fieldset>
	<legend>Procurar por paginas Privadas</legend>
	<br />
	<?php
	$statement = "";
		if(isset($_POST['apelid'])){
			if(preg_match("/^\w.{2,50}$/", trataValor($_POST['apelid'])))
				$statement = trataValor($_POST['apelid']);
		}
		
		//Paginacao
		define("TOTAL",15);
		
		if(isset($_GET['pg'])){
			$pagina = (int)$_GET['pg'];
		}else{
			$pagina = 1;
		}
		
		$celectAll = $connnect->prepare("SELECT * FROM etec_usuario WHERE u_apelido LIKE '%?%'") or die (SqlErro($connnect->ErrorInfo()[2]));
		$celectAll->execute(array($statement));
		
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
		
				$seleciona = $connnect->prepare("SELECT * FROM etec_usuario WHERE u_apelido LIKE '%?%' LIMIT $inicio,".TOTAL) or die (SqlErro($connnect->ErrorInfo()[2]));
				$seleciona->execute(array($statement));
				
				if($seleciona->rowCount() > 0){
					echo "
					<table align='center' style='border:1px solid black;border-collapse:collapse;clear:both;width:100%;'>
					<tr>
						<th>Apelido</th>
						<th>Nome</th>
						<th>Email</th>
						<th>Data de Registro</th>
					</tr>
					
					";
					while($objetoDados = mysql_fetch_object($seleciona)){
					$nasc = date("d-m-Y",strtotime($objetoDados->u_datanasc));
					$link = htmlentities(urlencode($objetoDados->u_apelido));
						echo "
						<tr>
							<td><a href='{$raiz}privado&usuario=$link' style='color:red;'>{$objetoDados->u_apelido}</a></td>
							<td>{$objetoDados->u_nome}</td>
							<td>{$objetoDados->u_email}</td>
							<td>$nasc</td>
						</tr>
						";
					}echo "</table>";
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
			echo "<strong><a href='{$raiz}privado&pg=$anterior' style='color:#000;'>ANTERIOR</a></strong>";
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
					echo "&nbsp;<strong><a href='{$raiz}privado&pg=$i' style='color:#000;'>$i</a></strong>&nbsp;";
				}
			}
		}
		
		for($i = $pagina; $i<=$valueMax; $i++){
			if($numP >= $i && $numP > 1){
				if($pagina == $i){
					echo "&nbsp;<strong style='color:red;'>$i</strong>&nbsp;";
				}else{
					echo "&nbsp;<strong><a href='{$raiz}privado&pg=$i' style='color:#000;'>$i</a></strong>&nbsp;";
				}
			}
		}
		
		if($proximo <= $numP){
			echo "<strong><a href='{$raiz}privado&pg=$proximo' style='color:#000;'>PROXIMO</a></strong>";
		}
		//dados paginacao\\
	?>
	<!--<table align="center" style="border:1px solid black;border-collapse:collapse;clear:both;width:100%;">
		<tr>
			<th>Apelido</th>
			<th>Nome</th>
			<th>Email</th>
			<th>Data de Registro</th>
		</tr>
		<tr>
			<td>teste</td>
			<td>Gabriel Bispo asdsad</td>
			<td>teste@teste.com</td>
			<td>20-05-2014</td>
		</tr>
	</table>-->
</fieldset>