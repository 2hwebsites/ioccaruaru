// Indica o estado dos elementos na inicialização da página
$(document).ready(function InicializarForm(){
	// Título
	if (document.getElementById("titulo") != null) {
		if (document.getElementById("titulo").alt == "obrigatorio"){
			$("#titulo").css({"background-color":"#faf261"});
		}
	}
	
	// Data
	if (document.getElementById("data") != null) {
		if (document.getElementById("data").alt == "obrigatorio"){
			$("#data").css({"background-color":"#faf261"});
		}
	}
	
	// Subtítulo
	if (document.getElementById("subtitulo") != null) {
		$("#subtitulo").css({"background-color":"#faf261"});
	}
	
	// Imagem de Capa
	if (document.getElementById("imgcapa") != null) {
		if (document.getElementById("imgcapa").alt == "obrigatorio"){
			$("#imgcapa").css({"background-color":"#faf261"});
		}
	}
	
	// Imagens da Galeria
	if (document.getElementById("imgGaleria") != null) {
		if (document.getElementById("imgGaleria").alt == "obrigatorio"){
			$("#imgGaleria").css({"background-color":"#faf261"});
		}
	}
	
	// Banner
	if (document.getElementById("banner_destaque") != null) {
		if ($("#banner_destaque").is(":visible")){
			if (document.getElementById("banner_destaque").alt == "obrigatorio"){
				$("#banner_destaque").css({"background-color":"#faf261"});
			}
		}
	}
	
	// Vídeo
	if (document.getElementById("video") != null) {
		if ($("#video").is(":visible")){
			$("#video").css({"background-color":"#faf261"});
		}
	}
	
	// Nome Completo
	if (document.getElementById("nome_completo") != null) {
		if (document.getElementById("nome_completo").alt == "obrigatorio"){
			$("#nome_completo").css({"background-color":"#faf261"});
		}
	}

	// Nome Resumido
	if (document.getElementById("nome_resumido") != null) {
		if (document.getElementById("nome_resumido").alt == "obrigatorio"){
			$("#nome_resumido").css({"background-color":"#faf261"});
		}
	}
	
	// Email
	if (document.getElementById("email") != null) {
		if (document.getElementById("email").alt == "obrigatorio"){
			$("#email").css({"background-color":"#faf261"});
		}
	}
	
	// Telefone
	if (document.getElementById("telefone") != null) {
		if (document.getElementById("telefone").alt == "obrigatorio"){
			$("#telefone").css({"background-color":"#faf261"});
		}
	}

	// Usuário
	if (document.getElementById("usuario_incluir") != null){
		if (document.getElementById("usuario_incluir").alt == "obrigatorio"){
			$("#usuario_incluir").css({"background-color":"#faf261"});
		}
	}
	
	// Senha
	if (document.getElementById("senha") != null){
		if (document.getElementById("senha").alt == "obrigatorio" && !(document.getElementById("senha").disabled)){
			$("#senha").css({"background-color":"#faf261"});
		}
	}
	
	// Confirmação de senha
	if (document.getElementById("confirmacao") != null){
		if (document.getElementById("confirmacao").alt == "obrigatorio" && !(document.getElementById("confirmacao").disabled)){
			$("#confirmacao").css({"background-color":"#faf261"});
		}
	}
	
	// Botão Mudar
	if (document.getElementById("mudarSenha_btn") != null){
		if (!(document.getElementById("mudarSenha_btn").disabled)){
			$("#mudarSenha_btn").css({"background-color":"#a4a4a4"});
		}
	}
	
	// Botão Cancelar
	if (document.getElementById("cancelarSenha_btn") != null){
		if (!(document.getElementById("cancelarSenha_btn").disabled)){
			$("#cancelarSenha_btn").css({"background-color":"#a4a4a4"});
		}
	}
	
	// Código do Paciente
	if (document.getElementById("codpaciente") != null){
		if (document.getElementById("codpaciente").alt == "obrigatorio"){
			$("#codpaciente").css({"background-color":"#faf261"});
		}
	}
	
	// Código do Médico
	if (document.getElementById("codMedico") != null){
		if (document.getElementById("codMedico").alt == "obrigatorio"){
			$("#codMedico").css({"background-color":"#faf261"});
		}
	}
	
	// Data de Entrega
	if (document.getElementById("dtentrega") != null){
		if (document.getElementById("dtentrega").alt == "obrigatorio"){
			$("#dtentrega").css({"background-color":"#faf261"});
		}
	}
	
	// Data da Marcação
	if (document.getElementById("dtMarcacao") != null){
		if (document.getElementById("dtMarcacao").alt == "obrigatorio"){
			$("#dtMarcacao").css({"background-color":"#faf261"});
		}
	}
	
	// Titulo do Exame
	if (document.getElementById("titexame") != null){
		if (document.getElementById("titexame").alt == "obrigatorio"){
			$("#titexame").css({"background-color":"#faf261"});
		}
	}
	
	// Exame
	if (document.getElementById("exame") != null){
		if (document.getElementById("exame").alt == "obrigatorio"){
			$("#exame").css({"background-color":"#faf261"});
		}
	}
	
	return (true);
});

