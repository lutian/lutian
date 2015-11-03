<?php

/**
 * Add headlines to images with text and background color
 * 
 * @version 1.0
 * @link https://github.com/lutian/CustomHeadlines
 * @author Lutian (Luciano Salvino)
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright Luciano Salvino
 */
 
 class CustomHeadlines {
 
	/**
     * @var string The image result source
     */
    private $im;
	
	/**
     * @var string Encoder version
     */
	private $version = '1.0';
	
	/**
     * @var array HEX colors
     */
	private $HEXColors = array();
	
	/**
     * @var array RGB colors
     */
	private $RGBColors = array();
	
	/**
     * @var string inverse color
     */
	private $inverseColor = '';
	
	/**
     * @var string brightness
     */
	private $brightness = '';
	
	/**
     * @var string bgColor
     */
	private $bgColor = '';
	
	/**
     * @var string txtColor
     */
	private $txtColor = '';
	
	/**
     * @var string font file path
     */
	private $fontFile = 'fonts/arial';
	
	/**
     * @var string font size
     */
	private $fontSize = 13;
	
	/**
     * @var boolean color inverse
     */
	public $colorInverse = false;
	
	/*
	* crate image with headline inside the box filling with background color similar to background image
	* @param: string $image image path
	* @param: string $headline text of headline
	* @param: int $fontSize
	* @param: int $areaX X position of box area
	* @param: int $areaY Y position of box area 
	* @param: int $areaW width of box area
	* @param: int $areaH height of box area
	* @param: int $alpha alpha of box area
	* @param: string $imageResult image result path
	* @return: string $imageResult image result path
	*/
	
	public function Create($image,$headline,$areaX,$areaY,$areaW,$areaH,$alpha=35,$imageResult='images/test.jpg')
    {
        // Create image from file
        if(is_file($image)) {

            $imageSize = getimagesize($image); 

			// create an empty image
			$W = $imageSize[0];
			$H = $imageSize[1];
            $im = ImageCreateTrueColor($W, $H);

            $imageExt = substr($image, -3);

            if(strtolower($imageExt) == "gif") {
              if (!$imSrc = imagecreatefromgif($image)) {
                    exit;
              }
            } else if(strtolower($imageExt) == "jpg") {
              if (!$imSrc = imagecreatefromjpeg($image)) {
                    exit;
              }
            } else if(strtolower($imageExt) == "png") {
              if (!$imSrc = imagecreatefrompng($image)) {
                    exit;
              }
            } else {
                die;
            }
             
            ImageCopyResampled($im, $imSrc, 0,0,0,0 , $W, $H, $imageSize[0], $imageSize[1]);

        }           


		// Get most significant colors from image
		$this->HEXColors = $this->GetColor($image,$areaX,$areaY,$areaW,$areaH);
		
		$colorsKeys=array_keys($this->HEXColors);
		
		$bgColor = $this->hex2rgb($colorsKeys[0]);
		if($this->colorInverse) $txtColor = $this->hex2rgb($this->getColorInverse($colorsKeys[0]));
		else $txtColor = $this->hex2rgb($this->getBrightness($colorsKeys[0]));
		$imBg = imagecolorallocatealpha($im, $bgColor['r'], $bgColor['g'], $bgColor['b'], $alpha);
		imagefilledrectangle($im, $areaX, $areaY, $areaX+$areaW, $areaY+$areaH, $imBg);

		// headline
	  
		$headlineColor = imagecolorallocate($im, $txtColor['r'], $txtColor['g'], $txtColor['b']);
		$wfield = $areaW+10;
		$hfield = $areaH+10;
		$arrWords = $this->fitTextOnBox($headline,$wfield,$hfield);

		$xBox = 10; 
        $yBox = $areaY+0;
        for($t=0;$t<count($arrWords);$t++) {
            $bbox2 = imagettfbbox ( $this->fontSize, 0, $this->fontFile, $arrWords[$t] );
            $ww = $bbox2[4] - $bbox2[6];  
            $hh = $bbox2[1] - $bbox2[7];  
			$xBox = $areaX+($areaW/2)-($ww/2); 
			$yBox += ($hh-($bbox2[1]/2));
            imagettftext($im, $this->fontSize, 0, $xBox, $yBox, $headlineColor, $this->fontFile, $arrWords[$t]);
        }

		// save the image
		imagejpeg($im,$imageResult,75); 
		$this->im = $imageResult;
		return $this->im;
		imagedestroy($im);

    }
 
	/*
	* Get most significant color from image
	* @param: string $image image path
	* @param: int $x X position of box area
	* @param: int $y Y position of box area 
	* @param: int $w width of box area
	* @param: int $h height of box area
	* @return: array of significant colors
	*/
	
	private function GetColor($image,$x,$y,$w,$h)
	{
		if (isset($image))
		{
			// Resize image to get most significant colors
			$arrayHex = array();
			$PREVIEW_WIDTH    = 150;  
			$PREVIEW_HEIGHT   = 150;
			$size = GetImageSize($image);
			$scale=1;
			if ($size[0]>0)
			$scale = min($PREVIEW_WIDTH/$size[0], $PREVIEW_HEIGHT/$size[1]);
			if ($scale < 1)
			{
				$width = floor($scale*$size[0]);
				$height = floor($scale*$size[1]);
				// Set the headlines area coordinates and measures
				$areaW = floor($scale*$w);
				$areaH = floor($scale*$h);
				$areaX = floor($scale*$x);
				$areaY = floor($scale*$y);
			}
			else
			{
				$width = $size[0];
				$height = $size[1];
				$areaW = $w;
				$areaH = $h;
				$areaX = $x;
				$areaY = $y;
			}
			$im = imagecreatetruecolor($width, $height);
			if ($size[2]==1)
			$imageOrig=imagecreatefromgif($image);
			if ($size[2]==2)
			$imageOrig=imagecreatefromjpeg($image);
			if ($size[2]==3)
			$imageOrig=imagecreatefrompng($image);
			imagecopyresampled($im, $imageOrig, 0, 0, 0, 0, $width, $height, $size[0], $size[1]); 
			// crop the image to fit the area selected
			$area = array('x'=>$areaX,'y'=>$areaY,'width'=>$areaW,'height'=>$areaH);
			$im = imagecrop($im,$area);
			$imgWidth = imagesx($im);
			$imgHeight = imagesy($im);
			for ($y=0; $y < $imgHeight; $y++)
			{
				for ($x=0; $x < $imgWidth; $x++)
				{
					$index = imagecolorat($im,$x,$y);
					$Colors = imagecolorsforindex($im,$index);
					$Colors['red']=intval((($Colors['red'])+15)/32)*32;  
					$Colors['green']=intval((($Colors['green'])+15)/32)*32;
					$Colors['blue']=intval((($Colors['blue'])+15)/32)*32;
					if ($Colors['red']>=256)
					$Colors['red']=240;
					if ($Colors['green']>=256)
					$Colors['green']=240;
					if ($Colors['blue']>=256)
					$Colors['blue']=240;
					$arrayHex[]=substr("0".dechex($Colors['red']),-2).substr("0".dechex($Colors['green']),-2).substr("0".dechex($Colors['blue']),-2);
				}
			}
			$arrayHex=array_count_values($arrayHex);
			natsort($arrayHex);
			$this->HEXColors=array_reverse($arrayHex,true);
			return $this->HEXColors;

		}
		else die();
	}
	
	/*
	* Get the inverse color
	* @param: string $color html code (ex: #dd2200)
	* @return: string inverse color in html code 
	*/
	
	private function getColorInverse($color){
		$color = str_replace('#', '', $color);
		$inverseColor = '';
		if (strlen($color) != 6){ return '000000'; }
		$rgb = '';
		for ($x=0;$x<3;$x++){
			$c = 255 - hexdec(substr($color,(2*$x),2));
			$c = ($c < 0) ? 0 : dechex($c);
			$inverseColor .= (strlen($c) < 2) ? '0'.$c : $c;
		}
		$inverseColor = '#'.$inverseColor;
		return $inverseColor;
	}
	
	/*
	* Get the brightness of a color
	* @param: string $hex html code (ex: #dd2200)
	* @return: string $brightness in html code 
	*/
	
	private function getBrightness($hex) {
		// returns brightness value from 0 to 255

		// strip off any leading #
		$hex = str_replace('#', '', $hex);

		$c_r = hexdec(substr($hex, 0, 2));
		$c_g = hexdec(substr($hex, 2, 2));
		$c_b = hexdec(substr($hex, 4, 2));

		$color = (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
	
		if ($color > 130) $this->brightness = '#000000';
		else $this->brightness = '#FFFFFF';
		return $this->brightness;
	
	}
	
	/*
	* Fit headlines on area
	* @param: string $string text of headline
	* @param: integer $len length of paragraph
	* @return: array $outstring 
	*/
	
	private function longWordWrap($string,$len) {
       $string = wordwrap($string,$len,"\n",1);
       $lines = explode("\n", $string); 
       return $lines;
    }
	
	private function fitTextOnBox($string,$width,$height) {
		// detect the w & h of string
		$bbox2 = imagettfbbox ( $this->fontSize, 0, $this->fontFile, $string );
        $ww = $bbox2[4] - $bbox2[6];  
        $hh = $bbox2[1] - $bbox2[7];  
		if($width > $ww) {
			if($height > $hh) {
				return array($string);
			} else {
				// try with font smaller
				$this->fontSize = ($this->fontSize-1);
				return $this->fitTextOnBox($string,$width,$height);
			}
		} else {
			// get font width for each letter
			$letterWidth = ceil($ww/mb_strlen($string));
			$widthBlock = ceil($width / $letterWidth)-2;
			// split string in blocks
			$blocks = $this->longWordWrap($string,$widthBlock);
			// verify tha string height is grater than height box
			$totH = (count($blocks)*($hh+0));
			if($totH > $height) {
				$this->fontSize = ($this->fontSize-1);
				return $this->fitTextOnBox($string,$width,$height);
			} else {
				return $blocks;
			}
		}
	}
	
	/*
	* Convert HEX to RGB color
	* @param: string $hex color code
	* @return: array $rgb colors 
	*/
	
	private function hex2rgb($hex) {
      $color = str_replace('#','',$hex);
      $this->RGBColors = array('r' => hexdec(substr($color,0,2)),
                   'g' => hexdec(substr($color,2,2)),
                   'b' => hexdec(substr($color,4,2)));
      return $this->RGBColors;
    }
	
	/*
	* Get font file
	* @param: string $font
	* @return: string $fontFile 
	*/
	
	public function getFontFile($font='arial')
    {
       if($font == 'arial') $this->fontFile = "fonts/arial.ttf";
       elseif($font == 'times') $this->fontFile = "fonts/times.ttf";

       return $this->fontFile;

    }
	
	/**
     * Get the image result string
     * 
     * @return string
	 */
	public function getImage()
    {
		return $this->im;
	}
	
	/**
     * Set font size
     * 
     * @return string
	 */
	public function setFontSize($fontSize)
    {
		return $this->fontSize = $fontSize;
	}
	
	/**
     * Get font size
     * 
     * @return string
	 */
	public function getFontSize()
    {
		return $this->fontSize;
	}
 
 
 }