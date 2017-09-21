            <div id="page">
                <div id="single">
            		<h1 class="titulo-single legenda-<?php echo $descricao; ?>"><?php echo $titulo; ?></h1>
            		<h2 class="subtitulo-single"><?php echo $subtitulo; ?></h2>
            		<h6 class="autor-sigle"><?php echo 'Por '.$autor.' - '.date('d/m/Y - H:i', strtotime($data)); ?></h6>
                    
                    <div class="fb-share-button" 
                        data-href="" 
                        data-layout="button"
                        data-size="large" 
                        data-mobile-iframe="true">
                    </div>
                    
<?php 		if($thumb_banner <> ''){ ?>
                    <div id="banner_single">
                        <img src="upload/<?php echo $descricao; ?>/<?php echo sprintf("%06d", $id_single); ?>/banner/<?php 
                            echo $thumb_banner; ?>" alt="<?php echo $titulo; ?>" class="banner-single" />
                    </div>
                    <div style="clear:both;"></div>
<?php 		}elseif($video <> ''){echo $video;}
 	  
	  		if($thumb <> '' && $naoExibirThumb == 0){ 
	  	  		$texto =  strstr($texto, "</p>", true)."<img src='upload/".$descricao."/".sprintf("%06d", $id_single)."/img_g/".$thumb.
							"' alt='".$titulo."' class='img-single' />".strstr($texto, "</p>");
	  		} 
		
			echo $texto;
?>
            	</div>
        	</div>
<?php
	include "sidebars/sidebar.php";
	$categoria = $post_categoria;
	$id_atual = $id_single;
	$chamada = 'single-sidebar';
	include "scripts/posts.php";
?>
</div>