<!-- Critica o formulário de usuário. -->
function critica(formName){
	// Título
	if (document.getElementById("titulo") != null) {
		if (formName.titulo.alt == "obrigatorio"){
			if (formName.titulo.value == ""){	
				formName.titulo.focus();
				return (false);
			}
		}
	}
	
	// Data
	if (document.getElementById("data") != null){
		if (formName.data.alt == "obrigatorio"){
			if (formName.data.value == ""){
				formName.data.focus();
				return false;
			} else{
				if (!ValidaData(formName.data.value)){
					$("#data").css({"background-color":"#fc978b"});
					formName.data.focus();
					formName.data.select();
					return false;
				} else{
					if (formName.data.alt == "obrigatorio"){
						$("#data").css({"background-color":"#faf261"});
					} else{
						$("#data").css({"background-color":"#ffffff"});
					}
				}
			}
		}
	}
	
	// Subtitulo
	if (document.getElementById("subtitulo") != null) {
		if (formName.subtitulo.value == ""){	
			formName.subtitulo.focus();
			return (false);
		}
	}
	
	// Imagem de Capa
	if (document.getElementById("imgcapa") != null){
		if (formName.imgcapa.alt == "obrigatorio"){
			if (formName.imgcapa.value == ""){
				formName.imgcapa.focus();
				return false;
			} else{
				var extensoes_permitidas = new Array(".jpg");
				
				if (!ValidaExtensao(formName.imgcapa.value, extensoes_permitidas)){
					$("#imgcapa").css({"background-color":"#fc978b"});
					formName.imgcapa.focus();
					return false;
				} else{
					if (formName.imgcapa.alt == "obrigatorio"){
						$("#imgcapa").css({"background-color":"#faf261"});
					} else{
						$("#imgcapa").css({"background-color":"#ffffff"});
					}
				}
			}
		}
	}
	
	// Imagens da Galeria
	if (document.getElementById("imgGaleria") != null){
		if (formName.imgGaleria.alt == "obrigatorio"){
			if (formName.imgGaleria.value == ""){
				formName.imgGaleria.focus();
				return false;
			} else{
				var extensoes_permitidas = new Array(".jpg", ".png", ".gif");
				
				if (!ValidaExtensao(formName.imgGaleria.value, extensoes_permitidas)){
					$("#imgGaleria").css({"background-color":"#fc978b"});
					formName.imgGaleria.focus();
					return false;
				} else{
					if (formName.imgGaleria.alt == "obrigatorio"){
						$("#imgGaleria").css({"background-color":"#faf261"});
					} else{
						$("#imgGaleria").css({"background-color":"#ffffff"});
					}
				}
			}
		}
	}
	
	// Imagem Banner
	if (document.getElementById("thumb_banner") != null){
		if ($("#banner_destaque").is(":visible")){
			if (formName.thumb_banner.alt == "obrigatorio"){
				if (formName.thumb_banner.value == ""){
					formName.thumb_banner.focus();
					return false;
				} else{
					var extensoes_permitidas = new Array(".jpg", ".png", ".gif");
					
					if (!ValidaExtensao(formName.thumb_banner.value, extensoes_permitidas)){
						$("#thumb_banner").css({"background-color":"#fc978b"});
						formName.thumb_banner.focus();
						return false;
					} else{
						if (formName.thumb_banner.alt == "obrigatorio"){
							$("#thumb_banner").css({"background-color":"#faf261"});
						} else{
							$("#thumb_banner").css({"background-color":"#ffffff"});
						}
					}
				}
			} else{
				if (document.getElementById("imgBannerDemo") != null){
					var selecao = document.getElementById("destaque_post");
					if ($("#imgBannerDemo").is(":hidden") && selecao.options[selecao.selectedIndex].value == "banner"){
						if (formName.thumb_banner.value == ""){
							formName.thumb_banner.focus();
							return false;
						}else{
							var extensoes_permitidas = new Array(".jpg", ".png", ".gif");
							
							if (!ValidaExtensao(formName.thumb_banner.value, extensoes_permitidas)){
								$("#thumb_banner").css({"background-color":"#fc978b"});
								formName.thumb_banner.focus();
								return false;
							} else{
								$("#thumb_banner").css({"background-color":"#faf261"});
							}
						}
					}
				}
			}
		}
	}
	
	// Video
	if (document.getElementById("video") != null) {
		if ($("#video_destaque").is(":visible")){
			if (formName.video.value == ""){
				formName.video.focus();
				return (false);
			}
		}
	}
	
	// Nome Completo
	if (document.getElementById("nome_completo") != null) {
		if (formName.nome_completo.alt == "obrigatorio"){
			if (formName.nome_completo.value == ""){	
				formName.nome_completo.focus();
				return (false);
			}
		}
	}

	// Nome Resumido
	if (document.getElementById("nome_resumido") != null) {
		if (formName.nome_resumido.alt == "obrigatorio"){
			if (formName.nome_resumido.value == ""){
				formName.nome_resumido.focus();
				return (false);
			}
		}
	}
	
	// Email
	if (document.getElementById("email") != null) {
		if (formName.email.alt == "obrigatorio"){
			if (formName.email.value == ""){
				formName.email.focus();
				return false;
			}
		}

		// Verifica se o email é válido
		if (formName.email.value != ""){
			var email = formName.email.value;
			var usuario_novo = email.substring(0, email.indexOf("@"));
			var dominio = email.substring(email.indexOf("@")+ 1, email.length);
			
			if( !((usuario_novo.length >=1) && (dominio.length >=3) && (usuario_novo.search("@")==-1) && (dominio.search("@")==-1) && (usuario_novo.search(" ")==-1) && 
				(dominio.search(" ")==-1) && (dominio.search(".")!=-1) && (dominio.indexOf(".") >=1)&& (dominio.lastIndexOf(".") < dominio.length - 1))){
				formName.email.focus();
				formName.email.select();
				$("#email").css({"background-color":"#fc978b"});
				return (false);
			}
		} else{
			if (formName.email.alt == "obrigatorio"){
				$("#email").css({"background-color":"#faf261"});
			} else{
				$("#email").css({"background-color":"#ffffff"});
			}
		}
	}
	
	// Telefone
	if (document.getElementById("telefone") != null) {
		if (formName.telefone.alt == "obrigatorio"){
			if (formName.telefone.value == ""){
				formName.telefone.focus();
				return false;
			}
		}
			
		// Verifica se o telefone é válido
		if (formName.telefone.value != ""){
			var telefone = formName.telefone.value;
							
			if(telefone.length < 14){
				formName.telefone.focus();
				formName.telefone.select();
				$("#telefone").css({"background-color":"#fc978b"});
				return (false);
			}
		} else{
			if (formName.telefone.alt == "obrigatorio"){
				$("#telefone").css({"background-color":"#faf261"});
			} else{
				$("#telefone").css({"background-color":"#ffffff"});
			}
		}
	}

	// Usuário
	if (document.getElementById("usuario_incluir") != null){
		if (formName.usuario_incluir.alt == "obrigatorio"){
			if (formName.usuario_incluir.value == ""){
				formName.usuario_incluir.focus();
				$("#usuario_incluir").css({"background-color":"#fc978b"});
				return (false);
			} else{
				if (formName.usuario_incluir.alt == "obrigatorio"){
					$("#usuario_incluir").css({"background-color":"#faf261"});
				} else{
					$("#usuario_incluir").css({"background-color":"#ffffff"});
				}
			}
		}
		
		if (formName.usuario_incluir.value.length < 4 || formName.usuario_incluir.value.length > 4) {
			$("#usuario_incluir").css({"background-color":"#fc978b"});
			formName.usuario_incluir.focus();
			formName.usuario_incluir.select();
			return false;
		} else{
			if (formName.usuario_incluir.alt == "obrigatorio"){
				$("#usuario_incluir").css({"background-color":"#faf261"});
			} else{
				$("#usuario_incluir").css({"background-color":"#ffffff"});
			}
		}
	}
	
	// Senha
	if (document.getElementById("senha") != null){
		if (!formName.senha.disabled){	
			if (formName.senha.alt == "obrigatorio"){
				if (formName.senha.value == ""){
					$("#senha").css({"background-color":"#fc978b"});
					formName.senha.focus();
					return false;
				} else{
					if (formName.senha.alt == "obrigatorio"){
						$("#senha").css({"background-color":"#faf261"});
					} else{
						$("#senha").css({"background-color":"#ffffff"});
					}
				}
			}
		
			if (formName.senha.value.length < 6 || formName.senha.value.length > 12) {
				formName.senha.focus();
				formName.senha.select();
				$("#senha").css({"background-color":"#fc978b"});
				return false;
			} else{
				if (formName.senha.alt == "obrigatorio"){
					$("#senha").css({"background-color":"#faf261"});
				} else{
					$("#senha").css({"background-color":"#ffffff"});
				}
			}
		}
	}
	
	// Confirmação de senha
	if (document.getElementById("confirmacao") != null){
		if (!formName.confirmacao.disabled){	
			if (formName.confirmacao.alt == "obrigatorio"){
				if (formName.confirmacao.value == ""){
					$("#confirmacao").css({"background-color":"#fc978b"});
					formName.confirmacao.focus();
					formName.confirmacao.select();
					return (false);
				} else{
					if (formName.confirmacao.alt == "obrigatorio"){
						$("#confirmacao").css({"background-color":"#faf261"});
					} else{
						$("#confirmacao").css({"background-color":"#ffffff"});
					}
				}
			}
			
			// Verifica se a senha e a confirmação estão iguais
			if (formName.senha.value != formName.confirmacao.value){
				formName.confirmacao.focus();
				formName.confirmacao.select();
				$("#confirmacao").css({"background-color":"#fc978b"});
				return (false);
			} else{
				if (formName.confirmacao.alt == "obrigatorio"){
					$("#confirmacao").css({"background-color":"#faf261"});
				} else{
					$("#confirmacao").css({"background-color":"#ffffff"});
				}
			}
		}
	}
	
	// Permissões
	if (document.getElementById("permissoes") != null){
		var administra = false;
		var cadusuario = false;
		var permissao = false;
		var cadconteudo = false;
		var exame = false;
		var consulta = false;
		
		if (document.getElementById('administra') != null){
			administra = document.getElementById('administra').checked;
		}
		
		if (document.getElementById('cadusuario') != null){
			cadusuario = document.getElementById('cadusuario').checked;
		}
		
		if (document.getElementById('permissao') != null){
			permissao = document.getElementById('permissao').checked;
		}
		
		if (document.getElementById('cadconteudo') != null){
			cadconteudo = document.getElementById('cadconteudo').checked;
		}
		
		if (document.getElementById('exame') != null){
			exame = document.getElementById('exame').checked;
		}
		
		if (document.getElementById('consulta') != null){
			consulta = document.getElementById('consulta').checked;
		}
		
		// Verifica se nenhuma permissão foi escolhida
		if (!administra && !cadusuario && !permissao && !cadconteudo && !exame && !consulta){
			$("#alertaPermissoes").css({"background-color":"#faf261"});			
			return (false);
		} else{
			$("#alertaPermissoes").css({"background-color":"#ffffff"});
		}
	}
	
	// Código do Paciente
	if (document.getElementById("codpaciente") != null){
		if (formName.codpaciente.alt == "obrigatorio"){
			if (formName.codpaciente.value == ""){
				formName.codpaciente.focus();
				return false;
			}
		}
		
		if (formName.codpaciente.value.length < 6) {
			formName.codpaciente.focus();
			formName.codpaciente.select();
			$("#codpaciente").css({"background-color":"#fc978b"});
			return false;
		} else{
			if (formName.codpaciente.alt == "obrigatorio"){
				$("#codpaciente").css({"background-color":"#faf261"});
			} else{
				$("#codpaciente").css({"background-color":"#ffffff"});
			}
		}
	}
	
	// Código do Médico
	if (document.getElementById("codMedico") != null){
		if (formName.codMedico.alt == "obrigatorio"){
			if (formName.codMedico.value == ""){
				formName.codMedico.focus();
				return false;
			}
		}
		
		if (formName.codMedico.value.length < 3) {
			formName.codMedico.focus();
			formName.codMedico.select();
			$("#codMedico").css({"background-color":"#fc978b"});
			return false;
		} else{
			if (formName.codMedico.alt == "obrigatorio"){
				$("#codMedico").css({"background-color":"#faf261"});
			} else{
				$("#codMedico").css({"background-color":"#ffffff"});
			}
		}
	}
	
	// Data de Entrega
	if (document.getElementById("dtentrega") != null){
		if (formName.dtentrega.alt == "obrigatorio"){
			if (formName.dtentrega.value == ""){
				formName.dtentrega.focus();
				return false;
			} else{
				if (!ValidaData(formName.dtentrega.value)){
					$("#dtentrega").css({"background-color":"#fc978b"});
					formName.dtentrega.focus();
					return false;
				} else{
					if (formName.dtentrega.alt == "obrigatorio"){
						$("#dtentrega").css({"background-color":"#faf261"});
					} else{
						$("#dtentrega").css({"background-color":"#ffffff"});
					}
				}
			}
		}
	}
	
	// Data de Marcação
	if (document.getElementById("dtMarcacao") != null){
		if (formName.dtMarcacao.alt == "obrigatorio"){
			if (formName.dtMarcacao.value == ""){
				formName.dtMarcacao.focus();
				return false;
			} else{
				if (!ValidaData(formName.dtMarcacao.value)){
					$("#dtMarcacao").css({"background-color":"#fc978b"});
					formName.dtMarcacao.focus();
					return false;
				} else{
					if (formName.dtMarcacao.alt == "obrigatorio"){
						$("#dtMarcacao").css({"background-color":"#faf261"});
					} else{
						$("#dtMarcacao").css({"background-color":"#ffffff"});
					}
				}
			}
		}
	}
	
	// Título do Exame
	if (document.getElementById("titexame") != null){
		if (formName.titexame.alt == "obrigatorio"){
			if (formName.titexame.value == ""){
				formName.titexame.focus();
				return false;
			}
		}
	}
	
	// Exame
	if (document.getElementById("exame") != null){
		if (formName.exame.alt == "obrigatorio"){
			if (formName.exame.value == ""){
				formName.exame.focus();
				return false;
			} else{
				var extensoes_permitidas = new Array(".pdf");
				
				if (!ValidaExtensao(formName.exame.value, extensoes_permitidas)){
					$("#exame").css({"background-color":"#fc978b"});
					formName.exame.focus();
					return false;
				} else{
					if (formName.exame.alt == "obrigatorio"){
						$("#exame").css({"background-color":"#faf261"});
					} else{
						$("#exame").css({"background-color":"#ffffff"});
					}
				}
			}
		}
	}
	
	return (true);
}

