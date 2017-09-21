<?php
	function extensao($arquivo){
		$tam = strlen($arquivo);

		//ext de 3 chars
		if( $arquivo[($tam)-4] == '.' ){
			$extensao = substr($arquivo,-3);
		}elseif( $arquivo[($tam)-5] == '.' ){ //ext de 4 chars
			$extensao = substr($arquivo,-4);
		}elseif( $arquivo[($tam)-3] == '.' ){ //ext de 2 chars
			$extensao = substr($arquivo,-2);
		}else{ //Caso a extensão não tenha 2, 3 ou 4 chars ele não aceita e retorna Nulo.
			$extensao = NULL;
		}

		return $extensao;
	}

/*
  Função converte_data
  Autor : Adir Amaral - Taober.com.br
  Data  : 18/11/2002
  Versão: 1.0

Esta função não necessita de parâmetros
ela converte a data automaticamente no
padrão americano para brasileiro e vice-versa
basta usar assim:

echo converte_data("data_a_converter");

*/

function converte_data($data){

	if($data==Null){
		return Null;
	}

	if (strstr($data, "/")){
		$A = explode("/", $data);
		$V_data = $A[2] . "-". $A[1] . "-" . $A[0];
	}
	else{
		$A = explode("-", $data);
		$V_data = $A[2] . "/". $A[1] . "/" . $A[0];	
	}
	return $V_data;
}

function converte_data2($data){

	if($data==Null){
		return Null;
	}

	if (strstr($data, "/")){
		$A = explode ("/", $data);
		$V_data = $A[2] . "-". $A[1] . "-" . $A[0];
	}
	else{
		$A = explode ("-", $data);
		$V_data = $A[2] . "|". $A[1] . "|" . $A[0];	
	}
	return $V_data;
}



//combo estado civil
function combo($tabela,$nome, $descricao, $selecionado=''){
		$combo = "<select name=\"$nome\" >";
	  	
		$secaoSql    = "SELECT  * FROM ".$tabela;
		$secaoQy     = mysql_query($secaoSql) or die(mysql_error());
		while($secaoRow    = mysql_fetch_assoc($secaoQy)){
		$combo .= "<option value=". $secaoRow['codigo']. ">".$secaoRow[$descricao]."</option>";
		}
		$combo .= "</select>";
		return $combo;

}

function redireciona($link){
	if ($link == -1){
		echo" <script>history.go(-1);</script>";
	}else{
		echo" <script>document.location.href='$link'</script>";
	}
}

function geraImg($img, $max_x, $max_y, $imgNome, $percent) { 
    //pega o tamanho da imagem ($original_x, $original_y)
    list($width, $height) = getimagesize($img); 
    $original_x = $width; 
    $original_y = $height;
	
	$porcentagem = (100 * $max_x) / $original_x;  //calcular pelo X

	$tipo = extensao($imgNome); //ver essa funcao acima
	
    // se a largura for maior que altura acho a porcentagem 
    /*if($original_x > $original_y) { 
       $porcentagem = (100 * $max_x) / $original_x;       
    } 
    else { 
       $porcentagem = (100 * $max_y) / $original_y;   
    } 
	*/
    $tamanho_x = $original_x * ($porcentagem / 100); 
    $tamanho_y = $original_y * ($porcentagem / 100); 
    $image_p = imagecreatetruecolor($tamanho_x, $tamanho_y); 
    
	if($tipo=='gif'){
		$image = imagecreatefromgif($img); 
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $tamanho_x, $tamanho_y, $width, $height); 
		return imagegif($image_p, $imgNome, $percent); 
	}else{
		if($tipo == 'png'){
			$image = imagecreatefrompng($img); 
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $tamanho_x, $tamanho_y, $width, $height); 
			return imagepng($image_p, $imgNome, 9); 
		} else{
			$image = imagecreatefromjpeg($img); 
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $tamanho_x, $tamanho_y, $width, $height); 
			return imagejpeg($image_p, $imgNome, $percent); 
		}
	}	
} 

