<?php
	if(!isset($_SESSION['codMedico'])){
		header("Location:mensagemerro.php");
	}
	
	$obs = "";
	$codMedico = array(0 => '004', 1=> '330', 2=> '329');
	
	if(in_array($_SESSION['codMedico'], $codMedico)){
		$local = "Consultório Empresarial Difusora";
	} else{
		$local = "IOC - Matriz";
	}
	
	if($_SESSION['hora'] == "0"){
		$hora = "Ordem de chegada";
		
		if($_SESSION['turno'] == "M"){
			if($_SESSION['codMedico'] == '004'){
				$obs = "Marcação da ordem de atendimento entre 09:30 e 10:30";
			} else{
				$obs = "Marcação da ordem de atendimento entre 07:00 e 09:00";
			}
		} elseif($_SESSION['turno'] == "T"){
			$obs = "Marcação da ordem de atendimento entre 12:00 e 14:00";
		} else{
			$obs = "Marcação da ordem de atendimento entre 17:00 e 18:00";
		}
	} else{
		$hora = $_SESSION['hora'];
	}
	
	if($_SESSION['turno'] == "M"){
		$turno = "Manhã";
	} elseif($_SESSION['turno'] == "T"){
		$turno = "Tarde";
	} else{
		$turno = "Noite";
	}
	
	if($_SESSION['confirmar'] == "S"){
		$nomeForm = "frmConfirma";
		$legenda = "Resumo da Marcação da Consulta";
	} else{
		$nomeForm = "frmConcluido";
		$legenda = "Marcação de Consulta Concluída";
	}
?>
<div id="confirmacao">
	<form id="<?php echo $nomeForm; ?>" name="<?php echo $nomeForm; ?>" enctype="multipart/form-data" method="post" action="">
        <fieldset>
            <legend class="titConfirm"><?php echo $legenda; ?></legend>
        
            <table>
                <tr>
                    <td class="legConfirm"><strong>Nome:</strong></td>
                    <td><?php echo ucwords(strtolower($_SESSION['nome'])); ?></td>
                </tr>
                <tr>
                    <td class="legConfirm"><strong>Data de Nascimento:</strong></td>
                    <td><?php echo $_SESSION['dtNasc']; ?></td>
                </tr>
                <tr>
                    <td class="legConfirm"><strong>Telefone:</strong></td>
                    <td><?php echo $_SESSION['telefone']; ?></td>
                </tr>
                <tr>
                    <td class="legConfirm"><strong>Celular:</strong></td>
                    <td><?php echo $_SESSION['celular']; ?></td>
                </tr>
                <tr>
                    <td class="legConfirm"><strong>Convênio:</strong></td>
                    <td><?php echo $_SESSION['convenioDesc']; ?></td>
                </tr>
                <tr>
                    <td class="legConfirm"><strong>Médico:</strong></td>
                    <td><?php echo $_SESSION['nomeMedico']; ?></td>
                </tr>
                <tr>
                    <td class="legConfirm"><strong>Local da Consulta:</strong></td>
                    <td><?php echo $local; ?></td>
                </tr>
                <tr>
                    <td class="legConfirm"><strong>Data:</strong></td>
                    <td><?php echo (strlen($_SESSION['dataMarcacao']) == 10 ? $_SESSION['dataMarcacao'] : "0".$_SESSION['dataMarcacao']); ?></td>
                </tr>
                <tr>
                    <td class="legConfirm"><strong>Horário:</strong></td>
                    <td><?php echo $hora; ?></td>
                </tr>
                <tr>
                    <td class="legConfirm"><strong>Turno:</strong></td>
                    <td><?php echo $turno; ?></td>
                </tr>
<?php
	if($_SESSION['hora'] == "0"){
?>   
                <tr>
                    <td class="legConfirm"><strong>Observação:</strong></td>
                    <td><?php echo $obs; ?></td>
                </tr>
<?php
	}
?>                
            </table>
            
            <div id="botoesConfirmacao" class="flutuaEsq">
<?php
	if($_SESSION['confirmar'] == "S"){
?>
				<input type="submit" id="btnVoltar" name="btnVoltar" class="designBotao margemDireita" value="Voltar" />
                <input type="submit" id="btnConfirmar" name="btnConfirmar" class="designBotao" value="Confirmar" />
<?php
	} else{
?>
                <input type="button" id="btnImprimir" name="btnImprimir" class="designBotao" value="Imprimir" onclick="javascript:window.print();" />
<?php
	}
?>
            </div>
        </fieldset>
	</form>
</div>