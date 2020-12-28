<?php
	class usuarios_malas{
		public $username,$senha,$nome,$grupo,$pri,$apelido,$sexo,$email,$nascimento,$detalhespri,$codigo,$mypagina;
	
		function setUsername($valor){$this->username = $valor;}
		function setSenha($valor){$this->senha = $valor;}
		function setNome($valor){$this->nome = $valor;}
		function setGrupo($valor){$this->grupo = $valor;}
		function setPri($valor){$this->pri = $valor;}
		function setApelido($valor){$this->apelido = $valor;}
		function setSexo($valor){$this->sexo = $valor;}
		function setEmail($valor){$this->email = $valor;}
		function setNascimento($valor){$this->nascimento = $valor;}
		function setDetalhespri($valor){$this->detalhespri = $valor;}
		function setCodigo($valor){$this->codigo = $valor;}
		function setMypagina($valor){$this->mypagina = $valor;}
		
		function usr_mala($codigo){
			if(!isset($connnect))
				$connnect = Conexao::getInstance();
			$id = (int)$codigo;
			if($id > 0){
				$query = $connnect->prepare("SELECT * FROM etec_usuario u JOIN etec_grupo g ON u.u_grupo = g.g_codigo JOIN etec_privilegio p ON g.g_privilegio = p.p_codigo WHERE u.u_codigo = ?");
				$query->execute(array($id));
				
				$obj = $query->fetch(PDO::FETCH_OBJ);
				$this->nome = $obj->u_nome;
				$this->username = $obj->u_login;
				$this->senha = $obj->u_senha;
				$this->grupo = $obj->g_nome;
				$this->pri = $obj->p_nivel;
				$this->apelido = $obj->u_apelido;
				$this->sexo = $obj->u_sexo;
				$this->email = $obj->u_email;
				$this->nascimento = date("d-m-Y",strtotime($obj->u_datanasc));
				$this->detalhespri = $obj->p_etc;
				$this->codigo = $obj->u_codigo;
				$this->mypagina = $obj->u_pagina;
			}
		}
	}
	$mala2 = new usuarios_malas();
	$mala = new usuarios_malas();
?>