<script>
	function privilegioo(pri){
		$.post("scriptspost/privilegiolist.php",{id:pri}, function(retorno){
			$('#privilegio').html(retorno);
		});
	}
	
	$(document).ready(function(){
		privilegioo();
	});
</script>
<?php

?>
<fieldset>
	<legend class="textEstiloso">Criar Novo Grupo de Usuarios</legend>
	<form method="post" action="">
		<input placeholder="Nome do grupo" name="namegroup" style="padding-left:10px;" type="text" class="caixaText"/>
		<select name="pri" class="caixaText" id="listpri" style="width:35%;float:left;" onchange="privilegioo(this.value);">
		<option>Selecione um Privilegio</option>
			<?php
				include_once("../php/listpri.php");
			?>
		</select>
	
	<div style="margin-left:36.5%;text-align:justify;" id="privilegio"></div>
	<input type="submit" class="btn_salvar" style="float:right;font-family: 'Cinzel', serif;" value="Salvar"/>
	</form>
</fieldset>
<p style="color:red;">
<?php
if(isset($_POST['namegroup']) && isset($_POST['pri'])){
 $pri = (int) $_POST['pri'];
 $nomeG = trataValor($_POST['namegroup']);
 if($pri <= 0){
	echo "Privilegio Invalido";
	return false;
 }
 if(preg_match("/^\w.{3,20}$/", $nomeG)){
	$verification = $connnect->prepare("SELECT * FROM etec_privilegio WHERE p_codigo = ? AND p_nivel <= ?");
	$verification->execute(array($pri, $userDado->pri));
	
	if($verification->rowCount() == 1){
	$verificanome = $connnect->prepare("SELECT * FROM etec_grupo WHERE g_nome = ?");
	$verificanome->execute(array($nomeG));
	
	if($verificanome->rowCount() == 0){
		
		$insert = $connnect->prepare("INSERT INTO etec_grupo (g_nome, g_data, g_privilegio, autor) VALUES (?,CURDATE(),?,?)");
		$insert->execute(array($nomeG, $pri, $userDado->name));
		
		if($insert)
			echo "Dados Gravados com sucesso!!!";
		else
			echo "Erro ao gravar dados.";
	}else{
		echo "O nome do grupo ja esta em uso";
	}
	
	}else{
		echo "Privilegio Invalido";
	}
 
 }else
	echo "O nome do grupo não é valido";
 
}
?>
</p>