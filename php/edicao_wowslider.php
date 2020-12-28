<script>
function exclude(){
	$('#apbtn').show(500);
}
function ocutar(){
	$('#apbtn').hide(500);
}
</script>
<?php
	
	if(isset($_GET['action'])){
		echo "<fieldset>";
		$cod = (int)$_GET['action'];
		
		if($cod > 0){
			$wowslider->wowslider($cod);
			if($wowslider->retorno == 1){
			echo "
				<legend>Editando {$wowslider->titulo}</legend>
				<label for='titulo'>Titulo do Slider</label>
				<form method='post' action='' style='margin:0px;padding:0px;'>
				<input type='text' value='{$wowslider->titulo}' id='titulo' class='caixaText' name='titulo'/>
				<label for='link'>Link anexado</label>
				<input type='text' value='{$wowslider->link}' id='link' class='caixaText' name='link'/>
				<label for='dataon'>Data de ativação</label>
				<input type='text' value='{$wowslider->ativo}' id='dataon' class='caixaText datetime' name='dataon'/>
				<label for='dataoff'>Data de Desativação</label>
				<input type='text' value='{$wowslider->desativo}' id='dataoff' class='caixaText datetime' name='dataoff'/>
				<input type='password' name='senha' placeholder='digite sua senha' class='caixaText'/>
				<input type='submit' value='salvar' class='btn_salvar' style='float:right;'/>
				</form>
				<input type='submit' value='apagar' class='btn_apagar' style='float:right;' onclick='exclude();'/>
				<p style='color:red;'>
			";
			
			if(isset($_POST['titulo']) && isset($_POST['link']) && isset($_POST['dataon']) && isset($_POST['dataoff']) && isset($_POST['senha'])){
				$titulo = trataValor($_POST['titulo']);
				$link = trataValor($_POST['link']);
				$dataon = explode(" ",trataValor($_POST['dataon']));
				$dataoff = explode(" ",trataValor($_POST['dataoff']));
				$senha = MD5(trataValor($_POST['senha']));
				
				$data_on_invert = implode("-",array_reverse(explode("/",$dataon[0])));
				$data_off_invert = implode("-",array_reverse(explode("/",$dataoff[0])));
				
				if($senha === $userDado->pw){
					if(preg_match("/^\w.{3,50}$/",$titulo)){
						$query = $connnect->prepare("SELECT * FROM etec_wowslide WHERE w_titulo = ? AND w_codigo <> ?");
						$query->execute(array($titulo, $wowslider->codigo));
						
						if($query->rowCount() == 0){
							
							$insert = $connnect->prepare("UPDATE etec_wowslide SET w_titulo = ?, w_link = ?, w_editor = ?, w_ativacao = ?, w_desativacao = ? WHERE w_codigo = ?");
							$insert->execute(array($titulo, $link, $userDado->iduser, $data_on_invert.' '.$dataon[1], $data_off_invert.' '.$dataoff[1], $wowslider->codigo));
							
							
							if($insert){
								echo "Slider atualizado com sucesso !!!";
							}else
								echo "Erro ao atualizar slide";
							
						}else
							echo "Titulo ja esta em uso.";
					}else
						echo "Titulo inrregular (3-50 caracteries).";
				}else
					echo "altenticação incorreta";
			}
			echo "</p>";
			?>
			
			<div id='apbtn' class='addc' style='display:none;clear:both;'>
	<p style='margin:0px;padding:0px;display:inline;color:red;'>você tem certeza que deseja apagar este slider ?</p>
	<input type='submit' value='sim' class='nao' onclick='ocutar();'/>
	<form method='post' action='' style='margin:0px;padding:0px;display:inline;'>
		<input type='submit' name='sim' value='sim' class='sim'/>
	</form>
	<?php
		if(isset($_POST['sim'])){
			
			if(unlink('../'.$wowslider->slide) == true){
			$del = $connnect->query("DELETE FROM etec_wowslide WHERE w_codigo = {$wowslider->codigo}");
				if($del->rowCount() > 0){
					echo "Apagado com sucesso !!!";
					header('location: ?b-pagina=home');
				}else
					echo "Embora o slide tenha sido apagado do servidor o registro não foi apagado.";
			
			}else
				echo "Erro ao tentar apagar.";
			
			
		}
	?>
</div>
<?php
		}else
			echo "Slide não encontrado";
		}else
			echo "Conteudo requisitado não encontrado, tente remover o script mal intencionado na variavel action.";
		echo "</fieldset>";
	}
?>