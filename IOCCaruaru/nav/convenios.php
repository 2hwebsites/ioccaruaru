<div id="page">
	<h1 class="legenda-page">Convênios</h1>

    <div id="convenios">
    	<div id="amil" class="img_convenio">
            <a href="https://www.amil.com.br/portal/web/institucional" target="_blank">
                <img src="img/convenios/logo-amil.jpg" alt="" />
            </a>
        </div>
        <div id="bradesco" class="img_convenio">
            <a href="http://www.bradescoseguros.com.br/wps/portal/TransforDigital/Site/Produtos/Saude/" target="_blank">
                <img src="img/convenios/logo-bradesco.jpg" alt="" />
            </a>
        </div>
        <div id="capesesp" class="img_convenio">
        	<a href="http://www.capesesp.com.br/" target="_blank"><img src="img/convenios/logo-capesesp.jpg" alt="" /></a>
        </div>
        <div id="cassi" class="img_convenio">
            <a href="http://www.cassi.com.br/index.php?option=com_content&view=category&layout=blog&id=118&Itemid=101&uf=PE" 
                target="_blank">
                <img src="img/convenios/logo-cassi.jpg" alt="" />
            </a>
        </div>
        <div id="geap" class="img_convenio">
        	<a href="http://www.geap.com.br/" target="_blank"><img src="img/convenios/logo-geap.jpg" alt="" /></a>
        </div>
        <div id="medial" class="img_convenio">
        	<a href="https://www.amil.com.br/portal/web/institucional" target="_blank">
            	<img src="img/convenios/logo-medial.jpg" alt="" />
            </a>
        </div>
        <div id="caixa" class="img_convenio">
        	<a href="https://saude.caixa.gov.br/PortalServicosPRD/Home/" target="_blank">
            	<img src="img/convenios/logo-saude-caixa.jpg" alt="" />
            </a>
        </div>
        <div id="sulamerica" class="img_convenio">
            <a href="https://portal.sulamericaseguros.com.br/main.jsp?lumPageId=8A6213A75416009A01541627B84A2220" target="_blank">
                <img src="img/convenios/logo-sulamerica.jpg" alt="" />
            </a>
        </div>
        <div id="unimed" class="img_convenio">
 	       	<a href="http://www.unimed.coop.br/pct/index.jsp?cd_canal=49146" target="_blank">
           		<img src="img/convenios/logo-unimed.jpg" alt="" />
           	</a>
        </div>
    </div>
    
    <div id="parceiros">
    	<h1 class="parceiros">Outros Parceiros</h1>
        
        <table>
        	<tr>
            	<td>AMPLA</td>
                <td>APCEF SAÚDE</td>
            </tr>
            <tr>
            	<td>ARAÚJO</td>
                <td>ASSISTENCIAL ASJ SÃO JORGE</td>
            </tr>
            <tr>
            	<td>ASSOC. DOS MORADORES DA BOA VISTA I-II</td>
                <td>BETH-SHALOM</td>
            </tr>
            
            <tr>
            	<td>BLUEMED</td>
                <td>BOA FÉ</td>
            </tr>
            <tr>
            	<td>C.I.D.</td>
                <td>CARD FÁCIL SAÚDE</td>
            </tr>
            <tr>
            	<td>CARMED SAÚDE</td>
                <td>CRISTO REDENTOR</td>
            </tr>
            <tr>
            	<td>EXPOMED</td>
                <td>INTERCLÍNICAS</td>
            </tr>
            
            <tr>
            	<td>MED SAÚDE CENTER</td>
                <td>NORDESTE SAÚDE</td>
            </tr>
            <tr>
            	<td>OAB</td>
                <td>ODONTO INTERMÉDIO</td>
            </tr>
            <tr>
            	<td>PAFC</td>
                <td>PASC</td>
            </tr>
            <tr>
            	<td>PLAN</td>
                <td>PLANFAB</td>
            </tr>
            <tr>
            	<td>PLANO DE ASSISTÊNCIA ROSAL - PAR</td>
                <td>PLASF</td>
            </tr>
            <tr>
            	<td>PLANO DE ASSISTÊNCIA FAMILIAR TEIXEIRA</td>
                <td>PLASVIDE</td>
            </tr>
            <tr>
            	<td>PLASVIDE AGRESTINA</td>
                <td>POLÍCIA CIVIL</td>
            </tr>
            <tr>
            	<td>PROSMED</td>
                <td>SANTA TEREZINHA</td>
            </tr>
            <tr>
            	<td>SÃO MARCOS</td>
                <td>SEMED</td>
            </tr>
            <tr>
            	<td>SINDECC</td>
                <td>SYSTEM SAÚDE</td>
            </tr>
            <tr>
            	<td>UNICARD SAÚDE</td>
                <td>VC CARD SAÚDE</td>
            </tr>
        </table>
    </div>
</div>
    

<?php 
	include "sidebars/sidebar.php";
	$chamada = 'page-sidebar';
	
	for($i = 1; $i <= 3; $i++){
		$categoria = $i;
		include "scripts/posts.php";
	}
?>