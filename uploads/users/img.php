<?php

error_reporting(E_ALL & ~E_NOTICE);


class TImageResizeException extends Exception {

}

class TImageResize {

	private $sites_def_img;
	private $jpeg_out_quality;
	private $angle;
	private $imagesize;

	public function __construct() {

		$this->jpeg_out_quality = 100;
		$this->sites_def_img = array (
		);

		if ($_GET['REQUEST_URI']) {
			$uri = $_GET['REQUEST_URI'];
		}
		else {
			$uri = urldecode($_SERVER['REQUEST_URI']);
		}

		if (preg_match('/(\d+?)_(.+?)$/', trim($uri), $match)) {
			$this->Resize($match);
		} else {
			$this->_Def();
		}
	}
	
	private function _Def(){echo $_SERVER['REQUEST_URI'];
		//header("Content-type: image/gif");
		//echo file_get_contents('');
	}

	private function Resize($match) {
		//print_r($match);
		$file = $_SERVER['DOCUMENT_ROOT'].'/'.dirname($_SERVER['REQUEST_URI']).'/'.$match[2];
		$file_to = $_SERVER['DOCUMENT_ROOT'].'/'.dirname($_SERVER['REQUEST_URI']).'/'.$match[1].'_'.$match[2];
		$sizeArr[1]=array('w'=>220, 'h'=>100);
        $sizeArr[2]=array('w'=>100, 'h'=>100);
        $sizeArr[3]=array('w'=>40, 'h'=>40);
        $sizeArr[4]=array('w'=>220, 'h'=>220);
        $sizeArr[5]=array('w'=>220, 'h'=>220);
        $sizeArr[6]=array('w'=>220, 'h'=>100);
        $sizeArr[7]=array('w'=>580, 'h'=>220);
        $sizeArr[8]=array('w'=>220, 'h'=>310);
        $sizeArr[9]=array('w'=>100, 'h'=>100);
        $sizeArr[10]=array('w'=>100, 'h'=>140);
        $sizeArr[11]=array('w'=>980, 'h'=>220);
        $sizeArr[12]=array('w'=>120, 'h'=>120);
        $sizeArr[13]=array('w'=>120, 'h'=>120);
		try {
			$this->imagesize=$match[1];
			$this->SampledLimitSizeImgFromFile($file, $sizeArr[$match[1]]['w'], $sizeArr[$match[1]]['h'], $file_to);
		}
		catch(Exception $e) {
			$this->_Def();
		}
	}
		private function LimitSize($x_lim, $y_lim, & $x_is, & $y_is) {
		do {
			if ($x_lim < $x_is) {
				$quot = $x_is/$x_lim;
				if (($y_is/$quot) <= $y_lim) {
					$x_is = floor($x_is/$quot);
					$y_is = floor($y_is/$quot);
					break;
				}
			}
			if ($y_lim < $y_is) {
				$quot = $y_is/$y_lim;
				$x_is = floor($x_is/$quot);
				$y_is = floor($y_is/$quot);
			}
		}
		while (0);
	}
	
	private function WinSize($x_lim, $y_lim, & $x_is, & $y_is) {
		if(($x_is/$x_lim) >= ($y_is/$y_lim)){
			$quot = $y_is/$y_lim;
			$y_is = $y_lim;
			$x_is = round($x_is/$quot);
		}
		else{
			$quot = $x_is/$x_lim;
			$x_is = $x_lim;
			$y_is = round($y_is/$quot);
		}
	}

	private function SampledLimitSizeImgFromFile($file, $x_lim, $y_lim, $file_to = NULL) {
		try {
			$img = getimagesize($file);
		}
		catch(TPHPException $e) {
			throw new TImageResizeException($e->getMessage(), 1001);
		}
		try {
			if ($img[2] == 1)$src = imagecreatefromgif($file);
			if ($img[2] == 2)$src = imagecreatefromjpeg($file);
			if ($img[2] == 3)$src = imagecreatefrompng($file);
			if (!$src) {
				throw new TImageResizeException("Can not create canvas from file [$file]", 2010);
			}
			
			//проверка на угол
 			if($this->angle){
			$background = imagecolorallocate($src, 255, 255, 255);
			$src = imagerotate($src, $this->angle, $background);
			}
			
			$x_is = $img[0];
			$y_is = $img[1];
			
			
			
			$this->WinSize($x_lim, $y_lim, $x_is, $y_is);
			
			$src_out = imagecreatetruecolor($x_lim, $y_lim);
			if (!$src_out) throw new TImageResizeException("Can not create new canvas", 2020);
			
			imagefilledrectangle($src_out, 0, 0, $x_lim, $y_lim, imagecolorallocate($src_out, 0, 0, 0));
			
			$dst_x=round($x_lim/2-$x_is/2);
			$dst_y=round($y_lim/2-$y_is/2);
			
			//проверка на вертикальность
			if ($y_is>$x_is)
			$dst_y=0;
			
			
			
			//imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x,$src_y,$dst_w,$dst_h, $src_w, $src_h)
			imagecopyresampled($src_out, $src, $dst_x, $dst_y, 0, 0, $x_is, $y_is, $img[0], $img[1]);
			
			
			if($this->imagesize==5 || $this->imagesize==6 || $this->imagesize==9 || $this->imagesize==13){
				
				$imgw = imagesx($src_out);
				$imgh = imagesy($src_out);
				
				for ($i=0; $i<$imgw; $i++)
				{
				        for ($j=0; $j<$imgh; $j++)
				        {
				        
				                // get the rgb value for current pixel
				                
				                $rgb = ImageColorAt($src_out, $i, $j); 
				                
				                // extract each value for r, g, b
				                
				                $rr = ($rgb >> 16) & 0xFF;
				                $gg = ($rgb >> 8) & 0xFF;
				                $bb = $rgb & 0xFF;
				                
				                // get the Value from the RGB value
				                
				                $g = round(($rr + $gg + $bb) / 3);
				                
				                // grayscale values have r=g=b=g
				                
				                $val = imagecolorallocate($src_out, $g, $g, $g);
				                
				                // set the gray value
				                
				                imagesetpixel ($src_out, $i, $j, $val);
				        }
				}

				
			}
			
			
			header("Content-type: image/jpeg");
			imagejpeg($src_out, NULL, $this->jpeg_out_quality);
			imagejpeg($src_out, $file_to, $this->jpeg_out_quality);
			imagedestroy($src);
			imagedestroy($src_out);
		}
		catch(TPHPException $e) {
			throw new TImageResizeException($e->getMessage(), 1100);
		}
	}
	

}

$Imgs = new TImageResize();

?>
