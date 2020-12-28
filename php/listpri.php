<?php
	$listpri = $connnect->prepare("SELECT * FROM etec_privilegio WHERE p_nivel <= ? ORDER BY p_nivel ASC");
	$listpri->execute(array($userDado->pri));
	
	if($listpri->rowCount() > 0){
		while($objnivel = $listpri->fetch(PDO::FETCH_OBJ)){
			echo "<option value='{$objnivel->p_codigo}'>{$objnivel->p_nivel}</option>";
		}
	}
?>