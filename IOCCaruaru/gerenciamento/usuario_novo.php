<?php	
	//inicializa as variáveis
	$id = '';
	$nome_completo = '';
	$nome_resumido = '';
	$email = '';
	$telefone = '';
	$senha = '';
	$data_cadastro = '';
	$ativo = '';
	$campos = '';
	$valores = '';
	$administra = '';
	$cadusuario = '';
	$permissao = '';
	$conteudo = '';
	$exame = '';
	$consulta = '';
	$valoresPermissoes = '';
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$nome_completo = "'".$_POST['nome_completo']."'";
		$nome_resumido = "'".$_POST['nome_resumido']."'";
		$email = "'".$_POST['email']."'";
		$telefone = "'".$_POST['telefone']."'";
		$usuario_novo = "'".anti_injection($_POST['usuario_incluir'])."'";
		$senha = "'".anti_injection(md5($_POST['senha']))."'";
		$data_cadastro = "'".date("Y-m-d")."'";
		$ativo = "'1'";
		
		$campos = array(
					0 => "nome_resumido", 
					1 => "nome_completo", 
					2 => "email", 
					3 => "fone", 
					4 => "usuario", 
					5 => "senha", 
					6 => "data_cadastro",
					7 => "ativo");
					
		$valores = array(
					0 => $nome_resumido, 
					1 => $nome_completo, 
					2 => $email, 
					3 => $telefone, 
					4 => $usuario_novo, 
					5 => $senha, 
					6 => $data_cadastro,
					7 => $ativo);
		
		$id = InserirDados($campos, $valores, "ioc_usuarios");
		
		
		if($id > 0){			
			if(isset($_POST['administra'])){
				$administra = $_POST['administra'];
			}else{
				$administra = 0;
			}
			
			if(isset($_POST['cadusuario'])){
				$cadUsuario = $_POST['cadusuario'];
			}else{
				$cadUsuario = 0;
			}
			
			if(isset($_POST['permissao'])){
				$permissao = $_POST['permissao'];
			}else{
				$permissao = 0;
			}
			
			if(isset($_POST['cadconteudo'])){
				$cadConteudo = $_POST['cadconteudo'];
			}else{
				$cadConteudo = 0;
			}
			
			if(isset($_POST['exame'])){
				$exame = $_POST['exame'];
			}else{
				$exame = 0;
			}
			
			if(isset($_POST['consulta'])){
				$consulta = $_POST['consulta'];
			}else{
				$consulta = 0;
			}
			
			$valores = array(
				   0 => $administra, 
				   1 => $cadUsuario, 
				   2 => $permissao, 
				   3 => $cadConteudo, 
				   4 => $exame, 
				   5 => $consulta);

			inserirUsuarioPermissao($id, $valores);
		}
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=usuarios&cat=7&us=".$usuario['id']."'>";
	}
	
	include "../connections/conn.php";
	
	$Permite = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ip.descricao FROM ioc_usuarios AS iu 
														INNER JOIN ioc_usuario_permissao AS iup ON iu.id = iup.usuario_id 
														INNER JOIN ioc_permissoes AS ip ON iup.permissao_id = ip.id
														WHERE iu.id = ".$usuario['id']."
														AND (ip.id = '3' OR ip.id = '1')"));
	
	mysqli_close($conn);
?>
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="usuario_novo" id="usuario_novo">
    	<fieldset>
        	<legend>Cadastrar Usuário</legend>
            
            <label class="full">
            	<strong class="legendaCampos">Nome Completo</strong>
            	<input type="text" id="nome_completo" name="nome_completo" maxlength="100" class="full input" autofocus="autofocus"
                	alt="obrigatorio" />
            </label>
            
            <label class="half">
            	<strong class="legendaCampos">Nome Resumido</strong>
                <input type="text" id="nome_resumido" name="nome_resumido" maxlength="50" class="full input obrigatorio" alt="obrigatorio" />
            </label>
            
            <label class="half halfMargem">
            	<strong class="legendaCampos">Email</strong>
                <input type="text" id="email" name="email" maxlength="50" class="full input" />
            </label>
            
            <label class="half">
            	<strong class="legendaCampos">DDD + Telefone</strong>
                <input type="text" id="telefone" name="telefone" maxlength="15" class="full input" onblur="verificarTelefone(this)"
                	onkeypress="formatar('(##) #####-####', this); return SomenteNumero(event)" />
            </label>
            
            <label class="half halfMargem">
            	<strong class="legendaCampos">Usuário<span class="alertaLegenda">*Entre 4 e 25 caracteres</span></strong>
                <input type="text" id="usuario_incluir" name="usuario_incluir" maxlength="25" class="full input obrigatorio" 
                	alt="obrigatorio" autocomplete="off" />
            </label>
            
            <label class="half">
            	<strong class="legendaCampos">Senha<span class="alertaLegenda">*Entre 6 e 12 caracteres</span></strong>
                <input type="password" id="senha" name="senha" maxlength="12" class="full input obrigatorio" alt="obrigatorio" />
            </label>
            
            <label class="half halfMargem">
            	<strong class="legendaCampos">Confirmar Senha</strong>
                <input type="password" id="confirmacao" name="confirmacao" maxlength="12" class="full input obrigatorio" alt="obrigatorio" />
            </label>
<?php if($Permite['descricao'] == 'permissao' || $Permite['descricao'] == 'administra'){ ?>
            <label class="permissoes" id="permissoes">
            	<strong class="legendaEmDestaque">Permissões<span id="alertaPermissoes" class="alertaLegenda">*Obrigatório informar ao menos uma permissão</span></strong>
            	<input type="checkbox" id="administra" name="administra" value="1" onclick="habilita_desabilita_checkbox(this)" /><span class="check">Administrador</span>
                <input type="checkbox" id="cadusuario" name="cadusuario" value="2" /><span class="check">Cadastrar Usuário</span>
                <input type="checkbox" id="permissao" name="permissao" value="3" /><span class="check">Dar Permissão a Usuário</span>
                <input type="checkbox" id="cadconteudo" name="cadconteudo" value="4" /><span class="check">Cadastrar Conteúdo</span>
                <input type="checkbox" id="exame" name="exame" value="5" /><span class="check">Upload de Exames</span>
                <input type="checkbox" id="consulta" name="consulta" value="6" /><span class="check">Configurar Marcação de Consulta</span>
			</label>
<?php } ?>
            
			<input name="cadastrar" type="submit" id="cadastrar" value="Cadastrar" class="cadastrar_btn" />
        </fieldset>
    </form>