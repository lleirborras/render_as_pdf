<?php
/**
 * Logiciel : exemple d'utilisation de HTML2PDF
 * 
 * Convertisseur HTML => PDF, utilise fpdf de Olivier PLATHEY 
 * Distribu� sous la licence LGPL. 
 *
 * @author		Laurent MINGUET <webmaster@spipu.net>
 * 
 * SetDisplayMode : permet de choisir le mode d'affichage par defaut
 * SetProtection : permet de proteger le document � l'ouverture avec un mot de passe, et de ne donner que certains droits d'action
 * 
 * isset($_GET['vuehtml']) n'est pas obligatoire
 * il permet juste d'afficher le r�sultat au format HTML
 * si le param�tre 'vuehtml' est pass� en param�tre _GET
 */
 	// r�cup�ration du contenu HTML
	ob_start();
 	include(dirname(__FILE__).'/res/exemple07a.php');
 	include(dirname(__FILE__).'/res/exemple07b.php');
	$content = ob_get_clean();

	// conversion HTML => PDF
	require_once(dirname(__FILE__).'/../html2pdf.class.php');

	$html2pdf = new HTML2PDF('P', 'A4', 'fr');
	$html2pdf->pdf->SetDisplayMode('fullpage');
//	$html2pdf->pdf->SetProtection(array('print'), 'spipu');
	$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('exemple07.pdf');

