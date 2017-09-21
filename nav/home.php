<?php
	//;
//	include "scripts/carrossel.php";

	include "scripts/carrossel.php";
?>
      		
            
            <div id="informacao">
<?php
					$chamada = 'home';
					for($i = 1; $i <= 3; $i++){
						$categoria = $i;
						include "scripts/posts.php";
					}
?>
			</div>
            
            <div id="mapa">
                <div id="legenda-mapa" class="omite_LegMap">
                    <br />
                    <h1>VENHA</h1>
                    <br />
                    <h1>PARA O</h1>
                    <br />
                    <h1>IOC</h1>
                </div>
              
                <div id="mapa-google"></div>
            </div>