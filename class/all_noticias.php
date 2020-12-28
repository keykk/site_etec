<?php
	class all_noticia{
		public $codigo;
		public $titulo;
		public $conteudo;
		public $data;
		public $data_on;
		public $data_off;
		public $autoria;
		public $editor;
		public $data_edicao;
		public $categoria;
		public $retorno;
		public $atividade;
		
		function setCodigo($valor){
			$this->codigo = $valor;
		}
		
		function setTitulo($valor){
			$this->titulo = $valor;
		}
		
		function setConteudo($valor){
			$this->conteudo = $valor;
		}
		
		function setData($valor){
			$this->data = $valor;
		}
		
		function setData_on($valor){
			$this->data_on = $valor;
		}
		
		function setData_off($valor){
			$this->data_off = $valor;
		}
		
		function setAutoria($valor){
			$this->autoria = $valor;
		}
		
		function setEditor($valor){
			$this->editor = $valor;
		}
		
		function setData_edicao($valor){
			$this->data_edicao = $valor;
		}
		
		function setCategoria($valor){
			$this->categoria = $valor;
		}
		
		function setRetorno($valor){
			$this->retorno = $valor;
		}
		function setAtividade($valor){
			$this->atividade = $valor;
		}
		
		function noticia_unica($codigo){
			if(!isset($connnect))
				$connnect = Conexao::getInstance();
			
			$id = (int)$codigo;
			if($id > 0){
				$query = $connnect->prepare("SELECT * FROM etec_integra WHERE in_codigo = ?");
				$query->execute(array($id));
				
				$query2 = $connnect->prepare("SELECT * FROM etec_integra WHERE in_codigo = ? AND in_data_on <= NOW() AND in_data_off > NOW()");
				$query2->execute(array($id));
				
				$this->atividade = $query2->rowCount();
				
				$this->retorno = $query->rowCount();
				
				if($this->retorno == 1){
					$obj_noticia = $query->fetch(PDO::FETCH_OBJ);
					$dataon = date("d-m-Y H:i:s",strtotime($obj_noticia->in_data_on));
					$dataoff = date("d-m-Y H:i:s",strtotime($obj_noticia->in_data_off));
					$this->codigo = $obj_noticia->in_codigo;
					$this->titulo = $obj_noticia->in_titulo;
					$this->conteudo = $obj_noticia->in_conteudo;
					$this->data = date("d-m-Y H:i:s",strtotime($obj_noticia->in_data));
					$this->data_on = $dataon;
					$this->data_off = $dataoff;
					$this->autoria = $obj_noticia->in_autoria;
					if(strlen($obj_noticia->in_editor) > 1){
					$this->editor = $obj_noticia->in_editor;
					}else
						$this->editor = "--";
					if(strlen($obj_noticia->in_data_edicao) > 1){
					$this->data_edicao = date("d-m-Y H:i:s",strtotime($obj_noticia->in_data_edicao));
					}else
						$this->data_edicao = "--";
					$this->categoria = $obj_noticia->in_categoria;
				}
			}
		}
	}
	
	$noticias = new all_noticia();
?>