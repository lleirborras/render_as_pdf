<?php
/*************************************************************************
 * http://www.fpdf.org/fr/script/script37.php
 * 
 * @author		Klemen Vodopivec
 * 
 * Ce script permet de prot�ger le PDF, c'est-�-dire emp�cher l'utilisateur de copier son contenu, de l'imprimer ou de le modifier.
 * 
 * SetProtection([array permissions [, string user_pass [, string owner_pass]]])
 * 
 * permissions : l'ensemble des permissions. Vide par d�faut (seule la lecture est autoris�e).
 * user_pass : mot de passe utilisateur. Vide par d�faut.
 * owner_pass : mot de passe propri�taire. Par d�faut, une valeur al�atoire est choisie.
 * 
 * Le tableau des permissions est compos� de valeurs prises parmi les suivantes :
 *		* copy : copie du texte et des images dans le presse-papier
 *		* print : impression du document
 *		* modify : modification (autre ques les annotations et les formulaires)
 *		* annot-forms : ajout d'annotations ou de formulaires 
 * 
 * Remarque : la protection contre la modification concerne les personnes poss�dant la version compl�te d'Acrobat.
 * 
 * Si vous ne sp�cifiez pas de mot de passe, le document s'ouvrira normalement. Si vous indiquez un mot de passe utilisateur,
 * le lecteur de PDF le demandera avant d'afficher le document. Le mot de passe propri�taire, s'il est diff�rent de celui utilisateur,
 * permet d'obtenir l'acc�s complet.
 * 
 * Note : prot�ger un document n�cessite de le crypter, ce qui augmente le temps de traitement de mani�re importante.
 * Cela peut dans certains cas entra�ner un time-out au niveau de PHP, en particulier si le document contient des
 * images ou des polices.
 ************************************************************************/

