<!-- Função para criticar preenchimento dos campos "Atendimento" e "Senha" para entrega de resultado de exame --> 
function criticaExame(formName, chamada){
	// Atendimento
	if (formName.atendimento.value == ""){
		$("#atendimento").css({ "border-color" : "#cd150c" });
		$("#senha").css({ "border-color" : "#d4d4d4" });
		formName.atendimento.focus();
		return (false);
	} else{
		$("#atendimento").css({ "border-color":"#d4d4d4" });
	}

	// Senha
	if (formName.senha.value == ""){
		$("#senha").css({ "border-color" : "#cd150c" });//		
		formName.senha.focus();
		return (false);
	} else{
		$("#senha").css({ "border-color" : "#d4d4d4" });
	}
}