<?php
/**
 * Logiciel : test de charge de HTML2PDF
 * 
 * Convertisseur HTML => PDF, utilise fpdf de Olivier PLATHEY 
 * Distribué sous la licence GPL. 
 *
 * @author		Laurent MINGUET <webmaster@spipu.net>
 * 
 * ce script permet de faire un test de charge sur la génération d'un PDF
 */
 	// chargement de la classe
	require_once(dirname(__FILE__).'/../html2pdf.class.php');

	// chargement de l'html
 	ob_start();
 		// ###DEBUT### mettez ici le code HTML à tester
 		for($k=0; $k<500; $k++)
 			echo ' ceci est du texte <b>ceci est du texte</b> <i>ceci est du texte</i> <u>ceci est du texte</u> <b><i><u>ceci est du texte</u></i></b>';
 		// ###FIN###
	$content = ob_get_clean();

	// taille de l'HTML
	echo 'Taille : '.strlen($content).'<br>';
	
	// initialisation du debug
	echo HTML2PDFgetTimerDebug();
	$total_t = 0;
	$total_m = 0;
	$nb = 2;
	
	// boucle de test
	for($k=0; $k<$nb; $k++)
	{
		// temps autorisé par boucle
		set_time_limit(60);
		
		// création du PDF
		$html2pdf = new HTML2PDF('P','A4','fr', array(0, 0, 0, 0));
		$html2pdf->WriteHTML($content);
		
		// affichage du debug
		$res = HTML2PDFgetTimerDebug(true);
		echo 'Timer : '.number_format($res[0], 3, '.', '').'s - Memory used '.$res[1].' Ko'."<br />\n";
		$total_t+= $res[0];
		$total_m+= $res[1];
		
		// nettoyage
		unset($html2pdf);
		$HTML2PDF_TABLEAU = array();
	}
	echo '<hr>';
	echo 'TOTAL : Timer : '.number_format($total_t, 3, '.', '').'s - Memory used '.$total_m.' Ko'."<br />\n";
	echo 'MOYENNE : Timer : '.number_format($total_t/$nb, 3, '.', '').'s - Memory used '.($total_m/$nb).' Ko'."<br />\n";
	