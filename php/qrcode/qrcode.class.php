<?php
/*
 * ATTENTION : 
 * Vous devez télécharger la librairie "QR-code generator" (sous licence LGPL)
 * a cette adresse : http://prgm.spipu.net/php_qrcode
 * et mettre tout son contenu dans ce repertoire (qrcode)
 * en remplacant également ce fichier (qrcode.class.php)
 * 
 * WARNING: 
 * You have to download the librairy "QR-code generator" (under LGPL licence)
 * at this url : http://prgm.spipu.net/php_qrcode
 * and to put all his content in this folder (qrcode)
 * and to replace also this file (qrcode.class.php)
 */

if (!defined('__CLASS_QRCODE__'))
{
	define('__CLASS_QRCODE__', '0.9');
	
	class QRcode
	{
		public function __construct($value, $level='L')
		{
			echo '
<pre>
	<b>ATTENTION :</b> 
		Vous devez télécharger la librairie "QR-code generator" (sous licence LGPL)
 		a cette adresse : <a href="http://prgm.spipu.net/php_qrcode" target="_blank">http://prgm.spipu.net/php_qrcode</a>
 		et mettre tout son contenu dans ce repertoire : '.dirname(__FILE__).'
 		en remplacant également ce fichier : '.basename(__FILE__).'
 		
 	<b>WARNING:</b> 
 		You have to download the librairy "QR-code generator" (under LGPL licence)
 		at this url : <a href="http://prgm.spipu.net/php_qrcode" target="_blank">http://prgm.spipu.net/php_qrcode</a>
 		and to put all his contents in this folder '.dirname(__FILE__).'
 		and to replace also this file : '.basename(__FILE__).'
 </pre>';
		exit;
		}
		
		public function getQrSize()
		{
			return 0;	
		}
		
		public function displayFPDF(&$fpdf, $x, $y, $s, $background, $color)
		{
			return true;
		}

		public function displayHTML()
		{
			return true;
		}
	}
}