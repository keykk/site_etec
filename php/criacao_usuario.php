<script>
function verificaGrupo(key){
	$.post("scriptspost/privilegiolist.php",{group:key}, function(retorno){
		$('#privilegio').html(retorno);
	});
}

</script>
<style>
input{
padding-left:15px;
padding-right:15px;
}
</style>
<fieldset>
	<legend class="textEstiloso">Criar Novo Usuario</legend>
	<form method="post" action="">
		<input required type="text" name="apelido" placeholder="Apelido" class="caixaText"/>
		<input required type="text" name="nome" placeholder="Nome" class="caixaText"/>
		<input required type="text" name="nasc" id="date" placeholder="Data de nascimento DD/MM/YYYY" class="caixaText"/>
		<input required type="text" name="cpf" id="cpf" placeholder="CPF" class="caixaText"/>
		<input required type="email" name="email" placeholder="Email" class="caixaText"/>
		<input required type="text" name="login" placeholder="Login" class="caixaText"/>
		<input required type="password" name="pw" placeholder="Senha" class="caixaText"/>
		
		<select required name="pri" class="caixaText" id="listpri" style="width:35%;float:left;" onchange="verificaGrupo(this.value);">
			<option>Selecione O Grupo</option>
			<?php
				$gruposandpri->listaGrupos();
			?>
		</select>
		<div style="margin-left:36.5%;text-align:justify;" id="privilegio"></div>
		<div id="sexo" style="width:100%;clear:both;">
			<p>Sexo: </p>
		<input type="radio" name="radio" value="Masculino" id="rd1"/><label for="rd1">Masculino</label>
		<input type="radio" value="Feminino" name="radio" id="rd2"/><label for="rd2">Feminino</label>
		</div>
		<input type="submit" class="btn_salvar" style="float:right;font-family: 'Cinzel', serif;" value="Salvar"/>
	</form>
</fieldset>
<p style="color:red;">
<?php
if(isset($_POST['apelido']) && isset($_POST['nome']) && isset($_POST['nasc']) && isset($_POST['cpf']) && isset($_POST['email']) && isset($_POST['login']) && isset($_POST['pw']) && isset($_POST['pri']) && isset($_POST['radio'])){
	
	$apelido = trataValor($_POST['apelido']);
	$nome = trataValor($_POST['nome']);
	$nasc = trataValor($_POST['nasc']);
	$cpf = trataValor($_POST['cpf']);
	$email = trataValor($_POST['email']);
	$login = trataValor($_POST['login']);
	$senha = trataValor(MD5($_POST['pw']));
	$privilegio = (int) $_POST['pri'];
	$sexo = trataValor($_POST['radio']);
	
	if(validaCPF($cpf) == true){

		$vapelido = $connnect->prepare("SELECT * FROM etec_usuario WHERE u_apelido = ?");
		$vapelido->execute(array($apelido));
		
		if(preg_match("/^\w.{3,30}$/", $apelido) && $vapelido->rowCount() == 0){
			if(preg_match("/^\w.{3,30}$/", $nome)){
				if(preg_match("/^[0-9\/]/", $nasc)){
					$vcpf = $connnect->prepare("SELECT * FROM etec_usuario WHERE u_cpf = ?");
					$vcpf->execute(array($cpf));
					
					if(preg_match("/^[0-9.-]/", $cpf) && $vcpf->rowCount() == 0){
						$vemail = $connnect->prepare("SELECT * FROM etec_usuario WHERE u_email = ?");
						$vemail->execute(array($email));
						
						if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $email) && $vemail->rowCount() == 0){
							$vlogin = $connnect->prepare("SELECT * FROM etec_usuario WHERE u_login = ?");
							$vlogin->execute(array($login));
							
							if(preg_match("/^\w.{3,30}$/", $login) && $vlogin->rowCount() == 0){
								if(preg_match("/^\w.{3,100}$/", $senha)){
									if(preg_match("/^\w.{3,20}$/", $sexo) && $sexo == "Masculino" || $sexo == "Feminino"){
										
										$vgrup = $connnect->prepare("SELECT * FROM etec_grupo g JOIN etec_privilegio p ON g.g_privilegio = p.p_codigo WHERE g.g_codigo = ? AND p.p_nivel <= ?");
										$vgrup->execute(array($privilegio, $userDado->pri));
										
										if($vgrup->rowCount() == 1){
											$dataInvertida = implode("-",array_reverse(explode("/",$nasc)));
											$insert = $connnect->prepare("INSERT INTO etec_usuario (u_login,u_senha,u_datanasc,u_dataregistro,u_cpf,u_nome,u_sexo,u_email,u_autor,u_grupo,u_apelido) VALUES (?,?,?,CURDATE(),?,?,?,?,?,?,?)") or die (SqlErro($connnect->ErrorInfo()[2]));
											$insert->execute(array($login, $senha, $dataInvertida, $cpf, $nome, $sexo, $email, $userDado->name, $privilegio, $apelido));
											
											
											if($insert){
												echo "Dados Gravados com Sucesso !!!";
											}else
												echo "Falha ao gravar dados";
										}else
											echo "Grupo solicitado é invalido, ou acesso negado";
										
									}else
										echo "Sexo Invalido";
								}else
									echo "Senha esta irregular";
							}else
								echo "Login Indisponivel";
						}else
							echo "Email Indisponivel => exemplo@dominio.com";
					}else
						echo "CPF indisponivel";
				}else
					echo "Data de nascimento invalida";
			}else
				echo "Nome cotem caracteries irregulares";
		}else
			echo "Apelido Indisponivel";
	
	}else
		echo "CPF INVALIDO";
}
?>
</p>