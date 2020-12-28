<?php
class grupo{
	public $username,$pw,$name,$grupo,$pri,$apelido,$sexo,$email,$nascimento,$detalhespri,$iduser,$mypagina;
	
	function setUsername($valor){$this->username = $valor;}
	function setPw($valor){$this->pw = $valor;}
	function setName($valor){$this->name = $valor;}
	function setGrupo($valor){$this->grupo = $valor;}
	function setPri($valor){$this->pri = $valor;}
	function setApelido($valor){$this->apelido = $valor;}
	function setSexo($valor){$this->sexo = $valor;}
	function setEmail($valor){$this->email = $valor;}
	function setNascimento($valor){$this->nascimento = $valor;}
	function setDetalhespri($valor){$this->detalhespri = $valor;}
	function setIduser($valor){$this->iduser = $valor;}
	function setMypagina($valor){$this->mypagina = $valor;}
	
	function dados_usuario(){
		if(!isset($connnect))
			$connnect = Conexao::getInstance();
			
		$query = $connnect->prepare("SELECT * FROM etec_usuario u JOIN etec_grupo g ON u.u_grupo = g.g_codigo JOIN etec_privilegio p ON g.g_privilegio = p.p_codigo WHERE u.u_login = ? AND u.u_senha = ?");
		
		$query->execute(array($this->username, $this->pw));
		
		if($query->rowCount() === 1){
			$objetoUsuario = $query->fetch(PDO::FETCH_OBJ);
			$this->grupo = $objetoUsuario->g_nome;
			$this->pri = $objetoUsuario->p_nivel;
			$this->name = $objetoUsuario->u_nome;
			$this->apelido = $objetoUsuario->u_apelido;
			$this->sexo = $objetoUsuario->u_sexo;
			$this->email = $objetoUsuario->u_email;
			$this->nascimento = $objetoUsuario->u_datanasc;
			$this->detalhespri = $objetoUsuario->p_etc;
			$this->iduser = $objetoUsuario->u_codigo;
			$this->mypagina = $objetoUsuario->u_pagina;
		}else{
			echo "SUA AUTENTICAÇÃO É INVALIDA.";
			ob_end_clean();
			session_destroy();
			header("location: ".$raiz."/index.php");
		}
	}
	
}

$userDado = new grupo();
$userDado->username = $_SESSION['etec_login'];
$userDado->pw = $_SESSION['etec_pass'];
$userDado->dados_usuario();
?>