<?php
class all_groups{
	public $groupname;
	public $date_b;
	public $privilegio;
	public $autor;
	
	function setGroupname($valor){
		$this->groupname = $valor;
	}
	function setDate_b($valor){
		$this->date_b = $valor;
	}
	function setPrivilegio($valor){
		$this->privilegio = $valor;
	}
	function setAutor($valor){
		$this->autor = $valor;
	}
	
	function todosGrupos(){
		if(!isset($connnect))
			$connnect = Conexao::getInstance();
		$query = $connnect->prepare("SELECT * FROM etec_grupo G JOIN etec_privilegio P ON G.g_privilegio = P.p_codigo WHERE P.p_nivel <= (SELECT p.p_nivel FROM etec_usuario u JOIN etec_grupo g ON u.u_grupo = g.g_codigo JOIN etec_privilegio p ON g.g_privilegio = p.p_codigo WHERE u.u_login = ?) LIMIT 5");
		
		$query->execute(array($_SESSION['etec_login']));
		
		if($query->rowCount() > 0){
			
			while($grp = $query->fetch(PDO::FETCH_OBJ)){
				$this->groupname = $grp->g_nome;
				$this->date_b = $grp->g_data;
				$this->privilegio = $grp->p_nivel;
				$this->autor = $grp->autor;
				echo "<li><a href='?b-pagina=groups&action={$grp->g_codigo}'>{$grp->g_nome}</a></li>";
			}
				echo "<li><a style='color:red;' href='?b-pagina=groups&action=todos'>Todos</a></li>";
			
		}
	}
	
	function listaGrupos(){
		if(!isset($connnect))
			$connnect = Conexao::getInstance();
		
		$query = $connnect->prepare("SELECT * FROM etec_grupo G JOIN etec_privilegio P ON G.g_privilegio = P.p_codigo WHERE P.p_nivel <= (SELECT p.p_nivel FROM etec_usuario u JOIN etec_grupo g ON u.u_grupo = g.g_codigo JOIN etec_privilegio p ON g.g_privilegio = p.p_codigo WHERE u.u_login = ?)");
		
		$query->execute(array($_SESSION['etec_login']));
		
		if($query->rowCount() > 0){
			
			while($grp = $query->fetch(PDO::FETCH_OBJ)){
				$this->groupname = $grp->g_nome;
				$this->date_b = $grp->g_data;
				$this->privilegio = $grp->p_nivel;
				$this->autor = $grp->autor;
				echo "<option value='{$grp->g_codigo}'>{$grp->g_nome}</option>";
			}
		}
	}

}


?>