<?php
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	
	//inicializa as variáveis
	$campos = '';
	$valores = '';
	$administra = '';
	$cadUsuario = '';
	$permissao = '';
	$cadConteudo = '';
	$exame = '';
	$consulta = '';
	$valoresPermissoes = '';
	
	include "../connections/conn.php";
	
	$Permite = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ip.descricao FROM ioc_usuarios AS iu 
														INNER JOIN ioc_usuario_permissao AS iup ON iu.id = iup.usuario_id 
														INNER JOIN ioc_permissoes AS ip ON iup.permissao_id = ip.id
														WHERE iu.id = ".$usuario['id']."
														AND (ip.id = '3' OR ip.id = '1')"));
														
	$res_usuario = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nome_completo, nome_resumido, email, fone, usuario
															From ioc_usuarios WHERE id = '".$id."'"));
	
	$nome_completo = $res_usuario['nome_completo'];
	$nome_resumido = $res_usuario['nome_resumido'];
	$email = $res_usuario['email'];
	$telefone = $res_usuario['fone'];
	$nome = $res_usuario['usuario'];
	
	$permissoes = mysqli_query($conn, "SELECT ip.descricao FROM ioc_usuarios AS iu 
										INNER JOIN ioc_usuario_permissao AS iup ON iu.id = iup.usuario_id 
										INNER JOIN ioc_permissoes AS ip ON iup.permissao_id = ip.id
										WHERE iu.id = '".$id."'")
											Or die('Erro ao obter permissões. '.mysqli_error($conn));

	mysqli_close($conn);
	
	$total_permissoes = @mysqli_num_rows($permissoes);
	
	if($total_permissoes > '0'){
		while($res_permissao = mysqli_fetch_array($permissoes)){
			$perm = $res_permissao[0];
			
			if($perm == "administra"){
				$administra = "Checked";
				$cadUsuario = "disabled";
				$permissao = "disabled";
				$cadConteudo = "disabled";
				$exame = "disabled";
				$consulta = "disabled";
			}
			
			if($perm == "cadusuario"){
				$cadUsuario = "Checked";
			}
			
			if($perm == "permissao"){
				$permissao = "Checked";
			}
			
			if($perm == "conteudo"){
				$cadConteudo = "Checked";
			}
			
			if($perm == "exame"){
				$exame = "Checked";
			}
			
			if($perm == "consulta"){
				$consulta = "Checked";
			}
		}
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$nome_completo = $_POST['nome_completo'];
		$nome_resumido = $_POST['nome_resumido'];
		$email = $_POST['email'];
		$telefone = $_POST['telefone'];
		$login = anti_injection($_POST['usuario_incluir']);
		
		$campos = array(
					0 => "nome_resumido", 
					1 => "nome_completo", 
					2 => "email", 
					3 => "fone", 
					4 => "usuario");
					
		$valores = array(
					0 => "'".$nome_resumido."'", 
					1 => "'".$nome_completo."'", 
					2 => "'".$email."'", 
					3 => "'".$telefone."'", 
					4 => "'".$login."'");
		
		if(!empty($_POST['senha'])){
			$senha = anti_injection(md5($_POST['senha']));
			$campos[5] = "senha";
			$valores[5] = "'".$senha."'";
		}
		
		if(AlterarDados($campos, $valores, "ioc_usuarios", $id)){
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

			alterarUsuarioPermissao($id, $valores);
		}
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=usuarios&cat=7&us=".$usuario['id']."'>";
	}
?>
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="usuario_editar" id="usuario_editar">
    	<fieldset>
        	<legend>Editar Usuário</legend>
            
            <label class="full">
            	<strong class="legendaCampos">Nome Completo</strong>
            	<input type="text" id="nome_completo" name="nome_completo" maxlength="100" class="full input" autofocus="autofocus" 
                	value="<?php echo $nome_completo; ?>" alt="obrigatorio" />
            </label>
            
            <label class="half">
            	<strong class="legendaCampos">Nome Resumido</strong>
                <input type="text" id="nome_resumido" name="nome_resumido" maxlength="50" class="full input"  alt="obrigatorio"
                	value="<?php echo $nome_resumido; ?>" />
            </label>
            
            <label class="half halfMargem">
            	<strong class="legendaCampos">Email</strong>
                <input type="text" id="email" name="email" maxlength="50" class="full input" value="<?php echo $email; ?>" />
            </label>
            
            <label class="half">
            	<strong class="legendaCampos">DDD + Telefone</strong>
                <input type="text" id="telefone" name="telefone" maxlength="15" class="full input" onblur="verificarTelefone(this)"
                	onkeypress="formatar('(##) #####-####', this); return SomenteNumero(event)" value="<?php echo $telefone; ?>" />
            </label>
            
            <label class="half halfMargem">
            	<strong class="legendaCampos">Usuário<span class="alertaLegenda">*Entre 4 e 25 caracteres</span></strong>
                <input type="text" id="usuario_incluir" name="usuario_incluir" maxlength="25" class="full input" value="<?php echo $nome; ?>" alt="obrigatorio"
                	autocomplete="off" />
            </label>
            
            <label class="half">
            	<strong class="legendaCampos">Senha<span class="alertaLegenda">*Entre 6 e 12 caracteres</span></strong>
                <input type="password" id="senha" name="senha" maxlength="12" class="full input" alt="obrigatorio" disabled="disabled"
                	style="background-color:#dfdfdf" />
            </label>
            
            <label class="half halfMargem">
            	<strong class="legendaCampos">Confirmar Senha</strong>
                <input type="password" id="confirmacao" name="confirmacao" maxlength="12" class="full input" disabled="disabled" alt="obrigatorio"
                	style="background-color:#dfdfdf" />
            </label>
            
            <input type="button" id="mudar_senha" name="mudar_senha" value="Mudar Senha" onclick="Habilitar_Senha()" class="mudarSenha_btn" />
            <input type="button" id="cancelar_senha" name="cancelar_senha" value="Cancelar" onclick="Desabilitar_Senha()" class="cancelarSenha_btn" 
            	disabled="disabled"	style="background-color:#efefef" />
<?php if($Permite['descricao'] == 'permissao' || $Permite['descricao'] == 'administra'){ ?>
            <label class="permissoes">
            	<strong class="legendaEmDestaque">Permissões<span class="alertaLegenda">*Obrigatório informar ao menos uma permissão</span></strong>
            	<input type="checkbox" id="administra" name="administra" value="1" onclick="habilita_desabilita_checkbox(this)" <?php echo $administra; ?> /><span class="check">Administrador</span>
                <input type="checkbox" id="cadusuario" name="cadusuario" value="2" <?php echo $cadUsuario; ?> /><span class="check">Cadastrar Usuário</span>
                <input type="checkbox" id="permissao" name="permissao" value="3" <?php echo $permissao; ?> /><span class="check">Dar Permissão a Usuário</span>
                <input type="checkbox" id="cadconteudo" name="cadconteudo" value="4" <?php echo $cadConteudo; ?> /><span class="check">Cadastrar Conteúdo</span>
                <input type="checkbox" id="exame" name="exame" value="5" <?php echo $exame; ?> /><span class="check">Upload de Exames</span>
                <input type="checkbox" id="consulta" name="consulta" value="6" <?php echo $consulta; ?> /><span class="check">Configurar Marcação de Consulta</span>
			</label>
<?php } ?>
            
			<input name="cadastrar" type="submit" id="cadastrar" value="Editar" class="cadastrar_btn" />
        </fieldset>
    </form>