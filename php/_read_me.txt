*********************************************************
** This program is distributed under the LGPL License, **
** for more information see file _LGPL.txt or          **
** http://www.gnu.org/licenses/lgpl.html               **
**                                                     **
**  Copyright 2000-2009 by Laurent Minguet             **
*********************************************************
*******************************
* HTML2PDF v3.25 - 2009-10-07 *
*******************************

How to use :
------------
 - You need at least PHP 4.3.10
 
 - Look at the examples provided to see how it works.

 - forms work only with ADOBE READER 8 and 9.0
 
 - It is very important to provide valid HTML 4.01 to the converter,
   but only what is in the <body>

 - for borders: it is advised that they are like "solid 1mm #000000"

 - for padding, they are applicable only on tags table, th, td, div, li

 - You can chose the encoding. A specific font must be used. The encodings available are: 
    cp1250, cp1251, cp1252, cp1253, cp1254, cp1255, cp1257, cp1258, cp874,
    ISO-8859-1, ISO-8859-2, ISO-8859-4, ISO-8859-5, ISO-8859-7, ISO-8859-9,
    ISO-8859-11, ISO-8859-15, ISO-8859-16, KOI8-R, KOI8-U
  To use it: $html2pdf->setEncoding('cp1250');
  
 - The possibility to protect your PDF is present, CF Example 7. It uses the script
   fpdf_protection of Klemen Vodopivec.
       
 - Some tests can be enabled (true) or disabled (false) :
     * setTestIsImage method: test that images must exist
     * setTestTdInOnePage method: test that the contents of TDs fit on one page

 - A DEBUG mode to know the resources used is present
   It is activated by adding the following command just after the contructor (see Example 0):
      $htmlpdf->setModeDebug();
      
 - Some specific tags have been introduced:
     * <page></page>  (CF Exemple 7) :
       determines the orientation, margins left, right, top and bottom, the background image
       and the background color of a page, its size and position, the footer.
       It is also possible to keep the header and footer of the previous pages,
       through the attribut pageset="old" (see Example 3)
 
     * <page_header></page_header> (CF Example 3)
     
     * <page_footer></page_footer> (CF Example 3)
     
     * <nobreak></nobreak> :
         used to force the display of a section on the same page.
         If this section does not fit into the rest of the page, a page break is done before.
 
     * <barcode></barcode>  (CF Examples 0 et 9) :
         can insert barcodes in pdfs, CF Examples 0 and 9
         The possible types od codebar are: EAN13, UPC_A, CODE39.
         This uses the scripts of The-eh and Olivier

     * <qrcode></qrcode> (CF Exemple 13) :
         permet d'inserer un codebar � 2 dimensions de type QRcode
         voici un exemple d'utilisation :
           <qrcode value="votre message ici" size="1mm" ec="M" style="color: black; background-color: white"></qrcode>
         seul le parametre "value" est obligatoire
         les diff�rentes valeurs de type de correction sont L, M, Q, H
         (QR Code is registered trademark of DENSO WAVE INCORPORATED | http://www.denso-wave.com/qrcode/)
         ATTENTION : l'utilisation des QRCODE n�cessite l'utilisation de PHP5

     * <bookmark></bookmark>  (CF Examples 7 et About) :
         can insert bookmark in pdfs, CF Example 7 and About.
         It is also possible to automatically create an index at the end of
         documentv  CF Example About.
         This uses the scripts of Olivier and Min's
          
     * css property "rotate" :
         values : 0, 90, 180, 270
         works only on div (cf example 8)
                 
change log :
-----------
 see on this page : http://localhost/en/download

Help & Support :
---------------
 For questions and bug reports, thank you to use only the support link below.
 I will answer to your questions only on it... 

Informations :
-------------
 Programming in PHP4

 Programmer : Spipu
      email    : webmaster@spipu.net
      web site : http://html2pdf.fr/
      wiki     : http://html2pdf.fr/wiki.php
      support  : http://html2pdf.fr/forum.php

Thanks :
-------
 * Olivier PLATHEY for his library Fpdf (http://www.fpdf.org/)
 * yAronet for hosting support forum
 * everyone who helped me to develop this library and to bring the texts
