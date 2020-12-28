	<?php
	
			$past = "";
			
			$pegatUr = $_SERVER['REQUEST_URI'];
			$pegatUr2 = str_replace($raiz,"",$pegatUr);
			
			if(substr_count($pegatUr2,"/") > 0){
				$paginasss = explode("/",$pegatUr2);
				$count = count($paginasss);
				$i = 1;
				foreach($paginasss as $value){
					if($i < $count){
						$past .= "../";
					}
					$i++;
				}
			
			}
		
		?>