<script>
function exclude(){
	$('#apbtn').show(500);
}
function ocutar(){
	$('#apbtn').hide(500);
}
</script>

<fieldset style="">
	<?php
		$id = (int) $_GET['paginas'];
		$paginas->pagina_dados($id,$raiz);
		if($paginas->retorno == 1){
			echo "<legend>Editar pagina existente ({$paginas->titulo})</legend>";
			echo "<strong>Criação:</strong> ".$paginas->data." <strong>Utima alteração:</strong> ".$paginas->edicao." <br /><strong>Criado por:</strong> ".$paginas->criacao." <strong>Utimo editor:</strong> ".$paginas->editor;
			include_once("../tinymce_pt/examples/full.php");
			echo "<input class='btn_apagar' type='submit' style='float:right;' onclick='exclude();' value='Apagar'/>";
		}
	?>
</fieldset>
<p style="color:red;">
<?php
	if(isset($_POST['mypag']) && isset($_POST['pa_titulo']) && isset($_POST['pww'])){
		
		$corpo = FILTER_INPUT(INPUT_POST,'mypag');
		$titulo = trataValor($_POST['pa_titulo']);
		$senha = trataValor(MD5($_POST['pww']));
			
		if($senha === $userDado->pw){
			if(preg_match("/^\w.{3,80}$/", $titulo)){
				
				$query = $connnect->prepare("SELECT * FROM etec_pagina WHERE pa_titulo = ? AND pa_titulo NOT IN (SELECT pa_titulo FROM etec_pagina WHERE pa_codigo = ?)");
				$query->execute(array($titulo, $id));
				
				if($query->rowCount() == 0){
					
					$altera = $connnect->prepare("UPDATE etec_pagina SET pa_titulo = ?, pa_conteudo = ?, pa_edicao = NOW(), pa_editor = ? WHERE pa_codigo = ?");
					$altera->execute(array($titulo, $corpo, $userDado->name, $id));
					
					$paginas->pagina_dados($id,$raiz);
					if($altera){
						echo "Pagina alterada.";
						
					}else
						echo "Erro ao alterar pagina";
				}else
					echo "Titulo ja esta em uso, por favor escolha outro.";
			}else
				echo "Titulo Invalido, os caracteries deve estar entre 3 e 80";
		}else
			echo "Autenticação incorreta.";
	}

?>
</p>
<?php
if($paginas->retorno == 1){
?>
<div id='apbtn' class='addc' style='display:none;clear:both;'>
	<p style='margin:0px;padding:0px;display:inline;color:red;'>você tem certeza que deseja apagar a pagina ?</p>
	<input type='submit' value='sim' class='nao' onclick='ocutar();'/>
	<form method='post' action='' style='margin:0px;padding:0px;display:inline;'>
		<input type='submit' name='sim' value='sim' class='sim'/>
	</form>
	<?php
		if(isset($_POST['sim'])){
			
			$delete = $connnect->prepare("DELETE FROM etec_pagina WHERE pa_codigo = ?") or die (mysql_error());
			$delete->execute(array($id));
			
			if($delete){
				header("location: inicial.php?b-pagina=conteudo");
			}else
				echo "Falha ao apagar";
		}
	?>
</div>
<?php
}
?>