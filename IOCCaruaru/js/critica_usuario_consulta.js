<!-- Critica o formulário de conteúdo. -->
function Critica_Usuario(formName){
	// Nome
	if (formName.nome.value == ""){
		$("#nome").css({ "border-color" : "#cd150c" });
		$("#dtNasc").css({ "border-color" : "#d4d4d4" });
		$("#telefone").css({ "border-color" : "#d4d4d4" });
		$("#celular").css({ "border-color" : "#d4d4d4" });
		$("#convenio").css({ "border-color" : "#d4d4d4" });
		$("#medico").css({ "border-color" : "#d4d4d4" });
		formName.nome.focus();
		return (false);
	} else{
		$("#nome").css({ "border-color" : "#d4d4d4" });
	}
	
	
	// Data de Nascimento
	if (formName.dtNasc.value == "" || !ValidaData(formName.dtNasc.value)){
		$("#dtNasc").css({ "border-color" : "#cd150c" });
		$("#telefone").css({ "border-color" : "#d4d4d4" });
		$("#celular").css({ "border-color" : "#d4d4d4" });
		$("#convenio").css({ "border-color" : "#d4d4d4" });
		$("#medico").css({ "border-color" : "#d4d4d4" });
		formName.dtNasc.focus();
		return (false);
	} else{
		$("#dtNasc").css({ "border-color" : "#d4d4d4" });
	}
	
	// Telefone
	if (formName.telefone.value == "" || formName.telefone.value.length < 14){
		$("#telefone").css({ "border-color" : "#cd150c" });
		$("#celular").css({ "border-color" : "#d4d4d4" });
		$("#convenio").css({ "border-color" : "#d4d4d4" });
		$("#medico").css({ "border-color" : "#d4d4d4" });
		formName.telefone.focus();
		return (false);
	} else{
		$("#telefone").css({ "border-color" : "#d4d4d4" });
	}
	
	// Celular
	if (formName.celular.value == "" || formName.celular.value.length < 15){
		$("#celular").css({ "border-color" : "#cd150c" });
		$("#convenio").css({ "border-color" : "#d4d4d4" });
		$("#medico").css({ "border-color" : "#d4d4d4" });
		formName.celular.focus();
		return (false);
	} else{
		$("#celular").css({ "border-color" : "#d4d4d4" });
	}
	
	// Convênio
	if (formName.convenio.value == "selecione"){
		$("#convenio").css({ "border-color" : "#cd150c" });
		$("#medico").css({ "border-color" : "#d4d4d4" });
		formName.convenio.focus();
		return (false);
	} else{
		$("#convenio").css({ "border-color" : "#d4d4d4" });
	}
	
	// Médico
	if (formName.medico.value == "0"){
		$("#medico").css({ "border-color" : "#cd150c" });
		formName.medico.focus();
		return (false);
	} else{
		$("#medico").css({ "border-color" : "#d4d4d4" });
	}
	
	return (true);
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