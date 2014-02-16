<?php

require_once 'modules/base/controllers/BaseArtist_Controller.php';

Class File_Controller Extends BaseArtist_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->registry->token=new token;
		}
        function indexAction() {
		}
		function open_image ($file) {
	    $extension = strrchr($file, '.');
	    $extension = strtolower($extension);

	    switch($extension) {
	        case '.jpg':
	        case '.jpeg':
	            $im = @imagecreatefromjpeg($file);
	            break;

	        case '.gif':
	            $im = @imagecreatefromgif($file);
	            break;

	        case '.png':
	            $im = @imagecreatefrompng($file);
	            break;

	        default:
	            $im = false;
	            break;
	    }
	    return $im;
		}
	function imageresizecrop($outfile_name, $infile, $left, $top, $width, $height, $quality) {
		$outfile = imagecreatetruecolor($width, $height);
        imagecolorallocate($outfile, 0, 0, 0);
        imagecopyresampled(
	        $outfile, $infile,
	        0, 0, $left, $top,
	        $width, $height, $width, $height);
		if(imagejpeg($outfile, $outfile_name, $quality)){
		imagedestroy($outfile);
		return $outfile_name;
		}
	}
		
		function cropAction(){
				
			    ///$data = json_decode(stripcslashes($_POST),true);
				//tools::print_r($_POST);
				//return;
				
				$data = array(
		        'post' => $_POST,
		        'files' => $_FILES,
		        'src' => '',
		        'status' => '',
		        'error' => false
		   		);
				
				$file=$_POST;
				
				$path_parts=pathinfo($file['src']);
				$newbase=md5(uniqid().microtime());
				$newfile=$path_parts['dirname']."/".$newbase.".".$path_parts['extension'];
				$newreturnfile=$path_parts['dirname']."/".$file['size']."_".$newbase.".".$path_parts['extension'];
				
				$im = self::open_image($_SERVER['DOCUMENT_ROOT'].$file['src']);
				
				
				$new_croped_file=self::imageresizecrop($_SERVER['DOCUMENT_ROOT'].$newfile, $im, $file['area'][0], $file['area'][1], $file['area'][2], $file['area'][3], 100);
				unlink($_SERVER['DOCUMENT_ROOT'].$file['src']);
				if($new_croped_file){
					$data['src'] = $newreturnfile;
			    } else {
			        $data['status'] = 'Произошла ошибка при загрузке изображения.';
			        $data['error'] = true;
			    }
				echo json_encode($data);
		}
		
		function uploadimageAction(){
			$data = array(
		        'post' => $_POST,
		        'files' => $_FILES,
		        'src' => '',
		        'status' => '',
		        'error' => false
		    );
			if (!empty($_FILES)) {
			$tempFile = $_FILES['image']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'].'/uploads/temp/';
			$path_parts=pathinfo($_FILES['image']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
			if(move_uploaded_file($tempFile,$targetFile)){
			    $data['src'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
	        } else {
	            $data['status'] = 'Произошла ошибка при загрузке изображения.';
	            $data['error'] = true;
	        }
			echo json_encode($data);
				
			}
		}
}


?>