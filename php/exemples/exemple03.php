<?php
/**
 * Logiciel : exemple d'utilisation de HTML2PDF
 * 
 * Convertisseur HTML => PDF, utilise fpdf de Olivier PLATHEY 
 * Distribu� sous la licence GPL. 
 *
 * @author		Laurent MINGUET <webmaster@spipu.net>
 */
 	ob_start();
?>
<page backtop="10mm" backbottom="10mm">
	<page_header>
		<table style="width: 100%; border: solid 1px black;">
			<tr>
				<td style="text-align: left;	width: 33%">html2pdf</td>
				<td style="text-align: center;	width: 34%">Test d'header</td>
				<td style="text-align: right;	width: 33%"><?php echo date('d/m/Y'); ?></td>
			</tr>
		</table>
	</page_header>
	<page_footer>
		<table style="width: 100%; border: solid 1px black;">
			<tr>
				<td style="text-align: left;	width: 50%">html2pdf.fr</td>
				<td style="text-align: right;	width: 50%">page [[page_cu]]/[[page_nb]]</td>
			</tr>
		</table>
	</page_footer>
	<span style="font-size: 20px; font-weight: bold">D�monstration des retour � la ligne automatique, ainsi que des sauts de page automatique<br></span>
	<br>
	<br>
	<table style="width: 80%;border: solid 1px #5544DD" align="center">
<?php for($k=0; $k<13; $k++) { ?>
		<tr>
			<td style="width: 30%; text-align: left; border: solid 1px #55DD44">
				test de texte assez long pour engendrer des retours � la ligne automatique...
				a b c d e f g h i j k l m n o p q r s t u v w x y z
				a b c d e f g h i j k l m n o p q r s t u v w x y z
			</td>
			<td style="width: 70%; text-align: left; border: solid 1px #55DD44">
				test de texte assez long pour engendrer des retours � la ligne automatique...
				a b c d e f g h i j k l m n o p q r s t u v w x y z
				a b c d e f g h i j k l m n o p q r s t u v w x y z
				
			</td>
		</tr>
<?php } ?>
	</table>
	<br>
	Ca marche !!!<br>
	refaisons un test : <br>
	<table style="width: 80%;border: solid 1px #5544DD">
<?php for($k=0; $k<12; $k++) { ?>

		<tr>
			<td style="width: 30%; text-align: left; border: solid 1px #55DD44">
				test de texte assez long pour engendrer des retours � la ligne automatique...
				a b c d e f g h i j k l m n o p q r s t u v w x y z
				a b c d e f g h i j k l m n o p q r s t u v w x y z
			</td>
			<td style="width: 70%; text-align: left; border: solid 1px #55DD44">
				test de texte assez long pour engendrer des retours � la ligne automatique...
				a b c d e f g h i j k l m n o p q r s t u v w x y z
				a b c d e f g h i j k l m n o p q r s t u v w x y z
				
			</td>
		</tr>
<?php } ?>
	</table>
	<br>
	Ca marche toujours ?!<br>
	De plus, vous pouvez faire des sauts de page manuellement en utilisant les balises &lt;page&gt; &lt;/page&gt;, comme ici par exemple :
</page>
<page pageset="old">
	Nouvelle page !!!!
</page>
<?php
	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
	$html2pdf = new HTML2PDF('P','A4', 'fr');
	$html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('exemple03.pdf');