function ValidaExtensao(arquivo, extensoes_permitidas){
	var extensao = arquivo.substring(arquivo.lastIndexOf(".")).toLowerCase();
	
	if (extensoes_permitidas.indexOf(extensao) < 0){
		return false;
	}
	
	return true;
}

function ValidaData(valor){
	var date = valor;
	var ardt = new Array;
	var ExpReg = new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
	ardt = date.split("/");
	erro = false;
	
	if (date || date.length != 0){
		if (date.search(ExpReg) == -1){
			erro = true;
		}
		else if (((ardt[1] == 4) || (ardt[1] == 6) || (ardt[1] == 9) || (ardt[1] == 11)) && (ardt[0] > 30)){
			erro = true;
		}
		else if (ardt[1] == 2){
			if ((ardt[0] > 28) && ((ardt[2]%4) != 0)){
				erro = true;
			}
			if ((ardt[0] > 29) && ((ardt[2]%4) == 0)){
				erro = true;
			}
		}
	}
	
	if (erro){
		return false;
	}
	
	return true;
}

function exibir_Ocultar_Elemento(){
	var v = $("#destaque_post").val();

	if(v == "selecione"){
		$("#banner_destaque").hide("slow");
		$("#video_destaque").hide("slow");
		$("#thumb_banner").val("");
		$("#video").val("");
		
		if (document.getElementById("lblImgBannerDemo") != null){
			$("#lblImgBannerDemo").hide("slow");
		}
	}else if(v == "banner"){
		$("#banner_destaque").show("slow");
		$("#lblImgBannerDemo").show("slow");
		$("#video_destaque").hide("slow");
		$("#video").val("");
		
		if (document.getElementById("thumb_banner").alt == "obrigatorio"){
			$("#thumb_banner").css({"background-color":"#faf261"});
		} else{
			if (document.getElementById("imgBannerDemo") != null){
				$("#thumb_banner").css({"background-color":"#ffffff"});
			} else{
				$("#thumb_banner").css({"background-color":"#faf261"});
			}
		}
	}else if(v == "video"){
		$("#banner_destaque").hide("slow");
		$("#video_destaque").show("slow");
		$("#thumb_banner").val("");
		$("#video").css({"background-color":"#faf261"});
		
		if (document.getElementById("lblImgBannerDemo") != null){
			$("#lblImgBannerDemo").hide("slow");
		}
	}
}

