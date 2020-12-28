<script type="text/javascript" src="<?php echo $raiz; ?>tinymce_pt/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo $raiz ?>tinymce_pt/jscripts/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>

<script type="text/javascript">
	tinyMCE.init({
		// General options
    language : "pt",
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,media,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
theme_advanced_buttons1:
"code,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,cleanup,link,unlink,image,media,table,formatselect,fontselect,fontsizeselect,forecolor,backcolor,fullscreen",

		// Theme options
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",


		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
	 content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
    file_browser_callback : "tinyBrowser",
		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->
<form name="frm3" method="post" style="margin:0px;padding:0px;" action="">
<textarea name="mypag" rows="15" cols="80" style="width: 80%">
<?php
if(isset($_GET['b-pagina'])){
	if($_GET['b-pagina'] == "yo" && isset($_GET['action']) && $_GET['action'] == "minhapagina")
		echo $userDado->mypagina;
	else if($_GET['b-pagina'] == "conteudo" && isset($_GET['paginas']) && (int)$_GET['paginas'] > 0){
		echo $paginas->corpo;
	}
}
?>
</textarea>
<?php
	if(isset($_GET['b-pagina'])){
		if($_GET['b-pagina'] == "conteudo" && isset($_GET['paginas'])){
			$valor = "";
			if((int)$_GET['paginas'] > 0){
				$valor = $paginas->titulo;
			}
			echo "<input type='text' name='pa_titulo' placeholder='Titulo da pagina' value='$valor' class='caixaText' style='padding-left:10px;margin-top:10px;' required/>";
		}
	}
?>
<input class="caixaText" name="pww" type="password" placeholder="Senha autenticadora" style="padding-left:10px;margin-top:10px;" required/>
<input type="submit" class="btn_salvar" value="Salvar" style="float:right;"/>
</form>
