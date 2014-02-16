<?php

require_once 'modules/base/controllers/BaseArtistAdmin_Controller.php';
require_once 'modules/artist/models/File.php';
require_once 'modules/artist/models/Release.php';
require_once 'modules/artist/models/Social.php';
class TImageResizeException extends Exception {

}

Class File_Controller Extends BaseArtistAdmin_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->registry->token=new token;
		}
        function indexAction() {
		}
		function uploadlogoAction(){
			if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
			$path_parts=pathinfo($_FILES['Filedata']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			//$newfilenameS="1_".$newfilename;
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
			//$fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
			// $fileTypes  = str_replace(';','|',$fileTypes);
			// $typesArray = split('\|',$fileTypes);
			// $fileParts  = pathinfo($_FILES['Filedata']['name']);
			
			// if (in_array($fileParts['extension'],$typesArray)) {
				// Uncomment the following line if you want to make the directory if it doesn't exist
				// mkdir(str_replace('//','/',$targetPath), 0755, true);
				move_uploaded_file($tempFile,$targetFile);
				//$targetFile=str_replace($newfilename,$newfilenameS, $targetFile);
				echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
				//echo $tempFile;
			// } else {
			// 	echo 'Invalid file type.';
			// }
			}
		}
		function uploadbackgroundAction(){
			if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
			$path_parts=pathinfo($_FILES['Filedata']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$newfilenameS="1_".$newfilename;
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
			//$fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
			// $fileTypes  = str_replace(';','|',$fileTypes);
			// $typesArray = split('\|',$fileTypes);
			// $fileParts  = pathinfo($_FILES['Filedata']['name']);
			
			// if (in_array($fileParts['extension'],$typesArray)) {
				// Uncomment the following line if you want to make the directory if it doesn't exist
				// mkdir(str_replace('//','/',$targetPath), 0755, true);
				move_uploaded_file($tempFile,$targetFile);
				$targetFile=str_replace($newfilename,$newfilenameS, $targetFile);
				echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
				//echo $tempFile;
			// } else {
			// 	echo 'Invalid file type.';
			// }
			}
		}
		function uploadfaviconAction(){
			if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
			$path_parts=pathinfo($_FILES['Filedata']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			//$newfilenameS="1_".$newfilename;
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
			//$fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
			// $fileTypes  = str_replace(';','|',$fileTypes);
			// $typesArray = split('\|',$fileTypes);
			// $fileParts  = pathinfo($_FILES['Filedata']['name']);
			
			// if (in_array($fileParts['extension'],$typesArray)) {
				// Uncomment the following line if you want to make the directory if it doesn't exist
				// mkdir(str_replace('//','/',$targetPath), 0755, true);
				move_uploaded_file($tempFile,$targetFile);
				//$targetFile=str_replace($newfilename,$newfilenameS, $targetFile);
				echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
				//echo $tempFile;
			// } else {
			// 	echo 'Invalid file type.';
			// }
			}
		}
		function uploadfileAction(){
			if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
			$path_parts=pathinfo($_FILES['Filedata']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$newfilenameS=$newfilename;
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
				move_uploaded_file($tempFile,$targetFile);
				$targetFile=str_replace($newfilename,$newfilenameS, $targetFile);
				echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
			}
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
		imagejpeg($outfile, $outfile_name, $quality);
		imagedestroy($outfile);
		return $outfile_name;
	}
	function imageresizegallerycrop($outfile_name, $infile, $left, $top, $width, $height, $quality) {
		$outfile = imagecreatetruecolor($width, $height);
        imagecolorallocate($outfile, 0, 0, 0);
        imagecopyresampled(
	        $outfile, $infile,
	        0, 0, $left, $top,
	        $width, $height, $width, $height);
		imagejpeg($outfile, $outfile_name, $quality);
		imagedestroy($outfile);
		return $outfile_name;
	}
		
		function cropAction(){
			    $data = json_decode(stripcslashes($_POST['data']),true);
				$path_parts=pathinfo($data['url']);
				$newbase=md5(uniqid().microtime());
				$newfile=$path_parts['dirname']."/".$newbase.".".$path_parts['extension'];
				$newreturnfile=$path_parts['dirname']."/".$data['size']."_".$newbase.".".$path_parts['extension'];
				
				$im = self::open_image($_SERVER['DOCUMENT_ROOT'].$data['url']);
				$new_croped_file=self::imageresizegallerycrop($_SERVER['DOCUMENT_ROOT'].$newfile, $im, $data['x'], $data['y'], $data['width'], $data['height'], 100);
				unlink($_SERVER['DOCUMENT_ROOT'].$data['url']);
				echo $newreturnfile;
		}
		function gallerycropAction(){
			    $data = json_decode(stripcslashes($_POST['data']),true);
				$path_parts=pathinfo($data['url']);
				$newbase=md5(uniqid().microtime());
				$newfile=$path_parts['dirname']."/".$newbase.".".$path_parts['extension'];
				$newreturnfile=$path_parts['dirname']."/".$data['size']."_".$newbase.".".$path_parts['extension'];
				
				$im = self::open_image($_SERVER['DOCUMENT_ROOT'].$data['url']);
				$new_croped_file=self::imageresizecrop($_SERVER['DOCUMENT_ROOT'].$newfile, $im, $data['x'], $data['y'], $data['width'], $data['height'], 100);
				$date['url']=$newreturnfile;
				$date['bigurl']=$data['url'];
				echo json_encode($date);
		}
		
		function uploadmp3Action(){
			if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
			$path_parts=pathinfo($_FILES['Filedata']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
				move_uploaded_file($tempFile,$targetFile);
				echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
			}
		}
		function uploadimageAction(){
			if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
			$path_parts=pathinfo($_FILES['Filedata']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
				move_uploaded_file($tempFile,$targetFile);
				echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
			}
		}
		function uploadnewsimageAction(){
			if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'].'/uploads/temp/';
			$path_parts=pathinfo($_FILES['Filedata']['name']);
			$newfilebase=md5(uniqid().microtime());
			$newfilename=$newfilebase.".".$path_parts['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
			$returnTargetFile  = str_replace('//','/',$targetPath) . $newfilebase.".".$path_parts['extension'];
				
				
				$this->Image=new Image;
						
				if($this->Image->thumbup($tempFile, $targetFile, $_GET['w'], $_GET['h'], false)){
				   $data['url'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$returnTargetFile);
					$data['small']=true;
		        }elseif(move_uploaded_file($tempFile,$targetFile)) {
		        	$data['url'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$returnTargetFile);
					$data['small']=false;
		        }
				
				$data['status']="Вы загрузили слишком маленькое изображение. Хотите его растянуть?";
				echo json_encode($data);
			}
		}
		function uploadmimageAction(){
			if (!empty($_FILES)) {
				echo $this->Session->User['id'];
			$db=db::init();
			$tempFile = $_FILES['Filedata']['tmp_name'];
			if(file_exists($tempFile)){
					$path_parts=pathinfo($_FILES['Filedata']['name']);
					$newfile=md5(uniqid().microtime()).'.'.$path_parts['extension'];
					move_uploaded_file($tempFile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
					
					$smallfile=self::Resize('220','100',$newfile,$_SESSION['Site']['id']);
					
					$db->exec('
					INSERT INTO z_gallery 
					(big_file, file_name, siteid, active, userid, gallerytypeid)
					VALUES
					("'.$newfile.'", "'.$smallfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_GET['userid']).', '.tools::int($_GET['id']).')
					');
					
					$data['id']=$db->lastInsertId();
					$data['url']="/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$smallfile;
					$data['bigurl']="/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile;
					echo json_encode($data);		
			}
		}
		}
		
		
		
		/*function testcropAction(){
			$image=$_SERVER['DOCUMENT_ROOT']."/4683630.jpg";
			$output_name=$_SERVER['DOCUMENT_ROOT']."/11_125f7a5caafc29f9771ce8168744f4b8.jpg";
			$x=0;
			$y=0;
			$width=220;
			$height=220;
			
			$im = self::open_image($image);
			$new_croped_file=self::imageresizecrop($output_name, $im, $x, $y, $width, $height, 100 );
			
			
			//echo $new_croped_file;
		
		}*/
		function uploadfilesAction(){
			
			if (!empty($_FILES)) {
			$MAXIMUM_FILESIZE = 5 * 1024 * 1024; 
			$extArr=array('pdf','doc','docx','rar','zip');
			$data=array();
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
			$path_parts=pathinfo($_FILES['Filedata']['name']);
			if(!in_array($path_parts['extension'],$extArr)){
				echo json_encode(array('error'=>'Запрещенное разрешение файла'));
				return;
			}
			/*if($_FILES['Filedata']['size']>$MAXIMUM_FILESIZE){
				echo json_encode(array('error'=>'Файл больше '.$MAXIMUM_FILESIZE.'MB'));
				return;				
			}*/
			
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			
			
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
				if(move_uploaded_file($tempFile,$targetFile)){
					$oldname=explode('.',$_FILES['Filedata']['name']);
					
					$data['extension']=$path_parts['extension'];
					$data['name']=$oldname[0];
					$data['url']=str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
					echo json_encode($data);
					
				}		
			}
		}
	private function Resize($width,$height,$filename,$siteid) {
		$path_parts=pathinfo($filename);
		$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
		$file = $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$siteid.'/img/'.$filename;
		$file_to = $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$siteid.'/img/'.$newfilename;
		try {
			$this->imagesize=$width;
			$this->SampledLimitSizeImgFromFile($file, $width, $height, $file_to);
			return $newfilename;
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
			imagejpeg($src_out, $file_to, 100);
			imagedestroy($src);
			imagedestroy($src_out);
		}
		catch(TPHPException $e) {
			throw new TImageResizeException($e->getMessage(), 1100);
		}
	}
	private function _Def(){
		//echo $_SERVER['REQUEST_URI'];
		//header("Content-type: image/gif");
		//echo file_get_contents('');
	}
	public function getmp3Action(){
		$this->File=new File;
		$this->filedata=$this->File->getMp3(tools::int($_GET['f']));
		if(!is_file($_SERVER['DOCUMENT_ROOT'].$this->filedata['mp3']))    die("No such file");
		header("Content-Disposition: attachment; filename=".tools::encodestring($_GET['name']).".mp3");
		header("Content-Type: audio/mpeg3");
		readfile($_SERVER['DOCUMENT_ROOT'].$this->filedata['mp3']);
	}
	public function getdownloadfileAction(){
		$this->File=new File;
		$this->filedata=$this->File->getDownload(tools::int($_GET['f']));
		if(!is_file($_SERVER['DOCUMENT_ROOT'].$this->filedata['file_name']))    die("No such file");
		
		switch ($this->filedata['extension']) { 
	      case "pdf": $ctype="application/pdf"; break; 
	      case "exe": $ctype="application/octet-stream"; break; 
	      case "zip": $ctype="application/zip"; break; 
	      case "doc": $ctype="application/msword"; break; 
		  case "docx": $ctype="application/msword"; break; 
	      case "xls": $ctype="application/vnd.ms-excel"; break; 
	      case "ppt": $ctype="application/vnd.ms-powerpoint"; break; 
	      case "gif": $ctype="image/gif"; break; 
	      case "png": $ctype="image/png"; break; 
	      case "jpeg": 
	      case "jpg": $ctype="image/jpg"; break; 
	      default: $ctype="application/force-download"; 
	    } 
		
		header("Content-Disposition: attachment; filename=".tools::encodestring($this->filedata['name']).".".$this->filedata['extension']);
		header("Content-Type: ".$ctype."");
		readfile($_SERVER['DOCUMENT_ROOT'].$this->filedata['file_name']);
	}
	public function checksocialfolderAction(){
			$data = array(
		        'status' => '',
		        'error' => false
		    );
			if($_POST['socialid']==198){
				$this->Beatport= new Beatport;
				$response=$this->Beatport->checkRelease($_POST['url']);
				
				
				if($response && $response->results->release->type!='release'){
					$data = array(
			        'status' => 'Вы ввели не правильную ссылку',
			        'error' => true);
				}
				if(!$response){
					$data = array(
			        'status' => 'Вы ввели не правильную ссылку',
					'error' => true);
				}
				if($response->results->release->type=='release'){
					$data['status']='Вы действительно хотите загрузить релиз?';
				}
			}
			echo json_encode($data);
	}
	public function getsocialfolderAction(){
			$data = array(
		        'status' => '',
		        'error' => false
		    );
			
			if($_POST['socialid']==198){
				$this->Beatport= new Beatport;
				$response=$this->Beatport->checkRelease($_POST['url']);
				$release=$response->results->release;
					$this->Release=new Release;
							$cnt=0;
							$releasedata=array();
							$releasedata['name']=$release->name;
							$releasedata['label']=$release->label->name;
							$releaseDateArr=null;
							$releaseDateArr=explode('-',$release->releaseDate);
							$releasedata['date_start']=$releaseDateArr[2].'.'.$releaseDateArr[1].'.'.$releaseDateArr[0];
							
							$releasedata['sort']=555;
							
							$authorArr=null;
							if(is_array($release->artists)){
								$authcnt=0;
								foreach($release->artists as $author)
									if($author->type=='artist'){
									$authorArr[]=$author->name;
									$authcnt++;
									}
							}
							if($authcnt>2){
							$authorArr=null;
							$authorArr[]='VA';
							}
							$releasedata['author']=implode(' & ',$authorArr);
							//$releasedata['stream']=$track->stream_url;
							//$releasedata['socialid']=tools::int($_POST['socialid']);
							//if($track->artwork_url)
							$releasedata['url']=tools::GetImageFromUrl($release->images->large->url,2);
							$releasedata['active']=1;
							$releasedata['links'][]=array('url'=>'http://beatport.com/release/'.$release->slug.'/'.$release->id.'');
							$releasedata['typeid']=$this->Release->updateReleaseTypeInner($releasedata);
							if($releasedata['typeid']>0)
							$cnt++;
							
							$releasetracks=$this->Beatport->getRelease($release->id);
							$trcnt=0;
							foreach($releasetracks->results->tracks as $track){
								$trackauthorArr=null;
								if(is_array($track->artists)){
									foreach($track->artists as $author)
										if($author->type=='artist')
										$trackauthorArr[]=$author->name;
								}
								$trackgenresArr=null;
								if(is_array($track->genres)){
									foreach($track->genres as $genre)
										if($genre->type=='genre')
										$trackgenresArr[]=$genre->name;
								}
								$trackdata=array();
								$trackdata['name']=$track->name;
								$trackdata['author']=implode(' & ',$trackauthorArr);
								$trackdata['remix']=$track->mixName;
								$trackdata['musictype']=implode(',',$trackgenresArr);								
								$trackdata['promocut']=1;
								$trackdata['typeid']=$releasedata['typeid'];
								$trackdata['download']=0;
								$trackdata['stream']=$track->sampleUrl;
								$trackdata['socialid']=$_POST['socialid'];
								$trackdata['sort']=$trcnt;
								$this->Release->updateReleaseInner($trackdata);
							$trcnt++;
							}
				if($cnt<1){
					$data = array(
			        'status' => 'Вам не удолось добавить релизы',
			        'error' => true);
				}else{
					$data = array(
			        'status' => 'Вы успешно добавили '.$cnt.' релизов',
			        'error' => false);
				}
			}
				
			echo json_encode($data);
	}
	public function checksocialprofileAction(){
			$data = array(
		        'status' => '',
		        'error' => false
		    );
			if($_POST['socialid']==227 || $_POST['socialid']==342 || $_POST['socialid']==343){
				$this->Youtube= new Youtube;
				$response=$this->Youtube->getChanel($_POST['url']);
				
				if($response && $response->feed->{'openSearch$totalResults'}->{'$t'}<1){
					$data = array(
			        'status' => 'Канал не содержит видео роликов',
			        'error' => true);
				}
				if(!$response){
					$data = array(
			        'status' => 'Канал не существует',
					'error' => true);
				}
				if($response->feed->{'openSearch$totalResults'}->{'$t'}>0){
					$data['status']='Вы действительно хотите загрузить '.$response->feed->{'openSearch$totalResults'}->{'$t'}.' видео?';
					$data['count']=$response->feed->{'openSearch$totalResults'}->{'$t'};
			        
				}
			}
			elseif($_POST['socialid']==232){
				$this->Vimeo=new Vimeo;
				$response=$this->Vimeo->checkChanel($_POST['url']);
				
				if($response && $response->total_videos_uploaded<1){
					$data = array(
			        'status' => 'Канал не содержит видео роликов',
			        'error' => true);
				}
				if(!$response){
					$data = array(
			        'status' => 'Канал не существует',
					'error' => true);
				}
				if($response->total_videos_uploaded>0){
					$data['status']='Вы действительно хотите загрузить '.$response->total_videos_uploaded.' видео?';
					$data['count']=$response->total_videos_uploaded;
			        
				}
			}
			elseif($_POST['socialid']==234){
				$this->Soundcloud= new Soundcloud;
				$response=$this->Soundcloud->getUser($_POST['url']);
				
				if($response->kind=='user' && $response->track_count<1){
					$data = array(
			        'status' => 'Профайл не содержит треков',
			        'error' => true);
				}
				if(!$response){
					$data = array(
			        'status' => 'Профайл не существует',
					'error' => true);
				}
				if($response->track_count>0){
					$data['status']='Вы действительно хотите загрузить '.$response->track_count.' треков?';
					$data['count']=$response->track_count;
			        
				}
				
			}
			elseif($_POST['socialid']==198){
				$this->Beatport= new Beatport;
				$response=$this->Beatport->getUser($_POST['url']);
				if($response->metadata->latestReleases->count<1){
					$data = array(
			        'status' => 'Профайл не содержит релизов',
			        'error' => true);
				}
				if(!$response){
					$data = array(
			        'status' => 'Профайл не существует',
					'error' => true);
				}
				if($response->metadata->latestReleases->count>0){
					$data['status']='Вы действительно хотите загрузить '.$response->metadata->latestReleases->count.' релизов?';
					$data['count']=$response->metadata->latestReleases->count;
			    }
			}
			echo json_encode($data);
	}
	public function getsocialprofileAction(){
			$data = array(
		        'status' => '',
		        'error' => false
		    );
			if($_POST['socialid']==227 || $_POST['socialid']==342 || $_POST['socialid']==343){
				$this->File= new File;
				$this->Youtube= new Youtube;
				if($_POST['count']>0){
					$vcnt=0;
					$cnt=$_POST['count'];
					$perpage=50;
					for ($i = 1; $i <= $cnt; $i=$i+$perpage) {
						 $response=$this->Youtube->getChanel($_POST['url'],$i);
						 foreach($response->feed->entry as $video){
						 	$dateArr=explode('-',mb_substr($video->published->{'$t'},0,10,'UTF-8'));
							$videolink=null;
							foreach($video->link as $link){
								if($link->rel=='alternate')
								$videolink=$link->href;
							}
							$data=array(
							'name'=>$video->title->{'$t'},
							'url'=>$videolink,
							'preview'=>tools::GetImageFromUrl($video->{'media$group'}->{'media$thumbnail'}[0]->url,1),
							'date_start'=>$dateArr[2].'.'.$dateArr[1].'.'.$dateArr[0],
							'socialid'=>$_POST['socialid']
							);
							if($this->File->updateVideo($data)>0)
							$vcnt++;
						 }
					}
				}
				if($vcnt<1){
					$data = array(
			        'status' => 'Вам не удолось добавить видео',
			        'error' => true);
				}else{
					$data = array(
			        'status' => 'Вы успешно добавили '.$vcnt.' видео',
			        'error' => false);
				}
				
			}elseif($_POST['socialid']==232){
				$this->File= new File;
				$this->Vimeo= new Vimeo;
				if($_POST['count']>0){
					$vcnt=0;
					$cnt=$_POST['count'];
					$pages=ceil($cnt/20);
					for ($i = 1; $i <= $pages; $i++) {
						 $response=$this->Vimeo->getChanel($_POST['url'],$i);
						 
						 foreach($response as $video){
						 	$dateArr=explode('-',mb_substr($video->upload_date,0,10,'UTF-8'));
							$data=array(
							'name'=>$video->title,
							'url'=>$video->url,
							'preview'=>tools::GetImageFromUrl($video->thumbnail_large,1),
							'date_start'=>$dateArr[2].'.'.$dateArr[1].'.'.$dateArr[0],
							'socialid'=>$_POST['socialid']
							);
							if($this->File->updateVideo($data)>0)
							$vcnt++;
						 }
					}
				}
				if($vcnt<1){
					$data = array(
			        'status' => 'Вам не удолось добавить видео',
			        'error' => true);
				}else{
					$data = array(
			        'status' => 'Вы успешно добавили '.$vcnt.' видео',
			        'error' => false);
				}
			}
			elseif($_POST['socialid']==234){
				$this->Soundcloud= new Soundcloud;
				$tracks=$this->Soundcloud->getUserTracks($_POST['url']);
				if(is_array($tracks)){
					$this->Track=new Track;
					$cnt=0;
					foreach($tracks as $track){
						if($track->kind='track'){
							$trackdata['name']=$track->title;
							$trackdata['stream']=$track->stream_url;
							$trackdata['socialid']=tools::int($_POST['socialid']);
							if($track->artwork_url)
							$trackdata['cover']=tools::GetImageFromUrl(str_replace('-large.','-crop.',$track->artwork_url),4);
							$trackdata['active']=1;
							if($this->Track->updateTrack($trackdata)>0)
							$cnt++;
						}
					}
				}
				if($cnt<1){
					$data = array(
			        'status' => 'Вам не удолось добавить треки',
			        'error' => true);
				}else{
					$data = array(
			        'status' => 'Вы успешно добавили '.$cnt.' треков',
			        'error' => false);
				}
			}elseif($_POST['socialid']==198){
				$this->Beatport= new Beatport;
				$user=$this->Beatport->getUser($_POST['url']);
				//tools::print_r($tracks->results->latestReleases);
				if(is_array($user->results->latestReleases)){
					$this->Release=new Release;
					$cnt2=0;
					$cnt=$_POST['count'];
					foreach($user->results->latestReleases as $release){
							//tools::print_r($release);
							$releasedata=array();
							$releasedata['name']=$release->name;
							$releasedata['label']=$release->label->name;
							$releaseDateArr=null;
							$releaseDateArr=explode('-',$release->releaseDate);
							$releasedata['date_start']=$releaseDateArr[2].'.'.$releaseDateArr[1].'.'.$releaseDateArr[0];
							
							$releasedata['sort']=$cnt;
							
							$authorArr=null;
							if(is_array($release->artists)){
								$authcnt=0;
								foreach($release->artists as $author)
									if($author->type=='artist'){
									$authorArr[]=$author->name;
									$authcnt++;
									}
							}
							if($authcnt>2){
							$authorArr=null;
							$authorArr[]='VA';
							}
							$releasedata['author']=implode(' & ',$authorArr);
							//$releasedata['stream']=$track->stream_url;
							//$releasedata['socialid']=tools::int($_POST['socialid']);
							//if($track->artwork_url)
							$releasedata['url']=tools::GetImageFromUrl($release->images->large->url,2);
							$releasedata['active']=1;
							$releasedata['links'][]=array('url'=>'http://beatport.com/release/'.$release->slug.'/'.$release->id.'');
							$releasedata['typeid']=$this->Release->updateReleaseTypeInner($releasedata);
							if($releasedata['typeid']>0){
							$cnt--;
							$cnt2++;
							}
							
							$releasetracks=$this->Beatport->getRelease($release->id);
							$trcnt=0;
							$trcnt2=count($releasetracks->results->tracks);
							foreach($releasetracks->results->tracks as $track){
								$trackauthorArr=null;
								if(is_array($track->artists)){
									foreach($track->artists as $author)
										if($author->type=='artist')
										$trackauthorArr[]=$author->name;
								}
								$trackgenresArr=null;
								if(is_array($track->genres)){
									foreach($track->genres as $genre)
										if($genre->type=='genre')
										$trackgenresArr[]=$genre->name;
								}
								$trackdata=array();
								$trackdata['name']=$track->name;
								$trackdata['author']=implode(' & ',$trackauthorArr);
								$trackdata['remix']=$track->mixName;
								$trackdata['musictype']=implode(',',$trackgenresArr);								
								$trackdata['promocut']=1;
								$trackdata['typeid']=$releasedata['typeid'];
								$trackdata['download']=0;
								$trackdata['stream']=$track->sampleUrl;
								$trackdata['socialid']=$_POST['socialid'];
								$trackdata['sort']=$trcnt2;
								$this->Release->updateReleaseInner($trackdata);
							$trcnt++;
							$trcnt2--;
							}
							
						
					}
				}
				if($cnt2<1){
					$data = array(
			        'status' => 'Вам не удолось добавить релизы',
			        'error' => true);
				}else{
					$data = array(
			        'status' => 'Вы успешно добавили '.$cnt2.' релизов',
			        'error' => false);
				}
			}
			echo json_encode($data);
	}
	public function getstreamAction(){
		if($_POST['socialid']==234){
			$this->Soundcloud=new Soundcloud;
			$data=$this->Soundcloud->getTrack($_POST['url'],2);
			echo json_encode($data);
		}
		if($_POST['socialid']==198){
			$this->Beatport=new Beatport;
			$data=$this->Beatport->getTrack($_POST['url'],2);
			echo json_encode($data);
		}
	}
	public function getsinglevideoAction(){
		$this->Social=new Social;
		$social=$this->Social->findSocial($_POST['url']);
		if(!$social['id']){
			echo json_encode(array('error'=>true,'status'=>'Вы ввели неправильную ссылку на видео'));
		}
		else{
			if($social['id']==232){
				$this->Video=new Vimeo;
			}elseif($social['id']==227 || $social['id']==342 || $social['id']==343){
				$this->Video=new Youtube;
			}
			$data=$this->Video->getSingleVideo($_POST['url']);
			echo json_encode(array('name'=>$data['name'], 'url'=>$data['url'], 'date'=>$data['date'], 'socialid'=>$social['id']));
		}
	}
		
}


?>