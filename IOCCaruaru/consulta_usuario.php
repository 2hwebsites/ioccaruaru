<div id="usuario">
   <form id="frmUsuario" name="frmUsuario" enctype="multipart/form-data" method="post" action="" onSubmit="SetNomeMedico(); return Critica_Usuario(this)">
   		<input type='text' id='txhChamada' name='txhChamada' hidden='hidden' />
        <fieldset>
        	<p class="alerta">
            	Clientes dos planos Amil e Medial, a marcação é apenas nos telefones (81) 2103-33333 e (81) 3723-4444, devido 
                	à rede credenciada.
            </p>
            
            <legend>Dados Pessoais</legend>
                        
            <label class="t75">
                <strong class="legendaCampos">Nome<span>&nbsp;*</span></strong>
                <input type="text" id="nome" name="nome" maxlength="75" class="full"<?php echo (empty($outroMedico) ? " autofocus" : ""); ?> alt="Nome"
                	autocomplete="off" value="<?php echo (isset($_SESSION['nome'])) ? $_SESSION['nome'] : ""; ?>" 
                    onkeypress="return SomenteLetra(event);" />
            </label>
                        
            <label class="t25">
                <strong class="legendaCampos">Data de Nascimento<span>&nbsp;*</span></strong>
                <input type="text" id="dtNasc" name="dtNasc" maxlength="10" class="full" alt="Data de Nascimento" placeholder="__ / __ / ____"
                    onkeypress="formatar('##/##/####', this); return SomenteNumero(event);" autocomplete="off" 
                    value="<?php echo (isset($_SESSION['dtNasc'])) ? $_SESSION['dtNasc'] : ""; ?>" />
            </label>
                        
            <label class="t50_left">
                <strong class="legendaCampos">Telefone<span>&nbsp;*</span></strong>
                <input type="text" id="telefone" name="telefone" maxlength="14" class="full" alt="Telefone" placeholder="( __ ) ____ - ____"
                    onkeypress="formatar('(##) ####-####', this); return SomenteNumero(event)" autocomplete="off"
                    value="<?php echo (isset($_SESSION['telefone'])) ? $_SESSION['telefone'] : ""; ?>" />
            </label>
                        
            <label class="t50_right">
                <strong class="legendaCampos">Celular<span>&nbsp;*</span></strong>
                <input type="text" id="celular" name="celular" maxlength="15" class="full" alt="Celular" placeholder="( __ ) _____ - ____"
                    onkeypress="formatar('(##) #####-####', this); return SomenteNumero(event);" autocomplete="off" 
                    value="<?php echo (isset($_SESSION['celular'])) ? $_SESSION['celular'] : ""; ?>" />
            </label>
<?php
	$convenios = selecionarConvenios();

	if(empty($convenios)){
		echo "Não há convênios cadastrados para marcação de consulta.";
		exit;
	}
?>       
            <label class="t50_left">
                <strong class="legendaCampos">Convênio<span>&nbsp;*</span></strong>
                <select name="convenio" id="convenio" class="full">
                    <option value="selecione">Convênios...</option>
<?php
	for($i = 0; $i <= $_SESSION['indice']; $i++){
?>
                    <option value="<?php echo $convenios['codconvenio'][$i]; ?>"
                        <?php echo (isset($_SESSION['convenio']) && $convenios['codconvenio'][$i] ==  $_SESSION['convenio']) ? "Selected" : ""; ?>>
                        <?php echo ucwords(strtolower(utf8_decode($convenios['descr'][$i]))); ?>
                    </option>
<?php 
	}

	$_SESSION['indice'] = -1; 
?>
                </select>
            </label>
<?php
	$medicos = selecionarMedicos();
	
	if(empty($medicos)){
		echo "Não há médicos cadastrados para marcação de consulta.";
		exit;
	}
?>            
            <label class="t50_right">
            	<strong class="legendaCampos">Médico<span>&nbsp;*</span></strong>
            	<select name="medico" id="medico" class="full"<?php echo (!empty($outroMedico) ? " autofocus" : ""); ?>>
            		<option value="0">Selecione um médico</option>
<?php
	for($i = 0; $i <= $_SESSION['indice']; $i++){
?>
                	<option value="<?php echo $medicos['codmedico'][$i]; ?>"
						<?php echo (isset($_SESSION['codMedico']) && $_SESSION['codMedico'] == $medicos['codmedico'][$i]) ? "Selected" : "";?>>
                   		<?php echo ($medicos['sexo'][$i] == "M" ? "Dr. " : "Dra. ").$medicos['nome'][$i]; ?>
                	</option>
<?php 
	}

	$_SESSION['indice'] = -1; 
?>
                </select>
                
                <input type="text" id="nomeMedico" name="nomeMedico" hidden="hidden" value="" />
                <input type="text" id="convenioDesc" name="convenioDesc" hidden="hidden" value="" />
            </label>
                        
            <span class="full obs">*&nbsp;Preenchimento obrigatório</span>
            
            <div id="botaoProximo" class="flutuaDir">
                <input type="submit" id="btnProximo" name="btnProximo" class="designBotao btnProximo flutuaDir" value="Próximo" 
                	onclick="SetaHiddens(0, 'MSSQL')" />
            </div>
        </fieldset>
    </form>
</div>