$(document).ready(function exibir_Destaque(){
	var v = $("#destaque_post").val();
	
	if(v == "selecione"){
		$("#banner_destaque").hide("slow");
		$("#lblImgBannerDemo").hide("slow");
		$("#video_destaque").hide("slow");
	}else if(v == "banner"){
		$("#banner_destaque").show("slow");
		$("#lblImgBannerDemo").show("slow");
		$("#video_destaque").hide("slow");
		$("#video").val("");
	}else{
		$("#banner_destaque").hide("slow");
		$("#lblImgBannerDemo").hide("slow");
		$("#video_destaque").show("slow");
		$("#thumb_banner").val("");
	}
});


function Habilitar_Senha(){
	document.getElementById("mudar_senha").disabled = true;
	document.getElementById("senha").disabled = false;
	document.getElementById("confirmacao").disabled = false;
	document.getElementById("cancelar_senha").disabled = false;
	
	$("#senha").css({"background-color":"#faf261"});
	$("#confirmacao").css({"background-color":"#faf261"});
	$("#mudar_senha").css({"background-color":"#efefef"});
	$("#mudar_senha").css({"cursor":"default"});
	$("#cancelar_senha").css({"background-color":"#a4a4a4"});
	$("#cancelar_senha").css({"cursor":"pointer"});
	
	document.getElementById("senha").focus();
}