if (!defined('__CLASS_FPDF_PROTECTION__'))
{
	define('__CLASS_FPDF_PROTECTION__', true);
	
	require_once(dirname(__FILE__).'/02_fpdf_formulaire.class.php');
	
	class FPDF_Protection extends FPDF_Formulaire
	{
		var $encrypted;			//whether document is protected
		var $Uvalue;			//U entry in pdf document
		var $Ovalue;			//O entry in pdf document
		var $Pvalue;			//P entry in pdf document
		var $enc_obj_id;		//encryption object id
		var $last_rc4_key;		//last RC4 key encrypted (cached for optimisation)
		var $last_rc4_key_c;	//last RC4 computed key
	
		function FPDF_Protection($orientation='P',$unit='mm',$format='A4')
		{
			$this->FPDF_Formulaire($orientation,$unit,$format);
	
			$this->encrypted=false;
			$this->last_rc4_key='';
			$this->padding="\x28\xBF\x4E\x5E\x4E\x75\x8A\x41\x64\x00\x4E\x56\xFF\xFA\x01\x08".
							"\x2E\x2E\x00\xB6\xD0\x68\x3E\x80\x2F\x0C\xA9\xFE\x64\x53\x69\x7A";
		}
	
		/**
		* Function to set permissions as well as user and owner passwords
		*
		* - permissions is an array with values taken from the following list:
		*	copy, print, modify, annot-forms
		*	If a value is present it means that the permission is granted
		* - If a user password is set, user will be prompted before document is opened
		* - If an owner password is set, document can be opened in privilege mode with no
		*	restriction if that password is entered
		*/
		function SetProtection($permissions=array(),$user_pass='',$owner_pass=null)
		{
			$options = array('print' => 4, 'modify' => 8, 'copy' => 16, 'annot-forms' => 32 );
			$protection = 192;
			foreach($permissions as $permission){
				if (!isset($options[$permission]))
					$this->Error('Incorrect permission: '.$permission);
				$protection += $options[$permission];
			}
			if ($owner_pass === null)
				$owner_pass = uniqid(rand());
			$this->encrypted = true;
			$this->_generateencryptionkey($user_pass, $owner_pass, $protection);
		}

/****************************************************************************
*																			*
*								Private methods								*
*																			*
****************************************************************************/

		function _putstream($s)
		{
			if ($this->encrypted) {
				$s = $this->_RC4($this->_objectkey($this->n), $s);
			}
			parent::_putstream($s);
		}
	
		function _textstring($s)
		{
			if ($this->encrypted) {
				$s = $this->_RC4($this->_objectkey($this->n), $s);
			}
			return parent::_textstring($s);
		}
	
		/**
		* Compute key depending on object number where the encrypted data is stored
		*/
		function _objectkey($n)
		{
			return substr($this->_md5_16($this->encryption_key.pack('VXxx',$n)),0,10);
		}
	
		function _putresources()
		{
			parent::_putresources();
			if ($this->encrypted) {
				$this->_newobj();
				$this->enc_obj_id = $this->n;
				$this->_out('<<');
				$this->_putencryption();
				$this->_out('>>');
				$this->_out('endobj');
			}
		}
	
		function _putencryption()
		{
			$this->_out('/Filter /Standard');
			$this->_out('/V 1');
			$this->_out('/R 2');
			$this->_out('/O ('.$this->_escape($this->Ovalue).')');
			$this->_out('/U ('.$this->_escape($this->Uvalue).')');
			$this->_out('/P '.$this->Pvalue);
		}
	
		function _puttrailer()
		{
			parent::_puttrailer();
			if ($this->encrypted) {
				$this->_out('/Encrypt '.$this->enc_obj_id.' 0 R');
				$this->_out('/ID [()()]');
			}
		}
	
		/**
		* RC4 is the standard encryption algorithm used in PDF format
		*/
		function _RC4($key, $text)
		{
			if ($this->last_rc4_key != $key) {
				$k = str_repeat($key, 256/strlen($key)+1);
				$rc4 = range(0,255);
				$j = 0;
				for ($i=0; $i<256; $i++){
					$t = $rc4[$i];
					$j = ($j + $t + ord($k{$i})) % 256;
					$rc4[$i] = $rc4[$j];
					$rc4[$j] = $t;
				}
				$this->last_rc4_key = $key;
				$this->last_rc4_key_c = $rc4;
			} else {
				$rc4 = $this->last_rc4_key_c;
			}
	
			$len = strlen($text);
			$a = 0;
			$b = 0;
			$out = '';
			for ($i=0; $i<$len; $i++){
				$a = ($a+1)%256;
				$t= $rc4[$a];
				$b = ($b+$t)%256;
				$rc4[$a] = $rc4[$b];
				$rc4[$b] = $t;
				$k = $rc4[($rc4[$a]+$rc4[$b])%256];
				$out.=chr(ord($text{$i}) ^ $k);
			}
	
			return $out;
		}
	
		/**
		* Get MD5 as binary string
		*/
		function _md5_16($string)
		{
			return pack('H*',md5($string));
		}
	
		/**
		* Compute O value
		*/
		function _Ovalue($user_pass, $owner_pass)
		{
			$tmp = $this->_md5_16($owner_pass);
			$owner_RC4_key = substr($tmp,0,5);
			return $this->_RC4($owner_RC4_key, $user_pass);
		}
	
		/**
		* Compute U value
		*/
		function _Uvalue()
		{
			return $this->_RC4($this->encryption_key, $this->padding);
		}
	
		/**
		* Compute encryption key
		*/
		function _generateencryptionkey($user_pass, $owner_pass, $protection)
		{
			// Pad passwords
			$user_pass = substr($user_pass.$this->padding,0,32);
			$owner_pass = substr($owner_pass.$this->padding,0,32);
			// Compute O value
			$this->Ovalue = $this->_Ovalue($user_pass,$owner_pass);
			// Compute encyption key
			$tmp = $this->_md5_16($user_pass.$this->Ovalue.chr($protection)."\xFF\xFF\xFF");
			$this->encryption_key = substr($tmp,0,5);
			// Compute U value
			$this->Uvalue = $this->_Uvalue();
			// Compute P value
			$this->Pvalue = -(($protection^255)+1);
		}
	}
}
