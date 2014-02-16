<?
require_once 'modules/base/controllers/BaseClub_Controller.php';
require_once 'modules/club/models/Video.php';
require_once 'modules/club/models/Track.php';
require_once 'modules/club/models/Social.php';
Class File_Controller Extends BaseClub_Controller {
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
				$return = array(
		        'src' => '',
		        'status' => '',
		        'error' => false
		   		);
				
				$data = json_decode(stripcslashes($_POST['data']),true);
				$path_parts=pathinfo($data['src']);
				$newbase=md5(uniqid().microtime());
				$newfile=$path_parts['dirname']."/".$newbase.".".$path_parts['extension'];
				$newreturnfile=$path_parts['dirname']."/".$data['size']."_".$newbase.".".$path_parts['extension'];
				
				$im = self::open_image($_SERVER['DOCUMENT_ROOT'].$data['src']);
				$new_croped_file=self::imageresizegallerycrop($_SERVER['DOCUMENT_ROOT'].$newfile, $im, $data['x'], $data['y'], $data['width'], $data['height'], 100);
				unlink($_SERVER['DOCUMENT_ROOT'].$data['src']);
				if($new_croped_file){
					$return['src'] = $newreturnfile;
			    } else {
			        $return['status'] = 'Произошла ошибка при загрузке изображения.';
			        $return['error'] = true;
			    }
				echo json_encode($return);
				
		}
		function gallerycropAction(){
			    $data = json_decode(stripcslashes($_POST['data']),true);
				$path_parts=pathinfo($data['src']);
				$newbase=md5(uniqid().microtime());
				$newfile=$path_parts['dirname']."/".$newbase.".".$path_parts['extension'];
				$newreturnfile=$path_parts['dirname']."/".$data['size']."_".$newbase.".".$path_parts['extension'];
				$im = self::open_image($_SERVER['DOCUMENT_ROOT'].$data['src']);
				$new_croped_file=self::imageresizecrop($_SERVER['DOCUMENT_ROOT'].$newfile, $im, $data['x'], $data['y'], $data['width'], $data['height'], 100);
				$date['url']=$newreturnfile;
				$date['bigurl']=$data['src'];
				echo json_encode($date);
		}
		
		function uploadimageAction(){
			$data = array(
		        'src' => '',
		        'status' => '',
		        'error' => false
		    );
			if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			
			if($_GET['w']>0 && $_GET['h']>0){
				$imgsize=getimagesize($tempFile);
				if($imgsize[0]<$_GET['w'] || $imgsize[1]<$_GET['h']){
				$data['status'] = 'Изображение должно быть не менее '.$_GET['w'].'px в ширину и '.$_GET['h'].' в высоту.';
	            $data['error'] = true;
				}
			}
			if(!$data['error']){	
				$targetPath = $_SERVER['DOCUMENT_ROOT'].'/uploads/temp/';
				$path_parts=pathinfo($_FILES['Filedata']['name']);
				$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
				$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
				if(move_uploaded_file($tempFile,$targetFile)){
				    $data['src'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
					$data['extension'] = $path_parts['extension'];
		        } else {
		            $data['status'] = 'Произошла ошибка при загрузке изображения.';
		            $data['error'] = true;
		        }
			}
			echo json_encode($data);
				
			}
		}
		function uploadmimageAction(){
			$data = array(
		        'status' => '',
		        'error' => false
		    );
			$tempFile = $_FILES['Filedata']['tmp_name'];
			if(file_exists($tempFile)){
					$path_parts=pathinfo($_FILES['Filedata']['name']);
					$newfile=md5(uniqid().microtime()).'.'.$path_parts['extension'];
					move_uploaded_file($tempFile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
					
					$smallfile=self::Resize('220','100',$newfile,$_SESSION['Site']['id']);
					$data['url']="/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$smallfile;
					$data['bigurl']="/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile;
			}
			else{
				$data['status'] = 'Произошла ошибка при загрузке изображения.';
	            $data['error'] = true;
					
			}
			echo json_encode($data);
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
	function uploadfaviconAction(){
			$data = array(
		        'src' => '',
		        'status' => '',
		        'error' => false
		    );
			if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
			$path_parts=pathinfo($_FILES['Filedata']['name']);
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
		function uploadfileAction(){
			$data = array(
		        'src' => '',
		        'status' => '',
		        'error' => false
		    );
			if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
			$path_parts=pathinfo($_FILES['Filedata']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$newfilenameS=$newfilename;
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
				if(move_uploaded_file($tempFile,$targetFile)){
					$targetFile=str_replace($newfilename,$newfilenameS, $targetFile);
					$data['src'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
		        } else {
		            $data['status'] = 'Произошла ошибка при загрузке изображения.';
		            $data['error'] = true;
		        }
				echo json_encode($data);
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
	public function getsinglevideoAction(){
		$_POST['url']=urldecode($_POST['url']);
		$this->Social=new Social;
		$social=$this->Social->findSocial($_POST['url']);
		if($social['id']==232){
			$this->Video=new Vimeo;
		}elseif($social['id']==227 || $social['id']==342 || $social['id']==343){
			$this->Video=new Youtube;
		}
		$data=$this->Video->getSingleVideo($_POST['url']);
		echo json_encode(array('name'=>$data['name'], 'url'=>$data['url'], 'date'=>$data['date'], 'socialid'=>$social['id']));
	}
	public function getstreamAction(){
		$_POST['url']=urldecode($_POST['url']);
		if($_POST['socialid']==234){
			$this->Soundcloud=new Soundcloud;
			$data=$this->Soundcloud->getTrack($_POST['url']);
			echo json_encode($data);
		}
	}
	public function checksocialprofileAction(){
			$_POST['url']=urldecode($_POST['url']);
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
			echo json_encode($data);
	}
	public function getsocialprofileAction(){
			$_POST['url']=urldecode($_POST['url']);
			$data = array(
		        'status' => '',
		        'error' => false
		    );
			if($_POST['socialid']==227 || $_POST['socialid']==342 || $_POST['socialid']==343){
				$this->Video= new Video;
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
							if($this->Video->updateVideo($data)>0)
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
				$this->Video= new Video;
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
							if($this->Video->updateVideo($data)>0)
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
                //tools::print_r($tracks);
				if(is_array($tracks)){
					$this->Track=new Track;
					$cnt=0;
					foreach($tracks as $track){
					    $trackdata=null;
						if($track->kind='track'){
							$trackdata['name']=$track->title;
                            $trackdata['date_start']=explode(" ",$track->created_at);
                            $trackdata['date_start']=explode("/",$trackdata['date_start'][0]);
                            $trackdata['date_start']=$trackdata['date_start'][2].'.'.$trackdata['date_start'][1].'.'.$trackdata['date_start'][0];
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
			}
			echo json_encode($data);
	}
}


?>