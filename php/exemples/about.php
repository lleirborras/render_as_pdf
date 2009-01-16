<?php
/**
 * Logiciel : exemple d'utilisation de HTML2PDF
 * 
 * Convertisseur HTML => PDF, utilise fpdf de Olivier PLATHEY 
 * Distribué sous la licence GPL. 
 *
 * @author		Laurent MINGUET <webmaster@spipu.net>
 */
	require_once(dirname(__FILE__).'/../html2pdf.class.php');

 	ob_start();
 	include(dirname('__FILE__').'/res/about.php');
	$content = ob_get_clean();

	$html2pdf = new HTML2PDF('P','A4','fr', array(0, 0, 0, 0));
	$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('about.pdf');
