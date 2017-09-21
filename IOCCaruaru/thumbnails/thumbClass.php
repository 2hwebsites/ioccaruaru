<?php require ('bmpGdClass.php');

/**
* Criada em 29/10/2010
* Ъltima atualizaзгo em 11/06/2015
*
* A classe tem como objetivo criar thumbnails 
* nos formatos gif, jpeg, png e wbmp
* 
* @author Ibrahim Brumate (periscuelo@hotmail.com)
* @version 1.1.1
*
*/
class thumbNails extends bmpGd {
    
    /**
    * Variбvel privada que vai informar a extensгo do arquivo
    * e tambйm se a imagem й valida.
    * @access private
    * @name $_ext
    */
    private $_ext;
    
    /**
    * Variбvel privada que vai informar o novo nome da imagem
    * @access private
    * @name $_nName
    */
    private $_nName;
	
	/**
    * Variбvel privada que vai informar o nome da imagem
    * @access private
    * @name $_image
    */
    private $_image;
    
    /**
    * Variбvel privada que vai conter a imagem final do thumbnail
    * @access private
    * @name $_finalImage
    */
    private $_finalImage;
    
	/**
    * Variбvel privada que vai conter o header da imagem caso queira
	* exibir direto no arquivo.
    * @access private
    * @name $_header
    */
    private $_header;
	
	/**
    * Variбvel privada que vai conter o cуdigo para ser usado posteriormente
    * em um eval. Ela й responsбvel pela criaзгo da imagem gd.
    * @access private
    * @name $_mCreate
    */
    private $_mCreate;
    
    /**
    * Variбvel privada que vai conter o cуdigo para ser usado posteriormente
    * em um eval. Ela й responsбvel por gerar o thumbnail.
    * @access private
    * @name $_mReturn
    */
    private $_mReturn;
    
    /**
    * Variбvel privada que vai conter os erros tratados do script
    * @access private
    * @name $_msg
    */
    private $_msg;
    
    /**
    * Variбvel privada que vai conter o eval que cria a imagem gd.
    * @access private
    * @name $_sourceImg
    */
    private $_sourceImg;
    
    /**
    * Variбvel privada que vai conter o tipo de imagem de retorno do thumbnail.
    * @access private
    * @name $_return
    */
    private $_return;
    
    /**
    * Variбvel privada do tipo array que vai conter o tamanho do thumbnail.
    * @access private
    * @name $_sThumb
    */
    private $_sThumb;
    
	/**
    * Variбvel privada que vai conter a imagem temporбria gerada pelo cURL.
    * @access private
    * @name $_tempImage
    */
    private $_tempImage;
	
	/**
    * Variбvel privada que vai conter o caminho da imagem temporбria gerada pelo cURL.
    * @access private
    * @name $_tempPath
    */
    private $_tempPath;
	
    /**
    * Variбvel privada que vai conter o nome do thumbnail.
    * @access private
    * @name $_thumb
    */
    private $_thumb;
    
	/**
    * Variбvel privada que vai conter a cor de fundo do thumbnail.
    * @access private
    * @name $_transparent
    */
    private $_transparent;
	
	/**
    * Variбvel privada que vai conter o array de imagens que podem ser transparentes.
    * @access private
    * @name $_transparents
    */
    private $_transparents;
	
	/**
    * Variбvel privada que vai conter a url da imagem a ser gerada.
    * @access private
    * @name $_url
    */
    private $_url;
	
    /****
	 * Metodo mбgico construct utilizado para verificar se as bibliotecas
	 * gd e exif estгo habilitadas e setar a variбvel $_transparents
	****/
    public function __construct() {
        if (!function_exists('imagepng')) $this->_msg[] = 'A Biblioteca GD2 deve estar ativada. Habilite a php_gd2.dll no php.ini';
        if (!function_exists('exif_imagetype')) $this->_msg[] = 'A Biblioteca EXIF deve estar ativada. Habilite a php_exif.dll no php.ini';
		if (!function_exists('curl_init')) $this->_msg[] = 'A Biblioteca cURL deve estar ativada. Habilite a php_curl.dll no php.ini';
		$this->_transparents = array('gif','png');
    }
	
	/****
	 * Metodo pageImage utilizado para criar uma pбgina com a imagem via cURL
	 * porйm sem armazenar o arquivo localmente.
	****/
	public function pageImage() {
		$imageC = file_get_contents($this->_thumb);
		unlink($this->_thumb);
		return $imageC;
	}
	
