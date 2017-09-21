<?php	
	//inicializa as variáveis
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$cont = 0;
		$campos = array();
		$valores = array();
		
		$campos[$cont] = "codmedico";
		$valores[$cont] = "'".$_POST['codMedico']."'";
		$cont++;
		
		$campos[$cont] = "datamarcacao";
		$dtMarcacaoArray = explode("/", $_POST['dtMarcacao']);
		$valores[$cont] = "'".$dtMarcacaoArray[2]."-".$dtMarcacaoArray[1]."-".$dtMarcacaoArray[0]."'";
		$cont++;
		
		$campos[$cont] = "usuario_id";
		$valores[$cont] = "'".$usuario['id']."'";
		
		AlterarDados($campos, $valores, "ioc_datamarcacao", $id);
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=consultas&cat=9&us=".$usuario['id']."'>";
	}
	
	include "../connections/conn.php";

	$res_marcacao = mysqli_fetch_assoc(mysqli_query($conn, "SELECT codmedico, datamarcacao From ioc_datamarcacao 
																WHERE id = '".$id."'"));
	
	mysqli_close($conn);
	
	$codMedico = $res_marcacao['codmedico'];
	$dtMarcacaoArray = explode("-", $res_marcacao['datamarcacao']);
	$dtMarcacao = $dtMarcacaoArray[2]."/".$dtMarcacaoArray[1]."/".$dtMarcacaoArray[0];
?>
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="consulta_novo" id="consulta_novo">
    	<fieldset>
        	<legend>Cadastrar Data de Marcação</legend>
            
            <label class="half">
            	<strong class="legendaCampos">Código do Médico</strong>
            	<input type="text" id="codMedico" name="codMedico" maxlength="3" class="half input" autofocus="autofocus" 
                	alt="obrigatorio" onkeypress="return SomenteNumero(event)" value="<?php echo $codMedico; ?>" />
            </label>
            
            <label class="half halfMargem">
            	<strong class="legendaCampos">Data da Marcação</strong>
                <input type="text" id="dtMarcacao" name="dtMarcacao" maxlength="10" class="half input" alt="obrigatorio"
                	onkeypress="formatar('##/##/####', this); return SomenteNumero(event)" value="<?php echo $dtMarcacao; ?>" />
            </label>
            
			<input name="cadastrar" type="submit" id="cadastrar" value="Cadastrar" class="cadastrar_btn" />
        </fieldset>
    </form>