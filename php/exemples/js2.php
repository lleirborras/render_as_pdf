<?php
/**
 * Logiciel : exemple d'utilisation de HTML2PDF
 * 
 * Convertisseur HTML => PDF, utilise fpdf de Olivier PLATHEY 
 * Distribu� sous la licence LGPL. 
 *
 * @author		Laurent MINGUET <webmaster@spipu.net>
 * 
 *  IncludeJS : permet d'inclure du Javascript au format PDF
 * 
 * isset($_GET['vuehtml']) n'est pas obligatoire
 * il permet juste d'afficher le r�sultat au format HTML
 * si le param�tre 'vuehtml' est pass� en param�tre _GET
 */
 	ob_start();
?>
<page>
	<h1>Test de JavaScript 2</h1><br>
	<br>
	Normalement une alerte devrait apparaitre, indiquant "coucou"
</page>
<?php
	$content = ob_get_clean();
	
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
	$html2pdf = new HTML2PDF('P','A4','fr');
	$html2pdf->pdf->IncludeJS("app.alert('coucou');");
	$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('js2.pdf');
