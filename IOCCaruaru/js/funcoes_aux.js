<!-- Função para definir máscara de um campo --> 
		function formatar(mascara, documento){
			var i = documento.value.length;
			var saida = '#';
			var texto = mascara.substring(i);
			
			if (texto.substring(0,1) != saida){
				while(texto.substring(0,1) != saida && documento.value.length < mascara.length){
					documento.value += texto.substring(0,1);
					i++;
					texto = mascara.substring(i);
				} 
			}			  
		}
		
		function verificarTelefone(documento){
			var i = documento.value.length;
			
			if (i == 14){
				documento.value = documento.value.substring(0,9) + "-" + documento.value.substring(9).replace("-", "");
			}
		}
	
		<!-- Função para determinar que somente números sejam digitados no campo --> 
		function SomenteNumero(e){
			var tecla=(window.event)?event.keyCode:e.which;   
			if((tecla>47 && tecla<58)) return true;
			else{
				if (tecla==8 || tecla==0) return true;
			else  return false;
			}
		}
		
		<!-- Função para determinar que somente letras sejam digitados no campo --> 
		function SomenteLetra(e){
			var tecla=(window.event)?event.keyCode:e.which;   
			if((tecla>47 && tecla<58)) return false;
			else{
				if (tecla==8 || tecla==0) return false;
			else  return true;
			}
		}
		
		<!-- Função para validar a data -->
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
	
		<!-- Função para obter a soma das alturas dos elementos da sidebar --> 
		setTimeout(function() { 
			var alturah1 = $('#informacao-sidebar h1').height();
			var alturaul = $("#informacao-sidebar ul").height();
			var alturainformacaosidebar = alturah1 + alturaul + 10;
		
			$("#informacao-sidebar").css({ "height": +alturainformacaosidebar+"px" });
		}, 600);
	
		<!-- Função para obter o tamanho da maior li, da page info, e aplicar a altura nas demais li´s -->
		setTimeout(function() {
			var maxAltura = $('.linha1').height();
			var linha = '';
			
			for(i = 2; i <= 4; i++){
				linha = '.linha' + i;
				if( $(linha).height() > maxAltura){
					maxAltura = $(linha).height();
				}
			}
		
			$(".info-margem-baixo").css({ "height": +maxAltura+"px" });
		}, 600);
	
		<!-- Função para obter a larguras das numerações e aplicar na largura da div paginação. Também irá centralizar a div paginação. -->
