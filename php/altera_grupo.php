<script>
function privilegioo(pri){
	$.post("scriptspost/privilegiolist.php",{id:pri}, function(retorno){
		$('#privilegio').html(retorno);
	});
}
function exclude(){
	$('#apbtn').show(500);
}
function ocutar(){
	$('#apbtn').hide(500);
}
</script>
<style>
table tr td, table tr th{
border:1px solid black;
}
</style>
<?php
$id_grupo = (int) $_GET['action'];
$query = $connnect->prepare("SELECT g.g_nome,g.g_data,g.autor,p.p_nivel,p.p_etc, COUNT(u.u_codigo) AS users FROM etec_grupo g JOIN etec_privilegio p ON g.g_privilegio = p.p_codigo JOIN etec_usuario u ON u.u_grupo = g.g_codigo WHERE g.g_codigo = ?") or die (SqlErro($connnect->ErrorInfo()[2]));
$query->execute(array($id_grupo));

if($query->rowCount() == 1){
	$objdadosGrupo = $query->fetch(PDO::FETCH_OBJ);
	$date = date("d-m-Y",strtotime($objdadosGrupo->g_data));
	if(isset($_GET['alterar'])){
		if($_GET['alterar'] === "dados"){
			echo "
				<fieldset>
					<legend>Alterar {$objdadosGrupo->g_nome}</legend>
				<form method='post' action=''>
				<label for='gruponome'>Nome do Grupo</label>
				<input id='gruponome' value='{$objdadosGrupo->g_nome}' type='text' name='nomegrupo' class='caixaText'/>
			<select name='pri' class='caixaText' id='listpri' style='width:35%;float:left;' onchange='privilegioo(this.value);'>
		<option>Selecione um Privilegio</option>
		";
			include_once("../php/listpri.php");
		echo "</select>
				<div style='margin-left:36.5%;text-align:justify;' id='privilegio'></div>
				<input type='submit' class='btn_salvar' style='float:right;' value='Salvar'/>
			</form>
			</fieldset>
			<p style='color:red;'>
		";
			if(isset($_POST['nomegrupo']) && isset($_POST['pri'])){
				$pri = (int) $_POST['pri'];
				$nomeGr = trataValor($_POST['nomegrupo']);
				
				 if($pri <= 0){
					echo "Privilegio Invalido";
					return false;
				}
				
				if(preg_match("/^\w.{3,30}$/", $nomeGr)){
					$verification = $connnect->prepare("SELECT * FROM etec_privilegio WHERE p_codigo = ? AND p_nivel <= ?");
					$verification->execute(array($pri, $userDado->pri));
					
					if($verification->rowCount() == 1){
						$verificanome = $connnect->prepare("SELECT * FROM etec_grupo WHERE g_nome NOT IN (SELECT g_nome FROM etec_grupo WHERE g_codigo = ?) AND g_nome = ?");
						$verificanome->execute(array($id_grupo, $nomeGr));
						
						if($verificanome->rowCount() == 0){
							
							$update = $connnect->rowCount("UPDATE etec_grupo SET g_nome = ? ,g_privilegio = ? WHERE g_codigo = ?") or die (SqlErro($connnect->ErrorInfo()[2]));
							$update->execute(array($nomeGr, $pri, $id_grupo));
							
							if($update){
								echo "Grupo Atualizado com sucesso!!!";
							}else
								echo "Falha al tentar alterar dados, verifique sua conexao";
							
						}else
							echo "Nome ja esta em uso";
					}else
						echo "Privilegio invalido ou acesso negado";
				}else
					echo "Nome do grupo é irregular";
			}
			echo "</p>";
		}else{
			include_once("../php/errorpag.php");
		}
	}else{
		
		
		echo "
			<fieldset>
				<legend>Grupo {$objdadosGrupo->g_nome}</legend>
				<p><strong>Autor:</strong> {$objdadosGrupo->autor}</p>
				<p><strong>Data de criação:</strong> $date</p>
				<p><strong>Nivel:</strong> {$objdadosGrupo->p_nivel} => {$objdadosGrupo->p_etc}</p>
				<p><strong>Participantes: </strong>{$objdadosGrupo->users}</p>
				";
					if($objdadosGrupo->users == 0){
				echo "
				<input class='btn_apagar' style='margin-top:10px;float:right;' type='submit' value='Apagar' onclick='exclude();'/>";
				}
				echo "
				<input type='submit' class='btn_editar' value='Editar' onclick=hrefe('?b-pagina=groups&action=$id_grupo&alterar=dados'); style='float:right;margin-top:10px;'/>
			</fieldset>
			
		";
		
		if($objdadosGrupo->users > 0){
		echo " 
			<div style='clear:both;'>
			<fieldset>
			<legend>Todos os Participantes</legend>
			
			";
			//paginacao
			define("TOTAL",15);
		
			if(isset($_GET['pg'])){
				$pagina = (int)$_GET['pg'];
			}else{
				$pagina = 1;
			}
			
			$celectAll = $connnect->prepare("SELECT * FROM etec_usuario u JOIN etec_grupo g ON u.u_grupo = g.g_codigo WHERE g.g_codigo = ?");
			$celectAll->execute(array($id_grupo));
			
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
			//\\paginacao
			
			$ptpg = $connnect->prepare("SELECT * FROM etec_usuario u JOIN etec_grupo g ON u.u_grupo = g.g_codigo WHERE g.g_codigo = ? LIMIT $inicio,".TOTAL);
			$ptpg->execute(array($id_grupo));
			
			echo "
					<table align='center' style='border:1px solid black;border-collapse:collapse;clear:both;width:100%;'>
					<tr>
						<th>Apelido</th>
						<th>Nome</th>
						<th>Email</th>
						<th>Data de Registro</th>
					</tr>
					";
			while($objpt = $ptpg->fetch(PDO::FETCH_OBJ)){
				$nasc = date("d-m-Y",strtotime($objpt->u_dataregistro));
				echo "
					<tr>
						<td>{$objpt->u_apelido}</td>
						<td>{$objpt->u_nome}</td>
						<td>{$objpt->u_email}</td>
						<td>$nasc</td>
					</tr>
				";
			}
			echo "</table>";
			//paginacao
			$anterior = $pagina - 1;
			$proximo = $pagina + 1;
			if($contagemdeLinhas == 1)
				$frescura = "Registro";
			else
				$frescura = "Registros";
				
			echo "<center>$pagina - $numP&nbsp;($contagemdeLinhas $frescura)<br />";
			if($anterior > 0){
				echo "<strong><a href='?b-pagina=groups&action=$id_grupo&pg=$anterior' style='color:#000;'>ANTERIOR</a></strong>";
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
						echo "&nbsp;<strong><a href='?b-pagina=groups&action=$id_grupo&pg=$i' style='color:#000;'>$i</a></strong>&nbsp;";
					}
				}
			}
			
			for($i = $pagina; $i<=$valueMax; $i++){
				if($numP >= $i && $numP > 1){
					if($pagina == $i){
						echo "&nbsp;<strong style='color:red;'>$i</strong>&nbsp;";
					}else{
						echo "&nbsp;<strong><a href='?b-pagina=groups&action=$id_grupo&pg=$i' style='color:#000;'>$i</a></strong>&nbsp;";
					}
				}
			}
			
			if($proximo <= $numP){
				echo "<strong><a href='?b-pagina=groups&action=$id_grupo&pg=$proximo' style='color:#000;'>PROXIMO</a></strong>";
			}
			//dados paginacao\\
			echo "
		</fieldset></div>
		
		";
		}else{
			//echo "<input id='apbtn' class='btn_apagar' style='margin-top:10px;float:right;' type='submit' value='Apagar' onclick='exclude();'/>";
			echo "
				<div id='apbtn' class='addc' style='display:none;clear:both;'>
					<p style='margin:0px;padding:0px;display:inline;color:red;'>você tem certeza que deseja apagar este grupo ?</p>
					<input type='submit' value='sim' class='nao' onclick='ocutar();'/>
					<form method='post' action='' style='margin:0px;padding:0px;display:inline;'>
					<input type='submit' name='sim' value='sim' class='sim'/>
					</form>
				</div>
			";
			if(isset($_POST['sim'])){
				echo "<div style='clear:both;color:red;'>
				";
					$deletgrup = $connnect->prepare("DELETE FROM etec_grupo WHERE g_codigo = ?") OR DIE (MYSQL_ERROR());
					$deletgrup->execute(array($id_grupo));
					
					if($deletgrup){
						header("location: inicial.php?b-pagina=groups&action=todos");
					}else{
						echo "Falha ao Apagar grupo, verifique sua conexao";
					}
				echo "
				</div>";
			}
		}
		
		echo "
			<div style='clear:both;'>
				<fieldset>
				<legend>Novo Participante</legend>
				<form method='post' action=''>
					<input type='email' name='novoParticipante' placeholder='E-mail do novo participante' class='caixaText'/>
					<input type='submit' value='Adicionar' style='float:right;'/>
				</form>
				</fieldset>
			<p style='color:red'>";
			if(isset($_POST['novoParticipante'])){
				$novoP = trataValor($_POST['novoParticipante']);
				if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $novoP)){
					if($userDado->email != $novoP){
					
						$existeNovoP = $connnect->prepare("SELECT * FROM etec_usuario WHERE u_email = ?");
						$existeNovoP->execute(array($novoP));
						
						if($existeNovoP->rowCount() == 1){
							$objNovoP = $existeNovoP->fetch(PDO::FETCH_OBJ);
							
							$grupNovop = $connnect->prepare("SELECT * FROM etec_usuario u JOIN etec_grupo g ON u.u_grupo = g.g_codigo WHERE g.g_codigo = ? AND u.u_codigo = ?");
							$grupNovop->execute(array($id_grupo, $objNovoP->u_codigo));
							
							if($grupNovop->rowCount() == 0){
							
								$alteraP = $connnect->prepare("UPDATE etec_usuario SET u_grupo = ? WHERE u_codigo = ?");
								$alteraP->execute(array($id_grupo, $objNovoP->u_codigo));
								
								if($alteraP)
									echo "Novo participante Inserido com sucesso!!!";
								else
									echo "ERRO AO ATUALIZAR INFORMAÇÕES DO BANCO DE DADOS";
							}else
								echo "E-mail requisitado ja pertence ao grupo solicitado";
						}else
							echo "E-mail não encontrado";
					}else
						echo "Você não pode alterar seu próprio grupo.";
				}else
					echo "Email Incorreto => exemplo@dominio.com";
			}
		echo "</p>
			</div>
		";
	}
}else
	echo "Grupo solicitado não existe";
?>