function Desabilitar_Senha(){
	document.getElementById("mudar_senha").disabled = false;
	document.getElementById("senha").disabled = true;
	document.getElementById("confirmacao").disabled = true;
	document.getElementById("cancelar_senha").disabled = true;
	
	$("#senha").css({"background-color":"#dfdfdf"});
	$("#confirmacao").css({"background-color":"#dfdfdf"});
	$("#mudar_senha").css({"background-color":"#a4a4a4"});
	$("#mudar_senha").css({"cursor":"pointer"});
	$("#cancelar_senha").css({"background-color":"#efefef"});
	$("#cancelar_senha").css({"cursor":"default"});
	
	document.getElementById("mmudar_senha").focus();
}

function habilita_desabilita_checkbox(obj){
	if (obj.checked == true){
		document.getElementById('cadusuario').disabled = true;
		document.getElementById('cadusuario').checked = false;
		document.getElementById('permissao').disabled = true;
		document.getElementById('permissao').checked = false;
		document.getElementById('cadconteudo').disabled = true;
		document.getElementById('cadconteudo').checked = false;
		document.getElementById('exame').disabled = true;
		document.getElementById('exame').checked = false;
		document.getElementById('consulta').disabled = true;
		document.getElementById('consulta').checked = false;
	}else{
		document.getElementById('cadusuario').disabled = false;
		document.getElementById('permissao').disabled = false;
		document.getElementById('cadconteudo').disabled = false;
		document.getElementById('exame').disabled = false;
		document.getElementById('consulta').disabled = false;
	}
}