//		$(document).ready(function() {
//			var largura = 0;
//			
//			$("#paginacao").children().each(function() {
//				largura += $(this).width();
//				largura += 14;
//			});
//			
//			$("#paginacao").css({ "width": +largura+"px" });
//			
//			var margem = (670 - largura - 5) / 2;
//		
//			$("#paginacao").css({ "margin-left": +margem+"px" });
//		});
	
		<!-- Verifica se os campos obrigatórios da page Trabalhe Conosco estão preenchidos. -->
		function checa_formulario(formname, chamado){
			// Nome
			if (formname.nome.value == ""){
				$("#nome").css({ "border-color" : "#cd150c" });
				formname.nome.focus();
				return (false);
			} else{
				$("#nome").css({ "border-color" : "#d4d4d4" });
			}
			
			if (formname.email.value == ""){
				$("#email").css({ "border-color" : "#cd150c" });
				formname.email.focus();
				return (false);
			} else{
				var email = formname.email.value;
				var usuario = email.substring(0, email.indexOf("@"));
				var dominio = email.substring(email.indexOf("@")+ 1, email.length);
				
				if( (usuario.length >=1) &&
					(dominio.length >=3) && 
					(usuario.search("@")==-1) && 
					(dominio.search("@")==-1) &&
					(usuario.search(" ")==-1) && 
					(dominio.search(" ")==-1) &&
					(dominio.search(".")!=-1) &&      
					(dominio.indexOf(".") >=1)&& 
					(dominio.lastIndexOf(".") < dominio.length - 1)) {
					$("#email").css({ "border-color" : "#d4d4d4" });
				} else{
					$("#email").css({ "border-color" : "#cd150c" });
					formname.email.focus();
					return (false);
				}
			}
			
			if(chamado == 'tc'){
				if(formname.curriculo.value == ""){
					$("#curriculo").css({ "border" : "2px solid" });
					$("#curriculo").css({ "border-color" : "#cd150c" });
					formname.curriculo.focus();
					return false;
				} else{
					var extensoes_permitidas = new Array(".pdf", ".doc", ".docx");
				
					if (!ValidaExtensao(formname.curriculo.value, extensoes_permitidas)){
						$("#curriculo").css({ "border" : "2px solid" });
						$("#curriculo").css({ "border-color" : "#cd150c" });
						formname.curriculo.focus();
						return false;
					}
					
					$("#curriculo").css({ "border" : "none" });
				}
			}
			
			if(chamado == 'ct'){
				if(formname.telefone.value == ""){
					document.getElementById("msgtelefone").innerHTML="<font color='red'>*Necessário informar o telefone</font>";
					formname.telefone.focus();
					return (false);
				} else{
					var telefone = formname.telefone.value;
					
					if(telefone.length < 14){
						document.getElementById("msgtelefone").innerHTML="<font color='red'>*Telefone inválido</font>";
						formname.telefone.focus();
						return (false);
					} else{
						document.getElementById("msgtelefone").innerHTML="<font></font>";
					}
				}
	
				if(formname.assunto.value == ""){
					document.getElementById("msgassunto").innerHTML="<font color='red'>*Necessário informar o assunto</font>";
					formname.assunto.focus();
					return (false);
				} else{
					document.getElementById("msgassunto").innerHTML="<font></font>";
				}
				
				if(formname.mensagem.value == ""){
					document.getElementById("msgmensagem").innerHTML="<font color='red'>*Necessário informar a mensagem</font>";
					formname.mensagem.focus();
					return (false);
				} else{
					document.getElementById("msgmensagem").innerHTML="<font></font>";
				}
			}
		}
	
		<!-- Função para obter a soma das alturas dos elementos do painel de conteúdo --> 
		setTimeout(function() { 
			var alturaContent = $('#content-full #content').height();
			var alturaMenu = $('#menu #menu-lateral').height();
			
			if(alturaContent >= alturaMenu){
				$("#menu #menu-lateral").css({ "height": +alturaContent+"px" });
				$("#content-full .separador-menu").css({ "height": +(alturaContent-10)+"px" });
			} else{
				$("#content-full #content").css({ "height": +alturaMenu+"px" });
				$("#content-full .separador-menu").css({ "height": +(alturaMenu-10)+"px" });
			}
		}, 600);
		
		function ValidaExtensao(arquivo, extensoes_permitidas){
			var extensao = arquivo.substring(arquivo.lastIndexOf(".")).toLowerCase();
			
			if (extensoes_permitidas.indexOf(extensao) < 0){
				return false;
			}
			
			return true;
		}
		
		function SetNomeMedico(){
			var nomeMedico = document.getElementById("medico").options[document.getElementById("medico").selectedIndex].text;
			var convenioDesc = document.getElementById("convenio").options[document.getElementById("convenio").selectedIndex].text;
			document.getElementById("nomeMedico").value = nomeMedico;
			document.getElementById("convenioDesc").value = convenioDesc;
		}
		
		$(document).ready(function(){
			if(document.getElementById("frmUsuario") != null){
				document.getElementById("cadastro_vazado").hidden = true;
				document.getElementById("cadastro").hidden = false;
				$("#cadastro_texto").css({ "font-weight": "bold" });
			}
			
			if(document.getElementById("frmCalendario") != null){
				document.getElementById("calendario_vazado").hidden = true;
				document.getElementById("calendario").hidden = false;
				$("#calendario_texto").css({ "font-weight": "bold" });
			}
			
			if(document.getElementById("frmConfirma") != null){
				document.getElementById("confirma_vazado").hidden = true;
				document.getElementById("confirma").hidden = false;
				$("#confirma_texto").css({ "font-weight": "bold" });
			}
			
			if(document.getElementById("frmConcluido") != null){
				document.getElementById("concluido_vazado").hidden = true;
				document.getElementById("concluido").hidden = false;
				$("#concluido_texto").css({ "font-weight": "bold" });
			}
		});
		
		function SetaHiddens(modificador, chamada){
			if(document.getElementById("txhModificadorMes") != null){
				document.getElementById("txhModificadorMes").value = modificador;
			}
			
			if(document.getElementById("txhChamada") != null){
				document.getElementById("txhChamada").value = chamada;
			}
		}
		
		function HabilitaBotao(){
			document.getElementById("btnMarcar").disabled = false;
		}
		
		function SetarHorario(turno){
			var id = $('input:radio[name=selHorario]:checked').val();
			
			if(document.getElementById("hora") != null){
				document.getElementById("hora").value = id;
			}
			
			if(document.getElementById("turno") != null){
				document.getElementById("turno").value = turno;
			}
		}