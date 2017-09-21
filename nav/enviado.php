<?php 
$envio = $_GET['envio'];
$sucesso = $_GET['sus'];
?>
			<div id="page">
            	<div id="enviado">
<?php if($sucesso){ ?>
					<h1 class="legenda-email sucesso">Email enviado com sucesso!</h1>
<?php if($envio == 'tc'){ ?>
                    <p class="page-p"> Obrigado por querer fazer parte da nossa equipe!</p>
                    <p class="page-p">
                    	Caso você preencha o perfil de alguma vaga disponível, entraremos em contato o mais breve possível.
                    </p>
<?php } elseif($envio == 'ct'){ ?>
					<p class="page-p"> Obrigado por entrar em contato conosco!</p>
                    <p class="page-p">
                    	Analisaremos a sua mensagem e, se necessário, retornaremos o contato o mais breve possível.
                    </p>
<?php } } else{ ?>
					<h1 class="legenda-email falha">Erro ao Enviar email</h1>
                    <p class="page-p"> Tente novamente! Caso o erro persista, entre em contato com o IOC para relatar o erro.</p>
                
<?php } ?>
				</div>
			</div>
<?php
include "sidebars/sidebar.php";
$chamada = 'page-sidebar';

for($i = 1; $i <= 3; $i++){
	$categoria = $i;
	include "scripts/posts.php";
}
?>