function selecionarPagina(categoria, acao, usuario){
	if(categoria != 0){
		var categoriaDesc = '';
		var id = $('input:radio[name=id_conteudo]:checked').val()
		
		if(id == null && acao != 'novo' && acao != 'excluidos'){
			if(acao == 'galeria'){
				alert("Selecione uma galeria para editar.");
			} else{
				alert("Selecione um registro para " + acao + ".");
			}
			
			return;
		}
	
		switch(categoria){
			case 1:
				categoriaDesc = "galeria";
				break;
			case 2:
				categoriaDesc = "noticia";
				break;
			case 3:
				categoriaDesc = "dica";
				break;
			case 4:
				categoriaDesc = "carrossel";
				break;
			case 5:
				categoriaDesc = "banner";
				break;
			case 6:
				categoriaDesc = "revista";
				break;
			case 7:
				categoriaDesc = "usuario";
				break;
			case 8:
				categoriaDesc = "exame";
				break;
			case 9:
				categoriaDesc = "consulta";
				break;
		}
		
		switch(acao){
			case "novo":
				location.href = ("index.php?p=" + categoriaDesc + "_novo&cat=" + categoria + "&acao=1&us=" + usuario);
				break;
			case "editar":
				location.href = ("index.php?p=" + categoriaDesc + "_editar&id=" + id + "&cat=" + categoria + "&acao=2&us=" + usuario);
				break;
			case "galeria":
				location.href = ("index.php?p=" + categoriaDesc + "&id=" + id + "&cat=" + categoria + "&us=" + usuario);
				break;
			case "excluir":
				var id2 = id;
				var adicionar = 6 - id.length;
				
				for (var i = 0; i < adicionar; i++){
					id2 = '0' + id2;
				}
				
				resp = confirm('Confirma a exlusão do registro ' + id2 + '?');
				
				if (resp){
					if(categoria == 4){
						categoriaDesc = "carrossei";
					}
					location.href = ("index.php?p=" + categoriaDesc + "s&acao=3&cat=" + categoria + "&id=" + id + "&us=" + usuario);
				}
				
				break;
			case "excluidos":
				location.href = ("index.php?p=excluidos&cat=" + categoria + "&acao=7&us=" + usuario);
				break;
		}
	}
}