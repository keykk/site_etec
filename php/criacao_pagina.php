<fieldset>
	<legend>Criar uma nova pagina</legend>
	<?php
		include_once("../tinymce_pt/examples/full.php");
	?>
</fieldset>
<p style="color:red;">
	<?php
	if(isset($_POST['pa_titulo']) && isset($_POST['mypag']) && isset($_POST['pww'])){
		
		$pa_titulo = filter_input(INPUT_POST,'pa_titulo', FILTER_SANITIZE_STRING);
		$senha = trataValor(MD5($_POST['pww']));
		$dados = FILTER_INPUT(INPUT_POST,'mypag');
		
		if($senha === $userDado->pw){
			if(preg_match("/^\w.{3,80}$/", $pa_titulo)){
				
				$pa_dispo = $connnect->prepare("SELECT * FROM etec_pagina WHERE pa_titulo = ?");
				$pa_dispo->execute(array($pa_titulo));
				
				if($pa_dispo->rowCount() == 0){
					
					$insert = $connnect->prepare("INSERT INTO etec_pagina (pa_titulo,pa_conteudo,pa_autoria,pa_data,pa_edicao) VALUES (?,?,?,NOW(),NOW())") or die (SqlErro($connnect->ErrorInfo()[2]));
					$insert->execute(array($pa_titulo, $dados, $userDado->name));
					
					if($insert)
						echo "Sucesso!!! -> Nova pagina Publicada.";
					else
						echo "Falha ao publicar nova pagina.";
				}else
					echo "Titulo Indisponivel";
				
			}else
				echo "Titulo Invalido, os caracteries deve estar entre 3 e 80";
		}else
			echo "Autenticação Incorreta";
		
	}
	?>
	</p>