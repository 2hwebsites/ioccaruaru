<?php
	// Inicializa variáveis
	$alteraExame = 0;
	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	
	include "../connections/conn.php";
	
	$exameSQL = "SELECT atendimento, titulo_exame, exame, dt_entrega FROM ioc_exames WHERE id = '".$id."'";
	$exameQY = mysqli_fetch_assoc(mysqli_query($conn, $exameSQL));
	
	mysqli_close($conn);
	
	$codPaciente = $exameQY['atendimento'];
	$dtEntregaArray = explode("-", $exameQY['dt_entrega']);
	$dtEntrega = $dtEntregaArray[2]."/".$dtEntregaArray[1]."/".$dtEntregaArray[0];
	$titExame = $exameQY['titulo_exame'];
	$exame = $exameQY['exame'];
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$cont = 0;
		$campos = array();
		$valores = array();
		
		if($titExame <> $_POST['titexame']){
			$campos[$cont] = "titulo_exame";
			$valores[$cont] = "'".$_POST['titexame']."'";
			$cont++;
		}
		
		if($dtEntrega <> $_POST['dtentrega']){
			$campos[$cont] = "dt_entrega";
			$dtEntregaArray = explode("/", $_POST['dtentrega']);
			$valores[$cont] = "'".$dtEntregaArray[2]."-".$dtEntregaArray[1]."-".$dtEntregaArray[0]."'";
			$cont++;
		}
		
		if(!empty($_FILES['exame']['name'])){
			$exame = date("dmyHms").$_FILES['exame']['name'];
			$exameTmp = $_FILES['exame']['tmp_name'];
			$alteraExame = 1;
			$campos[$cont] = "exame";
			$valores[$cont] = "'".$exame."'";
			$cont++;
		}

		if(!empty($campos)){
			AlterarDados($campos, $valores, "ioc_exames", $id);
		}
		if($alteraExame){
			$path = "../upload/exames/".$codPaciente."/".$exame;
		
			// Envia o arquivo para o servidor
			if(!move_uploaded_file($exameTmp, $path)){
				exit();
			}
		}
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=exames&cat=8&us=".$usuario['id']."'>";
	}
?>
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="exame_editar" id="exame_editar">
    	<fieldset>
        	<legend>Alterar Exame</legend>
            
            <label class="half">
            	<strong class="legendaCampos">Código do Paciente</strong>
            	<input type="text" id="codpaciente" name="codpaciente" maxlength="6" class="half input" value="<?php echo $codPaciente; ?>"
                	onkeypress="return SomenteNumero(event)" disabled="disabled" />
            </label>
            
            <label class="half halfMargem">
            	<strong class="legendaCampos">Data de Entrega</strong>
                <input type="text" id="dtentrega" name="dtentrega" maxlength="10" class="half input" alt="obrigatorio"
                	onkeypress="formatar('##/##/####', this); return SomenteNumero(event)"  value="<?php echo $dtEntrega; ?>"
                    autofocus="autofocus" autocomplete="off" />
            </label>

            <label class="full">
            	<strong class="legendaCampos">Título do Exame</strong>
                <div id="msgTituloExame" class="msgAlerta"></div>
                <input type="text" id="titexame" name="titexame" maxlength="60" class="full input" alt="obrigatorio" value="<?php echo $titExame; ?>"
                autocomplete="off" />
            </label>
            
            <label class="full">
            	<strong class="legendaCampos">Exame<span class="alertaLegenda">*Apenas arquivos .pdf</span></strong>
                <input type="file" id="exame" name="exame" class="full input" />
                <strong style="margin-top:5px;" class="legendaCampos"><?php echo substr($exame, 12); ?></strong>
            </label>
            
			<input name="cadastrar" type="submit" id="cadastrar" value="Cadastrar Exame" class="cadastrar_btn" />
        </fieldset>
    </form>