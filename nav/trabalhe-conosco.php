<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){	
	/* Inicializa variáveis  */
	$arquivo = $_FILES["curriculo"];
	$nome = $_POST['nome'];
	$replyto = strtolower(trim($_POST['email'])); 
	$mensagem_form = $_POST['observacoes'];
	$assunto = "Quero trabalhar no IOC";
	$to = "trabalhe@ioccaruaru.com.br";
	$remetente = "trabalhe@ioccaruaru.com.br";
	 
	/* Cabeçalho da mensagem  */
	$boundary = "XYZ-" . date("dmYis") . "-ZYX";
	$headers = "MIME-Version: 1.0\n";
	$headers.= "From: $remetente\n";
	$headers.= "Reply-To: $replyto\n";
	$headers.= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";  
	$headers.= "$boundary\n"; 
	 
	/* Layout da mensagem  */
	$corpo_mensagem = "
	<br /><p style='font:16px Tahoma, Geneva, sans-serif; color:#00F;'>Desejo me candidatar a uma vaga no IOC</p>
	<br />--------------------------------------------<br />
	<br /><strong style='font:12px Tahoma, Geneva, sans-serif; line-height:25px; font-weight:bold;'>Nome do cantidato:</strong>
		<span style='font:14px Tahoma, Geneva, sans-serif;'>$nome</span>
	<br /><strong style='font:12px Tahoma, Geneva, sans-serif; line-height:25px; font-weight:bold;'>Email para contato:</strong>
		<span style='font:14px Tahoma, Geneva, sans-serif;'>$email</span>
	<br /><strong style='font:12px Tahoma, Geneva, sans-serif; line-height:25px; font-weight:bold;'>Observações:</strong>
		<span style='font:14px Tahoma, Geneva, sans-serif;'>$mensagem_form</span>\n\n\n
	<br /><strong style='font:12px Tahoma, Geneva, sans-serif; color:#F00;'>* O currículo do candidato segue em anexo.</strong>
	<br /><br />--------------------------------------------
	<p style='font:12px Tahoma, Geneva, sans-serif;'>Enviado da página Trabalhe Conosco do site do IOC</p>
	"; 
	 
	/* Função que codifica o anexo para poder ser enviado na mensagem  */
	if(file_exists($arquivo["tmp_name"]) and !empty($arquivo)){
		$fp = fopen($_FILES["curriculo"]["tmp_name"],"rb");
		$anexo = fread($fp,filesize($_FILES["curriculo"]["tmp_name"]));
		$anexo = base64_encode($anexo);
		fclose($fp);
		$anexo = chunk_split($anexo);
		$mensagem = "--$boundary\n";
		$mensagem.= "Content-Transfer-Encoding: 8bits\n"; 
		$mensagem.= "Content-Type: text/html; charset=\"utf-8\"\n\n";
		$mensagem.= "$corpo_mensagem\n"; 
		$mensagem.= "--$boundary\n"; 
		$mensagem.= "Content-Type: ".$arquivo["type"]."\n";  
		$mensagem.= "Content-Disposition: attachment; filename=\"".$arquivo["name"]."\"\n";  
		$mensagem.= "Content-Transfer-Encoding: base64\n\n";  
		$mensagem.= "$anexo\n";  
		$mensagem.= "--$boundary--\r\n"; 
	}
	 
	/* Função que envia a mensagem  */
	if(mail($to, $assunto, $mensagem, $headers)){
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?pagina=nav/enviado&envio=tc&sus=1'>";
	} else{
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?pagina=nav/enviado&envio=tc&sus=0'>";
	}
}
?>
			<div id="page">
    			<h1 class="legenda-page" style=" ">Trabalhe Conosco</h1>
    
                <div id="trabalhe-conosco">
                    <p class="page-p">Já pensou em trabalhar em um lugar onde o principal objetivo é crescer junto e cooperar?</p>
                    <p class="page-p"><strong>No IOC é assim!</strong></p>
                    <p class="page-p">O crescimento do IOC está atrelado à sua cultura, que é um dos seus diferenciais no mercado acirrado de consultas oftalmológicas. Independente do cargo ocupado, profissionais que compartilhem os mesmos valores, sonhos e gostem de trabalhar "com" e "para" as pessoas são procurados pela empresa.​</p>
                    
                    <form onSubmit="return checa_formulario(this, 'tc');" method="post" action="" 
                    	name="trabalheconosco" id="trabalheconosco" enctype="multipart/form-data">
                        <fieldset>
                            <legend>Faça parte da equipe IOC</legend>
                            
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" class="txt-destaque" maxlength="60" autofocus="autofocus"
                            	autocomplete="off" required="required" />
                            
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" class="txt-destaque" maxlength="60" autocomplete="off" />
                            
                            <label for="observacoes">Observações</label>
                            <textarea id="observacoes" name="observacoes" class="txa-destaque"><?php echo ""; ?></textarea>
                            
                            
                            <label for="currículo">Currículo (arquivos .pdf, .doc e .docx)</label>
                            <input type="file" id="curriculo" name="curriculo" class="files-curriculo" />
                            

                            <input type="submit" id="enviar" name="enviar" value="Enviar" class="btn-enviar" />
                            <input type="hidden" name="envio" id="envio" value="tc" />
                        </fieldset>
                    </form>
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