function geraImg2($img, $max_x, $max_y, $imgNome, $percent) { 
    //pega o tamanho da imagem ($original_x, $original_y) 
    list($width, $height) = getimagesize($img); 
    $original_x = $width; 
    $original_y = $height; 
	
	$tipo = extensao($imgNome); //ver essa funcao acima
	
    // se a largura for maior que altura acho a porcentagem 
    if($original_x > $original_y) { 
       $porcentagem = (100 * $max_x) / $original_x;       
    } 
    else { 
       $porcentagem = (100 * $max_y) / $original_y;   
    } 
	
    $tamanho_x = $original_x * ($porcentagem / 100); 
    $tamanho_y = $original_y * ($porcentagem / 100); 
    $image_p = imagecreatetruecolor($tamanho_x, $tamanho_y); 
    
	if($tipo=='gif'){
		$image = imagecreatefromgif($img); 
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $tamanho_x, $tamanho_y, $width, $height); 
		return imagegif($image_p, $imgNome, 80); 
		}else{
			$image = imagecreatefromjpeg($img); 
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $tamanho_x, $tamanho_y, $width, $height); 
			return imagejpeg($image_p, $imgNome, 80); 
			}
		
		
} 



function gera_enquete($pagina){
$enq = mysql_query("select * from enquete where enquete=0 and atual=1");
$enquete = mysql_fetch_assoc($enq);
echo "<div>";
echo "<span class='enquete_questao'>$enquete[nome]</span>";
$perg = mysql_query("select * from enquete where enquete=$enquete[codigo]");
echo "<form action=.?$pagina method='post' style='padding:0;margin:0' id='enquete_voto'>
	  <div class='alternativas'>";
echo "<input type='hidden' name='enqueteAtual' value='$enquete[codigo]'/>\n";
while($perguntas=mysql_fetch_assoc($perg)){
	echo "<label><input type='radio' name='codigoVoto' value='$perguntas[codigo]'/>
		  $perguntas[nome]</label><br/><br/>\n";
}
echo "</div>
		<div class='enquete_bts'>
		<br/>
		<input name='Submit' type='submit'  value='votar'/>
	  	<a href='pizza.php' id='resultado'>
		<input name='resultado' type='button' id='resultado' value='Resulltado'/>
		</a>
	  </div>
	</form></div>";

}
	
function getPai($id){
		$pai = mysql_fetch_assoc(mysql_query("select * from categorias where id='$id'"));
		return $pai['pai'];

}

//Script para remover acentos e caracteres especiais:
function removeAcentos($palavra){
	$trans = array(	"á" => "a", "à" => "a",
					"ã" => "a", "â" => "a",
					"é" => "e", "ê" => "e",
					"í" => "i", "ó" => "o",
					"ô" => "o", "õ" => "o",
					"ú" => "u", "ü" => "u",
					"ç" => "c", "Á" => "A", 
					"À" => "A", "Ã" => "A",
					"Â" => "A", "É" => "E",
					"Ê" => "E", "Í" => "I",
					"Ó" => "O", "Ô" => "O",
					"Õ" => "O", "Ú" => "U",
					"Ü" => "U", "Ç" => "C"
				  );
  $palavra = strtr(trim($palavra), $trans);
  return $palavra;
}
   
function anti_injection($sql, $formUse = true)
 {
 // remove palavras que contenham sintaxe sql
 $sql = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i","",$sql);
 $sql = trim($sql);//limpa espaços vazio
 $sql = strip_tags($sql);//tira tags html e php
 if(!$formUse || !get_magic_quotes_gpc())
 $sql = addslashes($sql);//Adiciona barras invertidas a uma string
 return $sql;
 } 

