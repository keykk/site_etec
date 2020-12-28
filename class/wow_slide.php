<?php
class wow_dado{
	public $codigo,$slide,$data,$link,$autor,$editor,$ativo,$desativo,$retorno,$estado,$titulo;
	
	function setCodigo($valor){$this->codigo = $valor;}
	function setSlide($valor){$this->slide = $valor;}
	function setData($valor){$this->data = $valor;}
	function setLink($valor){$this->link = $valor;}
	function setAutor($valor){$this->autor = $valor;}
	function setEditor($valor){$this->editor = $valor;}
	function setAtivo($valor){$this->ativo = $valor;}
	function setDesativo($valor){$this->desativo = $valor;}
	function setRetorno($valor){$this->retorno = $valor;}
	function setEstado($valor){$this->estado = $valor;}
	function setTitulo($valor){$this->titulo = $valor;}
	
	function wowslider($codigo){
		if(!isset($connnect))
			$connnect = Conexao::getInstance();
		$id = (int)$codigo;
		
		if($id > 0){
			$query = $connnect->prepare("SELECT * FROM etec_wowslide WHERE w_codigo = ?");
			$query->execute(array($id));
			
			$this->retorno = $query->rowCount();
			
			if($this->retorno == 1){
				$obj = $query->fetch(PDO::FETCH_OBJ);
				$this->codigo = $obj->w_codigo;
				$this->slide = $obj->w_slide;
				$this->data = date("d-m-Y H:i:s",strtotime($obj->w_data));
				$this->link = $obj->w_link;
				$this->autor = $obj->w_autor;
				$this->editor = $obj->w_editor;
				$this->ativo = date("d-m-Y H:i:s",strtotime($obj->w_ativacao));
				$this->desativo = date("d-m-Y H:i:s",strtotime($obj->w_desativacao));
				$this->titulo = $obj->w_titulo;
			}
		}
	}
}
$wowslider = new wow_dado();

?>