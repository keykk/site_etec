<fieldset>
	<legend>Procura Por Grupos</legend>
	<form method="post" action="">
		<input type="text" name="pesquisaGrupo" placeholder="Nome Do Grupo" class="caixaText"/>
		<input style="float:right;" type="submit" value="Procurar"/>
	</form>
</fieldset>
<?php
$pesquisa = "";
if(isset($_POST['pesquisaGrupo'])){
	if(preg_match("/^\w.{2,50}$/", trataValor($_POST['pesquisaGrupo'])))
		$pesquisa = trataValor($_POST['pesquisaGrupo']);
}
//Paginacao
define("TOTAL",5);
if(isset($_GET['pg'])){
	$pagina = (int)$_GET['pg'];
}else{
	$pagina = 1;
}
$celectAll = $connnect->prepare("SELECT g.g_codigo,g.g_nome,g.g_data,g.autor,p.p_nivel,p.p_etc, COUNT(u.u_codigo) AS users FROM etec_grupo g JOIN etec_privilegio p ON g.g_privilegio = p.p_codigo LEFT JOIN etec_usuario u ON u.u_grupo = g.g_codigo WHERE g.g_nome LIKE '%?%' GROUP BY g.g_codigo") or die (SqlErro($connnect->ErrorInfo()[2]));
$celectAll->execute(array($pesquisa));

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
$query = $connnect->prepare("SELECT g.g_codigo,g.g_nome,g.g_data,g.autor,p.p_nivel,p.p_etc, COUNT(u.u_codigo) AS users FROM etec_grupo g JOIN etec_privilegio p ON g.g_privilegio = p.p_codigo LEFT JOIN etec_usuario u ON u.u_grupo = g.g_codigo WHERE g.g_nome LIKE '%?%' GROUP BY g.g_codigo LIMIT $inicio,".TOTAL) or die (SqlErro($connnect->ErrorInfo()[2]));
$query->execute(array($pesquisa));

if($query->rowCount() > 0){
	
	while($objgrupo = $query->fetch(PDO::FETCH_OBJ)){
		$date = date("d-m-Y",strtotime($objgrupo->g_data));
		echo "
			<fieldset style='clear:both;'>
				<legend>Grupo {$objgrupo->g_nome}</legend>
				<p><strong>Autor:</strong> {$objgrupo->autor}</p>
				<p><strong>Data de criação:</strong> $date</p>
				<p><strong>Nivel:</strong> {$objgrupo->p_nivel} => {$objgrupo->p_etc}</p>
				<p><strong>Participantes: </strong>{$objgrupo->users}</p>
				<input type='submit' value='Editar' class='btn_editar' onclick=hrefe('?b-pagina=groups&action={$objgrupo->g_codigo}'); style='float:right;margin-top:10px;'/>
			</fieldset>
			
		";
	}
	echo "<hr style='clear:both;'>";
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
			echo "<strong><a href='?b-pagina=groups&action=todos&pg=$anterior' style='color:#000;'>ANTERIOR</a></strong>";
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
					echo "&nbsp;<strong><a href='?b-pagina=groups&action=todos&pg=$i' style='color:#000;'>$i</a></strong>&nbsp;";
				}
			}
		}
		
		for($i = $pagina; $i<=$valueMax; $i++){
			if($numP >= $i && $numP > 1){
				if($pagina == $i){
					echo "&nbsp;<strong style='color:red;'>$i</strong>&nbsp;";
				}else{
					echo "&nbsp;<strong><a href='?b-pagina=groups&action=todos&pg=$i' style='color:#000;'>$i</a></strong>&nbsp;";
				}
			}
		}
		
		if($proximo <= $numP){
			echo "<strong><a href='?b-pagina=groups&action=todos&pg=$proximo' style='color:#000;'>PROXIMO</a></strong>";
		}
		//dados paginacao\\
?>