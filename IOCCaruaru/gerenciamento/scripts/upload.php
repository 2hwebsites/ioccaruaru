<?php
	if(isset($_POST['publicar'])){
		$file = $_FILES['galeria'];
		$numFile = count(array_filter($file['name']));
		$folder = "upload/galeria/".$id;
		$extensoesvalidas = array( 'jpg', 'jpeg', 'jpe', 'gif', 'bmp', 'png' );
		$maxSize = 1024 * 1024 * 2;
		$msg = array();
		$errorMsg = array(
			1 => "O arquivo enviado excede o tamanho limite de 2MB.",
			2 => "O arquivo excede a quantidade limite de 20 imagens.",
			3 => "O upload do arquivo foi feito parcialmente. Tente novamente com os arquivos que não foram carregados, caso o erro persista, 
					informe ao técnico responsável.",
			4 => "Nenhum arquivo foi enviado. Tente novamente, caso o erro persista, informe ao técnico responsável.",
			6 => "Pasta temporária ausente. Informe ao técnico responsável.",
			7 => "Falha em escrever o arquivo em disco. Informe ao técnico responsável.",
			8 => "Uma extensão do PHP interrompeu o upload do arquivo. Informe ao técnico responsável."
		);
		
		if($numFile <= 0){
			echo "Selecione ao menos um arquivo.";
		}else{
			for($i =0; $i < $numFile; $i++){
				$name = $file['name'][$i];
				$type = $file['type'][$i];
				$size = $file['size'][$i];
				$error = $file['error'][$i];
				$tmp = $file['tmp_name'][$i];
				
				$extensao = @end(explode(".", $name));
				$novoNome = date("dmyHms").$name;
				
				if($error != 0){
					$msg[] = "<b>$name : </b>".$errorMsg[$error];
				}elseif(!in_array($type, $extensoesvalidas)){
					$msg[] = "<b>$name : </b> Erro imagem não suportada!";
				}elseif($size > $maxSize){
					$msg[] = "<b>$name : </b> Erro imagem ultrapassa o tamanho limite de 2MB.";
				}else{
					if(move_uploaded_file($tmp, $folder."/".$novoNome)){
						$msg[] = "<b>$name : </b> Imagem carregada com sucesso!";
					}else{
						$msg[] = "<b>$name : </b> Ocorreu um erro!";
					}
				}
				
				foreach($msg as $pop){
					echo $pop."<br />";
				}
			}
		}
	}
?>