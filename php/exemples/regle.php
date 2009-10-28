<?php
/**
 * Logiciel : exemple d'utilisation de HTML2PDF
 * 
 * Convertisseur HTML => PDF, utilise fpdf de Olivier PLATHEY 
 * Distribu� sous la licence LGPL. 
 *
 * @author		Laurent MINGUET <webmaster@spipu.net>
 * 
 * isset($_GET['vuehtml']) n'est pas obligatoire
 * il permet juste d'afficher le r�sultat au format HTML
 * si le param�tre 'vuehtml' est pass� en param�tre _GET
 */
 	// r�cup�ration du contenu HTML
 	ob_start();
?>
<style type="text/css">
<!--
	table
	{
		padding: 0;
		margin: 0;
		border: none;
		border-right: solid 0.2mm black;
	}
	td
	{
		padding: 0;
		margin: 0;
		border: none;
	}
	
	img
	{
		width: 10mm;
	}
-->
</style>
<page>
<table cellpadding="0" cellspacing="0"><tr>
<?php for($k=0; $k<28; $k++) echo '<td><img src="./res/regle.png" alt="" ><br>'.$k.'</td>'; ?>
</tr></table>
</page>
<?php
 	$content = ob_get_clean();
	
	// conversion HTML => PDF
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
	$html2pdf = new HTML2PDF('L','A4','fr', array(10, 10, 10, 10));
	$html2pdf->pdf->SetDisplayMode('fullpage');
	$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('regle.pdf');
