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
 	$msg = "Le site de html2pdf\r\nhttp://html2pdf.fr/";
?>
<page backtop="10mm" >
	<page_header>
		<table style="width: 100%; border: solid 1px black;">
			<tr>
				<td style="text-align: left;	width: 50%">html2pdf</td>
				<td style="text-align: right;	width: 50%">Exemples de QRcode</td>
			</tr>
		</table>
	</page_header>
	<h1>Exemples de QRcode</h1>
	<h3>Message avec Correction d'erreur L, M, Q, H (valeur par d�faut : H)</h3>
	<qrcode value="<?php echo $msg; ?>" ec="L" ></qrcode>
	<qrcode value="<?php echo $msg; ?>" ec="M" ></qrcode>
	<qrcode value="<?php echo $msg; ?>" ec="Q" ></qrcode>
	<qrcode value="<?php echo $msg; ?>" ec="H" ></qrcode>
	<br>
	<h3>Message de taille 0.3mm, 0.6mm, 1mm, 2mm (valeur par d�faut : 0.6mm)</h3>
	<qrcode value="<?php echo $msg; ?>" size="0.3mm"></qrcode>
	<qrcode value="<?php echo $msg; ?>" size="0.6mm"></qrcode>
	<qrcode value="<?php echo $msg; ?>" size="1mm"></qrcode>
	<qrcode value="<?php echo $msg; ?>" size="2mm"></qrcode>
	<br>
	<h3>Message de diff�rentes couleurs</h3>
	<qrcode value="<?php echo $msg; ?>" style="background-color: white;   color: black;"></qrcode>
	<qrcode value="<?php echo $msg; ?>" style="background-color: yellow;  color: red"></qrcode>
	<qrcode value="<?php echo $msg; ?>" style="background-color: #FFCCFF; color: #003300"></qrcode>
	<qrcode value="<?php echo $msg; ?>" style="background-color: #CCFFFF; color: #003333"></qrcode>
	<br>
</page>
<?php
 	$content = ob_get_clean();
	
	// conversion HTML => PDF
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
	$html2pdf = new HTML2PDF('P','A4','fr');
	$html2pdf->pdf->SetDisplayMode('fullpage');
	$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('qrcode.pdf');
