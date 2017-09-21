<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){	
	/* Inicializa variáveis  */
	$nome = $_POST['nome'];
	$replyto = strtolower(trim($_POST['email'])); 
	$telefone = $_POST['telefone'];
	$mensagem_form = $_POST['mensagem'];
	$assunto = $_POST['assunto'];
	$to = "contato@ioccaruaru.com.br";
	$remetente = "contato@ioccaruaru.com.br";
	 
	/* Cabeçalho da mensagem  */
	$boundary = "XYZ-" . date("dmYis") . "-ZYX";
	$headers = "MIME-Version: 1.0\n";
	$headers.= "From: $remetente\n";
	$headers.= "Reply-To: $replyto\n";
	$headers.= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";  
	$headers.= "$boundary\n"; 
	 
	/* Layout da mensagem  */
	$corpo_mensagem = "
	<br /><p style='font:16px Tahoma, Geneva, sans-serif; color:#00F;'>Contato via site</p>
	<br />--------------------------------------------<br />
	<br /><strong style='font:12px Tahoma, Geneva, sans-serif; line-height:25px; font-weight:bold;'>Nome:</strong>
		<span style='font:14px Tahoma, Geneva, sans-serif;'>$nome</span>
	<br /><strong style='font:12px Tahoma, Geneva, sans-serif; line-height:25px; font-weight:bold;'>Email:</strong>
		<span style='font:14px Tahoma, Geneva, sans-serif;'>$email</span>
	<br /><strong style='font:12px Tahoma, Geneva, sans-serif; line-height:25px; font-weight:bold;'>Telefone:</strong>
		<span style='font:14px Tahoma, Geneva, sans-serif;'>$telefone</span>
	<br /><strong style='font:12px Tahoma, Geneva, sans-serif; line-height:25px; font-weight:bold;'>Mensagem:</strong>
		<span style='font:14px Tahoma, Geneva, sans-serif;'>$mensagem_form</span>\n\n\n
	<br /><br />--------------------------------------------
	<p style='font:12px Tahoma, Geneva, sans-serif;'>Enviado da página Contato do site do IOC</p>
	"; 
 
	$mensagem = "--$boundary\n"; 
	$mensagem.= "Content-Transfer-Encoding: 8bits\n"; 
	$mensagem.= "Content-Type: text/html; charset=\"utf-8\"\n\n";
	$mensagem.= "$corpo_mensagem\n";
	 
	/* Função que envia a mensagem  */
	if(mail($to, $assunto, $mensagem, $headers)){
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?pagina=nav/enviado&envio=ct&sus=1'>";
	} else{
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?pagina=nav/enviado&envio=ct&sus=0'>";
	}
} 
?>
<div id="page">
	<h1 class="legenda-page">Contato</h1>
    
    <p class="page-p"><strong>Quer falar com a gente?</strong> Envie-nos uma mensagem e entramos em contato o mais breve possível.</p>
    <p class="page-p">Entre em contato também pelos telefones:</p>
    
    <div id="telefones">
    	<table>
        	<tr>
            	<td>(81) 2103-3300</td>
                <td>(81) 2103-3333</td>
            </tr>
            <tr>
            	<td>(81) 3723-4444</td>
                <td>(81) 3095-9804 (Claro)</td>
            </tr>
            <tr>
            	<td>(81) 99216-8245 (Claro)</td>
                <td>(81) 99795-5100 (Tim)</td>
            </tr>
        </table>
    </div>    
    <form onSubmit="return checa_formulario(this, 'ct');" method="post" action="" name="contato" enctype="multipart/form-data">
    	<fieldset>
            <legend>Entre em contato conosco</legend>

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" class="txt-destaque" maxlength="60" autofocus="autofocus" />
            
            <label>Email</label>
            <input type="text" id="email" name="email" class="txt-destaque" maxlength="60" />
            
            <label>Telefone</label>
            <input type="text" id="telefone" name="telefone" class="txt-destaque" onkeypress="formatar('(##) #####-####', this); 
            	return SomenteNumero(event)" maxlength="15" onblur="verificarTelefone(this)" />
                
            <label>Assunto</label>
            <input type="text" id="assunto" name="assunto" class="txt-destaque" maxlength="60" />
                
            <label>Mensagem</label>
            <textarea name="mensagem" class="txa-destaque" ></textarea>
            
            <!--<input type="hidden" name="envio" value="ct" />-->
            <input type="submit" name="enviar" value="Enviar" class="btn-enviar" />
        </fieldset>
    </form>
</div>

<?php 
	include "sidebars/sidebar.php";
	$chamada = 'page-sidebar';
	
	for($i = 1; $i <= 3; $i++){
		$categoria = $i;
		include "scripts/posts.php";
	}
?>