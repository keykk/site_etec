<?php
	class all_pagina{
		public $codigo;
		public $titulo;
		public $corpo;
		public $editor;
		public $data;
		public $edicao;
		public $retorno;
		public $criacao;
		
		function setCodigo($valor){
			$this->codigo = $valor;
		}
		
		function setTitulo($valor){
			$this->titulo = $valor;
		}
		
		function setCorpo($valor){
			$this->corpo = $valor;
		}
		
		function setEditor($valor){
			$this->editor = $valor;
		}
		
		function setData($valor){
			$this->data = $valor;
		}
		
		function setEdicao($valor){
			$this->edicao = $valor;
		}
		
		function setRetorno($valor){
			$this->retorno = $valor;
		}
		
		function setCriacao($valor){
			$this->criacao = $valor;
		}
		function pagina_dados($id,$raiz){
			if(!isset($connnect))
				$connnect = Conexao::getInstance();
				
				
			$pa_dados = $connnect->prepare("SELECT * FROM etec_pagina WHERE pa_codigo = ?") or die (SqlErro($connnect->ErrorInfo()[2]));
			$pa_dados->execute(array($id));
			
			$this->retorno = 0;
			if($pa_dados->rowCount() == 1){
				$this->retorno = 1;
				$pa_obj = $pa_dados->fetch(PDO::FETCH_OBJ);
				
				$date = date("d-m-Y H:i:s",strtotime($pa_obj->pa_data));
				$date2 = date("d-m-Y H:i:s",strtotime($pa_obj->pa_edicao));
				
				$this->codigo = $pa_obj->pa_codigo;
				$this->titulo = $pa_obj->pa_titulo;
				$this->corpo = $pa_obj->pa_conteudo;
				$this->criacao = $pa_obj->pa_autoria;
				$this->editor = $pa_obj->pa_editor;
				$this->data = $date;
				$this->edicao = $date2;
			}else{
				if(file_exists("php/errorpag.php"))
					include_once("php/errorpag.php");
				else if(file_exists("../php/errorpag.php"))
					include_once("../php/errorpag.php");
				else
					echo "Pagina solicitada não existe.";
			}
		}
	}
	$paginas = new all_pagina();
	
	function lista_pagina($localizacao,$defaut){
		if(!isset($connnect))
			$connnect = Conexao::getInstance();
			
		$selecionapag = $connnect->query('SELECT * FROM etec_pagina ORDER BY pa_titulo LIMIT 0,5') or die (SqlErro($connnect->ErrorInfo()[2]));
		$linkk = "";
		if($selecionapag->rowCount() > 0){
			while($objpag = $selecionapag->fetch(PDO::FETCH_OBJ)){
				
				if($localizacao === "principal"){
					$linkk = "public&pg={$objpag->pa_codigo}";
				}else
					$linkk = "b-painel/inicial.php?b-pagina=conteudo&paginas={$objpag->pa_codigo}";
				echo "<li title='{$objpag->pa_titulo}'><a href='$defaut$linkk'>";
					echo Encurtanome($objpag->pa_titulo);
				echo "</a></li>";
			}
			$numreg = $selecionapag->rowCount();
			if($numreg == 5){
				if($localizacao === "principal"){
					$linkk = "public";
				}else
					$linkk = "b-painel/inicial.php?b-pagina=conteudo";
					
				echo "<li><a href='{$defaut}$linkk' style='color:red;'>Todas</a></li>";
			}
		}
	}
?>