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
 
 $generate = isset($_GET['make_pdf']);
 $nom = isset($_GET['nom']) ? $_GET['nom'] : 'inconnu';
 
 $nom = substr(preg_replace('/[^a-zA-Z0-9]/isU', '', $nom), 0, 26);
 
 if ($generate)
 {
 	ob_start();
 }
 else
 {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >	
		<title>Exemple d'auto g�n�ration de PDF</title>
	</head>
	<body>
<?php	
 }
?>
<br>
Ceci est un exemple de g�n�ration de PDF via un bouton :)<br>
<br>
<img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']); ?>/res/exemple09.png.php?px=5&amp;py=20" alt="image_php" ><br>
<br>
<?php if ($generate) { ?>
Bonjour <b><?php echo $nom; ?></b>, ton nom peut s'�crire : <br>
<barcode type="CODE39" value="<?php echo strtoupper($nom); ?>" style="color: #770000"></barcode><hr>
<br>
<?php } ?>
<br>
<?php
	if ($generate)
	{
		$content = ob_get_clean();
		require_once(dirname(__FILE__).'/../html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4', 'fr');
		$html2pdf->WriteHTML($content);
		$html2pdf->Output('exemple09.pdf');
		exit;
	}
?>
		<form method="get" action="">
			<input type="hidden" name="make_pdf" value="">
			Ton nom : <input type="text" name="nom" value=""> - 
			<input type="submit" value="Generer le PDF" >
		</form>
	</body>
</html>