<script type="text/javascript" src="<?php echo $raiz; ?>tinymce_pt/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo $raiz ?>tinymce_pt/jscripts/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script>
function exclude(){
	$('#apbtn').show(500);
}
function ocutar(){
	$('#apbtn').hide(500);
}
</script>
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
<?php
	$cod = (int)$_GET['noticia'];
	$noticias->noticia_unica($cod);
	if($noticias->retorno == 1){
	$categorias->categoria_unica($noticias->categoria);
?>

<fieldset>
	<legend><?php echo $noticias->titulo; ?></legend>
	apos alterar os dados atualize a pagina.
	<form name="churiuk" method="post" action="" style="margin:0px;padding:0px;">
	<textarea name="mypag" rows="15" cols="80" style="width: 80%"><?php echo $noticias->conteudo; ?></textarea>
	<input type="text" name="ntitulo" class="caixaText" value="<?php echo $noticias->titulo ?>" style="margin-top:10px;" placeholder="Titulo da noticia" required/>
	<input type="text" class="caixaText datetime" required placeholder="data de inicialização" name="in_data_on" value="<?php echo $noticias->data_on; ?>"/>
	<input type="text" class="caixaText datetime" required placeholder="data de encerramento" name="in_data_off" value="<?php echo $noticias->data_off ?>"/>
	<select name="categoria" class="caixaText">
		<option value="<?php echo $categorias->codigo ?>"><?php echo $categorias->titulo; ?></option>
		<?php
		lista_categoria_option();
		?>
	</select>
	<input type="password" class="caixaText" placeholder="Senha autenticadora" required name="pass"/>
	<input type="submit" value="Salvar" class="btn_salvar" style="float:right;margin-top:10px;"/>
	</form>
	<input type="submit" value="Apagar" onclick='exclude();' class="btn_apagar" style="float:right;margin-top:10px;"/>
</fieldset>
<div id='apbtn' class='addc' style='display:none;clear:both;'>
	<p style='margin:0px;padding:0px;display:inline;color:red;'>você tem certeza que deseja apagar a noticia ?</p>
	<input type='submit' value='sim' class='nao' onclick='ocutar();'/>
	<form method='post' action='' style='margin:0px;padding:0px;display:inline;'>
		<input type='submit' name='sim' value='sim' class='sim'/>
	</form>
	<?php
		if(isset($_POST['sim'])){
			
			$delete = $connnect->prepare("DELETE FROM etec_integra WHERE in_codigo = ?") or die (SqlErro($connnect->ErrorInfo()[2]));
			$delete->execute(array($noticias->codigo));
			
			if($delete){
				header("location: inicial.php?");
			}else
				echo "Falha ao apagar";
		}
	?>
</div>
	<p style="color:red;">
	<?php
		if(isset($_POST['mypag']) && isset($_POST['ntitulo']) && isset($_POST['in_data_on']) && isset($_POST['in_data_off']) && isset($_POST['categoria'])){
			$conteudo = filter_input(INPUT_POST,'mypag');
			$titulo = trataValor($_POST['ntitulo']);
			$data_on = explode(" ",trataValor($_POST['in_data_on']));
			$data_off = explode(" ",trataValor($_POST['in_data_off']));
			$data_on_invert = implode("-",array_reverse(explode("/",$data_on[0])));
			$data_off_invert = implode("-",array_reverse(explode("/",$data_off[0])));
			
			$pass = MD5(trataValor($_POST['pass']));
		
			
			$categoria = (int)$_POST['categoria'];
			
			if($categoria > 0){
				$categorias->categoria_unica($categoria);
				if($categorias->registro == 1){
					if(preg_match("/^\w.{3,50}$/",$titulo)){
						if($userDado->pw === $pass){
							$query = $connnect->prepare("SELECT * FROM etec_integra i JOIN etec_categoria c ON i.in_categoria = c.ca_codigo WHERE c.ca_codigo = ? AND i.in_titulo = ? AND i.in_codigo <> ?");
							$query->execute(array($categoria, $titulo, $noticias->codigo));
							
							if($query->rowCount() == 0){
								$update = $connnect->prepare("UPDATE etec_integra SET in_titulo = ?,in_conteudo = ?,in_data_on = ?,in_data_off = ?,in_editor = ?,in_data_edicao = NOW(),in_categoria = ? WHERE in_codigo = ?") OR DIE (MYSQL_ERROR());
								
								$update->execute(array($titulo, $conteudo, $data_on_invert.' '.$data_on[1], $data_off_invert.' '.$data_off[1], $userDado->name, $categoria, $noticias->codigo));
								
								if($update){
									echo "Dados Atualizado com sucesso!!!";
								}else
									echo "Falha ao atualizar dados";
							}else
								echo "O titulo ja esta em uso";
						}else
							echo "Autenticação incorreta";
					}else
						echo "Titulo irregular, deve estar entre 3 - 50 caracteries";
				}else
					echo "Categoria Invalida";
				
			}else
				echo "categoria invalida";
		}
		echo "</p>";
		
	}else
		include_once("../php/errorpag.php");
	?>