function paginacao($pagina, $total, $link){
	if($total > 1){
		echo "<div id='paginas'> \n";
		echo "<div id='paginacao'> \n";
	
		if ($pagina > 1){
			echo "						<a href='".$link."1' class='btn_navegacao'><img src='img/primeiro_pequeno.fw.png' alt='' /></a> \n";
			echo "						<a href='".$link.($pagina - 1)."' class='btn_navegacao'><img src='img/anterior_pequeno.fw.png' alt='' /></a> \n";
		}else{
			echo "						<p class='semLink btn_navegacao'><img src='img/primeiro_pequeno_sem_link.fw.png' alt='' /></p> \n";
			echo "						<p class='semLink btn_navegacao'><img src='img/anterior_pequeno_sem_link.fw.png' alt='' /></p> \n";
		}
	
		// Listando as paginas
		if($total <= 3){
			for($i = 1; $i <= $total; $i++){
				if($i != $pagina) {
					echo "<a href='".$link.$i."' class='numero'>".$i."</a>";
				} else {
					echo "<p class='semLink numero'>".$i."</p>";
				}
			}
		} else{
			if($pagina <= ($total - 2)){
				for($i = ($pagina > 2 ? $pagina - 1 : 1); $i <= ($pagina > 2 ? $pagina + 1 : 3); $i++){
					if($i != $pagina) {
						echo "						<a href='".$link.$i."' class='numero'>".$i."</a> \n";
					} else {
						echo "						<p class='semLink numero'>".$i."</p> \n";
					}
				}
			} else {
				for($i = ($total - 2); $i <= $total; $i++){
					if($i != $pagina) {
						echo "						<a href='".$link.$i."' class='numero'>".$i."</a> \n";
					} else {
						echo "						<p class='semLink numero'>".$i."</p> \n";
					}
				}
			}
		}
	
		if ($pagina < $total){
			echo "						<a href='".$link.($pagina + 1)."' class='btn_navegacao'><img src='img/proximo_pequeno.fw.png' alt='' /></a> \n";
			echo "						<a href='".$link.$total."' class='btn_navegacao last'><img src='img/ultimo_pequeno.fw.png' alt='' /></a> \n";
		}else{
			echo "						<p class='semLink btn_navegacao'><img src='img/proximo_pequeno_sem_link.fw.png' alt='' /></p> \n";
			echo "						<p class='semLink btn_navegacao last'><img src='img/ultimo_pequeno_sem_link.fw.png' alt='' /></p> \n";
		}
			
		echo "					</div> \n";
		echo "</div> \n";
	}
}

function ValidaData($dat){
	$data = explode("/","$dat"); // fatia a string $dat em pedados, usando / como referência

	$d = @$data[0];
	$m = @$data[1];
	$y = @$data[2];

	// verifica se a data é válida!
	// 1 = true (válida)
	// 0 = false (inválida)
	$res = 0;
	if ($d !='' and $m !='' and $y !=''){
		$res = checkdate($m,$d,$y);
	}
	
	if ($res == 1){
	   return true;
	} else {
	   return false;;
	}
}

function get_link_tour($sub){
if($sub!=""){
	$link = BASE."/".$sub."/tourvirtual/";
	}else{
	$link = BASE."/tourvirtual/";
	}
	return $link;
}


