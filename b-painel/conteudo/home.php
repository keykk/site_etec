
<fieldset>
	<legend>Adicionar Wow Slider</legend>
		é essencial que os sliders seja 960x360 px, sendo 960px de largura e 360px de altura.
	<form method="post" action="" enctype="multipart/form-data">
		<input type="text" name="titulo" class="caixaText" placeholder="Titulo do Slider"/>
		<input type="text" name="link" class="caixaText" placeholder="Anexar um link interno"/>
		<input type="text" name="dataon" class="caixaText datetime" placeholder="Data de ativação"/>
		<input type="text" name="dataoff" class="caixaText datetime" placeholder="Data de desativação"/>
		<label for="imageslider">Selecionar Slider (JPG, PNG, GIF)</label>
		<input type="file" id="imageslider" name="imageslider" style=""/>
		<input type="password" name="password" class="caixaText" placeholder="Digie sua senha"/>
		<input type="submit" value="salvar" class="btn_salvar" style="float:right;"/>
	</form>
</fieldset>
<?php
	echo "<p style='color:red;'>";
	if(isset($_POST['titulo']) && isset($_POST['link']) && isset($_POST['dataon']) && isset($_POST['dataoff']) && isset($_FILES['imageslider']) && isset($_POST['password'])){
		
		$titulo = trataValor($_POST['titulo']);
		$link = trataValor($_POST['link']);
		$dataon = explode(" ",trataValor($_POST['dataon']));
		$dataoff = explode(" ",trataValor($_POST['dataoff']));
		$senha = MD5(trataValor($_POST['password']));
		
		$data_on_invert = implode("-",array_reverse(explode("/",$dataon[0])));
		$data_off_invert = implode("-",array_reverse(explode("/",$dataoff[0])));
		
		if(preg_match("/^\w.{3,50}$/",$titulo)){
			$ti_dispo = $connnect->prepare("SELECT * FROM etec_wowslide WHERE w_titulo = ?");
			$ti_dispo->execute(array($titulo));
			
			if($ti_dispo->rowCount() == 0){
				if($userDado->pw === $senha){
					$nomeFoto = $_FILES['imageslider']['name'];
					$camiFoto = $_FILES['imageslider']['tmp_name'];
					$tamanho = strlen($nomeFoto);
					$extensao = substr($nomeFoto,-3,$tamanho);
					
					if($extensao == "png" || $extensao == "jpg" || $extensao == "gif"){
						$file_id = md5($_FILES["imageslider"]["tmp_name"] . rand()*100000);
						$uploaddir = "../..".$raiz."wowslider/";
						$uploadfile = $uploaddir . basename($file_id . ".jpg");
						if(move_uploaded_file($camiFoto, $uploadfile)){
							
							$insert = $connnect->prepare("INSERT INTO etec_wowslide (w_slide,w_data,w_titulo,w_link,w_autor,w_ativacao,w_desativacao) VALUES (?,NOW(),?,?,?,'{$data_on_invert} {$dataon[1]}','{$data_off_invert} {$dataoff[1]}')") or die (SqlErro($connnect->ErrorInfo()[2]));
							$insert->execute(array('wowslider/'.$file_id.'.jpg', $titulo, $link, $userDado->iduser));
							
							
							if($insert){
								echo "Novo Slider cadastrado com sucesso !!!";
							}else
								echo "Fail ao cadastrar.";
							
						}else
							echo "Erro ao tentar upar a imagem";
						
					}else{
						echo "somente .jpg,png, e gif";
					}
				}else
					echo "Autenticação incorreta";
			}else
				echo "Titulo solicitado ja esta em uso";
		}
	}
	echo "</p>";
?>