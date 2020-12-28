<?php
class all_categoria{
	public $codigo;
	public $titulo;
	public $descricao;
	public $data;
	public $autoria;
	public $registro;
	public $noticias;
	
	function setCodigo($valor){
		$this->codigo = $valor;
	}
	function setTitulo($valor){
		$this->titulo = $valor;
	}
	function setDescricao($valor){
		$this->descricao = $valor;
	}
	function setData($valor){
		$this->data = $valor;
	}
	function setAutoria($valor){
		$this->autoria = $valor;
	}
	function setRegistro($valor){
		$this->registro = $valor;
	}
	function setNoticias($valor){
		$this->noticias = $valor;
	}
	
	function categoria_unica($codigo){
		if(!isset($connnect))
			$connnect = Conexao::getInstance();
		
		$id = (int)$codigo;
		
		if($id > 0){
			
			$query = $connnect->prepare("SELECT * FROM etec_categoria WHERE ca_codigo = $id");
			$query->execute(array($id));
			
			$this->registro = $query->rowCount();
			
			
			
			if($this->registro == 1){
				
				$obj_categoria = $query->fetch(PDO::FETCH_OBJ);
				$this->codigo = $obj_categoria->ca_codigo;
				$this->titulo = $obj_categoria->ca_titulo;
				$this->descricao = $obj_categoria->ca_desc;
				$this->data = date("d-m-Y H:i:s",strtotime($obj_categoria->ca_data));
				$this->autoria = $obj_categoria->ca_autoria;
				
				$n_noticias = $connnect->prepare("SELECT * FROM etec_categoria c JOIN etec_integra i ON c.ca_codigo = i.in_categoria WHERE c.ca_codigo = ?");
				$n_noticias->execute(array($this->codigo));
				
				$this->noticias = $n_noticias->rowCount();
			}
		}
	}

}
$categorias = new all_categoria();
?>