<?
require_once 'modules/base/models/Basemodel.php';
require_once 'modules/artist/models/Social.php';

Class File Extends Basemodel {
	
	public function getYoutube($url=null){
		if(!$url)
		return;
		$youObj=json_decode(file_get_contents(sprintf('http://www.youtube.com/oembed?url=%s&format=json', urlencode($url))));
		return $youObj;
	}
	public function getYoutubechanel($url=null){
		if(!$url)
		return;
		preg_match('/\/user\/(\w+)?$/', $url, $match);
		$graph_url=sprintf('http://gdata.youtube.com/feeds/api/users/%s/uploads?alt=json', urlencode($match[1]));
		$user = json_decode(file_get_contents(utf8_encode($graph_url)));
		if(is_array($user->feed->entry))
		return $user->feed->entry;
	}
	
	public function updateLogo($data){
		$db=db::init();
		$result=$db->exec('
					UPDATE 
					z_site
					SET color="'.$data.'"
					WHERE z_site.id='.tools::int($_SESSION['Site']['id']).'
					AND z_site.userid='.tools::int($_SESSION['User']['id']).'
					');
	}
	public function getFiles(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  z_downloads.name,
		  z_downloads.extension,
		  CONCAT(
				    "/file/getdownloadfile/?f=",
				    z_downloads.id
				  ) AS url
		FROM
		  z_downloads 
		WHERE z_downloads.siteid = '.tools::int($_SESSION['Site']['id']).' 
		AND z_downloads.active=1
		ORDER BY z_downloads.sort
		');
		if($result)
		return $result;
	}
	public function getAdminFiles(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  z_downloads.id,
		  z_downloads.file_name as name,
		  z_downloads.name as `visible_name`,
		  z_downloads.extension,
		  CONCAT(
				    "/uploads/sites/",
				    z_downloads.siteid,
				    "/files/",
				    z_downloads.file_name
				  ) AS url,
		  IF(z_downloads.active > 0, 0, 1) hidden,
		  DATE_FORMAT(z_downloads.date_create, "%d.%m.%Y") as date
		FROM
		  z_downloads 
		WHERE z_downloads.siteid = '.tools::int($_SESSION['Site']['id']).' 
		  AND z_downloads.userid = '.tools::int($_SESSION['User']['id']).' 
		ORDER BY z_downloads.sort
		');
		if($result)
		return $result;
	}
	public function updateFiles($data, $deleted){
	$db=db::init();
	if(is_array($data))
	foreach($data as $k=>$bg){
		$bg['visible_name']=explode('.',$bg['visible_name']);
		$bg['visible_name']=$bg['visible_name'][0];
		if($bg['url'] && $bg['id']<1){
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['url']."";
				if(file_exists($tempfile)){
					$bg['url']=pathinfo($bg['url']);
					$newfile=md5(uniqid().microtime()).'.'.$bg['url']['extension'];
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/files/".$newfile."");
					if($bg['hidden']==1)
					$bg['hidden']=0;
					else
					$bg['hidden']=1;
					
					$result=$db->exec('
					INSERT INTO z_downloads 
					(name, file_name, extension, siteid, active, userid, sort)
					VALUES
					("'.tools::str($bg['visible_name']).'", "'.$newfile.'", "'.$bg['url']['extension'].'", '.tools::int($_SESSION['Site']['id']).', '.tools::int($bg['hidden']).', '.tools::int($_SESSION['User']['id']).', '.$k.')
					');
				}
		}
		
		
		if($bg['id']>0){
					if($bg['hidden']==1)
					$bg['hidden']=0;
					else
					$bg['hidden']=1;
					$result=$db->exec('
					UPDATE z_downloads
					SET name="'.tools::str($bg['visible_name']).'",
					active='.$bg['hidden'].',
					sort='.$k.'
					WHERE
					id='.$bg['id'].'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');	
		}
	$cnt++;
	
	}
	if(is_array($deleted)){
		$db=db::init();
		foreach($deleted as $del){
			$dellArr[$del['id']]=$del['id'];
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$del['url']))
				unlink($_SERVER['DOCUMENT_ROOT'].$del['url']);
		}
		if(count($dellArr)>0)
			$db->exec('
			DELETE FROM z_downloads WHERE id IN('.implode(',',$dellArr).')
			AND siteid='.tools::int($_SESSION['Site']['id']).'
			AND userid='.tools::int($_SESSION['User']['id']).'
			');		
	}
	
}
	public function getAdminVideos(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  z_video.id,
		  z_video.itemid,
		  z_video.name,
		  z_video.url,
		  z_video.previewid,
		  CONCAT(
		    "/uploads/sites/",
		    z_video.siteid,
		    "/img/1_",
		    z_videopreview.url
		  ) AS preview 
		FROM
		  z_video 
		  LEFT JOIN
		  z_videopreview 
		  ON z_videopreview.id = z_video.previewid 
		WHERE z_video.siteid = '.tools::int($_SESSION['Site']['id']).'  
		  AND z_video.userid = '.tools::int($_SESSION['User']['id']).'
		ORDER BY z_video.sort
		');
		if($result)
		return $result;
	}
	public function getVideo(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  z_video.id,
		  z_video.itemid,
		  z_video.name,
		  z_video.url,
		  z_video.socialid,
		  z_video.previewid,
		  if(z_videopreview.id>0,CONCAT(
				    "/uploads/sites/",
				    z_video.siteid,
				    "/img/1_",
				    z_videopreview.url
				  ),
				  CONCAT(
				    "/uploads/sites/",
				    z_video.siteid,
				    "/img/1_",
				    z_videopreview_default.url
				  )) AS `preview`
		FROM
		  z_video 
		  LEFT JOIN
		  z_videopreview 
		  ON z_videopreview.id = z_video.previewid 
		  LEFT JOIN
		  z_videopreview z_videopreview_default
		  ON z_videopreview_default.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_videopreview_default.major=1
		WHERE z_video.siteid = '.tools::int($_SESSION['Site']['id']).'
		ORDER BY z_video.sort DESC
		');
		if($result)
		return $result;
	}
	
	public function updateVideo($bg, $deleted){
	$db=db::init();
		$cnt=555;
		if($bg['preview'] && !$bg['previewid']){
				$bg['preview']=str_replace('1_', '', $bg['preview']);
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['preview']."";
				if(file_exists($tempfile)){
					$bg['preview']=pathinfo($bg['preview']);
					$newfile=md5(uniqid().microtime()).'.'.$bg['preview']['extension'];
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
					$result=$db->exec('
					INSERT INTO z_videopreview 
					(url, siteid, active, userid, major)
					VALUES
					("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).', 0)
					');
					$bg['previewid']=$db->lastInsertId();
				}
		}
		 if(!$bg['previewid'])
		 $bg['previewid']="NULL";
		if($bg['id']<1){
				$db->exec('
				INSERT INTO _items (datatypeid,siteid,userid) VALUES (10,'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).')');
				$itemid=$db->lastInsertId();
				$db->exec('
				INSERT INTO z_video 
				(socialid, name, active, previewid, sort, siteid, userid, url, itemid)
				VALUES
				('.$bg['socialid'].', "'.tools::str($bg['name']).'", 1, '.$bg['previewid'].', '.$cnt.', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', "'.tools::str($bg['url']).'", '.$itemid.')
				');
		}
		if($db->lastInsertId()>0)
		return true;
	
	
}
	
	public function updateVideos($data, $deleted){
	$db=db::init();
	$cnt=0;
	foreach($data as $k=>$bg){
		if($bg['preview'] && !$bg['previewid']){
			
				$bg['preview']=str_replace('1_', '', $bg['preview']);
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['preview']."";
				if(file_exists($tempfile)){
					$bg['preview']=pathinfo($bg['preview']);
					$newfile=md5(uniqid().microtime()).'.'.$bg['preview']['extension'];
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
					$result=$db->exec('
					INSERT INTO z_videopreview 
					(url, siteid, active, userid, major)
					VALUES
					("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).', 0)
					');
					$bg['previewid']=$db->lastInsertId();
				}
		}
		 if(!$bg['previewid'])
		 $bg['previewid']="NULL";
		 if(!$bg['socialid'])
		 {
		 $this->Social=new Social;
		 $this->socdata=$this->Social->findSocial($bg['url']);
		 	if($this->socdata['id'])
				$bg['socialid']=$this->socdata['id'];
			else 
				$bg['socialid']="NULL";
		 }
		 
		 
		
		if($bg['id']>0){
					$result=$db->exec('
					UPDATE z_video
					SET name="'.tools::str($bg['name']).'",
					url="'.tools::str($bg['url']).'",
					previewid='.$bg['previewid'].',
					socialid='.$bg['socialid'].',
					sort='.$cnt.'
					WHERE
					id='.tools::int($bg['id']).'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
		}
		if($bg['id']<1){
				$db->exec('
				INSERT INTO _items (datatypeid,siteid,userid) VALUES (10,'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).')');
				$itemid=$db->lastInsertId();
				$db->exec('
				INSERT INTO z_video 
				(name, active, previewid, sort, siteid, userid, url, socialid, itemid)
				VALUES
				("'.tools::str($bg['name']).'", 1, '.$bg['previewid'].', '.$cnt.', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', "'.tools::str($bg['url']).'", '.$bg['socialid'].','.$itemid.')
				');
		}
		
	$cnt++;
	
	}
	if(is_array($deleted)){
		foreach($deleted as $delbg){
		$deletedIdArr[$delbg['id']]=$delbg['id'];
		$db->exec('DELETE FROM _items WHERE id='.tools::int($delbg['itemid']).' AND siteid='.tools::int($_SESSION['Site']['id']).'
		AND userid='.tools::int($_SESSION['User']['id']).'');
		}
		if(count($deletedIdArr)>0){
		$db->exec('
		DELETE FROM z_video WHERE id IN('.implode(',',$deletedIdArr).') AND userid='.tools::int($_SESSION['User']['id']).'
		');
		}
	}
}
public function getMp3($id){
	$db=db::init();
		$result=$db->queryFetchRowAssoc('
		  SELECT 
		  CONCAT(
					"/uploads/sites/",
					z_mp3.siteid,
					"/mp3/",
					z_mp3.file_name
					) AS mp3,
		  z_mp3.file_name
		  FROM z_mp3
		  WHERE 
		  z_mp3.id='.tools::int($id).' AND z_mp3.siteid = '.tools::int($_SESSION['Site']['id']).' 
		');
		if($result)
		return $result;
}
public function getDownload($id){
	$db=db::init();
		$result=$db->queryFetchRowAssoc('
		  SELECT 
		  CONCAT(
					"/uploads/sites/",
					z_downloads.siteid,
					"/files/",
					z_downloads.file_name
					) AS file_name,
		  z_downloads.name,
		  z_downloads.extension
		  FROM z_downloads
		  WHERE 
		  z_downloads.id='.tools::int($id).' AND z_downloads.siteid = '.tools::int($_SESSION['Site']['id']).' 
		');
		if($result)
		return $result;
}
	
	
	
}
?>