<fieldset>
	<legend>Criar nova categoria de paginas</legend>
	<form method="post" action="">
	<input type="text" name="cat_titulo" placeholder="Titulo da categoria" class="caixaText"/>
	<input type="text" name="cat_desc" placeholder="Descrição" class="caixaText"/>
	<input type="submit" class="btn_salvar" value="Salvar" style="float:right;"/>
	</form>
</fieldset>
<p style="color:red;">
<?php
	if(isset($_POST['cat_titulo']) && isset($_POST['cat_desc'])){
		$titulo = trataValor($_POST['cat_titulo']);
		$desc = trataValor($_POST['cat_desc']);
		
		if(preg_match("/^\w.{3,50}$/", $titulo)){
			$verificaT = $connnect->prepare("SELECT * FROM etec_categoria WHERE ca_titulo = ?");
			$verificaT->execute(array($titulo));
			
			if($verificaT->rowCount() == 0){
				if(preg_match("/^\w.{5,50}$/", $desc)){
					$novacat = $connnect->prepare("INSERT INTO etec_categoria (ca_titulo, ca_desc, ca_data, ca_autoria) VALUES (?, ?, NOW(), ?)") or die (SqlErro($connnect->ErrorInfo()[2]));
					$novacat->execute(array($titulo, $desc, $_SESSION['etec_username']));
					
					
					if($novacat)
						echo "Nova categoria Registrada";
					else
						echo "Falha ao registrar categoria.";
				}else
					echo "Descrição requer 5-50 (minimo e maximo) caracteries, contendo somente -, _, ., letras e numeros";
			}else{
				echo "Titulo ja existe, escolha outro";
			}
		}else
			echo "Titulo requer 3-50 (minimo e maximo) caracteries, contendo somente -, _, ., letras e numeros";
	}
?>
</p>