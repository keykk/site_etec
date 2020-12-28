<fieldset>
	<legend>Criar nova noticias na integra</legend>
	<form method="post" action="">
	<?php
		include_once("../tinymce_pt/examples/full2.php");
	?>
		
		<input type="text" name="in_titulo" placeholder="Titulo da pagina" class="caixaText" style="padding-left:10px;margin-top:10px;" required/>
		<input type="text" name="in_data_on" placeholder="Data e hora de inicialização - dia/mez/ano horas:minutos:segundos" class="caixaText datetime" required/>
		<input type="text" name="in_data_off" placeholder="Data e hora de encerramento - dia/mez/ano horas:minutos:segundos" class="caixaText datetime" required/>
		<select name="categoria" class="caixaText">
			<option>Selecione a categoria</option>
			<?php
				lista_categoria_option();
			?>
		</select>
		<input type="password" class="caixaText" placeholder="Senha autenticadora" required name="pass"/>
		<input type="submit" value="Salvar" class="btn_salvar" style="float:right;margin-top:10px;"/>
	</form>
</fieldset>
<p style="color:red;">
<?php
	if(isset($_POST['mypag']) && isset($_POST['in_titulo']) && isset($_POST['in_data_on']) && isset($_POST['in_data_off']) && isset($_POST['categoria'])){
		
		$date_on = explode(" ",trataValor($_POST['in_data_on']));
		$date_off = explode(" ",trataValor($_POST['in_data_off']));
		
		$data_on_invert = implode("-",array_reverse(explode("/",$date_on[0])));
		$data_off_invert = implode("-",array_reverse(explode("/",$date_off[0])));
		
		$in_titulo = trataValor($_POST['in_titulo']);
		$in_conteudo = filter_input(INPUT_POST,'mypag');
		$categoria = (int)$_POST['categoria'];
		$pass = MD5(trataValor($_POST['pass']));
		if(preg_match("/^\w.{3,50}$/",$in_titulo)){
			$verificategoria = $connnect->query("SELECT * FROM etec_categoria WHERE ca_codigo = $categoria");
			if($categoria > 0 && $verificategoria->rowCount() == 1){
				$query = $connnect->prepare("SELECT * FROM etec_integra i JOIN etec_categoria c ON i.in_categoria = c.ca_codigo WHERE c.ca_codigo = ? AND i.in_titulo = ?");
				$query->execute(array($categoria, $in_titulo));
				
				if($query->rowCount() == 0){
					if($userDado->pw === $pass){
						$insert = $connnect->prepare("INSERT INTO etec_integra (in_titulo,in_conteudo,in_data,in_data_on,in_data_off,in_autoria,in_categoria) VALUES (?,?,NOW(),?,?,?,?)") or die (SqlErro($connnect->ErrorInfo()[2]));
						$insert->execute(array($in_titulo, $in_conteudo, $data_on_invert.' '.$date_on[1], $data_off_invert.' '.$date_off[1], $userDado->name, $categoria));
						
						if($insert)
							echo "Sucesso!!! -> Nova noticia publicada";
						else
							echo "Falha na publicação da noticia";
					}else
						echo "Autenticação incorreta";
				}else
					echo "Titulo Referente a essa categoria ja esta em uso, escolha outro";
				
			}else
				echo "Categoria invalida ou não especificada";
		}else
			echo "Titulo irregular, deve estar entre 3 - 50 caracteries";
		
	}
?>
</p>