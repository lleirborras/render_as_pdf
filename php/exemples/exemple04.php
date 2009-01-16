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
<page style="font-size: 16px">
	Vous pouvez choisir l'orientation de votre document, en utilisant ceci :<br>
	<br>
	&lt;page orientation="portrait" &gt; <i>code de la page</i> &lt;/page&gt; : mode portrait<br>
	<br>
	&lt;page orientation="paysage" &gt; <i>code de la page</i> &lt;/page&gt; : mode paysage<br>
	<br>
	En voici un petit exemple !
</page>
<page orientation="paysage" style="font-size: 18px">
	Ceci est une page en paysage<br>
	<table style="width: 100%; border: solid 1px #FFFFFF;">
		<tr>
			<td style="width: 30%; border: solid 1px #FF0000;">AAA</td>
			<td style="width: 40%; border: solid 1px #00FF00;">BBB</td>
			<td style="width: 30%; border: solid 1px #0000FF;">CCC</td>
		</tr>
		<tr>
			<td style="width: 30%; border: solid 1px #FF0000;">AAA</td>
			<td style="width: 40%; border: solid 1px #00FF00;">BBB</td>
			<td style="width: 30%; border: solid 1px #0000FF;">CCC</td>
		</tr>
		<tr>
			<td style="width: 30%; border: solid 1px #FF0000;">AAA</td>
			<td style="width: 40%; border: solid 1px #00FF00;">BBB</td>
			<td style="width: 30%; border: solid 1px #0000FF;">CCC</td>
		</tr>
	</table>
</page>
<page orientation="portrait" style="font-size: 18px">
	Ceci est une page en portrait<br>
	<table style="width: 100%; border: solid 1px #FFFFFF;">
		<tr>
			<td style="width: 30%; border: solid 1px #FF0000;">AAA</td>
			<td style="width: 40%; border: solid 1px #00FF00;">BBB</td>
			<td style="width: 30%; border: solid 1px #0000FF;">CCC</td>
		</tr>
		<tr>
			<td style="width: 30%; border: solid 1px #FF0000;">AAA</td>
			<td style="width: 40%; border: solid 1px #00FF00;">BBB</td>
			<td style="width: 30%; border: solid 1px #0000FF;">CCC</td>
		</tr>
		<tr>
			<td style="width: 30%; border: solid 1px #FF0000;">AAA</td>
			<td style="width: 40%; border: solid 1px #00FF00;">BBB</td>
			<td style="width: 30%; border: solid 1px #0000FF;">CCC</td>
		</tr>
	</table>
</page>
<?php
	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
	$html2pdf = new HTML2PDF('P','A4', 'fr');
	$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('exemple04.pdf');
