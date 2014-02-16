<?
require_once 'modules/base/models/Basemodel.php';

Class Design Extends Basemodel {

public function getColor(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT
				z_site.color
				FROM z_site
				WHERE
				z_site.id='.tools::int($_SESSION['Site']['id']).'
				');
	if($result['color'])
	return $result['color'];
}
public function getMargin(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT
				z_site.margin
				FROM z_site
				WHERE
				z_site.id='.tools::int($_SESSION['Site']['id']).'
				');
	if($result['margin'])
	return $result['margin'];
}
public function updateDesign($data){
	$db=db::init();
	#Background
	if($data['bg']['url'] && $data['bg']['id']<1){
		$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['bg']['url']."";
		if(file_exists($tempfile)){
			$data['bg']['url']=pathinfo($data['bg']['url']);
			$newfile=md5(uniqid().microtime()).'.'.$data['bg']['url']['extension'];
			
			rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
			$result=$db->exec('
			INSERT INTO z_background 
			(file_name, siteid, active, userid, major)
			VALUES
			("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).',1)
			');
		}
	}
	if($data['deleted']['bg']['id']>0){
			tools::delImg($data['deleted']['bg']['url']);
			$db->exec('
				DELETE FROM 
				z_background
				WHERE 
				z_background.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_background.userid='.tools::int($_SESSION['User']['id']).'
				AND z_background.id='.tools::int($data['deleted']['bg']['id']).'
				');
	}
	#Pattern
	if($data['pattern']['url'] && $data['pattern']['id']<1){
		$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['pattern']['url']."";
		if(file_exists($tempfile)){
			$data['pattern']['url']=pathinfo($data['pattern']['url']);
			$newfile=md5(uniqid().microtime()).'.'.$data['pattern']['url']['extension'];
			
			rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
			$result=$db->exec('
			INSERT INTO z_pattern 
			(url, siteid, active, userid)
			VALUES
			("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).')
			');
		}
	}
	if($data['deleted']['pattern']['id']>0){
			tools::delImg($data['deleted']['pattern']['url']);
			$db->exec('
				DELETE FROM 
				z_pattern
				WHERE 
				z_pattern.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_pattern.userid='.tools::int($_SESSION['User']['id']).'
				AND z_pattern.id='.tools::int($data['deleted']['pattern']['id']).'
				');
	}
	#Favicon
	if($data['favicon']['url'] && $data['favicon']['id']<1){
			$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['favicon']['url']."";
			if(file_exists($tempfile)){
				$data['favicon']['url']=pathinfo($data['favicon']['url']);
				$newfile=md5(uniqid().microtime()).'.ico';
			        
					$img = $tempfile;
					
					if(exif_imagetype($tempfile)==17){
				        rename($tempfile, $_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile);
						if(file_exists($tempfile))
						unlink($tempfile);
					}else{
					$Imagick = new Imagick($img);
			
			        $Imagick->cropThumbnailImage(16,16);
			
			        $Imagick->setFormat('ico');
			
			        $Imagick->writeImage("".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
					if(file_exists($tempfile))
					unlink($tempfile);
					}
					$result=$db->exec('
					INSERT INTO z_favicon 
					(url, siteid, active, userid)
					VALUES
					("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).')
					');
			}
		}
	if($data['deleted']['favicon']['id']>0){
			tools::delImg($data['deleted']['favicon']['url']);
			$db->exec('
				DELETE FROM 
				z_favicon
				WHERE 
				z_favicon.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_favicon.userid='.tools::int($_SESSION['User']['id']).'
				AND z_favicon.id='.tools::int($data['deleted']['favicon']['id']).'
				');
	}
	#Banner
	if($data['banner']['url'] && $data['banner']['id']<1){
		$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['banner']['url']."";
		if(file_exists($tempfile)){
			$data['banner']['url']=pathinfo($data['banner']['url']);
			$newfile=md5(uniqid().microtime()).'.'.$data['banner']['url']['extension'];
			rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
			$sizeData=getimagesize($_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile);
			$result=$db->exec('
			INSERT INTO z_logo 
			(url, siteid, active, userid, width, height)
			VALUES
			("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).', '.$sizeData[0].','.$sizeData[1].')
			');
		}
	}
	if($data['deleted']['banner']['id']>0){
			tools::delImg($data['deleted']['banner']['url']);
			$db->exec('
				DELETE FROM 
				z_logo
				WHERE 
				z_logo.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_logo.userid='.tools::int($_SESSION['User']['id']).'
				AND z_logo.id='.tools::int($data['deleted']['banner']['id']).'
				');
	}
	
	
	$db=db::init();
	$db->exec('
	UPDATE z_site
	SET margin='.tools::int($data['margin']).'
	WHERE z_site.id = '.tools::int($_SESSION['Site']['id']).' 
	AND z_site.userid= '.tools::int($_SESSION['User']['id']).'
	');
}
public function updateClublogo($data,$deleted){
	$db=db::init();
	if($deleted)
	tools::delImg($deleted);
	if(!$data['url'])
	$db->exec('DELETE FROM z_clublogo WHERE id='.tools::int($data['id']).'
	AND siteid='.tools::int($_SESSION['Site']['id']).'
	AND userid='.tools::int($_SESSION['User']['id']).'');
	
	if($data['url']){
		if(!$data['id'] || $deleted){
			$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['url']."";
			if(file_exists($tempfile)){
				$data['url']=pathinfo($data['url']);
				$newfile=md5(uniqid().microtime()).'.'.$data['url']['extension'];
				rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
			}
		}
	}
	
	if($data['url'] && !$data['id'])
	$db->exec('INSERT INTO z_clublogo (file_name,siteid,userid,extension) VALUES ("'.$newfile.'",'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).',"'.$data['url']['extension'].'")');
	if($data['url'] && $data['id'] && $deleted)
	$db->exec('UPDATE z_clublogo SET file_name="'.$newfile.'", extension="'.$data['url']['extension'].'"
	WHERE id='.tools::int($data['id']).'
	AND siteid='.tools::int($_SESSION['Site']['id']).'
	AND userid='.tools::int($_SESSION['User']['id']).'');
}
public function getFavicon(){
	$db=db::init();
		$result=$db->queryFetchRow('
				SELECT 
				z_favicon.id,
				CONCAT("/uploads/sites/",z_favicon.siteid,"/img/",z_favicon.url) AS url
				FROM
				z_favicon
				WHERE z_favicon.siteid='.tools::int($_SESSION['Site']['id']).'
				LIMIT 0,1
				');
	if($result)
	return $result;
}
public function getBackground(){
	$db=db::init();
		$result=$db->queryFetchRowAssoc('
				SELECT 
				z_background.id,
				CONCAT("/uploads/sites/",z_background.siteid,"/img/",z_background.file_name) AS url
				FROM
				z_background
				WHERE z_background.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_background.userid='.tools::int($_SESSION['User']['id']).'
				LIMIT 0,1
				');
	if($result)
	return $result;
}
public function getBanner(){
	$db=db::init();
		$result=$db->queryFetchRowAssoc('
				SELECT 
				z_logo.id,
				CONCAT("/uploads/sites/",z_logo.siteid,"/img/",z_logo.url) AS url,
				z_logo.width,
				z_logo.height
				FROM
				z_logo
				WHERE z_logo.siteid='.tools::int($_SESSION['Site']['id']).'
				LIMIT 0,1
				');
	if($result)
	return $result;
}
public function getPattern(){
	$db=db::init();
		$result=$db->queryFetchRowAssoc('
				SELECT 
				z_pattern.id,
				CONCAT("/uploads/sites/",z_pattern.siteid,"/img/",z_pattern.url) AS url
				FROM
				z_pattern
				WHERE z_pattern.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_pattern.userid='.tools::int($_SESSION['User']['id']).'
				LIMIT 0,1
				');
	if($result)
	return $result;
}
public function getPagebg(){
	$db=db::init();
		$result=$db->queryFetchRowAssoc('
				SELECT
				CONCAT("/uploads/sites/",z_background.siteid,"/img/",z_background.file_name) AS url
				FROM
				z_background
				WHERE z_background.siteid='.tools::int($_SESSION['Site']['id']).'
				LIMIT 0,1
				');
	if($result['url'])
	return $result['url'];
}
public function getPagePattern(){
	$db=db::init();
		$result=$db->queryFetchRowAssoc('
				SELECT
				CONCAT("/uploads/sites/",z_pattern.siteid,"/img/",z_pattern.url) AS url
				FROM
				z_pattern
				WHERE z_pattern.siteid='.tools::int($_SESSION['Site']['id']).'
				LIMIT 0,1
				');
	if($result['url'])
	return $result['url'];
}
public function updateColor($data){
	$db=db::init();
	$db->exec('
	UPDATE z_site
	SET color="'.tools::str($data).'"
	WHERE z_site.id = '.tools::int($_SESSION['Site']['id']).' 
	AND z_site.userid= '.tools::int($_SESSION['User']['id']).'
	');
}
public function getCover(){
	$db=db::init();
		$result=$db->queryFetchAllAssoc('
				SELECT 
				z_cover.id,
				z_cover.major,
				CONCAT("/uploads/sites/",z_cover.siteid,"/img/2_",z_cover.url) AS url
				FROM
				z_cover
				WHERE z_cover.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_cover.lib=1
				AND z_cover.userid='.tools::int($_SESSION['User']['id']).'
				ORDER BY z_cover.id ASC
				');
	if($result)
	return $result;
}
public function updateCover($data, $deleted){
	$db=db::init();
	if(is_array($data))
	foreach($data as $bg){
		if($bg['id']<1){
			$bg['url']=str_replace('2_', '', $bg['url']);
			$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['url']."";
			if(file_exists($tempfile)){
				$bg['url']=pathinfo($bg['url']);
				$newfile=md5(uniqid().microtime()).'.'.$bg['url']['extension'];
				
				rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
				$result=$db->exec('
				INSERT INTO z_cover 
				(url, siteid, active, userid, major, lib)
				VALUES
				("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).', 0, 1)
				');
			}
		}
		if($bg['id']>0){
				if(intval($bg['major'])==1){
					$result=$db->exec('
					UPDATE z_cover
					SET major=0
					WHERE
					id!='.$bg['id'].'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
					
					$result=$db->exec('
					UPDATE z_cover
					SET major='.$bg['major'].'
					WHERE
					id='.$bg['id'].'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
				}
		}
	}
	if(is_array($deleted))
	foreach($deleted as $delbg){
		if($delbg['id']>0){
			
			tools::delImg($delbg['url']);
			
			$db->exec('
				DELETE FROM 
				z_cover
				WHERE 
				z_cover.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_cover.userid='.tools::int($_SESSION['User']['id']).'
				AND z_cover.id='.$delbg['id'].'
				');
		}
	}
}
public function getVideopreview(){
	$db=db::init();
		$result=$db->queryFetchAllAssoc('
				SELECT 
				z_videopreview.id,
				z_videopreview.major,
				CONCAT("/uploads/sites/",z_videopreview.siteid,"/img/1_",z_videopreview.url) AS url
				FROM
				z_videopreview
				WHERE z_videopreview.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_videopreview.lib=1
				AND z_videopreview.userid='.tools::int($_SESSION['User']['id']).'
				ORDER BY z_videopreview.id ASC
				');
	if($result)
	return $result;
}
public function updateVideopreview($data, $deleted){
	$db=db::init();
	if(is_array($data))
	foreach($data as $bg){
		if($bg['id']<1){
			$bg['url']=str_replace('1_', '', $bg['url']);
			$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['url']."";
			if(file_exists($tempfile)){
				$bg['url']=pathinfo($bg['url']);
				$newfile=md5(uniqid().microtime()).'.'.$bg['url']['extension'];
				
				rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
				$result=$db->exec('
				INSERT INTO z_videopreview 
				(url, siteid, active, userid, major,lib)
				VALUES
				("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).', 0, 1)
				');
			}
		}
		if($bg['id']>0){
				if(intval($bg['major'])==1){
					$result=$db->exec('
					UPDATE z_videopreview
					SET major=0
					WHERE
					id!='.$bg['id'].'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
					
					$result=$db->exec('
					UPDATE z_videopreview
					SET major='.$bg['major'].'
					WHERE
					id='.$bg['id'].'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
				}
		}
	}
	if(is_array($deleted))
	foreach($deleted as $delbg){
		if($delbg['id']>0){
			
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$delbg['url']))
			unlink($_SERVER['DOCUMENT_ROOT'].$delbg['url']);
			$delbg['url']=str_replace('1_', '', $delbg['url']);
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$delbg['url']))
			unlink($_SERVER['DOCUMENT_ROOT'].$delbg['url']);
			
			$db->exec('
				DELETE FROM 
				z_videopreview
				WHERE 
				z_videopreview.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_videopreview.userid='.tools::int($_SESSION['User']['id']).'
				AND z_videopreview.id='.$delbg['id'].'
				');
		}
	}
}
public function getPoster(){
	$db=db::init();
		$result=$db->queryFetchAllAssoc('
				SELECT 
				z_poster.id,
				z_poster.major,
				CONCAT("/uploads/sites/",z_poster.siteid,"/img/10_",z_poster.url) AS url
				FROM
				z_poster
				WHERE z_poster.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_poster.userid='.tools::int($_SESSION['User']['id']).'
				AND z_poster.lib=1
				ORDER BY z_poster.id ASC
				');
	if($result)
	return $result;
}
public function updatePoster($data, $deleted){
	$db=db::init();
	if(is_array($data))
	foreach($data as $bg){
		if($bg['id']<1){
			$bg['url']=str_replace('10_', '', $bg['url']);
			$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['url']."";
			if(file_exists($tempfile)){
				$bg['url']=pathinfo($bg['url']);
				$newfile=md5(uniqid().microtime()).'.'.$bg['url']['extension'];
				
				rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
				$result=$db->exec('
				INSERT INTO z_poster 
				(url, siteid, active, userid, major, lib)
				VALUES
				("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).', 0, 1)
				');
			}
		}
		if($bg['id']>0){
				if(intval($bg['major'])==1){
					$result=$db->exec('
					UPDATE z_poster
					SET major=0
					WHERE
					id!='.$bg['id'].'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
					
					$result=$db->exec('
					UPDATE z_poster
					SET major='.$bg['major'].'
					WHERE
					id='.$bg['id'].'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
				}
		}
	}
	if(is_array($deleted))
	foreach($deleted as $delbg){
		if($delbg['id']>0){
			
			tools::delImg($delbg['url']);
			
			$db->exec('
				DELETE FROM 
				z_poster
				WHERE 
				z_poster.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_poster.userid='.tools::int($_SESSION['User']['id']).'
				AND z_poster.id='.$delbg['id'].'
				');
		}
	}
}
public function getDefaultCover($siteid, $size=2){
	$db=db::init();
	$result=$db->queryFetchRow('SELECT 
	  CONCAT(
	    "/uploads/sites/",
	    z_cover.siteid,
	    "/img/'.tools::int($size).'_",
	    z_cover.url
	  ) AS url 
	FROM
	  z_cover 
	WHERE siteid = '.tools::int($siteid).' AND major=1');
	if($result['url'])
	return $result['url'];
}
public function getDefaultPoster($siteid, $size=8){
	$db=db::init();
	$result=$db->queryFetchRow('SELECT 
	  CONCAT(
	    "/uploads/sites/",
	    z_poster.siteid,
	    "/img/'.tools::int($size).'_",
	    z_poster.url
	  ) AS url 
	FROM
	  z_poster 
	WHERE siteid = '.tools::int($siteid).' AND major=1');
	if($result['url'])
	return $result['url'];
}
public function getDefaultPreview($siteid){
	$db=db::init();
	$result=$db->queryFetchRow('SELECT 
	  CONCAT(
	    "/uploads/sites/",
	    z_videopreview.siteid,
	    "/img/1_",
	    z_videopreview.url
	  ) AS url 
	FROM
	  z_videopreview 
	WHERE siteid = '.tools::int($siteid).' AND major=1');
	if($result['url'])
	return $result['url'];
}
public function getVideoPreviewList(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('SELECT 
	 z_videopreview.id,
	 z_videopreview.major,
	  CONCAT(
	    "/uploads/sites/",
	    z_videopreview.siteid,
	    "/img/1_",
	    z_videopreview.url
	  ) AS url 
	FROM
	  z_videopreview 
	WHERE siteid = '.tools::int($_SESSION['Site']['id']).' AND lib=1');
	if($result)
	return $result;
}
public function getCoverList(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('SELECT 
	 z_cover.id,
	 z_cover.major,
	  CONCAT(
	    "/uploads/sites/",
	    z_cover.siteid,
	    "/img/2_",
	    z_cover.url
	  ) AS url 
	FROM
	  z_cover 
	WHERE siteid = '.tools::int($_SESSION['Site']['id']).' AND lib=1');
	if($result)
	return $result;
}
public function getPosterList(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('SELECT 
	 z_poster.id,
	 z_poster.major,
	  CONCAT(
	    "/uploads/sites/",
	    z_poster.siteid,
	    "/img/10_",
	    z_poster.url
	  ) AS url 
	FROM
	  z_poster 
	WHERE siteid = '.tools::int($_SESSION['Site']['id']).' AND lib=1');
	if($result)
	return $result;
}
public function getClublogo(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('SELECT 
	 z_clublogo.id,
	 z_clublogo.extension,
	  CONCAT(
	    "/uploads/sites/",
	    z_clublogo.siteid,
	    "/img/",
	    z_clublogo.file_name
	  ) AS url 
	FROM
	  z_clublogo 
	WHERE siteid = '.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
	if($result)
	return $result;
}


}
?>