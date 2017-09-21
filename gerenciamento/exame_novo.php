<?php	
	//inicializa as variáveis
	$id = '';
	$codPaciente = '';
	$titExame = '';
	$dtEntrega = '';
	$exame = '';
	$exameTmp = '';
	$res_paciente = '';
	$pacienteSQL = '';
	$pacienteQY = '';
	$nome = '';
	$senha = '';
	$campos = '';
	$valores = '';
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		include "../connections/connMSS.php";
		
		$paciente = sqlsrv_fetch_array(sqlsrv_query($connMSS, "SELECT codpaciente, paciente, rtrim(convert(char, datanasc, 103)) AS datanasc 
																FROM cadpaciente WHERE codpaciente = '".$_POST['codpaciente']."'"));
		
		if(!isset($paciente) || empty($paciente)){
?>
			<h1 style="text-align:center; color:red; margin-top:15px;">Paciente não localizado!</h1>
            <h2 style="text-align:center; color:red; margin-top:10px;">Verifique o código informado.</h2>
			<input type="button" id="voltar" class="voltar_btn" value="Voltar" onclick="javascript:history.back()"
            	style="margin:15px 0 0 330px;" />
<?php
			exit;
		} else{
			$nome = $paciente['paciente'];
			$dataNasc = explode("/", $paciente['datanasc']);
			$senha = md5($dataNasc[0].$dataNasc[1].$dataNasc[2]);
		}
		
		$codPaciente = $_POST['codpaciente'];
		$titExame = $_POST['titexame'];
		$dtEntregaArray = explode("/", $_POST['dtentrega']);
		$dtEntrega = $dtEntregaArray[2]."-".$dtEntregaArray[1]."-".$dtEntregaArray[0];
		
		$exame = date("dmyHms").$_FILES['exame']['name'];
		$exameTmp = $_FILES['exame']['tmp_name'];
		
		$campos = array(
					0 => "atendimento", 
					1 => "senha", 
					2 => "nome", 
					3 => "titulo_exame", 
					4 => "exame", 
					5 => "dt_entrega",
					6 => "ativo");
					
		$valores = array(
					0 => "'".$codPaciente."'",
					1 => "'".$senha."'", 
					2 => "'".$nome."'", 
					3 => "'".$titExame."'", 
					4 => "'".$exame."'", 
					5 => "'".$dtEntrega."'", 
					6 => '1');

		if(InserirDados($campos, $valores, "ioc_exames") > 0){
			$path = "../upload/exames/".$codPaciente;
			
			// Cria o diretório do paciente, se não existir
			if(!file_exists($path)){
				mkdir($path);
			}
			
			$path = $path."/".$exame;
			
			// Envia o arquivo para o servidor
			if(!move_uploaded_file($exameTmp, $path)){
				exit();
			}
		}
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=exames&cat=8&us=".$usuario['id']."'>";
	}
?>
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="exame_novo" id="exame_novo">
    	<fieldset>
        	<legend>Inserir Exame</legend>
            
            <label class="half">
            	<strong class="legendaCampos">Código do Paciente</strong>
            	<input type="text" id="codpaciente" name="codpaciente" maxlength="6" class="half input" autofocus="autofocus" alt="obrigatorio"
                	onkeypress="return SomenteNumero(event)" />
            </label>
            
            <label class="half halfMargem">
            	<strong class="legendaCampos">Data de Entrega</strong>
                <input type="text" id="dtentrega" name="dtentrega" maxlength="10" class="half input" alt="obrigatorio"
                	onkeypress="formatar('##/##/####', this); return SomenteNumero(event)" />
            </label>

            <label class="full">
            	<strong class="legendaCampos">Título do Exame</strong>
                <div id="msgTituloExame" class="msgAlerta"></div>
                <input type="text" id="titexame" name="titexame" maxlength="60" class="full input" alt="obrigatorio" />
            </label>
            
            <label class="full">
            	<strong class="legendaCampos">Exame<span class="alertaLegenda">*Apenas arquivos .pdf</span></strong>
                <input type="file" id="exame" name="exame" class="full input" alt="obrigatorio" />
                
            </label>
            
			<input name="cadastrar" type="submit" id="cadastrar" value="Cadastrar Exame" class="cadastrar_btn" />
        </fieldset>
    </form>