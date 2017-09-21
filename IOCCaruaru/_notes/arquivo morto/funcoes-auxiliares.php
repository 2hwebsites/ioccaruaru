
	
	<script>
		<!-- Função para definir máscara de um campo --> 
		function formatar(mascara, documento){
			var i = documento.value.length;
			var saida = '#';
			var texto = mascara.substring(i)
			
			if (texto.substring(0,1) != saida){
				if(texto.substring(1,2) == " "){
					documento.value += texto.substring(0,1)+" ";
				} else {
					documento.value += texto.substring(0,1);
				}
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
		setTimeout(function() {
			var largura = 0;
			
			$("#paginacao").children().each(function() {
				largura += $(this).width();
				largura += 14;
			});
			
			$("#paginacao").css({ "width": +largura+"px" });
			
			var margem = (670 - largura - 5) / 2;
		
			$("#paginacao").css({ "margin-left": +margem+"px" });
		}, 600);
	
		<!-- Verifica se os campos obrigatórios da page Trabalhe Conosco estão preenchidos. -->
		function checa_formulario(formname, chamado){
			if (formname.nome.value == ""){
				document.getElementById("msgnome").innerHTML="<font color='red'>*Necessário informar o nome</font>";
				formname.nome.focus();
				return (false);
			} else{
				document.getElementById("msgnome").innerHTML="<font></font>";
			}
			
			if (formname.email.value == ""){
				document.getElementById("msgemail").innerHTML="<font color='red'>*Necessário informar o email</font>";
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
					document.getElementById("msgemail").innerHTML="<font></font>";
				} else{
					document.getElementById("msgemail").innerHTML="<font color='red'>*Email inválido</font>";
					formname.email.focus();
					return (false);
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
	</script>