	/****
	 * Metodo urlImage utilizado para criar localmente uma imagem temporaria
	 * via cURL na pasta temp, gerar uma thumb e setar a variбvel $_tempImage
	****/
	public function urlImage() {
		$ch = curl_init($this->_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		curl_close($ch);
		
		$arIN = explode('/',$this->_url);
		$this->_tempImage = end($arIN);
		$handle = fopen($this->_tempPath.$this->_tempImage, 'w+');
		fwrite($handle, $data);
		fclose($handle);
	}
    
    /****
	 * Metodo mбgico set utilizado gerar o thumbnail
	 * @param $property string
	 * @param $value mixed
	****/
    public function __set($property,$value) {
        switch ($property) {
		    case '_url':
				$this->_url = $value;
			break;
			case '_tempPath':
				$this->_tempPath = $value;
			break;
			case '_nName':
				$this->_nName = $value.'_';
			break;
			case '_image':
                $typeImage = exif_imagetype(implode('',$value));
                switch ($typeImage) {
                    case 1:
                        $this->_ext = 'gif';
						$this->_header = 'Content-type: image/gif';
                        $this->_mCreate = 'return imagecreatefromgif(\''.implode('',$value).'\');';
                        $this->_thumb = ($value[2]) ? $value[1].$this->_nName.substr($value[2],0,-4).'.'.$this->_ext : $value[0].$this->_nName.substr($value[1],0,-4).'.'.$this->_ext;
						while (file_exists($this->_thumb)) {
							   $i++;
							   $this->_thumb = ($value[2]) ? $value[1].$this->_nName.$i.'_'.substr($value[2],0,-4).'.'.$this->_ext : $value[0].$this->_nName.$i.'_'.substr($value[1],0,-4).'.'.$this->_ext;
						}
						$this->_mReturn = 'return imagegif($this->_finalImage,$this->_thumb);';
                    break;
                    case 2:
                        $this->_ext = 'jpg';
						$this->_header = 'Content-type: image/jpeg';
                        $this->_mCreate = 'return imagecreatefromjpeg(\''.implode('',$value).'\');';
                        $this->_thumb = ($value[2]) ? $value[1].$this->_nName.substr($value[2],0,-4).'.'.$this->_ext : $value[0].$this->_nName.substr($value[1],0,-4).'.'.$this->_ext;
						while (file_exists($this->_thumb)) {
							   $i++;
							   $this->_thumb = ($value[2]) ? $value[1].$this->_nName.$i.'_'.substr($value[2],0,-4).'.'.$this->_ext : $value[0].$this->_nName.$i.'_'.substr($value[1],0,-4).'.'.$this->_ext;
						}
                        $this->_mReturn = 'return imagejpeg($this->_finalImage,$this->_thumb,100);';
                    break;
                    case 3:
                        $this->_ext = 'png';
						$this->_header = 'Content-type: image/png';
                        $this->_mCreate = 'return imagecreatefrompng(\''.implode('',$value).'\');';
                        $this->_thumb = ($value[2]) ? $value[1].$this->_nName.substr($value[2],0,-4).'.'.$this->_ext : $value[0].$this->_nName.substr($value[1],0,-4).'.'.$this->_ext;
						while (file_exists($this->_thumb)) {
							   $i++;
							   $this->_thumb = ($value[2]) ? $value[1].$this->_nName.$i.'_'.substr($value[2],0,-4).'.'.$this->_ext : $value[0].$this->_nName.$i.'_'.substr($value[1],0,-4).'.'.$this->_ext;
						}
                        $this->_mReturn = 'return imagepng($this->_finalImage,$this->_thumb,9);';
                    break;
                    case 6:
                        $this->_ext = 'bmp';
						$this->_header = 'Content-type: image/bmp';
                        $this->_mCreate = 'return $this->imagecreatefrombmp(\''.implode('',$value).'\');';
                        $this->_thumb = ($value[2]) ? $value[1].$this->_nName.substr($value[2],0,-4).'.'.$this->_ext : $value[0].$this->_nName.substr($value[1],0,-4).'.'.$this->_ext;
						while (file_exists($this->_thumb)) {
							   $i++;
							   $this->_thumb = ($value[2]) ? $value[1].$this->_nName.$i.'_'.substr($value[2],0,-4).'.'.$this->_ext : $value[0].$this->_nName.$i.'_'.substr($value[1],0,-4).'.'.$this->_ext;
						}
                        $this->_mReturn = 'return $this->imagebmp($this->_finalImage,$this->_thumb);';
                    break;
                    case 15:
                        $this->_ext = 'wbmp';
						$this->_header = 'Content-type: image/vnd.wap.wbmp';
                        $this->_mCreate = 'return imagecreatefromwbmp(\''.implode('',$value).'\');';
                        $this->_thumb = ($value[2]) ? $value[1].$this->_nName.substr($value[2],0,-4).'.'.$this->_ext : $value[0].$this->_nName.substr($value[1],0,-4).'.'.$this->_ext;
						while (file_exists($this->_thumb)) {
							   $i++;
							   $this->_thumb = ($value[2]) ? $value[1].$this->_nName.$i.'_'.substr($value[2],0,-4).'.'.$this->_ext : $value[0].$this->_nName.$i.'_'.substr($value[1],0,-4).'.'.$this->_ext;
						}
                        $this->_mReturn = 'return imagewbmp($this->_finalImage,$this->_thumb);';
                    break;
                    default:
                        $this->_ext = false;
                }
            break;
            case '_return':
                switch ($value) {
                    case 'gif':
                        $this->_ext = 'gif';
                        $this->_thumb = substr($this->_thumb,0,-3).$this->_ext;
                        $this->_mReturn = 'return imagegif($this->_finalImage,$this->_thumb);';
                    break;
                    case 'jpg':
                        $this->_ext = 'jpg';
                        $this->_thumb = substr($this->_thumb,0,-3).$this->_ext;
                        $this->_mReturn = 'return imagejpeg($this->_finalImage,$this->_thumb,100);';
                    break;
                    case 'png':
                        $this->_ext = 'png';
                        $this->_thumb = substr($this->_thumb,0,-3).$this->_ext;
                        $this->_mReturn = 'return imagepng($this->_finalImage,$this->_thumb,9);';
                    break;
                    case 'bmp':
                        $this->_ext = 'bmp';
                        $this->_thumb = substr($this->_thumb,0,-3).$this->_ext;
                        $this->_mReturn = 'return $this->imagebmp($this->_finalImage,$this->_thumb);';
                    break;
                    case 'wbmp':
                        $this->_ext = 'wbmp';
                        $this->_thumb = substr($this->_thumb,0,-3).$this->_ext;
                        $this->_mReturn = 'return imagewbmp($this->_finalImage,$this->_thumb);';
                    break;
                    default:
                        $this->_ext = false;
                }
            break;
            case '_sThumb':
			    //GERA RETORNOS CASO O VALOR PASSADO NO PARВMETRO NГO ESTEJA CORRETO
                if (is_array($value)) {
                    $keys = array_keys($value);
                    if ($keys[0]!='x' || $keys[1]!='y') $this->_msg[] = 'A primeira posiзгo do array deve ser x e o valor o width (largura) da imagem. A segunda posiзгo do array deve ser y e o valor o height (altura) da imagem.';
					$mType = (!empty($value[0])) ? $value[0] : '';
                } else {
                    $this->_msg[] = 'O Parametro _sThumb precisa ser um array';
                }
                
                if ($this->_ext) {
                    $this->_sourceImg = eval($this->_mCreate); //Lк a imagem de origem
                    
                    //PEGA AS DIMENSХES DA IMAGEM DE ORIGEM
                    $source_x = imagesx($this->_sourceImg); //Largura
                    $source_y = imagesy($this->_sourceImg); //Altura
					$crop_x = 0; //Largura do Crop
					$crop_y = 0; //Altura do Crop
                    switch ($mType) {
						case 'stretched':
							//SIMPLESMENTE MODIFICA O TAMANHO DA IMAGEM
							$value_x = $final_x = $value['x']; //A largura serб a do thumbnail
							$value_y = $final_y = $value['y']; //A altura serб a do thumbnail
							$f_x = 0; //Colar no x = 0
							$f_y = 0; //Colar no y = 0
							break;
						case 'thumb':
							//SETA A LARGURA DA IMAGEM COMO DEFAULT
							$value_x = $value['x']; //A largura serб a do thumbnail
							$value_y = $final_y = floor($value_x * $source_y / $source_x); //A altura й calculada
							$final_x = $value_x; //A largura serб a do thumbnail
							$f_x = 0; //Colar no x = 0
							$f_y = 0; //Colar no y = 0
							break;
						case 'expanded':
							//SETA A ALTURA DA IMAGEM COMO DEFAULT
							$value_y = $value['y']; //A altura serб a do thumbnail
							$value_x = $final_x = floor($value_y * $source_x / $source_y); //Calcula a largura
							$final_y = $value_y; //A altura serб a do thumbnail
							$f_x = 0; //Colar no x = 0
							$f_y = 0; //Colar no y = 0
							break;
						case 'centered':
							//CENTRALIZA A IMAGEM NO TAMANHO DO THUMB CASO O MESMO NГO SEJA UM QUADRADO EXATO
							$value_x = $value['x']; //A largura serб a do thumbnail
							$value_y = $value['y']; //A altura serб a do thumbnail
							if($source_x > $value['x'] && $source_y > $value['y']) {
								//Se a altura e a largura forem maior que o thumb calcula ambos
								$final_x = floor($value_y * $source_x / $source_y);
								$final_y = floor($value_x * $source_y / $source_x);
							} elseif($source_x > $value['x']) { 
								//Se a largura for maior que a do thumb calcula a altura
								$final_x = $value_x; //A largura serб a do thumbnail
								$final_y = floor($value_x * $source_y / $source_x);
							} elseif ($source_y > $value['y']) {
								//Se a altura for maior que a do thumb calcula a largura
								$final_x = floor($value_y * $source_x / $source_y);
								$final_y = $value_y; //A altura serб a do thumbnail
							} else {
								//Se a altura e a largura forem menor que o thumb apenas centraliza
								$final_x = $source_x; //A largura serб a do thumbnail
								$final_y = $source_y; //A altura serб a do thumbnail
							}
							//Centraliza a imagem no meio x e y do thumbnail
							$f_x = round(($value_x / 2) - ($final_x / 2));
							$f_y = round(($value_y / 2) - ($final_y / 2));
							break;
						case 'param_center':
							//CENTRALIZA A IMAGEM NO TAMANHO DO THUMB DE ACORDO COM O X OU Y SETADO E NГO EXPANDE A IMAGEM CASO ELA SEJA MENOR
							if ($value['x']!='0') {
								$value_x = $value['x']; //Trava a Imagem para Resoluзгo informada por parametro
								$value_y = floor($value_x * $source_y / $source_x); //A altura й calculada
							} elseif ($value['y']!='0') {
								$value_y = $value['y']; //Trava a Imagem para Resoluзгo informada por parametro
								$value_x = floor($value_y * $source_x / $source_y); //Calcula a largura
							}
							if($value['x']!='0' && $source_x > $value['x']) { 
								//Se a largura for maior que a do thumb e a do thumb estiver setada calcula a altura
								$final_x = $value_x; //A largura serб a do thumbnail
								$final_y = floor($value_x * $source_y / $source_x);
							} elseif ($value['y']!='0' && $source_y > $value['y']) {
								//Se a altura for maior que a do thumb e a do thumb estiver setada calcula a largura
								$final_x = floor($value_y * $source_x / $source_y);
								$final_y = $value_y; //A altura serб a do thumbnail
							} else {
								//Se a altura e a largura forem menor que o thumb apenas centraliza
								$final_x = $source_x; //A largura serб a do thumbnail
								$final_y = $source_y; //A altura serб a do thumbnail
							}
							//Centraliza a imagem no meio x e y do thumbnail
							$f_x = round(($value_x / 2) - ($final_x / 2));
							$f_y = round(($value_y / 2) - ($final_y / 2));
							break;
						case 'crop':
							//FAZ O CROP DA IMAGEM NO TAMANHO DEFINIDO
							$f_x = 0;
							$f_y = 0;
							$crop_x = $value['pos_x']; //Posiзгo de largura onde a div parou sobre a imagem
							$crop_y = $value['pos_y']; //Posiзгo de altura onde a div parou sobre a imagem
							$value_x = $final_x = $value['x']; //A largura serб a do thumbnail
							$value_y = $final_y = $value['y']; //A altura serб a do thumbnail
							$source_x = $value['w']; //Largura do crop
							$source_y = $value['h']; //Altura do crop
							break;
						case 'crop_auto':
							//FAZ O CROP AUTOMБTICO DA IMAGEM NO TAMANHO DEFINIDO
							$f_x = 0;
							$f_y = 0;
							$prop_X = ($source_x/$value['x']); //Proporзгo de largura inicial
							$prop_Y = ($source_y/$value['y']); //Proporзгo de altura inicial
							if ($prop_X > $prop_Y) { //Se a largura for maior que a altura
								$crop_x = round(($source_x-($source_x/$prop_X*$prop_Y))/2); //Posiзгo de largura onde sera recortada a imagem
								$source_x = round($source_x/$prop_X*$prop_Y); //Largura do crop
							} else if($prop_Y > $prop_X) { //Se a altura for maior ou igual а largura
								$crop_y = round(($source_y-($source_y/$prop_Y*$prop_X))/2); //Posiзгo de altura onde sera recortada a imagem
								$source_y = round($source_y/$prop_Y*$prop_X); //Altura do crop
							}
							$value_x = $final_x = $value['x']; //A largura serб a do thumbnail
							$value_y = $final_y = $value['y']; //A altura serб a do thumbnail
							break;
						default:
							//ESCOLHE A LARGURA MAIOR E, BASEADO NELA, GERA A LARGURA MENOR
							$value_x = ($value['x']>=900) ? 900 : $value['x']; //Seta a largura da imagem final
							$value_y = ($value['y']>=560) ? 560 : $value['y']; //Seta a altura da imagem final
							if($source_x > $source_y) { //Se a largura for maior que a altura
							   $final_x = $value['x']; //A largura serб a do thumbnail
							   $final_y = floor($value['x'] * $source_y / $source_x); //A altura й calculada
							   $f_x = 0; //Colar no x = 0
							   $f_y = round(($value['y'] / 2) - ($final_y / 2)); //Centralizar a imagem no meio y do thumbnail
							} else { //Se a altura for maior ou igual а largura
							   $final_x = floor($value['y'] * $source_x / $source_y); //Calcula a largura
							   $final_y = $value['y']; //A altura serб a do thumbnail
							   $f_x = round(($value['x'] / 2) - ($final_x / 2)); //Centraliza a imagem no meio x do thumbnail
							   $f_y = 0; //Colar no y = 0
							}
					}
					
                    $this->_finalImage = imagecreatetruecolor($value_x,$value_y); //Cria a imagem final do thumbnail
					
					//Adiciona transparкncia a imagem caso exista a mesma
					if (in_array($this->_ext,$this->_transparents)) {
						imagealphablending($this->_finalImage, false);
						imagesavealpha($this->_finalImage,true);
						$this->_transparent = imagecolorallocatealpha($this->_finalImage, 255, 255, 255, 127);
					} else {
						$this->_transparent = imagecolorallocate($this->_finalImage, 255, 255, 255);
					}
					
                    imagefill($this->_finalImage, 0, 0, $this->_transparent); //Define cor de fundo do thumbnail caso a imagem fique menor que o thumbnail
					imagecopyresampled($this->_finalImage, $this->_sourceImg, $f_x, $f_y, $crop_x, $crop_y, $final_x, $final_y, $source_x, $source_y); //Copia a imagem original para dentro do thumbnail
                    
                    eval($this->_mReturn); //Gera o thumbnail
					if ($this->_tempImage) unlink($this->_tempPath.$this->_tempImage); //Apaga imagem temporбria copiada via cURL caso exista
                } else {
                    $this->_msg[] = 'Imagem Invбlida!';
                }
            break;
        }
    }
    
    /****
	 * Metodo mбgico get utilizado para retorno de erros
	 * caso queira utilizar as mensagens geradas para debug
	 * ou mensagens para o usuбrio final. Tambйm utilizado
	 * para exibir valores internos desejados.
	****/
    public function __get($property) {
        switch ($property) {
            case '_msg':
			case '_thumb':
			case '_tempImage':
			case '_header':
                return $this->$property;
            break;
            default:
                return false;
        }
    }
    
    /****
	 * Metodo mбgico destruct utilizado para liberar a memуria
	 * das imagens caso elas sejam criadas com sucesso.
	****/
    public function __destruct() {
        if ($this->_ext) {
            imagedestroy($this->_sourceImg);
            imagedestroy($this->_finalImage);
        }
    }
}
?>