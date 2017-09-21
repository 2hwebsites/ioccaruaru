<?php	
	//inicializa as variáveis
	$id = '';
	$codMedico = '';
	$dtMarcacao = '';
	$campos = '';
	$valores = '';
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$codMedico = $_POST['codMedico'];
		$dtMarcacaoArray = explode("/", $_POST['dtMarcacao']);
		$dtMarcacao = $dtMarcacaoArray[2]."-".$dtMarcacaoArray[1]."-".$dtMarcacaoArray[0];
		
		$campos = array(
					0 => "codmedico", 
					1 => "datamarcacao", 
					2 => "usuario_id");
					
		$valores = array(
					0 => "'".$codMedico."'",
					1 => "'".$dtMarcacao."'", 
					2 => "'".$usuario['id']."'");

		InserirDados($campos, $valores, "ioc_datamarcacao");
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=consultas&cat=9&us=".$usuario['id']."'>";
	}
?>
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="consulta_novo" id="consulta_novo">
    	<fieldset>
        	<legend>Cadastrar Data de Marcação</legend>
            
            <label class="half">
            	<strong class="legendaCampos">Código do Médico</strong>
            	<input type="text" id="codMedico" name="codMedico" maxlength="3" class="half input" autofocus="autofocus" 
                	alt="obrigatorio" onkeypress="return SomenteNumero(event)" />
            </label>
            
            <label class="half halfMargem">
            	<strong class="legendaCampos">Data da Marcação</strong>
                <input type="text" id="dtMarcacao" name="dtMarcacao" maxlength="10" class="half input" alt="obrigatorio"
                	onkeypress="formatar('##/##/####', this); return SomenteNumero(event)" />
            </label>
            
			<input name="cadastrar" type="submit" id="cadastrar" value="Cadastrar" class="cadastrar_btn" />
        </fieldset>
    </form>