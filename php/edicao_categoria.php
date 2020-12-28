<script>
	function toggle(){
		$('#tog').toggle(400);
	}
	
	$(document).ready(function(){
		
	});
</script>
<?php
	$id = (int)$_GET['action'];
	$categorias->categoria_unica($id);
?>
<fieldset>
	<?php
		if($categorias->registro == 1){
	?>
	<legend><?php echo $categorias->titulo; ?></legend>
	<?php
	
		echo "
			<strong>Descrição: </strong>{$categorias->descricao}<br />
			<strong>Criação: </strong>{$categorias->data}<br />
			<strong>Autor: </strong>{$categorias->autoria}<br />
			<strong>Noticias vinculadas: </strong><a href='#'>{$categorias->noticias}</a>
		";
		echo "
			<input type='submit' class='btn_apagar' value='Apagar' style='float:right;'/>";
			
			echo "
			<input type='submit' onclick='toggle();' class='btn_editar' value='Editar' style='float:right;'/>
			
		";
		}else
			include_once("../php/errorpag.php");
	?>
</fieldset>

<?php
	if($categorias->registro == 1){
		echo "
			<fieldset id='tog' style='margin-top:10px;display:none;'>
				<legend>Editar categoria</legend>
				<form method='post' action=''>
				<label for='ca_titulo'>Titulo da categoria</label>
				<input type='text' id='ca_titulo' name='ca_titulo' class='caixaText' value='{$categorias->titulo}'/>
				<label for='ca_desc'>Descrição</label>
				<input type='text' id='ca_desc' name='ca_desc' class='caixaText' value='{$categorias->descricao}'/>
				<input type='submit' value='Salvar' class='btn_salvar' style='float:right;margin-top:10px;'/>
				</form>
			</fieldset><p style='color:red;'>
			";
			if(isset($_POST['ca_titulo']) && isset($_POST['ca_desc'])){
				$titulo = trataValor($_POST['ca_titulo']);
				$descricao = trataValor($_POST['ca_desc']);
				
				if(preg_match("/^\w.{3,50}$/", $titulo)){
					$verificaT = $connnect->prepare("SELECT * FROM etec_categoria WHERE ca_titulo = ? AND ca_codigo <> ?");
					$verificaT->execute(array($titulo, $categorias->codigo));
					
					if($verificaT->rowCount() == 0){
						if(preg_match("/^\w.{5,50}$/",$descricao)){
							$query = $connnect->prepare("UPDATE etec_categoria SET ca_titulo = ?, ca_desc = ? WHERE ca_codigo = ?") or die (mysql_error());
							$query->execute(array($titulo, $descricao, $categorias->codigo));
							
							if($query){
								echo "Alteração efetuada com sucesso!!!";
							}else
								echo "Falha ao alterar.";
						}else
							echo "Descrição requer 5-50 (minimo e maximo) caracteries, contendo somente -, _, ., letras e numeros";
					}else
						echo "Titulo ja existe, escolha outro";
				}else
					echo "Titulo requer 3-50 (minimo e maximo) caracteries, contendo somente -, _, ., letras e numeros";
			}
			echo "</p>
			<fieldset style='margin-top:10px;'>
				<legend>Noticias Vinculadas</legend>
			";
				integra_ca($categorias->codigo,$raiz."b-painel/inicial.php?b-pagina=categories&action={$categorias->codigo}",$raiz);
			echo "
			</fieldset>
		";
		
		
	}
?>