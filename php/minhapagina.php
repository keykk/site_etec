<fieldset>
	<legend>Meu Conteudo</legend>
	<p>Seu conteudo esta disponivel em <?php echo $raiz.$userDado->apelido; ?>
	<br />
	<br />
	<?php
	include_once("../tinymce_pt/examples/full.php");

	?>
</fieldset>
<?php
	echo "<p style='color:red;'>";
	if(isset($_POST['mypag']) && isset($_POST['pww'])){
		$senha = trataValor(MD5($_POST['pww']));
		$dados = filter_var($_POST['mypag']);
		
		if($senha === $userDado->pw){
			$query = $connnect->prepare("UPDATE etec_usuario SET u_pagina = ? WHERE u_codigo = ?") or die (SqlErro($connnect->ErrorInfo()[2]));
			$query->execute(array($dados, $userDado->iduser));
			
			if($query->rowCount() > 0){
				echo "Pagina pessoal Atualizada.";
			}else
				echo "Nenhum registro Atualizado.";
		}else
			echo "Senha Invalida";
	}
	echo "</p>";
?>