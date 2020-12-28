<?php
if(isset($_GET['action']) && $_GET['action'] == "mydados"){
?>
<fieldset>
	<legend>Meus dados</legend>
	<?php
	echo "<p><strong>Apelido:</strong> ".$userDado->apelido."</p>";
	echo "<p><strong>Nome:</strong> ".$userDado->name."</p>";
	echo "<p><strong>Data de Nascimento:</strong> ".$userDado->nascimento."</p>";
	echo "<p><strong>Email:</strong> ".$userDado->email."</p>";
	echo "<p><strong>Sexo:</strong> ".$userDado->sexo."</p>";
	echo "<p><strong>Grupo:</strong> ".$userDado->grupo." => {$userDado->detalhespri}</p>";
	
	?>
	<input style="float:right;margin-top:10px;" class="btn_editar" onclick="location.href='?b-pagina=yo&action=editardados'" type="submit" value="Editar"/>
</fieldset>

<?php
}else if(isset($_GET['action']) && $_GET['action'] == "editardados"){
	$nasc = date("d-m-Y",strtotime($userDado->nascimento));
	echo "
	<form method='post' action='' name='frm'>
	<fieldset>
	<legend>Editar dados cadastrais</legend>
	
	<label for='apelido'>Apelido</label>
	<input id='apelido' name='apelido' required style='padding-left:10px;' value='{$userDado->apelido}' class='caixaText' type='text'/>
	
	<label for='nome'>Nome</label>
	<input id='nome' name='nome' required style='padding-left:10px;' value='{$userDado->name}' class='caixaText' type='text'/>
	
	<label for='email'>E-mail</label>
	<input id='email' name='email' required style='padding-left:10px;' value='{$userDado->email}' class='caixaText' type='email'/>
	
	<label for='date'>Data de nascimento</label>
	<input id='date' name='data' required style='padding-left:10px;' value='{$nasc}' class='caixaText' type='text'/>
	
	<input type='radio' name='sexo' value='Masculino' id='male'/>
	<label for='male'>Masculino</label>
	
	<input type='radio' name='sexo' value='Feminino' id='female'/>
	<label for='female'>Feminino</label>
	<input name='pass' required style='padding-left:10px;' placeholder='Senha autenticadora' class='caixaText' type='password'/>
	<input type='submit' class='btn_salvar' value='Salvar' style='float:right;'/>
	</fieldset>
	
	</form>
	<p style='color:red;margin:0px;padding:0px;'>
	";
	if(isset($_POST['nome']) && isset($_POST['data']) && isset($_POST['sexo']) && isset($_POST['pass']) && isset($_POST['apelido']) && isset($_POST['email'])){
		$apelido = trataValor($_POST['apelido']);
		$nome = trataValor($_POST['nome']);
		$data = trataValor($_POST['data']);
		$sexo = trataValor($_POST['sexo']);
		$senha = trataValor(MD5($_POST['pass']));
		$email = trataValor($_POST['email']);
		
		$vapelido = $connnect->prepare("SELECT * FROM etec_usuario WHERE u_apelido NOT IN (SELECT u_apelido FROM etec_usuario WHERE u_codigo = ?) AND u_apelido = ?");
		$vapelido->execute(array($userDado->iduser, $apelido));
		
		if(preg_match("/^\w.{3,30}$/", $apelido) && $vapelido->rowCount() == 0){

			$vemail = $connnect->prepare("SELECT * FROM etec_usuario WHERE u_email NOT IN (SELECT u_email FROM etec_usuario WHERE u_codigo = ?) AND u_email = ?");
			$vemail->execute(array($userDado->iduser, $email));
			
			if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $email) && $vemail->rowCount() == 0){
		
				if(preg_match("/^\w.{3,30}$/", $nome)){
				
					if(preg_match("/^[0-9\/]/", $data)){
					
						if(preg_match("/^\w.{3,20}$/", $sexo) && $sexo == "Masculino" || $sexo == "Feminino"){
						
							if($senha === $userDado->pw){
							
								$dataInvertida = implode("-",array_reverse(explode("/",$data)));
								$update = $connnect->prepare("UPDATE etec_usuario SET u_nome=?,u_datanasc=?,u_sexo=? WHERE u_codigo = ?");
								$update->execute(array($nome, $dataInvertida, $sexo, $userDado->iduser));
							
								if($update)
									echo "Dados Alterados com sucesso !!!";
								else
									echo "Nenhum registro foi alterado";
							}else
								echo "Senha Invalida";
						}else
							echo "Sexo Invalido";
					}else
						echo "Data Invalido";
				}else
					echo "Nome não é valido";
			}else
				echo "Email Ivalido ou Indisponivel (exemplo@dominio.com)";
		}else
			echo "Apelido Indisponivel";
	}
	echo "</p>
	
	<fieldset>
		<legend>Editar Senha</legend>
		<form name='frm2' method='post' action=''>
		
		<input name='atualpw' required style='padding-left:10px;' placeholder='Senha autenticadora' class='caixaText' type='password'/>
		
		<input name='newpw' required style='padding-left:10px;' placeholder='Nova senha' class='caixaText' type='password'/>
		<input name='newpw2' required style='padding-left:10px;' placeholder='Repetir Nova senha' class='caixaText' type='password'/>
		
		<input type='submit' class='btn_salvar' value='Salvar' style='float:right;'/>
		</form>
	</fieldset>
	<p style='color:red;'>";
		if(isset($_POST['atualpw']) && isset($_POST['newpw']) && isset($_POST['newpw2'])){
			
			$atualSenha = trataValor(MD5($_POST['atualpw']));
			$novaSenha = trataValor(MD5($_POST['newpw']));
			$reNovaSenha = trataValor(MD5($_POST['newpw2']));
			
			if($atualSenha === $userDado->pw){
				if($novaSenha === $reNovaSenha){
				
				if(preg_match("/^\w.{7,100}$/", trataValor($_POST['newpw']))){
					$alter = $connnect->prepare("UPDATE etec_usuario SET u_senha=? WHERE u_codigo = ?");
					$alter->execute(array($novaSenha, $userDado->iduser));
					
					if($alter){
						$_SESSION['etec_pass'] = $novaSenha;
						echo "Senha alterada com sucesso !!!";
					}else
						echo "Nenhuma alteração efetuada.";
				}else
					echo "Senha muito curta, deve estar entre 7 - 100 caracteries";
				}else
					echo "Confirmação de senha Incorreta";
			}else
				echo "Senha Invalida";
		}
	echo "</p>";
}
?>