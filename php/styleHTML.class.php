<?php
/**
 * Logiciel : HTML2PDF - classe styleHTML
 * 
 * Convertisseur HTML => PDF, utilise fpdf de Olivier PLATHEY 
 * Distribu� sous la licence LGPL. 
 *
 * @author		Laurent MINGUET <webmaster@spipu.net>
 * @version		3.25 - 07/10/2009
 */
 
if (!defined('__CLASS_STYLEHTML__'))
{
	define('__CLASS_STYLEHTML__', true);
	
	class styleHTML
	{
		var $css		= array();		// tableau des CSS
		var $css_keys	= array();		// tableau des clefs CSS, pour l'ordre d'execution
		var $value		= array();		// valeurs actuelles
		var $table		= array();		// tableau d'empilement pour historisation des niveaux
		var $pdf		= null;			// r�f�rence au PDF parent
		var $htmlColor	= array();		// liste des couleurs HTML
		var $onlyLeft	= false;		// indique si on est dans un sous HTML et qu'on bloque � gauche
		
		/**
		 * Constructeur
		 *
		 * @param	&pdf		r�f�rence � l'objet HTML2PDF parent
		 * @return	null
		 */
		function styleHTML(&$pdf)
		{
			$this->init();		// initialisation
			$this->pdf = &$pdf;
		}
		
 		/**
		 * Initialisation du style
		 *
		 * @return	null
		 */
		function init()
		{
			$color = array();
			$color['AliceBlue']			= '#F0F8FF';
			$color['AntiqueWhite']		= '#FAEBD7';
			$color['Aqua']				= '#00FFFF';
			$color['Aquamarine']		= '#7FFFD4';
			$color['Azure']				= '#F0FFFF';
			$color['Beige']				= '#F5F5DC';
			$color['Bisque']			= '#FFE4C4';
			$color['Black']				= '#000000';
			$color['BlanchedAlmond']	= '#FFEBCD';
			$color['Blue']				= '#0000FF';
			$color['BlueViolet']		= '#8A2BE2';
			$color['Brown']				= '#A52A2A';
			$color['BurlyWood']			= '#DEB887';
			$color['CadetBlue']			= '#5F9EA0';
			$color['Chartreuse']		= '#7FFF00';
			$color['Chocolate']			= '#D2691E';
			$color['Coral']				= '#FF7F50';
			$color['CornflowerBlue']	= '#6495ED';
			$color['Cornsilk']			= '#FFF8DC';
			$color['Crimson']			= '#DC143C';
			$color['Cyan']				= '#00FFFF';
			$color['DarkBlue']			= '#00008B';
			$color['DarkCyan']			= '#008B8B';
			$color['DarkGoldenRod']		= '#B8860B';
			$color['DarkGray']			= '#A9A9A9';
			$color['DarkGrey']			= '#A9A9A9';
			$color['DarkGreen']			= '#006400';
			$color['DarkKhaki']			= '#BDB76B';
			$color['DarkMagenta']		= '#8B008B';
			$color['DarkOliveGreen']	= '#556B2F';
			$color['Darkorange']		= '#FF8C00';
			$color['DarkOrchid']		= '#9932CC';
			$color['DarkRed']			= '#8B0000';
			$color['DarkSalmon']		= '#E9967A';
			$color['DarkSeaGreen']		= '#8FBC8F';
			$color['DarkSlateBlue']		= '#483D8B';
			$color['DarkSlateGray']		= '#2F4F4F';
			$color['DarkSlateGrey']		= '#2F4F4F';
			$color['DarkTurquoise']		= '#00CED1';
			$color['DarkViolet']		= '#9400D3';
			$color['DeepPink']			= '#FF1493';
			$color['DeepSkyBlue']		= '#00BFFF';
			$color['DimGray']			= '#696969';
			$color['DimGrey']			= '#696969';
			$color['DodgerBlue']		= '#1E90FF';
			$color['FireBrick']			= '#B22222';
			$color['FloralWhite']		= '#FFFAF0';
			$color['ForestGreen']		= '#228B22';
			$color['Fuchsia']			= '#FF00FF';
			$color['Gainsboro']			= '#DCDCDC';
			$color['GhostWhite']		= '#F8F8FF';
			$color['Gold']				= '#FFD700';
			$color['GoldenRod']			= '#DAA520';
			$color['Gray']				= '#808080';
			$color['Grey']				= '#808080';
			$color['Green']				= '#008000';
			$color['GreenYellow']		= '#ADFF2F';
			$color['HoneyDew']			= '#F0FFF0';
			$color['HotPink']			= '#FF69B4';
			$color['IndianRed']			= '#CD5C5C';
			$color['Indigo']			= '#4B0082';
			$color['Ivory']				= '#FFFFF0';
			$color['Khaki']				= '#F0E68C';
			$color['Lavender']			= '#E6E6FA';
			$color['LavenderBlush']		= '#FFF0F5';
			$color['LawnGreen']			= '#7CFC00';
			$color['LemonChiffon']		= '#FFFACD';
			$color['LightBlue']			= '#ADD8E6';
			$color['LightCoral']		= '#F08080';
			$color['LightCyan']			= '#E0FFFF';
			$color['LightGoldenRodYellow']	= '#FAFAD2';
			$color['LightGray']			= '#D3D3D3';
			$color['LightGrey']			= '#D3D3D3';
			$color['LightGreen']		= '#90EE90';
			$color['LightPink']			= '#FFB6C1';
			$color['LightSalmon']		= '#FFA07A';
			$color['LightSeaGreen']		= '#20B2AA';
			$color['LightSkyBlue']		= '#87CEFA';
			$color['LightSlateGray']	= '#778899';
			$color['LightSlateGrey']	= '#778899';
			$color['LightSteelBlue']	= '#B0C4DE';
			$color['LightYellow']		= '#FFFFE0';
			$color['Lime']				= '#00FF00';
			$color['LimeGreen']			= '#32CD32';
			$color['Linen']				= '#FAF0E6';
			$color['Magenta']			= '#FF00FF';
			$color['Maroon']			= '#800000';
			$color['MediumAquaMarine']	= '#66CDAA';
			$color['MediumBlue']		= '#0000CD';
			$color['MediumOrchid']		= '#BA55D3';
			$color['MediumPurple']		= '#9370D8';
			$color['MediumSeaGreen']	= '#3CB371';
			$color['MediumSlateBlue']	= '#7B68EE';
			$color['MediumSpringGreen']	= '#00FA9A';
			$color['MediumTurquoise']	= '#48D1CC';
			$color['MediumVioletRed']	= '#C71585';
			$color['MidnightBlue']		= '#191970';
			$color['MintCream']			= '#F5FFFA';
			$color['MistyRose']			= '#FFE4E1';
			$color['Moccasin']			= '#FFE4B5';
			$color['NavajoWhite']		= '#FFDEAD';
			$color['Navy']				= '#000080';
			$color['OldLace']			= '#FDF5E6';
			$color['Olive']				= '#808000';
			$color['OliveDrab']			= '#6B8E23';
			$color['Orange']			= '#FFA500';
			$color['OrangeRed']			= '#FF4500';
			$color['Orchid']			= '#DA70D6';
			$color['PaleGoldenRod']		= '#EEE8AA';
			$color['PaleGreen']			= '#98FB98';
			$color['PaleTurquoise']		= '#AFEEEE';
			$color['PaleVioletRed']		= '#D87093';
			$color['PapayaWhip']		= '#FFEFD5';
			$color['PeachPuff']			= '#FFDAB9';
			$color['Peru']				= '#CD853F';
			$color['Pink']				= '#FFC0CB';
			$color['Plum']				= '#DDA0DD';
			$color['PowderBlue']		= '#B0E0E6';
			$color['Purple']			= '#800080';
			$color['Red']				= '#FF0000';
			$color['RosyBrown']			= '#BC8F8F';
			$color['RoyalBlue']			= '#4169E1';
			$color['SaddleBrown']		= '#8B4513';
			$color['Salmon']			= '#FA8072';
			$color['SandyBrown']		= '#F4A460';
			$color['SeaGreen']			= '#2E8B57';
			$color['SeaShell']			= '#FFF5EE';
			$color['Sienna']			= '#A0522D';
			$color['Silver']			= '#C0C0C0';
			$color['SkyBlue']			= '#87CEEB';
			$color['SlateBlue']			= '#6A5ACD';
			$color['SlateGray']			= '#708090';
			$color['SlateGrey']			= '#708090';
			$color['Snow']				= '#FFFAFA';
			$color['SpringGreen']		= '#00FF7F';
			$color['SteelBlue']			= '#4682B4';
			$color['Tan']				= '#D2B48C';
			$color['Teal']				= '#008080';
			$color['Thistle']			= '#D8BFD8';
			$color['Tomato']			= '#FF6347';
			$color['Turquoise']			= '#40E0D0';
			$color['Violet']			= '#EE82EE';
			$color['Wheat']				= '#F5DEB3';
			$color['White']				= '#FFFFFF';
			$color['WhiteSmoke']		= '#F5F5F5';
			$color['Yellow']			= '#FFFF00';
			$color['YellowGreen']		= '#9ACD32';
			
			$this->htmlColor = array();
			foreach($color as $key => $val) $this->htmlColor[strtolower($key)] = $val;			
			unset($color);
			
			$this->table = array();
			
			$this->value = array();
			$this->initStyle();
			
			// initialisation des styles sans h�ritages
			$this->resetStyle();
		}
		
		function initStyle()
		{
	 		$this->value['id_balise']			= 'body';		// balise
			$this->value['id_name']				= null;			// name
			$this->value['id_id']				= null;			// id
			$this->value['id_class']			= null;			// class
			$this->value['id_lst']				= array('*');	// lst de dependance
			$this->value['mini-size']			= 1.;			// rapport de taille	sp�cifique aux sup, sub
			$this->value['mini-decal']			= 0;			// rapport de position	sp�cifique aux sup, sub
			$this->value['font-family']			= 'Arial';
			$this->value['font-bold']			= false;
			$this->value['font-italic']			= false;
			$this->value['font-underline']		= false;
			$this->value['font-overline']		= false;
			$this->value['font-linethrough']	= false;
			$this->value['text-transform']		= 'none';
			$this->value['font-size']			= $this->ConvertToMM('10pt');
			$this->value['text-indent']			= 0;
			$this->value['text-align']			= 'left';
			$this->value['vertical-align']		= 'middle';
			$this->value['line-height']			= 'normal';

			$this->value['position']			= null;
			$this->value['x']					= null;
			$this->value['y']					= null;
			$this->value['width']				= 0;
			$this->value['height']				= 0;
			$this->value['top']					= null;
			$this->value['right']				= null;
			$this->value['bottom']				= null;
			$this->value['left']				= null;
			$this->value['float']				= null;
			$this->value['display']				= null;
			$this->value['rotate']				= null;

			$this->value['color']				= array(0, 0, 0);
			$this->value['background']			= array('color' => null, 'image' => null, 'position' => null, 'repeat' => null);
			$this->value['border']				= array();
			$this->value['padding']				= array();
			$this->value['margin']				= array();
			$this->value['margin-auto']			= false;

			$this->value['list-style-type']		= '';
			$this->value['list-style-image']	= '';

			$this->value['xc']					= null;
			$this->value['yc']					= null;
		}
		
		/**
		 * Initialisation des styles sans h�ritages
		 *
		 * @param	string	balise HTML
		 * @return	null
		 */
		function resetStyle($balise = '')
		{
			$collapse = isset($this->value['border']['collapse']) ? $this->value['border']['collapse'] : false;
			if (!in_array($balise, array('tr', 'td', 'th'))) $collapse = false;
			
			$this->value['position']			= null;
			$this->value['x']					= null;
			$this->value['y']					= null;
			$this->value['width']				= 0;
			$this->value['height']				= 0;
			$this->value['top']					= null;
			$this->value['right']				= null;
			$this->value['bottom']				= null;
			$this->value['left']				= null;
			$this->value['float']				= null;
			$this->value['display']				= null;
			$this->value['rotate']				= null;
			$this->value['background']			= array('color' => null, 'image' => null, 'position' => null, 'repeat' => null);
			$this->value['border']	= array(
										't' => $this->readBorder('none'),
										'r' => $this->readBorder('none'),
										'b' => $this->readBorder('none'),
										'l' => $this->readBorder('none'),
										'radius' => array(0, 0),
										'collapse' => $collapse,
									);

			if (!in_array($balise, array('h1', 'h2', 'h3', 'h4', 'h5', 'h6')))
			$this->value['margin']	= array(
									't' => 0,
									'r' => 0,
									'b' => 0,
									'l' => 0
								);
			$this->value['margin-auto'] = false;
			
			if (in_array($balise, array('div')))
				$this->value['vertical-align']	 = 'top';

			if (in_array($balise, array('ul', 'li')))
			{
				$this->value['list-style-type']		= '';
				$this->value['list-style-image']	= '';
			}

			if (!in_array($balise, array('tr', 'td')))
			{
				$this->value['padding']	= array(
										't' => 0,
										'r' => 0,
										'b' => 0,
										'l' => 0
									);
			}
			else
			{
				$this->value['padding']	= array(
										't' => $this->ConvertToMM('1px'),
										'r' => $this->ConvertToMM('1px'),
										'b' => $this->ConvertToMM('1px'),
										'l' => $this->ConvertToMM('1px')
									);
			}
			
			if ($balise=='hr')
			{
				$this->value['border']	= array(
										't' => $this->readBorder('solid 1px #000000'),
										'r' => $this->readBorder('solid 1px #000000'),
										'b' => $this->readBorder('solid 1px #000000'),
										'l' => $this->readBorder('solid 1px #000000'),
										'radius' => array(0, 0),
										'collapse' => false,
									);
				$this->ConvertBackground('#FFFFFF', $this->value['background']);
			}

			$this->value['xc']					= null;
			$this->value['yc']					= null;
		}
		
		/**
		 * Initialisation de la font PDF
		 *
		 * @return	null
		 */
		function FontSet()
		{
			$b = ($this->value['font-bold']			? 'B' : '');
			$i = ($this->value['font-italic']		? 'I' : '');
			$u = ($this->value['font-underline']	? 'U' : '');
			
			// taille en mm, � ramener en pt
			$size = $this->value['font-size'];
			$size = 72 * $size / 25.4;
			
			$this->pdf->setOverline($this->value['font-overline']);
			$this->pdf->setLinethrough($this->value['font-linethrough']);
			
			// application de la fonte 
			$this->pdf->SetFont($this->value['font-family'], $b.$i.$u, $this->value['mini-size']*$size);
			$this->pdf->SetTextColor($this->value['color'][0],$this->value['color'][1], $this->value['color'][2]);
			if ($this->value['background']['color'])
				$this->pdf->SetFillColor($this->value['background']['color'][0],$this->value['background']['color'][1], $this->value['background']['color'][2]);
			else
				$this->pdf->SetFillColor(255);				
		}

 		/**
		 * Monter d'un niveau dans l'historisation
		 *
		 * @return	null
		 */		
		function save()
		{
			$this->table[count($this->table)] = $this->value;
		}
		
 		/**
		 * Descendre d'un niveau dans l'historisation
		 *
		 * @return	null
		 */		
		function load()
		{
			if (count($this->table))
			{
				$this->value = $this->table[count($this->table)-1];
				unset($this->table[count($this->table)-1]);
			}
		}

		function restorePosition(&$current_x, &$current_y)
		{
			if ($this->value['y']==$current_y) $current_y = $this->value['yc'];
		}
		
		function setPosition(&$current_x, &$current_y)
		{
			$this->value['xc'] = $current_x;
			$this->value['yc'] = $current_y;
			
			if ($this->value['position']=='relative' || $this->value['position']=='absolute')
			{
				if ($this->value['right']!==null)
				{
					$x = $this->getLastWidth(true) - $this->value['right'] - $this->value['width'];
					if ($this->value['margin']['r']) $x-= $this->value['margin']['r'];
				} 
				else
				{
					$x = $this->value['left'];
					if ($this->value['margin']['l']) $x+= $this->value['margin']['l'];
				}
				
				if ($this->value['bottom']!==null)
				{
					$y = $this->getLastHeight(true) - $this->value['bottom'] - $this->value['height'];
					if ($this->value['margin']['b']) $y-= $this->value['margin']['b'];
				} 	
				else
				{
					$y = $this->value['top'];
					if ($this->value['margin']['t']) $y+= $this->value['margin']['t'];
				}
								
				if ($this->value['position']=='relative')
				{
					$this->value['x'] = $current_x + $x;
					$this->value['y'] = $current_y + $y;
				}
				else
				{
					$this->value['x'] = $this->getLastAbsoluteX()+$x;
					$this->value['y'] = $this->getLastAbsoluteY()+$y;					
				}
			}
			else
			{
				$this->value['x'] = $current_x;
				$this->value['y'] = $current_y;	
				if ($this->value['margin']['l'])	$this->value['x']+= $this->value['margin']['l'];
				if ($this->value['margin']['t'])	$this->value['y']+= $this->value['margin']['t'];
			}
			
			$current_x = $this->value['x'];
			$current_y = $this->value['y'];
		}

 		/**
		 * Analyse un tableau de style provenant du parseurHTML
		 *
		 * @param	string	nom de la balise
		 * @param	array	tableau de style
		 * @return	null
		 */			
		function analyse($balise, &$param)
		{
			// preparation
			$balise = strtolower($balise);
			$id		= isset($param['id'])		? strtolower(trim($param['id']))	: null; if (!$id)	$id		= null;
			$name	= isset($param['name'])		? strtolower(trim($param['name']))	: null; if (!$name)	$name	= null;

			// lecture de la propriete classe
			$class = array();
			$tmp	= isset($param['class'])	? preg_replace('/[\s]+/', ' ', strtolower($param['class']))	: '';
			$tmp = explode(' ', $tmp);
			foreach($tmp as $k => $v)
			{
				$v = trim($v);
				if ($v) $class[] = $v;
			}

			// identification de la balise et des styles direct qui pourraient lui �tre appliqu�s
			$this->value['id_balise']	= $balise;
			$this->value['id_name']		= $name;
			$this->value['id_id']		= $id;
			$this->value['id_class']	= $class;
			$this->value['id_lst']		= array();
			$this->value['id_lst'][] = '*';
			$this->value['id_lst'][] = $balise;
			if (count($class))
			{
				foreach($class as $v)
				{ 
					$this->value['id_lst'][] = '*.'.$v;
					$this->value['id_lst'][] = '.'.$v;
					$this->value['id_lst'][] = $balise.'.'.$v;
				}
			}
			if ($id)
			{
				$this->value['id_lst'][] = '*#'.$id;
				$this->value['id_lst'][] = '#'.$id;
				$this->value['id_lst'][] = $id.'#'.$id;
			}

			// style CSS
			$styles = $this->getFromCSS();

			// on ajoute le style propre � la balise
			$styles = array_merge($styles, $param['style']);
			if (isset($param['allwidth']) && !isset($styles['width'])) $styles['width'] = '100%';

			// mise � zero des styles non h�rit�s
			$this->resetStyle($balise);
					
			// interpreration des nouvelles valeurs
			$correct_width = false;
			$no_width = true;

			foreach($styles as $nom => $val)
			{
				switch($nom)
				{
					case 'font-family':
						$val = explode(',', $val);
						$val = trim($val[0]);

						if ($val) $this->value['font-family'] = $val;
						break;
						
					case 'font-weight':
						$this->value['font-bold'] = ($val=='bold');
						break;
					
					case 'font-style':
						$this->value['font-italic'] = ($val=='italic');
						break;
					
					case 'text-decoration':
						$val = explode(' ', $val);
						$this->value['font-underline']		= (in_array('underline',	$val));
						$this->value['font-overline']		= (in_array('overline',		$val));
						$this->value['font-linethrough']	= (in_array('line-through',	$val));
						break;
					
					case 'text-indent':
						$this->value['text-indent']			= $this->ConvertToMM($val);
						break;
					
					case 'text-transform':
						if (!in_array($val, array('none', 'capitalize', 'uppercase', 'lowercase'))) $val = 'none';
						$this->value['text-transform']		= $val;
						break;
						
					case 'font-size':
						$val = $this->ConvertToMM($val, $this->value['font-size']);
						if ($val) $this->value['font-size'] = $val;
						break;
					
					case 'color':
						$res = null;
						$this->value['color'] = $this->ConvertToRVB($val, $res);
						
						if ($balise=='hr')
						{
							$this->value['border']['l']['color'] = $this->value['color'];
							$this->value['border']['t']['color'] = $this->value['color'];
							$this->value['border']['r']['color'] = $this->value['color'];
							$this->value['border']['b']['color'] = $this->value['color'];
						}
						break;
					
					case 'text-align':
						$this->value['text-align'] = $val;
						break;
						
					case 'vertical-align':
						$this->value['vertical-align'] = $val;
						break;
					
					case 'width':
						$this->value['width'] = $this->ConvertToMM($val, $this->getLastWidth());
						if ($this->value['width'] && substr($val, -1)=='%') $correct_width=true;
						$no_width = false;
						break;
					
					case 'height':
						$this->value['height'] = $this->ConvertToMM($val, $this->getLastHeight());
						break;
				
					case 'line-height':
						if (preg_match('/^[0-9\.]+$/isU', $val)) $val = floor($val*100).'%';
						$this->value['line-height'] = $val;
						break;
					case 'rotate':
						if (!in_array($val, array(0, -90, 90, 180, 270, -180, -270))) $val = null;
						if ($val<0) $val+= 360;
						$this->value['rotate'] = $val;
						break;
					case 'padding':
						$val = explode(' ', $val);
						foreach($val as $k => $v)
						{
							$v = trim($v);
							if ($v!='') $val[$k] = $v;
							else	unset($val[$k]);
						}
						$val = array_values($val);
						if (count($val)!=4)
						{
							$val = $this->ConvertToMM($val[0], 0);
							$this->value['padding']['t'] = $val;
							$this->value['padding']['r'] = $val;
							$this->value['padding']['b'] = $val;
							$this->value['padding']['l'] = $val;
						}
						else
						{
							$this->value['padding']['t'] = $this->ConvertToMM($val[0], 0);
							$this->value['padding']['r'] = $this->ConvertToMM($val[1], 0);
							$this->value['padding']['b'] = $this->ConvertToMM($val[2], 0);
							$this->value['padding']['l'] = $this->ConvertToMM($val[3], 0);							
						}
						break;
						
					case 'padding-top':
						$this->value['padding']['t'] = $this->ConvertToMM($val, 0);
						break;

					case 'padding-right':
						$this->value['padding']['r'] = $this->ConvertToMM($val, 0);
						break;

					case 'padding-bottom':
						$this->value['padding']['b'] = $this->ConvertToMM($val, 0);
						break;

					case 'padding-left':
						$this->value['padding']['l'] = $this->ConvertToMM($val, 0);
						break;
												
					case 'margin':
						if ($val=='auto')
						{
							$this->value['margin-auto'] = true;
							break;	
						}
						$val = explode(' ', $val);
						foreach($val as $k => $v)
						{
							$v = trim($v);
							if ($v!='') $val[$k] = $v;
							else	unset($val[$k]);
						}
						$val = array_values($val);
						if (count($val)!=4)
						{
							$val = $this->ConvertToMM($val[0], 0);
							$this->value['margin']['t'] = $val;
							$this->value['margin']['r'] = $val;
							$this->value['margin']['b'] = $val;
							$this->value['margin']['l'] = $val;
						}
						else
						{
							$this->value['margin']['t'] = $this->ConvertToMM($val[0], 0);
							$this->value['margin']['r'] = $this->ConvertToMM($val[1], 0);
							$this->value['margin']['b'] = $this->ConvertToMM($val[2], 0);
							$this->value['margin']['l'] = $this->ConvertToMM($val[3], 0);							
						}
						break;
						
					case 'margin-top':
						$this->value['margin']['t'] = $this->ConvertToMM($val, 0);
						break;

					case 'margin-right':
						$this->value['margin']['r'] = $this->ConvertToMM($val, 0);
						break;

					case 'margin-bottom':
						$this->value['margin']['b'] = $this->ConvertToMM($val, 0);
						break;

					case 'margin-left':
						$this->value['margin']['l'] = $this->ConvertToMM($val, 0);
						break;
	
					case 'border':
						$val = $this->readBorder($val);
						$this->value['border']['t'] = $val;
						$this->value['border']['r'] = $val;
						$this->value['border']['b'] = $val;
						$this->value['border']['l'] = $val;
						break;
						
					case 'border-style':
						$val = explode(' ', $val);
						foreach($val as $val_k => $val_v)
							if (!in_array($val_v, array('solid', 'dotted', 'dashed')))
								$val[$val_k] = null; 
						$this->duplicateBorder($val);
						
						if ($val[0]) $this->value['border']['t']['type'] = $val[0];
						if ($val[1]) $this->value['border']['r']['type'] = $val[1];
						if ($val[2]) $this->value['border']['b']['type'] = $val[2];
						if ($val[3]) $this->value['border']['l']['type'] = $val[3];
						break;

					case 'border-top-style':
						if (in_array($val, array('solid', 'dotted', 'dashed'))) 
							$this->value['border']['t']['type'] = $val;
						break;

					case 'border-right-style':
						if (in_array($val, array('solid', 'dotted', 'dashed'))) 
							$this->value['border']['r']['type'] = $val;
						break;

					case 'border-bottom-style':
						if (in_array($val, array('solid', 'dotted', 'dashed'))) 
							$this->value['border']['b']['type'] = $val;
						break;

					case 'border-left-style':
						if (in_array($val, array('solid', 'dotted', 'dashed'))) 
							$this->value['border']['l']['type'] = $val;
						break;

					case 'border-color':
						$res = false;
						$val = preg_replace('/,[\s]+/', ',', $val); 
						$val = explode(' ', $val);

						foreach($val as $val_k => $val_v)
						{
								$val[$val_k] = $this->ConvertToRVB($val_v, $res);
								if (!$res) $val[$val_k] = null;
						}
						$this->duplicateBorder($val);

						if (is_array($val[0])) $this->value['border']['t']['color'] = $val[0];
						if (is_array($val[1])) $this->value['border']['r']['color'] = $val[1];
						if (is_array($val[2])) $this->value['border']['b']['color'] = $val[2];
						if (is_array($val[3])) $this->value['border']['l']['color'] = $val[3];
						
						break;

					case 'border-top-color':
						$res = false;
						$val = $this->ConvertToRVB($val, $res); 
						if ($res) $this->value['border']['t']['color'] = $val;
						break;

					case 'border-right-color':
						$res = false;
						$val = $this->ConvertToRVB($val, $res); 
						if ($res) $this->value['border']['r']['color'] = $val;
						break;

					case 'border-bottom-color':
						$res = false;
						$val = $this->ConvertToRVB($val, $res); 
						if ($res) $this->value['border']['b']['color'] = $val;
						break;

					case 'border-left-color':
						$res = false;
						$val = $this->ConvertToRVB($val, $res); 
						if ($res) $this->value['border']['l']['color'] = $val;
						break;
						
					case 'border-width':
						$val = explode(' ', $val);
						foreach($val as $val_k => $val_v)
						{
								$val[$val_k] = $this->ConvertToMM($val_v, 0);
						}
						$this->duplicateBorder($val);
						
						if ($val[0]) $this->value['border']['t']['width'] = $val[0];
						if ($val[1]) $this->value['border']['r']['width'] = $val[1];
						if ($val[2]) $this->value['border']['b']['width'] = $val[2];
						if ($val[3]) $this->value['border']['l']['width'] = $val[3];
						break;

					case 'border-top-width':
						$val = $this->ConvertToMM($val, 0);; 
						if ($val) $this->value['border']['t']['width'] = $val;
						break;

					case 'border-right-width':
						$val = $this->ConvertToMM($val, 0);; 
						if ($val) $this->value['border']['r']['width'] = $val;
						break;

					case 'border-bottom-width':
						$val = $this->ConvertToMM($val, 0);; 
						if ($val) $this->value['border']['b']['width'] = $val;
						break;

					case 'border-left-width':
						$val = $this->ConvertToMM($val, 0);; 
						if ($val) $this->value['border']['l']['width'] = $val;
						break;
											
					case 'border-collapse':
						if ($balise=='table') $this->value['border']['collapse'] = ($val=='collapse');
						break;
						
					case 'border-radius':
						// nettoyage des valeurs
						$val = explode(' ', $val);
						foreach($val as $k => $v)
						{
							$v = trim($v);
							if ($v)
							{
								$v = $this->ConvertToMM($v, 0);
								if ($v) $val[$k] = $v;
								else	unset($val[$k]);
							}
							else	unset($val[$k]);	
						}
						$val = array_values($val);
						
						if (!isset($val[1]) && isset($val[0])) $val[1] = $val[0];
						if (count($val)==2)
							$this->value['border']['radius'] = array($val[0], $val[1]);

						break;
						
					case 'border-top':
						$this->value['border']['t'] = $this->readBorder($val);
						break;

					case 'border-right':
						$this->value['border']['r'] = $this->readBorder($val);
						break;

					case 'border-bottom':
						$this->value['border']['b'] = $this->readBorder($val);
						break;

					case 'border-left':
						$this->value['border']['l'] = $this->readBorder($val);
						break;
					
					case 'background-color':
						$this->value['background']['color'] = $this->ConvertBackgroundColor($val);
						break;

					case 'background-image':
						$this->value['background']['image'] = $this->ConvertBackgroundImage($val);
						break;

					case 'background-position':
						$res = null;
						$this->value['background']['position'] = $this->ConvertBackgroundPosition($val, $res);
						break;

					case 'background-repeat':
						$this->value['background']['repeat'] = $this->ConvertBackgroundRepeat($val);
						break;

					case 'background':
						$this->ConvertBackground($val, $this->value['background']);
						break;

					case 'position':
						if ($val=='absolute')		$this->value['position'] = 'absolute';
						else if ($val=='relative')	$this->value['position'] = 'relative';
						else						$this->value['position'] = null;
						break;

					case 'float':
						if ($val=='left')			$this->value['float'] = 'left';
						else if ($val=='right')		$this->value['float'] = 'right';
						else						$this->value['float'] = null;
						break;

					case 'display':
						if ($val=='inline')			$this->value['display'] = 'inline';
						else if ($val=='block')		$this->value['display'] = 'block';
						else if ($val=='none')		$this->value['display'] = 'none';
						else						$this->value['display'] = null;
						break;
											
					case 'top':
					case 'bottom':
					case 'left':
					case 'right':
						$this->value[$nom] = $val;
						break;

					case 'list-style':
					case 'list-style-type':
					case 'list-style-image':
						if ($nom=='list-style') $nom = 'list-style-type';
						$this->value[$nom] = $val;
						break;
				
					default:
						break;	
				}				
			}

			if ($this->onlyLeft) $this->value['text-align'] = 'left';
			
			// correction de la largeur pour correspondre au mod�le de boite quick
			if ($no_width && in_array($balise, array('div')) && $this->value['position']!='absolute')
			{
				$this->value['width'] = $this->getLastWidth();
				$this->value['width']-= $this->value['margin']['l'] + $this->value['margin']['r'];
			}
			else
			{
				if ($correct_width)
				{
					if (!in_array($balise, array('table', 'div', 'hr')))
					{
						$this->value['width']-= $this->value['padding']['l'] + $this->value['padding']['r'];
						$this->value['width']-= $this->value['border']['l']['width'] + $this->value['border']['r']['width'];
					}
					if (in_array($balise, array('th', 'td')))
					{
						$this->value['width']-= $this->ConvertToMM(isset($param['cellspacing']) ? $param['cellspacing'] : '2px');
					}
					if ($this->value['width']<0) $this->value['width']=0;
				}
				else
				{
					if ($this->value['width'])
					{
						if ($this->value['border']['l']['width'])	$this->value['width']	+= $this->value['border']['l']['width'];
						if ($this->value['border']['r']['width'])	$this->value['width']	+= $this->value['border']['r']['width'];			
						if ($this->value['padding']['l'])			$this->value['width']	+= $this->value['padding']['l'];
						if ($this->value['padding']['r'])			$this->value['width']	+= $this->value['padding']['r'];
					}		
				}
			}
			if ($this->value['height'])
			{
				if ($this->value['border']['b']['width']) { $this->value['height']	+= $this->value['border']['b']['width']; }
				if ($this->value['border']['t']['width']) { $this->value['height']	+= $this->value['border']['t']['width']; }
				if ($this->value['padding']['b'])			$this->value['height']	+= $this->value['padding']['b'];
				if ($this->value['padding']['t'])			$this->value['height']	+= $this->value['padding']['t'];		
			}			
			
			if ($this->value['top']!=null)		$this->value['top']		= $this->ConvertToMM($this->value['top'],		$this->getLastHeight(true));
			if ($this->value['bottom']!=null)	$this->value['bottom']	= $this->ConvertToMM($this->value['bottom'],	$this->getLastHeight(true));
			if ($this->value['left']!=null)		$this->value['left']	= $this->ConvertToMM($this->value['left'],		$this->getLastWidth(true));
			if ($this->value['right']!=null)	$this->value['right']	= $this->ConvertToMM($this->value['right'],		$this->getLastWidth(true));
			
			if ($this->value['top'] && $this->value['bottom'] && $this->value['height'])	$this->value['bottom']	= null;
			if ($this->value['left'] && $this->value['right'] && $this->value['width'])		$this->value['right']	= null;
		}
		
 		/**
		 * R�cup�ration de la hauteur de ligne courante
		 *
		 * @return	float	hauteur en mm
		 */
		function getLineHeight()
		{
			$val = $this->value['line-height'];
			if ($val=='normal') $val = '108%';
			return $this->ConvertToMM($val, $this->value['font-size']);
		}
		
 		/**
		 * R�cup�ration de la largeur de l'objet parent
		 *
		 * @return	float	largeur
		 */
		function getLastWidth($mode = false)
		{
			for($k=count($this->table); $k>0; $k--)
			{
				if ($this->table[$k-1]['width'])
				{
					$w = $this->table[$k-1]['width'];
					if ($mode)
					{
						$w+= $this->table[$k-1]['border']['l']['width'] + $this->table[$k-1]['padding']['l']+0.02;
						$w+= $this->table[$k-1]['border']['r']['width'] + $this->table[$k-1]['padding']['r']+0.02;
					}
					return $w;
				}
			}
			return $this->pdf->w - $this->pdf->lMargin - $this->pdf->rMargin;
		}

 		/**
		 * R�cup�ration de la hauteur de l'objet parent
		 *
		 * @return	float	hauteur
		 */
		function getLastHeight($mode = false)
		{
			for($k=count($this->table); $k>0; $k--)
			{
				if ($this->table[$k-1]['height'])
				{
					$h = $this->table[$k-1]['height'];
					if ($mode)
					{
						$h+= $this->table[$k-1]['border']['t']['width'] + $this->table[$k-1]['padding']['t']+0.02;
						$h+= $this->table[$k-1]['border']['b']['width'] + $this->table[$k-1]['padding']['b']+0.02;
					}
					return $h;
				}
			}
			return $this->pdf->h - $this->pdf->tMargin - $this->pdf->bMargin;
		}
		
		function getFloat()
		{
			if ($this->value['float']=='left')	return 'left';
			if ($this->value['float']=='right')	return 'right';
			return null;
		}
		
		function getParentBalise()
		{
			$nb = count($this->table);
			if ($nb>0)
				return $this->table[$nb-1]['id_balise'];
			return null;
		}
		
		function getLastAbsoluteX()
		{
			for($k=count($this->table); $k>0; $k--)
			{
				if ($this->table[$k-1]['x'] && $this->table[$k-1]['position']) return $this->table[$k-1]['x'];
			}
			return $this->pdf->lMargin;
		}
		
		function getLastAbsoluteY()
		{
			for($k=count($this->table); $k>0; $k--)
			{
				if ($this->table[$k-1]['y'] && $this->table[$k-1]['position']) return $this->table[$k-1]['y'];
			}
			return $this->pdf->tMargin;
		}
		
		/**
		 * R�cup�ration des propri�t�s CSS de la balise en cours
		 *
		 * @return	array()		tableau des propri�t�s CSS
		 */		
		function getFromCSS()
		{
			$styles	= array();	// style � appliquer
			$getit	= array();	// styles � r�cuperer

			// identification des styles direct, et ceux des parents
			$lst = array();
			$lst[] = $this->value['id_lst'];
			for($i=count($this->table)-1; $i>=0; $i--) $lst[] = $this->table[$i]['id_lst'];

			// identification des styles � r�cuperer
			foreach($this->css_keys as $key => $num)
				if ($this->getReccursiveStyle($key, $lst))
					$getit[$key] = $num;

			// si des styles sont � recuperer
			if (count($getit))
			{
				// on les r�cup�re, mais dans l'odre de d�finition, afin de garder les priorit�s
				asort($getit);
				foreach($getit as $key => $val) $styles = array_merge($styles, $this->css[$key]);				
			}
			
			return $styles;	
		}
		
		/**
		 * Identification des styles � r�cuperer, en fonction de la balise et de ses parents
		 *
		 * @param	string		clef CSS � analyser
		 * @param	array()		tableau des styles direct, et ceux des parents
		 * @param	string		prochaine etape
		 * @return	boolean		clef autoris�e ou non
		 */
		function getReccursiveStyle($key, $lst, $next = null)
		{
			// si propchaine etape, on construit les valeurs
			if ($next!==null)
			{
				if ($next) $key = trim(substr($key, 0, -strlen($next))); // on el�ve cette etape
				unset($lst[0]);
				if (!count($lst)) return false; // pas d'etape possible
				$lst = array_values($lst);
			}
			
			// pour chaque style direct possible de l'etape en cours
			foreach($lst[0] as $nom)
			{
				if ($key==$nom) return true; // si la clef conrrespond => ok
				if (substr($key, -strlen(' '.$nom))==' '.$nom && $this->getReccursiveStyle($key, $lst, $nom)) return true; // si la clef est la fin, on analyse ce qui pr�c�de
			}

			// si on est pas � la premiere etape, on doit analyse toutes les sous etapes			
			if ($next!==null && $this->getReccursiveStyle($key, $lst, '')) return true;
		
			// aucun style trouv�	
			return false;	
		}
		
		/**
		 * Analyse d'une propri�t� Border
		 *
		 * @param	string		propri�t� border
		 * @return	array()		propri�t� d�cod�e
		 */
		function readBorder($val)
		{
			$none = array('type' => 'none', 'width' => 0, 'color' => array(0, 0, 0));

			// valeurs par d�fault
			$type	= 'solid';
			$width	= $this->ConvertToMM('1pt');
			$color	= array(0, 0, 0);

			// nettoyage des valeurs
			$val = explode(' ', $val);
			foreach($val as $k => $v)
			{
				$v = trim($v);
				if ($v)	$val[$k] = $v;
				else	unset($val[$k]);	
			}
			$val = array_values($val);
			// identification des valeurs
			$res = null;
			foreach($val as $key)
			{
				if ($key=='none' || $key=='hidden') return $none;
				
				if ($this->ConvertToMM($key)!==null)							$width = $this->ConvertToMM($key);	
				else if (in_array($key, array('solid', 'dotted', 'dashed')))	$type = $key;	
				else
				{
					$tmp = $this->ConvertToRVB($key, $res);
					if ($res) $color = $tmp;
				}
			}
			if (!$width) return $none;
			return array('type' => $type, 'width' => $width, 'color' => $color);
		}
		
		function duplicateBorder(&$val)
		{
			if (count($val)==1)
			{
				$val[1] = $val[0];
				$val[2] = $val[0];
				$val[3] = $val[0];
			}
			else if (count($val)==2)
			{
				$val[2] = $val[0];
				$val[3] = $val[1];
			}
			else if (count($val)==3)
			{
				$val[3] = $val[1];
			}
		}

		function ConvertBackground($stl, &$res)
		{
			// Image
			$text = '/url\(([^)]*)\)/isU';
			if (preg_match($text, $stl, $match))
			{
				$res['image'] = $this->ConvertBackgroundImage($match[0]);				
				$stl = preg_replace($text, '', $stl);
				$stl = preg_replace('/[\s]+/', ' ', $stl);
			}
			
			// protection des espaces 
			$stl = preg_replace('/,[\s]+/', ',', $stl); 
			$lst = explode(' ', $stl);
			
			$pos = '';
			foreach($lst as $val)
			{
				$ok = false;
				$color = $this->ConvertToRVB($val, $ok);
				
				if ($ok)
				{
					$res['color'] = $color;
				}
				else if ($val=='transparent')
				{
					$res['color'] = null;
				}
				else
				{
					$repeat = $this->ConvertBackgroundRepeat($val);
					if ($repeat)
					{
						$res['repeat'] = $repeat;
					}
					else
					{
						$pos.= ($pos ? ' ' : '').$val;
					}
				}
			}
			if ($pos)
			{
				$pos = $this->ConvertBackgroundPosition($pos, $ok);
				if ($ok) $res['position'] = $pos;
			}
		}

		function ConvertBackgroundColor($val)
		{
			$res = null;
			if ($val=='transparent')	return null;
			else						return $this->ConvertToRVB($val, $res);
		}

		function ConvertBackgroundImage($val)
		{
			if ($val=='none')
				return null;
			else if (preg_match('/^url\(([^)]*)\)$/isU', $val, $match))
				return $match[1];
			else
				return null;
		}
		
		function ConvertBackgroundPosition($val, &$res)
		{
			$val = explode(' ', $val);
			if (count($val)<2)
			{
				if (!$val[0]) return null;
				$val[1] = 'center';
			}
			if (count($val)>2) return null;

			$x = 0;
			$y = 0;
			$res = true;
			
			if ($val[0]=='left')		$x = '0%';
			else if ($val[0]=='center')	$x = '50%';
			else if ($val[0]=='right')	$x = '100%';
			else if ($val[0]=='top')	$y = '0%';
			else if ($val[0]=='bottom')	$y = '100%';
			else if (preg_match('/^[-]?[0-9\.]+%$/isU',	$val[0])) $x = $val[0];
			else if ($this->ConvertToMM($val[0])) $x = $this->ConvertToMM($val[0]);
			else $res = false;
			
			if ($val[1]=='left')		$x = '0%';
			else if ($val[1]=='right')	$x = '100%';
			else if ($val[1]=='top')	$y = '0%';
			else if ($val[1]=='center')	$y = '50%';
			else if ($val[1]=='bottom')	$y = '100%';
			else if (preg_match('/^[-]?[0-9\.]+%$/isU',	$val[1])) $y = $val[1];
			else if ($this->ConvertToMM($val[1])) $y = $this->ConvertToMM($val[1]);
			else $res = false;

			$val[0] = $x;
			$val[1] = $y;
			
			return $val;	
		}
		
 		function ConvertBackgroundRepeat($val)
		{
			switch($val)
			{
				case 'repeat':
					return array(true, true);
				case 'repeat-x':
					return array(true, false);
				case 'repeat-y':
					return array(false, true);
				case 'no-repeat':
					return array(false, false);
			}
			return null;
		}
 		/**
		 * Convertir une longueur en mm
		 *
		 * @param	string			longueur, avec unit�, � convertir
		 * @param	float			longueur du parent
		 * @return	float			longueur exprim�e en mm
		 */	
		function ConvertToMM($val, $old=0.)
		{
			$val = trim($val);
			if (preg_match('/^[0-9\.\-]+$/isU', $val))			$val.= 'px';
			if (preg_match('/^[0-9\.\-]+px$/isU', $val))		$val = 25.4/96. * str_replace('px', '', $val);
			else if (preg_match('/^[0-9\.\-]+pt$/isU', $val))	$val = 25.4/72. * str_replace('pt', '', $val);
			else if (preg_match('/^[0-9\.\-]+in$/isU', $val))	$val = 25.4 * str_replace('in', '', $val);
			else if (preg_match('/^[0-9\.\-]+mm$/isU', $val))	$val = 1.*str_replace('mm', '', $val);
			else if (preg_match('/^[0-9\.\-]+%$/isU', $val))	$val = 1.*$old*str_replace('%', '', $val)/100.;
			else												$val = null;	

			return $val;
		}
		
 		/**
		 * D�composition d'un code couleur HTML
		 *
		 * @param	string			couleur au format CSS
		 * @return	array(r, v, b)	couleur exprim� par ses comporantes R, V, B, de 0 � 255.
		 */	
		function ConvertToRVB($val, &$res)
		{
			$val = trim($val);
			$res = true;
				
			if (strtolower($val)=='transparent') return array(null, null, null);
			if (isset($this->htmlColor[strtolower($val)])) $val = $this->htmlColor[strtolower($val)];
			
			if (preg_match('/rgb\([\s]*([0-9%]+)[\s]*,[\s]*([0-9%]+)[\s]*,[\s]*([0-9%]+)[\s]*\)/isU', $val, $match))
			{
				$r =$match[1]; if (substr($r, -1)=='%') $r = floor(255*substr($r, 0, -1)/100);
				$v =$match[2]; if (substr($v, -1)=='%') $v = floor(255*substr($v, 0, -1)/100);
				$b =$match[3]; if (substr($b, -1)=='%') $b = floor(255*substr($b, 0, -1)/100);
			}
			else if (strlen($val)==7 && substr($val, 0, 1)=='#')
			{
				$r = hexdec(substr($val, 1, 2));
				$v = hexdec(substr($val, 3, 2));
				$b = hexdec(substr($val, 5, 2));
			}
			else if (strlen($val)==4 && substr($val, 0, 1)=='#')
			{
				$r = hexdec(substr($val, 1, 1).substr($val, 1, 1));
				$v = hexdec(substr($val, 2, 1).substr($val, 2, 1));
				$b = hexdec(substr($val, 3, 1).substr($val, 3, 1));
			}
			else
			{
				$r=0;
				$v=0;
				$b=0;
				$res = false;
			}
			return array(floor($r), floor($v), floor($b));	
		}
		
		/**
		 * Analyser une feuille de style
		 *
		 * @param	string			code CSS
		 * @return	null
		 */	
		function analyseStyle(&$code)
		{
			// on remplace tous les espaces, tab, \r, \n, par des espaces uniques
			$code = preg_replace('/[\s]+/', ' ', $code);

			// on enl�ve les commentaires
			$code = preg_replace('/\/\*.*?\*\//s', '', $code);

			// on analyse chaque style
			preg_match_all('/([^{}]+){([^}]*)}/isU', $code, $match);
			for($k=0; $k<count($match[0]); $k++)
			{
				// noms
				$noms	= strtolower(trim($match[1][$k]));
				
				// style, s�par� par des; => on remplie le tableau correspondant
				$styles	= trim($match[2][$k]);
				$styles = explode(';', $styles);
				$stl = array();
				foreach($styles as $style)
				{
					$tmp = explode(':', $style);
					if (count($tmp)>1)
					{
						$cod = $tmp[0]; unset($tmp[0]); $tmp = implode(':', $tmp); 
						$stl[trim(strtolower($cod))] = trim($tmp);
					}
				}
				
				// d�composition des noms par les ,
				$noms = explode(',', $noms);
				foreach($noms as $nom)
				{
					$nom = trim($nom);
					// Si il a une fonction sp�cifique, comme :hover => on zap
					if (strpos($nom, ':')!==false) continue;
					if (!isset($this->css[$nom]))
						$this->css[$nom] = $stl;
					else
						$this->css[$nom] = array_merge($this->css[$nom], $stl);
					
				}
			}
			
			$this->css_keys = array_flip(array_keys($this->css));
		}
		
		/**
		 * Extraction des feuille de style du code HTML
		 *
		 * @param	string			code HTML
		 * @return	null
		 */	
		function readStyle(&$html)
		{
			$style = ' ';

			// extraction des balises link, et suppression de celles-ci dans le code HTML
			preg_match_all('/<link([^>]*)>/isU', $html, $match);
			$html = preg_replace('/<link[^>]*>/isU',	'', $html);			
			$html = preg_replace('/<\/link[^>]*>/isU',	'', $html);
			
			// analyse de chaque balise
			foreach($match[1] as $code)
			{
				$tmp = array();
				// lecture des param�tres du type nom=valeur
				$prop = '([a-zA-Z0-9_]+)=([^"\'\s>]+)';
				preg_match_all('/'.$prop.'/is', $code, $match);
				for($k=0; $k<count($match[0]); $k++)
					$tmp[trim(strtolower($match[1][$k]))] = trim($match[2][$k]);
	
				// lecture des param�tres du type nom="valeur"
				$prop = '([a-zA-Z0-9_]+)=["]([^"]*)["]';
				preg_match_all('/'.$prop.'/is', $code, $match);
				for($k=0; $k<count($match[0]); $k++)
					$tmp[trim(strtolower($match[1][$k]))] = trim($match[2][$k]);
	
				// lecture des param�tres du type nom='valeur'
				$prop = "([a-zA-Z0-9_]+)=[']([^']*)[']";
				preg_match_all('/'.$prop.'/is', $code, $match);
				for($k=0; $k<count($match[0]); $k++)
					$tmp[trim(strtolower($match[1][$k]))] = trim($match[2][$k]);

				// si de type text/css => on garde
				if (isset($tmp['type']) && strtolower($tmp['type'])=='text/css' && isset($tmp['href']))
				{
					$content = @file_get_contents($tmp['href']);
					$url = $tmp['href'];
					if (strpos($url, 'http://')!==false)
					{
						$url = str_replace('http://', '', $url);
						$url = explode('/', $url);
						$url_main = 'http://'.$url[0].'/';
						$url_self = $url; unset($url_self[count($url_self)-1]); $url_self = 'http://'.implode('/', $url_self).'/';

						$content = preg_replace('/url\(([^\\\\][^)]*)\)/isU', 'url('.$url_self.'$1)', $content);
						$content = preg_replace('/url\((\\\\[^)]*)\)/isU', 'url('.$url_main.'$1)', $content);
					}

					$style.= $content."\n";
				}
			}


			// extraction des balises style, et suppression de celles-ci dans le code HTML
			preg_match_all('/<style[^>]*>(.*)<\/style[^>]*>/isU', $html, $match);
			$html = preg_replace('/<style[^>]*>(.*)<\/style[^>]*>/isU', '', $html);			

			// analyse de chaque balise
			foreach($match[1] as $code)
			{
				$code = str_replace('<!--', '', $code);
				$code = str_replace('-->', '', $code);
				$style.= $code."\n";
			} 
			
			$this->analyseStyle($style);
		}
	}
}
