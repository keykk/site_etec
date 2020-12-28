<?php
if(isset($_GET['arquivo']) && isset($_GET['largura']) && isset($_GET['altura'])){
include('class/m2brimagem.class.php');
$arquivo	= $_GET['arquivo'];
$largura	= $_GET['largura'];
$altura		= $_GET['altura'];
$oImg = new m2brimagem($arquivo);
$valida = $oImg->valida();
if ($valida == 'OK') {
	$oImg->redimensiona($largura,$altura,'crop');
	$rgb = array(255,255,255);
	 $oImg->legenda('Bispodasilva PHP Tester','11','20','20',$rgb,false,NULL);
    $oImg->grava();
} else {
	die($valida);
}
exit;
}else
	echo "N tem nada aqui '=.=";
?>