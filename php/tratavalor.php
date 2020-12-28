<?php
function trataValor($valor){
	$valor = str_replace("'","",$valor);
	$valor = str_replace("(","",$valor);
	$valor = str_replace(")","",$valor);
	$valor = str_replace("{","",$valor);
	$valor = str_replace("}","",$valor);
	$valor = str_replace('"','',$valor);
	$valor = trim($valor); /*removemos os espaÃ§os iniciais e finais do valor*/
	$valor = strip_tags($valor); /*cortamos qualquer tag HTML ou PHP do valor*/
	$valor = addslashes($valor); /*adicionamos uma barra invertida antes de cada aspa dupla ou simples (evitando assim a Inection)*/
	return $valor;
}

function login($usuario,$senha){
	if(!isset($connnect))
	$connnect = Conexao::getInstance();
	
	$login = trataValor($usuario);
	$pass = MD5(trataValor($senha));
	
	if(preg_match("/^\w.{3,20}$/", $login)){
		$query = $connnect->prepare("SELECT * FROM etec_usuario WHERE u_login = ? AND u_senha = ?") or die (SqlErro($connnect->ErrorInfo()[2]));
		$query->execute(array($login, $pass));
		
		if($query->rowCount() === 1){
			$objetoUsuario = $query->fetch(PDO::FETCH_OBJ);
			if($login === $objetoUsuario->u_login && $pass === $objetoUsuario->u_senha){
				
				$_SESSION['etec_login'] = $objetoUsuario->u_login;
				$_SESSION['etec_pass'] = $objetoUsuario->u_senha;
				$_SESSION['etec_username'] = $objetoUsuario->u_nome;
				ob_end_clean();
				header("location: ".$raiz."b-painel/inicial.php");
			}else{
				echo "Usuario ou senha incorretos";
			}
		}else{
			echo "Usuario ou senha incorretos";
		}
	}else{
		echo "Caracteries Irregulares Detectados";
	}

}

function Encurtanome($name){
	$caracter = explode(" ",$name);
	$contage = count($caracter);
	$final = "";
	if(isset($caracter[1])) 
		$final = $caracter[0];
	else
		$final = ucfirst($name);
		
	if(strlen($final) > 9)
			$final = substr($final, 0, 9)."...";
		
	echo ucfirst($final);
}
function Encurtatitulo($name){
		$final = ucfirst($name);
		
	if(strlen($final) > 25)
			$final = substr($final, 0, 25)."...";
		
	return ucfirst($final);
}
function lista_categoria_option(){
	if(!isset($connnect))
	$connnect = Conexao::getInstance();
	
	$query = $connnect->query("SELECT * FROM etec_categoria");
	if($query->rowCount() > 0){
		
		while($obj_categoria = $query->fetch(PDO::FETCH_OBJ)){
			echo "<option value='{$obj_categoria->ca_codigo}'>{$obj_categoria->ca_titulo}</option>";
		}
	}
}
function Encurtatitulo2($name){
		$final = ucfirst($name);
		
	if(strlen($final) > 18)
			$final = substr($final, 0, 18)."...";
		
	return ucfirst($final);
}
function Encurtatitulo_16($name){
		$final = ucfirst($name);
		
	if(strlen($final) > 16)
			$final = substr($final, 0, 16)."...";
		
	return ucfirst($final);
}

function Encurtatitulo_44($name){
		$final = ucfirst($name);
		
	if(strlen($final) > 44)
			$final = substr($final, 0, 44)."...";
		
	return ucfirst($final);
}
?>