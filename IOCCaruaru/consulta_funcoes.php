<?php
	function selecionarConvenios(){
		$convenios = array();
		
		include "connections/connMSS.php";
		
		$QYconvenios = sqlsrv_query($connMSS, "SELECT codconvenio, descr
												FROM cadconvenio
											   WHERE grupoemp IN ('01','99') 
												 AND filial IN ('01','99')
												 AND (tabref IS NULL OR tabref <> 'S')
												 AND (suspenso IS NULL OR suspenso <> 'S')
												 AND modofat IN ('P','C')
												 AND codconvenio NOT IN ('014', '018', '019', '025', '026', '027', '024', '022', '008', '002') 
											ORDER BY descr");
		if($QYconvenios === false){
			die( print_r( sqlsrv_errors(), true));
		}
		
		if(sqlsrv_has_rows($QYconvenios)){
			$cont = 0;
			
			while($res_convenios = sqlsrv_fetch_array($QYconvenios)){
				$convenios['codconvenio'][$cont] = $res_convenios['codconvenio'];
				$convenios['descr'][$cont] = $res_convenios['descr'];
				$cont++;
			}
			
			$_SESSION['indice'] = ($cont - 1);
		}

		sqlsrv_close($connMSS);
		
		$_SESSION['selConv'] = "S";

		return $convenios;
	}
	
	function selecionarMedicos(){
		$medicos = array();
		
		include "connections/connMSS.php";

		$QYmedicos = sqlsrv_query($connMSS, "SELECT codmedico, nome, sexo
											FROM cadmedico
										   WHERE grupoemp IN ('01','99') 
											 AND filial IN ('01','99')
											 AND agenda = 'S'
											 AND ambesp = '101'
											 AND condicao NOT IN ('D','C')
										   ORDER BY nome");
		if($QYmedicos === false){
			die( print_r( sqlsrv_errors(), true));
		}

		if(sqlsrv_has_rows($QYmedicos)){
			$cont = 0;
			
			while($res_medicos = sqlsrv_fetch_array($QYmedicos)){
				$medicos['codmedico'][$cont] = $res_medicos['codmedico'];
				$medicos['sexo'][$cont] = $res_medicos['sexo'];
				
				if($res_medicos['codmedico'] == '001'){
					$medicos['nome'][$cont] = "João Caldas - Matriz";
				} elseif($res_medicos['codmedico'] == '004'){
					$medicos['nome'][$cont] = "João Caldas - Difusora";
				} elseif($res_medicos['codmedico'] == '002'){
					$medicos['nome'][$cont] = "Nadja Caldas - Matriz";
				} elseif($res_medicos['codmedico'] == '330'){
					$medicos['nome'][$cont] = "Nadja Caldas - Difusora";
				} elseif($res_medicos['codmedico'] == '091'){
					$medicos['nome'][$cont] = "Nayra Caldas - Matriz";
				} elseif($res_medicos['codmedico'] == '329'){
					$medicos['nome'][$cont] = "Nayra Caldas - Difusora";
				} elseif($res_medicos['codmedico'] == '003'){
					$medicos['nome'][$cont] = "Paulo Limeira - Matriz";
				} else{
					$medicos['nome'][$cont] = $res_medicos['nome'];
				}
				
				$cont++;
			}
			
			$_SESSION['indice'] = ($cont - 1);
		}
		
		sqlsrv_close($connMSS);
		
		return $medicos;
	}
	
	function obterAgendaMSSQL(){
		include "connections/connMSS.php";
		
		$restricao = sqlsrv_query($connMSS, "SELECT data1, data2 FROM restringeag WHERE codmedico IN 	
									('".$_SESSION['codMedico']."', 'TTT') AND data2 >= GETDATE() AND trava = 'S'");

		if($restricao === false){
			echo "<div id='mensagemErro'>";
			echo "<h1 class='tituloErro'>Erro ao tentar obter as restrições da agenda.</h1>";
			echo "<h2 class='subtituloErro'>Feche a aba e tente novamente. Caso o erro persista, entre em contato com o IOC e informe o problema. </h2>";
			
			if( ($errors = sqlsrv_errors() ) != null) {
				foreach( $errors as $error ) {
					echo "<p class='msgErro msgErroTit'>Detalhes do erro</p>";
					echo "<p class='msgErro'>Estado SQL: ".$error[ 'SQLSTATE']."</p>";
					echo "<p class='msgErro'>Código do Erro: ".$error[ 'code']."</p>";
					echo "<p class='msgErro'>Mensagem: ".utf8_encode($error[ 'message'])."</p>";
				}
			}
			
			echo "<div>";
			
			sqlsrv_close($connMSS);
			return false;
		}
		
		$query = "SELECT datahora FROM agenda WHERE codmedico = '".$_SESSION['codMedico']."' AND datahora >= GETDATE() AND
					(nome IS NULL OR DATALENGTH(nome) = 0) AND (codconvenio IS NULL OR DATALENGTH(codconvenio) = 0) 
					AND (datanasc2 IS NULL OR DATALENGTH(DataNasc2) = 0) AND tipo = 'CONSULTA'";

		
		if(sqlsrv_has_rows($restricao)){
			$restInicial = "";
			$restFinal = "";
				
			while($res_restricao = sqlsrv_fetch_array($restricao)){
				$restInicial = substr(str_replace(" ","T", date_format($res_restricao['data1'], "Y-m-d H:i:s.u")), 0, -3);
				$restFinal = substr(str_replace(" ", "T", date_format($res_restricao['data2'], "Y-m-d H:i:s.u")), 0, -3);
				$query = $query." AND (datahora < CONVERT(DATETIME, '".$restInicial."', 126) 
									OR datahora > CONVERT(DATETIME, '".$restFinal."', 126))";
			}
		}
		
		$horarios = sqlsrv_query($connMSS, $query);
		if($horarios === false){
			echo "<div id='mensagemErro'>";
			echo "<h1 class='tituloErro'>Erro ao tentar obter os horários da agenda.</h1>";
			echo "<h2 class='subtituloErro'>Feche a aba e tente novamente. Caso o erro persista, entre em contato com o IOC e informe o problema. </h2>";
			
			if( ($errors = sqlsrv_errors() ) != null) {
				foreach( $errors as $error ) {
					echo "<p class='msgErro msgErroTit'>Detalhes do erro</p>";
					echo "<p class='msgErro'>Estado SQL: ".$error[ 'SQLSTATE']."</p>";
					echo "<p class='msgErro'>Código do Erro: ".$error[ 'code']."</p>";
					echo "<p class='msgErro'>Mensagem: ".utf8_encode($error[ 'message'])."</p>";
				}
			}
			
			echo "<div>";
			
			sqlsrv_close($connMSS);
			return false;
		}
			
		if(!sqlsrv_has_rows($horarios)){
			echo "<div id='mensagemErro'>";
			echo "<h1 class='tituloErro'>Não há horários disponíveis para esse médico.</h1>";
			echo "<h2 class='subtituloErro'>Clique em <strong>Voltar para escolher outro médico.</strong></h2>";
			echo "<div id='botoesErro'>
                    <form method='post' action='' name='frmBotoes' id='frmBotoes' enctype='multipart/form-data'>
                        <input type='submit' id='btnVoltar' name='btnVoltar' value='Voltar' class='designBotao' />
						<input type='hidden' id='btnOutroMedico' name='btnOutroMedico' value='OutroMedico' />
                    </form>
                </div>";
			echo "<div>";
			echo "</div>";
			include "footer_sistemas.php";
			
			sqlsrv_close($connMSS);
			exit;
		} else{
			$dias = array();
			$cont = 0;

			include "connections/conn.php";
				
			$query = "DELETE FROM ioc_horarios WHERE usuario_id = '".$_SESSION['usuario']."' 
						AND medico_id = '".$_SESSION['codMedico']."'";
			if(!mysqli_query($conn, $query)){
				echo "<div id='mensagemErro'>";
				echo "<h1 class='tituloErro'>Erro ao tentar obter os horários da agenda.</h1>";
				echo "<h2 class='subtituloErro'>
						Feche a aba e tente novamente. Caso o erro persista, entre em contato com o IOC e informe o problema.
					  </h2>";
				echo "<p class='msgErro msgErroTit'>Detalhes do erro</p>";
				echo "<p class='msgErro'>Mensagem: ".mysqli_error($conn)."</p>";
				echo "<div>";
				
				sqlsrv_close($connMSS);
				mysqli_close($conn);
				return false;
			}

			while($res_horarios = sqlsrv_fetch_array($horarios)){
				$dia = date_format($res_horarios[0], "Y/m/j");
				$hora = date_format($res_horarios[0], "H:i");

				$query = "INSERT INTO ioc_horarios(usuario_id, medico_id, dia, hora, data_cadastro) 
							VALUES('".$_SESSION['usuario']."', '".$_SESSION['codMedico']."','".$dia."','".$hora."', current_timestamp)";

				if(!mysqli_query($conn, $query)){
					echo "<div id='mensagemErro'>";
					echo "<h1 class='tituloErro'>Erro ao tentar inserir os horários.</h1>";
					echo "<h2 class='subtituloErro'>
							Feche a aba e tente novamente. Caso o erro persista, entre em contato com o IOC e informe o problema.
						  </h2>";
					echo "<p class='msgErro msgErroTit'>Detalhes do erro</p>";
					echo "<p class='msgErro'>Mensagem: ".mysqli_error($conn)."</p>";
					echo "<div>";
					
					sqlsrv_close($connMSS);
					mysqli_close($conn);
					return false;
				}
			}

				mysqli_close($conn);
		} 
		sqlsrv_close($connMSS);
		
		return true;
	}
	
	function obterAgendaMySQL($modificadorMes, $chamada){
		include "connections/conn.php";
		
		$query = "SELECT DISTINCT dia FROM ioc_horarios WHERE usuario_id = '".$_SESSION['usuario']."' 
					AND medico_id = '".$_SESSION['codMedico']."' ORDER BY dia";
		if(!($dias = mysqli_query($conn, $query))){
			echo "<div id='mensagemErro'>";
			echo "<h1 class='tituloErro'>Erro ao tentar obter os horários</h1>";
			echo "<h2 class='subtituloErro'>
					Feche a aba e tente novamente. Caso o erro persista, entre em contato com o IOC e informe o problema.
				  </h2>";
			echo "<p class='msgErro msgErroTit'>Detalhes do erro</p>";
			echo "<p class='msgErro'>Mensagem: ".mysqli_error($conn)."</p>";
			echo "<div>";
			
			mysqli_close($conn);
			return false;
		}

		if(@mysqli_num_rows($dias) == '0'){
			echo "<div id='mensagemErro'>";
			echo "<h1 class='tituloErro'>Erro ao tentar obter os horários</h1>";
			echo "<h2 class='subtituloErro'>
					Feche a aba e tente novamente. Caso o erro persista, entre em contato com o IOC e informe o problema.
				  </h2>";
			echo "<p class='msgErro msgErroTit'>Detalhes do erro</p>";
			echo "<p class='msgErro'>Mensagem: Não foram encontrados registros na tabela.</p>";
			echo "<div>";
			
			mysqli_close($conn);
			return false;
		}else{
			$datas = array();
			$cont = 0;
			$pegouMes = 0;
			$_SESSION['mesMaior'] = "N";
			$_SESSION['mesMenor'] = "N";
			
			while($res_dias = mysqli_fetch_array($dias)){
				if(!$pegouMes){
					if($modificadorMes == 0){
						if(!isset($_SESSION['mesAnoBase']) || empty($_SESSION['mesAnoBase'])){
							$_SESSION['mesAnoBase'] = substr($res_dias[0], 5, 2)."/".substr($res_dias[0], 0, 4);
							$pegouMes = 1;
						}
					} else{
						if($_SESSION['mesAnoBase'] == substr($res_dias[0], 5, 2)."/".substr($res_dias[0], 0, 4)){
							continue;
						} else{
							if($modificadorMes > 0){
								if(substr($_SESSION['mesAnoBase'], 3, 4).substr($_SESSION['mesAnoBase'], 0, 2) < substr($res_dias[0], 0, 4).substr($res_dias[0], 5, 2)){
									$_SESSION['mesAnoBase'] = substr($res_dias[0], 5, 2)."/".substr($res_dias[0], 0, 4);
									$pegouMes = 1;
									$_SESSION['mesMenor'] = "S";
								}
							} else{
								if(substr($_SESSION['mesAnoBase'], 3, 4).substr($_SESSION['mesAnoBase'], 0, 2) > substr($res_dias[0], 0, 4).substr($res_dias[0], 5, 2)){
									$_SESSION['mesAnoBase'] = substr($res_dias[0], 5, 2)."/".substr($res_dias[0], 0, 4);
									$pegouMes = 1;
									$_SESSION['mesMaior'] = "S";
								}
							}
						}
					}
				}
				
				if($_SESSION['mesAnoBase'] == substr($res_dias[0], 5, 2)."/".substr($res_dias[0], 0, 4)){
					$datas[$cont] = substr($res_dias[0], 8, 2);
					$cont++;
				} else{
					if(substr($_SESSION['mesAnoBase'], 3, 4) == substr($res_dias[0], 0, 4)){
						if(substr($_SESSION['mesAnoBase'], 0, 2) < substr($res_dias[0], 5, 2)){
							$_SESSION['mesMaior'] = "S";
						} else{
							$_SESSION['mesMenor'] = "S";
						}
					} else{
						if(substr($_SESSION['mesAnoBase'], 3, 4) < substr($res_dias[0], 0, 4)){
							$_SESSION['mesMaior'] = "S";
						} else{
							$_SESSION['mesMenor'] = "S";
						}
					}
				}
			}
			mysqli_close($conn);
		}
		
		montaCalendario($datas, $chamada);
		
		return true;
	}
	
	function descricaoMes($mes){
		switch ($mes){
			case 1:
				return "Janeiro";
			case 2:
				return "Fevereiro";				
			case 3:
				return "Março";
			case 4:
				return "Abril";
			case 5:
				return "Maio";
			case 6:
				return "Junho";
			case 7:
				return "Julho";
			case 8:
				return "Agosto";
			case 9:
				return "Setembro";
			case 10:
				return "Outubro";
			case 11:
				return "Novembro";
			case 12:
				return "Dezembro";
		}
	}
	
	function ultimoDiaMes($mes, $ano){
		switch ($mes){
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
			case 12:
				return 31;
			case 2:
				if($ano % 4 == 0){
					return 29;
				} else{
					return 28;
				}
			case 4:
			case 6:
			case 9:
			case 11:
				return 30;
		}
	}
	
	function montaCalendario($datas, $chamada){
		$primeiroDiaMes = date("w", strtotime(substr($_SESSION['mesAnoBase'], 0, 2)."/1/".substr($_SESSION['mesAnoBase'], 3, 4)));
		$descricaoMes = descricaoMes(substr($_SESSION['mesAnoBase'], 0, 2));
		$ultimoDiaMes = ultimoDiaMes(substr($_SESSION['mesAnoBase'], 0, 2), substr($_SESSION['mesAnoBase'], 3, 4));
		$semanasMes = ceil(($ultimoDiaMes + $primeiroDiaMes) / 7);
		
		$medicosHomens = array(0 => "001", 1 => "004", 2 => "003");
		
		$masculino = ((in_array($_SESSION['codMedico'], $medicosHomens)) ? 1 : 0);
		
		if(isset($_SESSION['dataMarcacao'])){
			$dataMarcacao = substr($_SESSION['dataMarcacao'], 0, (strlen($_SESSION['dataMarcacao']) == 9 ? 1 : 2));
		} else{
			$dataMarcacao = "";
		}
		
		echo "<div id='Calendario'>
             	<p>Clique nos dias em <span class='verde'>verde</span> para visualizar os horários.</p>
             	<p><strong class='nomeMedico'>Médic".($masculino ? "o: " : "a: ").$_SESSION['nomeMedico']."</strong></p>
			 
			 	<form method='post' action='' name='frmCalendario' id='frmCalendario' enctype='multipart/form-data'>
					<input type='text' id='txhModificadorMes' name='txhModificadorMes' hidden='hidden' />
					<input type='text' id='txhChamada' name='txhChamada' hidden='hidden' />

                    <table id='tblCalendario'>
                    	<tr class='legenda_calendario'>
                       		<td>
                    	        <input class='btnSeta' type='submit' name='btnSetaEsq' id='btnSetaEsq' value='&laquo;'".
									(($_SESSION['mesMenor'] == "N") ? " disabled='disabled'" : "")."
									onclick=".'"'."SetaHiddens(-1, '"."Calendario"."')".'"'." />
                            </td>
							<td colspan='3'>".$descricaoMes."</td>
							<td colspan='2'>".substr($_SESSION['mesAnoBase'], 3, 4)."</td>
                            <td>
								<input class='btnSeta' type='submit' name='btnSetaDir' id='btnSetaDir' value='&raquo;'".
									(($_SESSION['mesMaior'] == "N") ? " disabled='disabled'" : "")." 
									onclick=".'"'."SetaHiddens(1, '"."Calendario"."')".'"'." />
							</td>
                        </tr>
                        <tr class='legenda_calendario'>
                        	<td>DOM</td>
                            <td>SEG</td>
                            <td>TER</td>
                            <td>QUA</td>
                            <td>QUI</td>
                            <td>SEX</td>
                            <td>SAB</td>
                        </tr>";
		$cont = 1;

		for($i = 0; $i < $semanasMes; $i++){
			if($i == 0){
				$semana1 = 1;
			} else{
				$semana1 = 0;
			}	
			
			echo "<tr>";
			
			for($j= 0; $j < 7; $j++){
				if(($semana1 && $j < $primeiroDiaMes) || (!$semana1 && $cont > $ultimoDiaMes)){
					echo "<td class='sem_data'></td>";
				} else{
					if(in_array($cont, $datas)){
						echo "<td class='dia_marcacao'>
            	             <input type='submit' id='btnDia' name='btnDia' class='btnDia".(!empty($dataMarcacao) && $dataMarcacao == $cont ? " diaMarcacao" : "")."' 
							 	value='".$cont."' onclick=".'"'."SetaHiddens(0, '"."Horarios"."')".'"'." />
                    	     </td>";
					} else{
						echo "<td>".$cont."</td>";
					}
					
					$cont++;
				}
		}
			
			echo "</tr>";
		}

		echo		"</table>
			 	</form>				
				<div id='botoes'".($chamada == "Horarios" ? " class='margemDireitaDiv'" : "").">
					<form method='post' action='' name='frmBotoes' id='frmBotoes' enctype='multipart/form-data'>".($chamada == "Horarios" ? "
						<input type='submit' id='btnMarcar' name='btnMarcar' class='designBotao flutuaDir' value='Marcar' disabled='disabled' />" : "").
						"<input type='submit' id='btnVoltar' name='btnVoltar' value='Voltar' class='designBotao flutuaDir".
							($chamada == "Horarios" ? " margemDireita" : " btnVoltarCal")."' />
						<input type='text' id='hora' name='hora' hidden='hidden' />
						<input type='text' id='turno' name='turno' hidden='hidden' />
					</form>
				</div>
				<div id='clear' style='clear:both'></div>
			 </div>";
	}
	
	function obterHorarios(){
		include "connections/conn.php";

		$tamanhoData = strlen($_SESSION['dataMarcacao']);
		$arData = explode("/", $_SESSION['dataMarcacao']);
		$diaSemana = date("w", strtotime($arData[1]."/".($tamanhoData == 9 ? "0" : "").$arData[0]."/".$arData[2]));
		$data = $arData[2]."/".$arData[1]."/".$arData[0];
		$query = "SELECT hora FROM ioc_horarios WHERE usuario_id = '".$_SESSION['usuario']."' AND medico_id = 
					'".$_SESSION['codMedico']."' AND dia = '".$data."' ORDER BY hora";
		
		if(!($horarios = mysqli_query($conn, $query))){
			echo "<div id='mensagemErroHr'>";
			echo "<h1 class='tituloErro'>Erro ao tentar obter os horários</h1>";
			echo "<h2 class='subtituloErro'>
					Feche a aba e tente novamente. Caso o erro persista, entre em contato com o IOC e informe o problema.
				  </h2>";
			echo "<p class='msgErro msgErroTit'>Detalhes do erro</p>";
			echo "<p class='msgErro'>Mensagem: ".mysqli_error($conn)."</p>";
			echo "<div>";
			
			mysqli_close($conn);
			return false;
		}

		if(@mysqli_num_rows($horarios) == '0'){
			echo "<div id='mensagemErroHr'>";
			echo "<h1 class='tituloErro'>Erro ao tentar obter os horários</h1>";
			echo "<h2 class='subtituloErro'>
					Feche a aba e tente novamente. Caso o erro persista, entre em contato com o IOC e informe o problema.
				  </h2>";
			echo "<p class='msgErro msgErroTit'>Detalhes do erro</p>";
			echo "<p class='msgErro'>Mensagem: Não foram encontrados registros na tabela.</p>";
			echo "<div>";
			
			mysqli_close($conn);
			return false;
		}

		$_SESSION['horarioManha'] = "";
		$_SESSION['horarioTarde'] = "";
		$_SESSION['horarioNoite'] = "";
		$cont = 0;

		while($res_horarios = mysqli_fetch_array($horarios)){
			$hora = $res_horarios[0];
			
			if($hora < 12){
				if(empty($_SESSION['horarioManha'])){
					$_SESSION['horarioManha'] = "Ordem de Chegada";
				}
			} elseif($hora < 18){
				if($_SESSION['codMedico'] == "001"){
					$_SESSION['horarioTarde'][$cont] = $hora;
					$cont++;
				} else{
					if(!($_SESSION['codMedico'] == "002" && $_SESSION['convenio'] <> '000' && $diaSemana == 5)){
						if(empty($_SESSION['horarioTarde'])){
							$_SESSION['horarioTarde'] = "Ordem de Chegada";
						}
					}
				}
			} else{
				if(empty($_SESSION['horarioNoite'])){
					$_SESSION['horarioNoite'] = "Ordem de Chegada";
				}
			}
		}
		
		$_SESSION['indice'] = $cont - 1;
		
		mysqli_close($conn);
		
		montaHorarios();

		return true;
	}
	
	function montaHorarios(){
		echo "<div id='horarios'>
              	<p>Horários disponíveis</p>
                
				<div id='tabelas'>
                <form method='post' action='' name='frmMedicos' id='frmMedicos' enctype='multipart/form-data'
					onSubmit='SetNomeMedico()'>";
		
		if(!empty($_SESSION['horarioManha'])){
			echo "<table id='tblManha' class='tblHorario".(!empty($_SESSION['horarioTarde']) || !empty($_SESSION['horarioNoite']) ? " tblHorMrgDir" : "")."'>
                  	<tr class='legendaHorarios'><td colspan='2'>Manhã</td></tr>
                    <tr class='legendaHorarios'><td>Sel</td><td>Horário</td></tr>
					<tr>
                    	<td class='tdSelecao'>
                        	<input name='selHorario' id='selHorario' type='radio' value='0' onclick=".'"'."HabilitaBotao(); SetarHorario('M')".'"'."' />
                        </td>
                        <td class='tdHorario'>".$_SESSION['horarioManha']."</td>
                    </tr>
				  </table>";
		}
		
		if(!empty($_SESSION['horarioTarde'])){
			echo "<table id='tblTarde' class='tblHorario".(!empty($_SESSION['horarioNoite']) ? " tblHorMrgDir" : "")."'>
					<tr class='legendaHorarios'><td colspan='2'>Tarde</td></tr>
					<tr class='legendaHorarios'><td>Sel</td><td>Horário</td></tr>";
					
			if($_SESSION['codMedico'] == "001"){
				for($i = 0; $i <= $_SESSION['indice']; $i++){
					echo "<tr>
							<td class='tdSelecao'>
								<input name='selHorario' id='selHorario' type='radio' value='".$_SESSION['horarioTarde'][$i]."' 
									onclick=".'"'."HabilitaBotao(); SetarHorario('T')".'"'."' />
							</td>
							<td class='tdHorario tdHorCheg'>".$_SESSION['horarioTarde'][$i]."</td>
						</tr>";
				}
			} else{
				echo "<tr>
						<td class='tdSelecao'>
							<input name='selHorario' id='selHorario' type='radio' value='0' onclick=".'"'."HabilitaBotao(); SetarHorario('T')".'"'."' />
						</td>
						<td class='tdHorario'>".$_SESSION['horarioTarde']."</td>
					</tr>";
			}
			
			echo "</table>";
		}
		
		if(!empty($_SESSION['horarioNoite'])){
			echo "<table id='tblNoite' class='tblHorario'>
                  	<tr class='legendaHorarios'><td colspan='2'>Noite</td></tr>
                    <tr class='legendaHorarios'><td>Sel</td><td>Horário</td></tr>
					<tr>
                    	<td class='tdSelecao'>
                        	<input name='selHorario' id='selHorario' type='radio' value='0' onclick=".'"'."HabilitaBotao(); SetarHorario('N')".'"'."' />
                        </td>
                        <td class='tdHorario'>".$_SESSION['horarioNoite']."</td>
                    </tr>
				  </table>";
		}
		
		echo "</form>
		   </div>
        </div>";	
	}

	function marcarConsulta(){
		if(strlen($_SESSION['dataMarcacao']) == 10){
			$dataMarcacao = $_SESSION['dataMarcacao'];
		} else{
			$dataMarcacao = "0".$_SESSION['dataMarcacao'];
		}
		
		$aDataMarcacao = explode("/", $dataMarcacao);
		$dataMarcacao = $aDataMarcacao[2]."/".$aDataMarcacao[1]."/".$aDataMarcacao[0];
		$telefone = substr($_SESSION['telefone'], 1, 2).substr($_SESSION['telefone'], 5, 4).substr($_SESSION['telefone'], 10, 4);
		$celular = substr($_SESSION['celular'], 1, 2).substr($_SESSION['celular'], 5, 5).substr($_SESSION['celular'], 11, 4);
		
		include "connections/connMSS.php";
		
		$query = "UPDATE agenda SET nome = '".ucwords(strtolower($_SESSION['nome']))."', codconvenio = '".$_SESSION['convenio']."', 
					descr = '".$_SESSION['convenioDesc']."', plano = '".$_SESSION['convenioDesc']."', telefone = '".$telefone."', 
					celular = '".$celular."', datanasc2 = '".$_SESSION['dtNasc']."', retorno = 'N'
					WHERE nome IS NULL AND codconvenio IS NULL AND descr IS NULL AND plano IS NULL AND telefone IS NULL AND celular IS NULL
					  AND datanasc2 IS NULL AND codmedico = '".$_SESSION['codMedico']."' AND CAST(datahora AS DATE) = '".$dataMarcacao."'";
					  
		$queryHora = "SELECT datahora FROM agenda WHERE nome IS NULL AND codconvenio IS NULL AND descr IS NULL AND plano IS NULL AND telefone IS NULL 
						AND celular IS NULL AND datanasc2 IS NULL AND codmedico = '".$_SESSION['codMedico']."' 
						AND CAST(datahora AS DATE) = '".$dataMarcacao."'";
		
		if($_SESSION['hora'] <> 0){
			$query = $query." AND CAST(datahora AS TIME) = '".$_SESSION['hora']."'";
			
			$marcacao = sqlsrv_query($connMSS, $query);
			
			if($marcacao === false){
				echo "<div id='mensagemErro'>";
				echo "<h1 class='tituloErro'>Erro ao salvar a marcação de consulta</h1>";
				echo "<h2 class='subtituloErro'>
						Feche a aba e tente novamente. Caso o erro persista, entre em contato com o IOC e informe o problema.
					  </h2>";
				
				if( ($errors = sqlsrv_errors()) != null) {
					echo "<p class='msgErro msgErroTit'>Detalhes do erro</p>";
					foreach($errors as $error) {
						echo "<p class='msgErro'>Estado SQL: ".$error[ 'SQLSTATE']."</p>";
						echo "<p class='msgErro'>Código do Erro: ".$error[ 'code']."</p>";
						echo "<p class='msgErro'>Mensagem: ".utf8_encode($error[ 'message'])."</p>";
					}
				}
				
				echo "<div>";
				
				sqlsrv_close($connMSS);
				return false;
			}
		} else{
			if($_SESSION['turno'] == "M"){
				$queryHora = $queryHora." AND CAST(datahora AS TIME) <= '12:00'";
			} elseif($_SESSION['turno'] == "T"){
				$queryHora = $queryHora." AND CAST(datahora AS TIME) > '12:00' AND CAST(datahora AS TIME) < '18:00'";
			} else{
				$queryHora = $queryHora." AND CAST(datahora AS TIME) >= '18:00'";
			}
			
			$horaDisp = sqlsrv_query($connMSS, $queryHora);
			
			if($horaDisp === false){
				echo "<div id='mensagemErro'>";
				echo "<h1 class='tituloErro'>Erro ao salvar a marcação de consulta</h1>";
				echo "<h2 class='subtituloErro'>
						Feche a aba e tente novamente. Caso o erro persista, entre em contato com o IOC e informe o problema.
					  </h2>";
				
				if( ($errors = sqlsrv_errors()) != null) {
					echo "<p class='msgErro msgErroTit'>Detalhes do erro</p>";
					foreach($errors as $error) {
						echo "<p class='msgErro'>Estado SQL: ".$error[ 'SQLSTATE']."</p>";
						echo "<p class='msgErro'>Código do Erro: ".$error[ 'code']."</p>";
						echo "<p class='msgErro'>Mensagem: ".utf8_encode($error[ 'message'])."</p>";
					}
				}
				
				echo "<div>";
				
				sqlsrv_close($connMSS);
				return false;
			}
			
			if(sqlsrv_has_rows($horaDisp)){
				$horaVaga = "1";
					
				while($res_horaDisp = sqlsrv_fetch_array($horaDisp)){
					if($horaVaga){
						$query = $query." AND CAST(datahora AS TIME) = '".$res_horaDisp['datahora']->format('H:i')."'";
						
						$marcacao = sqlsrv_query($connMSS, $query);
			
						if($marcacao === false){
							continue;
						} else{
							$horaVaga = "0";
						}
					}
				}
				
				if($horaVaga){
					echo "<div id='mensagemErro'>";
					echo "<h1 class='tituloErro'>Erro ao salvar a marcação de consulta</h1>";
					echo "<h2 class='subtituloErro'>
							Feche a aba e tente novamente. Caso o erro persista, entre em contato com o IOC e informe o problema.
						  </h2>";
					
					if( ($errors = sqlsrv_errors()) != null) {
						foreach($errors as $error) {
							echo "<p class='msgErro msgErroTit'>Detalhes do erro</p>";
							echo "<p class='msgErro'>Estado SQL: ".$error[ 'SQLSTATE']."</p>";
							echo "<p class='msgErro'>Código do Erro: ".$error[ 'code']."</p>";
							echo "<p class='msgErro'>Mensagem: ".utf8_encode($error[ 'message'])."</p>";
						}
					}
					
					echo "<div>";
					
					sqlsrv_close($connMSS);
					return false;
				}
			} else{
				echo "<div id='mensagemErro'>";
				echo "<h1 class='tituloErro'>Erro ao salvar a marcação de consulta</h1>";
				echo "<h2 class='subtituloErro'>
						Feche a aba e tente novamente. Caso o erro persista, entre em contato com o IOC e informe o problema.
					  </h2>";
				
				if( ($errors = sqlsrv_errors()) != null) {
					foreach($errors as $error) {
						echo "<p class='msgErro msgErroTit'>Detalhes do erro</p>";
						echo "<p class='msgErro'>Estado SQL: ".$error[ 'SQLSTATE']."</p>";
						echo "<p class='msgErro'>Código do Erro: ".$error[ 'code']."</p>";
						echo "<p class='msgErro'>Mensagem: ".utf8_encode($error[ 'message'])."</p>";
					}
				}
				
				echo "<div>";
				
				sqlsrv_close($connMSS);
				return false;
			}
		}
		
		sqlsrv_close($connMSS);
		
		return true;
	}
	
	function diaLiberarMarcacao(){
		include "connections/conn.php";
		
		$query = "SELECT max(datamarcacao) AS datamarcacao FROM ioc_datamarcacao WHERE codmedico = '".$_SESSION['codMedico']."'";
		
		if(!($data = mysqli_query($conn, $query))){
			echo "<div id='mensagemErro'>";
			echo "<h1 class='tituloErro'>Erro ao tentar obter calendário</h1>";
			echo "<h2 class='subtituloErro'>
					Feche a aba e tente novamente. Caso o erro persista, entre em contato com o IOC e informe o problema.
				  </h2>";
			echo "<p class='msgErro msgErroTit'>Detalhes do erro</p>";
			echo "<p class='msgErro'>Mensagem: ".mysqli_error($conn)."</p>";
			echo "<div>";
			
			mysqli_close($conn);
			return false;
		}
		
		if(@mysqli_num_rows($data) > '0'){
			$res_data = mysqli_fetch_array($data);
			
			if(date("Y-m-d") < $res_data[0]){
				echo "<div id='mensagemErro'>";
				echo "<h1 class='tituloErro'>Ainda não está liberada a marcação de consulta  para Dra. Nadja Caldas</h1>";
				echo "<h2 class='subtituloErro'>
						A data de liberação para marcação é ".date("d/m/Y", strtotime($res_data[0])).
					  "</h2>";
				echo "<div>";
				
				mysqli_close($conn);
				
				return false;
			}
		}
		
		mysqli_close($conn);
		
		return true;
	}
?>

