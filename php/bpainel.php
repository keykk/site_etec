
<?php
if(isset($_SESSION['etec_login']) && isset($_SESSION['etec_pass'])){
	echo "<a href='{$raiz}b-painel/inicial.php' title='{$userDado->name}'>";
	Encurtanome($userDado->name);
	echo "</a>";
	echo "&nbsp;&nbsp;<a href='".$raiz."logout.php' style='color:#000;'>Sair</a>";
}else{
?>
<center>
	<?php
	if(isset($_POST['user']) && isset($_POST['pass'])){
		login($_POST['user'],$_POST['pass']);
	}
	
	?>
</center>
	<form name="login" method="post" action="">
		<input placeholder="Login" type="text" class="caixaText" name="user"/>
		<input placeholder="Senha" type="password" class="caixaText" name="pass"/>
		<input type="submit" value="OK!" class="submitbtn"/>
	</form>
<?php
}
?>