function agenda($data){
				
				if(empty($data)){//navega&ccedil;ao entre os meses
				
					$dia = date('d');
				
					$month =ltrim(date('m'),"0");
				
					$ano = date('Y');
				
				}else{
				
					$data = explode('/',$data);//nova data
				
					$dia = $data[0];
				
					$month = $data[1];
				
					$ano = $data[2];
				
				}
				
				if($month==1){//m&ecirc;s anterior se janeiro mudar valor
				
					$mes_ant = 12;
				
					$ano_ant = $ano - 1;
				
				}else{
				
					$mes_ant = $month - 1;
				
					$ano_ant = $ano;
				
				}
				if($month==12){//proximo m&ecirc;s se dezembro tem que mudar
				
					$mes_prox = 1;
				
					$ano_prox = $ano + 1;
				
				}else{
				
					$mes_prox = $month + 1;
				
					$ano_prox = $ano;
				
				}
				
				
				
				$hoje = date('j');//fun&ccedil;&atilde;o importante pego o dia corrente
				
				switch($month){/*notem duas variaveis para o switch para identificar dia e limitar numero de dias*/
				
					case 1: $mes = "JANEIRO";
				
							$n = 31;
				
					break;
				
					case 2: $mes = "FEVEREIRO";// todo ano bixesto fev tem 29 dias
				
							$bi = $ano % 4;//anos multiplos de 4 s&atilde;o bixestos
				
							if($bi == 0){
				
								$n = 29;
				
							}else{
				
								$n = 28;
				
							}
				
					break;
				
					case 3: $mes = "MAR&Ccedil;O";
				
							$n = 31;
				
					break;
				
					case 4: $mes = "ABRIL";
				
							$n = 30;
				
					break;
				
					case 5: $mes = "MAIO";
				
							$n = 31;
				
					break;
				
					case 6: $mes = "JUNHO";
				
							$n = 30;
				
					break;
				
					case 7: $mes = "JULHO";
				
							$n = 31;
				
					break;
				
					case 8: $mes = "AGOSTO";
				
							$n = 31;
				
					break;
				
					case 9: $mes = "SETEMBRO";
				
							$n = 30;
				
					break;
				
					case 10: $mes = "OUTUBRO";
				
							$n = 31;
				
					break;
				
					case 11: $mes = "NOVEMBRO";
				
							$n = 30;
				
					break;
				
					case 12: $mes = "DEZEMBRO";
				
							$n = 31;
				
					break;
				
				}
				
				
				
				$pdianu = mktime(0,0,0,$month,1,$ano);//primeiros dias do mes
				
				$dialet = date('D', $pdianu);//escolhe pelo dia da semana
				
				switch($dialet){//verifica que dia cai
				
					case "Sun": $branco = 0; break;
				
					case "Mon": $branco = 1; break;
				
					case "Tue": $branco = 2; break;
				
					case "Wed": $branco = 3; break;
				
					case "Thu": $branco = 4; break;
				
					case "Fri": $branco = 5; break;
				
					case "Sat": $branco = 6; break;
				
				}            
				
				
				
					print '<table class="tabela" >';//constru&ccedil;&atilde;o do calendario
				
					print '<tr>';
				
					print '<td class="mes"><a href="?data='.$dia.'/'.$mes_ant.'/'.$ano_ant.'" title="M&ecirc;s anterior"> << </a></td>';/*m&ecirc;s anterior*/
					//print '<td class="mes"></td>';/*m&ecirc;s anterior*/
					print '<td class="mes" colspan="5">'.$mes.'/'.$ano.'</td>';/*mes atual e ano*/
				
					print '<td class="mes"><a href="?data='.$dia.'/'.$mes_prox.'/'.$ano_prox.'" title="Pr&oacute;ximo m&ecirc;s">  >> </a></td>';/*Proximo m&ecirc;s*/
					//print '<td class="mes"></td>';/*Proximo m&ecirc;s*/
				
				
					print '</tr><tr>';
				
					print '<td class="sem">D</td>';//printar os dias da semana
				
					print '<td class="sem">S</td>';
				
					print '<td class="sem">T</td>';
				
					print '<td class="sem">Q</td>';
				
					print '<td class="sem">Q</td>';
				
					print '<td class="sem">S</td>';
				
					print '<td class="sem">S</td>';
				
					print '</tr><tr>';
				
					$dt = 1;
				
					if($branco > 0){
				
						for($x = 0; $x < $branco; $x++){
				
							 print '<td>&nbsp;</td>';/*preenche os espa&ccedil;os em branco*/
				
							$dt++;
				
						}
				
					}
				
					
					$qt =0;
					for($i = 1; $i <= $n; $i++ ){/*agora vamos no banco de dados verificar os evendos*/
							$dtevento = $ano."-".$month."-".$i;
				
						
						$sqlag = mysql_query("SELECT * FROM paginas WHERE id_secao = 3 and ativo = 1 and data = '$dtevento'") or die(mysql_error());
				
								$num = mysql_num_rows($sqlag);/*quantos eventos tem para o mes*/
								$idev = @mysql_result($sqlag, 0, "data");
								$eve = @mysql_result($sqlag, 0, "titulo");              
								$eid = @mysql_result($sqlag, 0, "id");              
					
								if($num > 0){/*prevalece qualquer dia especial do calendario, por isso est&aacute; em primeiro*/
				
						   print '<td class="evt">';
				
						   //print '<a href="?d='.$idev.'&data='.$dia.'/'.$month.'/'.$ano.'" title="'.$eve.'">'.$i.'</a>';
						   print '<a href=".?agenda/ct/'.$eid.'/'.removeAcentos($eve).'" title="'.$eve.'">'.$i.'</a>';
						   print '</td>';
				
						   $dt++;/*incrementa os dias da semana*/
				
								   $qt++;/*quantos eventos tem no mes*/
				
						}elseif($i == $hoje){/*imprime os dia corrente*/
				
							print '<td class="hj">';
				
							print $i;
				
							print '</td>';
				
							$dt++;
				
						
				
						}elseif($dt == 1){/*imprime os domingos*/
				
							print '<td class="dom">';
				
							print $i;
				
							print '</td>';
				
							$dt++;
				
						}else{/*imprime os dias normais*/
				
									print '<td class="td">';
				
							print $i;
				
							print '</td>';
				
							$dt++;
				
								}
				
						if($dt > 7){/*faz a quebra no sabado*/
				
						print '</tr><tr>';
				
						$dt = 1;
				
						}
				
					}
				
					print '</tr>';
				
					print '</table>';
	}
	
	function montaURL($titulo){
		// Remove acentos, deixa todas as letras minúsculas e retica os caracteres especiais
		$url_post = preg_replace("/[^a-zA-Z0-9 ]/", "", strtolower(removeAcentos($titulo)));
		
		// substitui espaços em branco por hífen(-)
		$url_post = preg_replace('/[ -]+/', '-', $url_post);
		
		return $url_post;
	}
	
	function InserirDados($campos, $valores, $tabela){
		// Inicializa sa variáveis
		$camposQuery = '';
		$valoresQuery = '';
		$numCampos = max(array_keys($campos));
		$sql = '';
		$id = '';
		
		// Organiza os campos e seus valores
		for ($i = 0; $i <=$numCampos; $i++){
			$camposQuery = $camposQuery.$campos[$i].($i < $numCampos ? ", " : "");
			$valoresQuery = $valoresQuery.$valores[$i].($i < $numCampos ? ", " : "");
		}
		
		// Abre a conexão
		include "../connections/conn.php";
		
		// Insere os dados na tabela
		if($sql = mysqli_query($conn, "INSERT INTO ".$tabela."(".$camposQuery.") VALUES(".$valoresQuery.")")){
			// Obtém o ID do do novo registro
			$id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT max(id) AS id FROM ".$tabela));
		}else{
			return 0;
		}
		
		//Fecha a conexão
		mysqli_close($conn);
		
		return $id['id'];
	}
	
	function AlterarDados($campos, $valores, $tabela, $id){
		// Inicialização de variáveis
		$camposQuery = '';
		$sql = '';
		$numCampos = max(array_keys($campos));
		$numValores = max(array_keys($valores));
		
		if($numCampos <> $numValores){
			return 0;
		}
		
		// Obtém valores dos campos à serem alterados
		for($i = 0; $i <= $numCampos; $i++){
			$camposQuery = $camposQuery.$campos[$i]." = ".$valores[$i].($i < $numCampos ? ", " : "");
		}
		
		// Abre a conexão
		include "../connections/conn.php";
		
		// Altera o registro na tabela
		$sql = mysqli_query($conn, "UPDATE ".$tabela." SET ".$camposQuery." WHERE id = '".$id."'") 
					Or die('Erro ao alterar registro na tabela. '.mysqli_error($conn));
					
					
		
		//Fecha a conexão
		mysqli_close($conn);
		
		// Erro ao inserir
		if(!$sql){
			return 0;
		}
		
		return 1;
	}
	
	function inserirUsuarioPermissao($id, $valores){
		// Inicialização de variáveis
		$sqlUsuarioPermissao = '';
		$numValores = max(array_keys($valores));
		
		// Abre a conexão
		include "../connections/conn.php";
		
		// Obtém valores das permissões
		for($i = 0; $i <= $numValores; $i++){
			//insere o usuário e sua permissão
			if($valores[$i] <> 0){
				$sqlUsuarioPermissao = mysqli_query($conn, "INSERT INTO ioc_usuario_permissao(usuario_id, permissao_id) VALUES(".$id.", ".$valores[$i].")")
														Or die('Erro ao inserir permissões do usuário. '.mysqli_error($conn));
			}
		}
		
		//Fecha a conexão
		mysqli_close($conn);
		
		// Erro ao inserir
		if(!$sqlUsuarioPermissao){
			return 0;
		}
		
		return 1;
	}
	
	function alterarUsuarioPermissao($id, $valores){
		// Inicialização de variáveis
		$sqlUsuarioPermissao = '';
		$numValores = max(array_keys($valores));
		
		// Abre a conexão
		include "../connections/conn.php";
		
		mysqli_query($conn, "DELETE FROM ioc_usuario_permissao WHERE usuario_id = '".$id."'")
									Or die('Erro ao deletar permissões. '.mysqli_error($conn));

		// Obtém valores das permissões
		for($i = 0; $i <= $numValores; $i++){			
			//insere o usuário e sua permissão
			if($valores[$i] <> 0){
				$sqlUsuarioPermissao = mysqli_query($conn, "INSERT INTO ioc_usuario_permissao(usuario_id, permissao_id) 
															VALUES(".$id.", ".$valores[$i].")")
														Or die('Erro ao inserir permissões do usuário. '.mysqli_error($conn));
			}
		}
		
		//Fecha a conexão
		mysqli_close($conn);
		
		// Erro ao inserir
		if(!$sqlUsuarioPermissao){
			return 0;
		}
		
		return 1;
	}
	
	function inserirGaleria($id, $imgGaleria, $numFile){
		$InstrucaoSQL = '';
		
		// Abre a conexão
		include "../connections/conn.php";
	
		for($i = 0; $i < $numFile; $i++){
			$InstrucaoSQL = "INSERT INTO ioc_galeria(posts_id, thumb) VALUES(".$id.", '".$imgGaleria[$i]."'); ";
	
			//insere o post no banco
			$sqlPost = mysqli_query($conn, $InstrucaoSQL) Or die('Erro ao inserir imagens da galeria. '.mysqli_error($conn));
		}
		
		//Fecha a conexão
		mysqli_close($conn);
		
		// Erro ao inserir
		if(!$sqlPost){
			return 0;
		}
		
		return 1;
	}
	
	function alterarGaleria($id, $imgGaleria, $legenda, $id_imagem, $imgGaleriaAntigo){
		$InstrucaoSQL = "UPDATE ioc_galeria SET ";
		$InstrucaoSQL .= !empty($imgGaleria) ? "thumb = '".$imgGaleria."'" : "";
		$InstrucaoSQL .= (!empty($imgGaleria) && !empty($legenda) ? ", " : "").(!empty($legenda) ? "legenda = '".$legenda."'" : "");
		$InstrucaoSQL .= " WHERE posts_id = '".$id."' ";
		
		if(empty($id_imagem)){
			$InstrucaoSQL .= "AND thumb = '".$imgGaleriaAntigo."'";
		} else{
			$InstrucaoSQL .= "AND id = '".$id_imagem."'";
		}
		
		// Abre a conexão
		include "../connections/conn.php";
	
		//insere o post no banco
		$sqlPost = mysqli_query($conn, $InstrucaoSQL) Or die('Erro ao editar a galeria. '.mysqli_error($conn));
		
		//Fecha a conexão
		mysqli_close($conn);
		
		// Erro ao inserir
		if(!$sqlPost){
			return 0;
		}
		
		return 1;
	}
	
	function excluirImagem($id){
		$InstrucaoSQL = "DELETE FROM ioc_galeria WHERE id = '".$id."'";
		
		// Abre a conexão
		include "../connections/conn.php";
	
		//insere o post no banco
		$sqlPost = mysqli_query($conn, $InstrucaoSQL) Or die('Erro ao excluir a imagem. '.mysqli_error($conn));
		
		//Fecha a conexão
		mysqli_close($conn);
		
		// Erro ao inserir
		if(!$sqlPost){
			return 0;
		}
		
		return 1;
	}
	
	// Função para ajustar o tamanho da imagem e criar um thumbnail da imagem.
	// Autor: Hugo Holanda8
	// Data: 29/08/2017
	// Observações: - Antes de chamar a função é necessário fazer o upload da imagem para uma pasta temporária.
	// Parâmetros: 	
	//				- pathTmp: Caminho da pasta temporária
	//				- imagem: Endereço, nome e extensão da imagem (Ex: "tmp/imagem.jpg")
	//				- tipo: Tipo da imagem (inicialmente a função só ajustará imagens JPG)
	//				- largura_base: Valor em pixel da largura que a imagem terá
	//				- altura_base: Valor em pixel da altura que a imagem terá
	//				- metade_base: Para evitar que uma imagem muito pequena seja muito ampliada, caso ela tenha largura menor que 		
	//				a metade da largura_base a largura e altura base serão a metade do valor informado nos parâmetros largura_base
	//				e altura_base. Valores aceitos: true (usar a metade da base) e false (não usar a metade da base)
	//				- altura_thumbnail: Valor em pixel da altura do thumbnail
	//				- cor_fundo: Cor de fundo da imagem em RGB (Ex: "255,255,255"), se omitido, a cor será preta
	function AjustaImagem($pathTmp, $path, $pathThumbnail, $imagem, $largura_base, $altura_base, $metade_base, $altura_thumbnail, $so_thumbnail, $unlink){
		// Inicializa variáveis
		$copyImg = true;
		$msgErro = "";
		$larguraBase = $largura_base;
		$alturaBase = $altura_base;
		
		// Cria um resource da imagem
		$img_rsc = imagecreatefromjpeg($pathTmp.$imagem);

		// Obtém a largura e altura da imagem
		$largura = imagesx($img_rsc);
		$altura = imagesy($img_rsc);
		
		// Obtém largura e altura base
		$larguraBase = $largura_base;
		$alturaBase = $altura_base;
		
		if($metade_base){
			if($largura < ($largura_base / 2 )){
				$larguraBase = ($largura_base / 2 );
				$alturaBase = ($altura_base / 2 );
			}
		}
		
		// Cria thumbnail
		// Percentual da altura da thumbnail em relação à altura base
		$percentualThumbnail = $altura_thumbnail * 100 / $altura_base;
		// Percentual da altura da thumbnail em relação à altura base
		$percThumbnail = $altura_thumbnail * 100 / $altura;
		// Largura máxima que a thumbnail pode ter em relação à altura
		$maxLarguraThumbnail = floor($largura_base * $percentualThumbnail / 100);
		// Largura que a imagem terá apenas ajustando pelo percentual
		$larguraThumbnail = floor($largura * $percThumbnail / 100);
		
		$imgFundo = imagecreatetruecolor($maxLarguraThumbnail, $altura_thumbnail);
		
		if($larguraThumbnail > $maxLarguraThumbnail){
			// crop
			$percLargura = $maxLarguraThumbnail * 100 / $larguraThumbnail;
			$larguraNova = floor($largura * $percLargura / 100);
			$margemEsq = ($largura - $larguraNova) / 2;
			//$coordenadas = array('x' => $margemEsq, 'y' => 0, 'width' => $larguraNova, 'height' => $altura);
			//$img2 = imagecrop($img_rsc, $coordenadas);
			imagecopyresampled($imgFundo, $img_rsc, 0, 0, $margemEsq, 0, $maxLarguraThumbnail, $altura_thumbnail, $larguraNova, $altura);
			imagejpeg($imgFundo, $pathThumbnail.$imagem, 90);
		} else{
			// stretched
			imagecopyresampled($imgFundo, $img_rsc, 0, 0, 0, 0, $maxLarguraThumbnail, $altura_thumbnail, $largura, $altura);
			imagejpeg($imgFundo, $pathThumbnail.$imagem, 90);
		}
		
		if(!$so_thumbnail){
			if($largura <> $larguraBase && $altura <> $alturaBase){
				$larguraNova = $larguraBase;
				$percentual = $larguraNova * 100 / $largura;
				$alturaNova = ceil($altura * $percentual / 100);
				$margemCima = ($alturaBase - $alturaNova) / 2;
				$margemEsq = 0;
		
				if($alturaNova > $alturaBase){
					$margemCima = 0;
					$alturaNova = $alturaBase;
					$percentual = $alturaNova * 100 / $altura;
					$larguraNova = ceil($largura * $percentual / 100);
					$margemEsq = ($larguraBase - $larguraNova) / 2;
				}
			} else{
				$alturaNova = $alturaBase;
				$larguraNova = $larguraBase;
				
				if($largura <> $larguraBase){
					$margemCima = ($alturaBase - $altura) / 2;
					$margemEsq = 0;
				} elseif($altura <> $alturaBase){
					$margemCima = 0;
					$margemEsq = ($larguraBase - $larguraNova) / 2;
				} else{
					$margemCima = 0;
					$margemEsq = 0;
				}
			}
			
			$imgFundo = imagecreatetruecolor($larguraBase, $alturaBase);
			imagecopyresampled($imgFundo, $img_rsc, $margemEsq, $margemCima, 0, 0, $larguraNova, $alturaNova, $largura, $altura);
			imagejpeg($imgFundo, $path.$imagem, 90);
		}
		
		if($unlink){
			unlink($pathTmp.$imagem);
		}
	}
?>