<?
Class Image {
	public function __construct(){
	}
	function thumb($filename, $destination, $th_width, $th_height, $forcefill)
	{    
	     //Get Image size info
		 $imgInfo = getimagesize($filename);
		 switch ($imgInfo[2]) {
		  case 1: $source = imagecreatefromgif($filename); break;
		  case 2: $source = imagecreatefromjpeg($filename);  break;
		  case 3: $source = imagecreatefrompng($filename); break;
		  default:  trigger_error('Unsupported filetype!', E_USER_WARNING);  break;
		 }	
		 $width = $imgInfo[0];
  		 $height = $imgInfo[1];
		 
		 
	      if($width > $th_width || $height > $th_height){
	      $a = $th_width/$th_height;
	      $b = $width/$height;
	
	      if(($a > $b)^$forcefill)
	      {
	         $src_rect_width  = $a * $height;
	         $src_rect_height = $height;
	         if(!$forcefill)
	         {
	            $src_rect_width = $width;
	            $th_width = $th_height/$height*$width;
	         }
	      }
	      else
	      {
	         $src_rect_height = $width/$a;
	         $src_rect_width  = $width;
	         if(!$forcefill)
	         {
	            $src_rect_height = $height;
	            $th_height = $th_width/$width*$height;
	         }
	      }
	
	      $src_rect_xoffset = ($width - $src_rect_width)/2*intval($forcefill);
	      $src_rect_yoffset = ($height - $src_rect_height)/2*intval($forcefill);
		
	     
			 $thumb  = imagecreatetruecolor($th_width, $th_height);
		   /* Check if this image is PNG or GIF, then set if Transparent*/  
			 if(($imgInfo[2] == 1) OR ($imgInfo[2]==3)){
			  imagealphablending($thumb, false);
			  imagesavealpha($thumb,true);
			  $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
			  imagefilledrectangle($thumb, 0, 0, $th_width, $th_height, $transparent);
			 }
			 
		 
		 
		  
		 
		  if(imagecopyresampled($thumb, $source, 0, 0, $src_rect_xoffset, $src_rect_yoffset, $th_width, $th_height, $src_rect_width, $src_rect_height)){
		  
		  switch ($imgInfo[2]) {
			  case 1: imagegif($thumb,$destination); break;
			  case 2: imagejpeg($thumb,$destination,100);  break;
			  case 3: imagepng($thumb,$destination); break;
			  default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
		  }
		  return true;
		  }
	   }else{
	   	rename($filename,$destination);
	   }
	}
	function thumbup($filename, $destination, $th_width, $th_height, $forcefill)
	{    
	     //Get Image size info
		 $imgInfo = getimagesize($filename);
		 
		 //echo json_encode(array('status'=>$imgInfo[2]));
		 
		 switch ($imgInfo[2]) {
		  case 1: $source = imagecreatefromgif($filename); break;
		  case 2: $source = imagecreatefromjpeg($filename);  break;
		  case 3: $source = imagecreatefrompng($filename); break;
		  default:  trigger_error('Unsupported filetype!', E_USER_WARNING);  break;
		 }	
		 $width = $imgInfo[0];
  		 $height = $imgInfo[1];
		 
		 
		 
	      if($width < $th_width || $height < $th_height){
	      $a = $th_width/$th_height;
	      $b = $width/$height;
		 
	      if(($a < $b)^$forcefill)
	      {
	         $src_rect_width  = $a * $height;
	         $src_rect_height = $height;
	         if(!$forcefill)
	         {
	            $src_rect_width = $width;
	            $th_width = $th_height/$height*$width;
	         } 
	      }
	      else
	      {
	      	 $src_rect_height = $width/$b;
	         $src_rect_width  = $width;
	         if(!$forcefill)
	         {
	            $src_rect_height = $height;
	            $th_height = $th_width/$width*$height;
	         }
	      }
	
	      $src_rect_xoffset = ($width - $src_rect_width)/2*intval($forcefill);
	      $src_rect_yoffset = ($height - $src_rect_height)/2*intval($forcefill);
		
	     
			 $thumb  = imagecreatetruecolor($th_width, $th_height);
		   /* Check if this image is PNG or GIF, then set if Transparent*/  
			 if(($imgInfo[2] == 1) OR ($imgInfo[2]==3)){
			  imagealphablending($thumb, false);
			  imagesavealpha($thumb,true);
			  $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
			  imagefilledrectangle($thumb, 0, 0, $th_width, $th_height, $transparent);
			 }
			 
		 
		 
		  
		 
		  if(imagecopyresampled($thumb, $source, 0, 0, $src_rect_xoffset, $src_rect_yoffset, $th_width, $th_height, $src_rect_width, $src_rect_height)){
		  
		  switch ($imgInfo[2]) {
			  case 1: imagegif($thumb,$destination); break;
			  case 2: imagejpeg($thumb,$destination,100);  break;
			  case 3: imagepng($thumb,$destination); break;
			  default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
		  }
		  return true;
		  }
	   }
	}

}