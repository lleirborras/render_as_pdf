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
	include(dirname(__FILE__).'/res/exemple10.php');
	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
	$html2pdf = new HTML2PDF('P','A4','fr');
	$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('exemple10.pdf');
