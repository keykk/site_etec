<?php
function link_integra_on($categoria,$raiz){
	if(!isset($connnect))
	$connnect = Conexao::getInstance();
	$id = (int)$categoria;
	
	if($id > 0){
		$query = $connnect->prepare("SELECT * FROM etec_categoria WHERE ca_codigo = ?");
		$query->execute(array($id));
		
		if($query->rowCount() == 1){
			
			$links = $connnect->prepare("SELECT * FROM etec_integra WHERE in_categoria = ? AND in_data_on <= NOW() AND in_data_off > NOW() ORDER BY in_titulo ASC LIMIT 0,5");
			$links->execute(array($id));
			
			while($obj_link = $links->fetch(PDO::FETCH_OBJ)){
				echo "<li><a title='{$obj_link->in_titulo}' href='{$raiz}noticias&news={$obj_link->in_codigo}'>";
				echo Encurtatitulo2($obj_link->in_titulo);
				echo "</a></li>";
			}
		}
	}
}
?>