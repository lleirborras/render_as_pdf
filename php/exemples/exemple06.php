<?php
/**
 * Logiciel : exemple d'utilisation de HTML2PDF
 * 
 * Convertisseur HTML => PDF, utilise fpdf de Olivier PLATHEY 
 * Distribué sous la licence GPL. 
 *
 * @author		Laurent MINGUET <webmaster@spipu.net>
 */
 	ob_start();
?>
<link type="text/css" href="./res/exemple06.css" rel="stylesheet" >
<style type="text/css">
<!--
table, td	{ border: solid 1px #000000; color: #0000AA; }
td.col1		{ color: #00AA00; }

table.liste				{ border: solid 2px #FF0000; }
table.liste td			{ background: #DDDDDD; }
table.liste td.col1	{ color: #FF0000; }
-->
</style>
<table>
	<tr>
		<td>Ceci est un</td>
		<td class="col1">test de style</td>
	</tr>
</table>
<br>
<table class="liste">
	<tr>
		<td>Ceci est un</td>
		<td class="col1">test de style</td>
	</tr>
</table>
<br>
<H1>Essai de titre en H1</H1>
<H2>Essai de titre en H2</H2>
<H3>Essai de titre en H3</H3>
<H4>Essai de titre en H4</H4>
<H5>Essai de titre en H5</H5>
<H6>Essai de titre en H6</H6>
<H6 class="titre">Essai de titre en H6</H6>
<H5 class="titre">Essai de titre en H5</H5>
<H4 class="titre">Essai de titre en H4</H4>
<H3 class="titre">Essai de titre en H3</H3>
<H2 class="titre">Essai de titre en H2</H2>
<H1 class="titre">Essai de titre en H1</H1>
<br>
<s>Texte barré !</s><br>
<br>
<span>Texte avec la couleur par défault (style *)</span><br>
<?php
	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
	$html2pdf = new HTML2PDF('P','A4', 'fr');
	$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('exemple06.pdf');
