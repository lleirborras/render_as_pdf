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
<span style="font-size: 20px; font-weight: bold">Démonstration des retour à la ligne automatique, ainsi que des sauts de page automatique<br></span>
<br>
<br>
<table style="width: 100%;border: solid 1px #5544DD;">
<?php for($k=0; $k<100; $k++) { ?>
	<tr>
		<td style="width: 100%; text-align: left; border: solid 1px #55DD44;">
			test de texte assez long pour engendrer des retours à la ligne automatique...
		</td>
	</tr>
<?php } ?>
</table>
<?php
	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
	$html2pdf = new HTML2PDF('P','A4', 'fr');
	$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('exemple05.pdf');
