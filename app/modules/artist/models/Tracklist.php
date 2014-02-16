<?
require_once 'modules/base/models/Basemodel.php';
require_once 'modules/artist/models/Social.php';

Class Tracklist Extends Basemodel {


public function getAdminTracklist(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_tracklist.id,
				  z_tracklist.author,
				  if(z_cover.id>0,CONCAT(
				    "/uploads/sites/",
				    z_tracklist.siteid,
				    "/img/2_",
				    z_cover.url
				  ),
				  CONCAT(
				    "/uploads/sites/",
				    z_tracklist.siteid,
				    "/img/2_",
				    z_cover_default.url
				  )) AS `cover`,
				  DATE_FORMAT(z_tracklist.date_start, "%d.%m.%Y") as date_start,
				  z_tracklist.label,
				  z_tracklist.name,
				  z_tracklist.remix,
				  z_tracklist.style 
				FROM
				  z_tracklist
				LEFT JOIN
				  z_cover 
				  ON z_cover.id = z_tracklist.coverid
				LEFT JOIN
				  z_cover z_cover_default
				  ON z_cover_default.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_cover_default.major=1
				WHERE z_tracklist.siteid = '.tools::int($_SESSION['Site']['id']).' 
				  AND z_tracklist.userid = '.tools::int($_SESSION['User']['id']).'
				ORDER BY z_tracklist.sort 
				');
	if($result){
	return $result;
	}
	
}

public function updateTracklist($data,$deleted,$autoplay){
	$db=db::init();
	$cnt=0;
	
	self::updateAutoplay($autoplay);
	
	
	if(is_array($data))
	foreach($data as $k=>$bg){
		if($bg['id']>0){
					$db->exec('
					UPDATE z_tracklist
					SET 
					sort='.$cnt.'
					WHERE
					id='.tools::int($bg['id']).'
					AND z_tracklist.siteid='.tools::int($_SESSION['Site']['id']).'
					AND z_tracklist.userid='.tools::int($_SESSION['User']['id']).'
					');
		}
	$cnt++;
	}
	if(is_array($deleted)){
		foreach($deleted as $delbg){
			if($delbg['id']>0)
			$delIdArr[$delbg['id']]=$delbg['id'];
		}
		if(is_array($delIdArr))
		$db->exec('
			DELETE FROM z_tracklist
			WHERE
			id IN('.implode(',',$delIdArr).') 
			AND z_tracklist.siteid='.tools::int($_SESSION['Site']['id']).'
			AND z_tracklist.userid='.tools::int($_SESSION['User']['id']).'
		');
	}
}
public function getTracklist($siteid){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_tracklist.author,
				  z_tracklist.name,
				  z_tracklist.download,
				  z_tracklist.remix,
				  z_mp3.id AS mp3id,
				  CONCAT(
					    "/uploads/sites/",
					    z_tracklist.siteid,
					    "/mp3/",
					    z_mp3.file_name
					  ) AS url, 
				  IF(z_cover.id>0,CONCAT(
				    "/uploads/sites/",
				    z_tracklist.siteid,
				    "/img/2_",
				    z_cover.url
				  ),
				  CONCAT(
				    "/uploads/sites/",
				    z_tracklist.siteid,
				    "/img/2_",
				    z_cover_default.url
				  )) AS `cover`,
				  DATE_FORMAT(z_tracklist.date_start, "%d.%m.%Y") as date_start
				FROM
				  z_tracklist
				LEFT JOIN z_mp3
				  ON  z_mp3.id=z_tracklist.fileid
				LEFT JOIN
				  z_cover 
				  ON z_cover.id = z_tracklist.coverid
				LEFT JOIN
				  z_cover z_cover_default
				  ON z_cover_default.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_cover_default.major=1
				WHERE z_tracklist.siteid = '.tools::int($siteid).' 
				ORDER BY z_tracklist.sort
				');
	if($result){
	return $result;
	}
	
}
public function getAutoplay(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  id,
				  autoplay
				FROM
				  z_site
				WHERE id = '.tools::int($_SESSION['Site']['id']).' 
				');
	if($result['id']>0){
	return $result['autoplay'];
	}
}
public function updateAutoplay($autoplay){
	$db=db::init();
	$_SESSION['Site']['autoplay']=$autoplay;
	$result=$db->queryFetchRowAssoc('
				UPDATE 
				  z_site
				SET autoplay='.tools::int($autoplay).'
				WHERE id = '.tools::int($_SESSION['Site']['id']).' 
				');
	return true;
}

}
?>