<?
require_once 'modules/base/models/Basemodel.php';

Class Track Extends Basemodel {

public function getTracks($start=0,$end=4){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_tracks.id,
				  z_tracks.name,
				  z_tracks.socialid,
				  z_tracks.stream,
				  z_tracks.download,
				  z_tracks.fileid,
				  z_tracks.date_start,
				  if(z_cover.id>0,CONCAT(
				    "/uploads/sites/",
				    z_cover.siteid,
				    "/img/4_",
				    z_cover.url
				  ),
				  CONCAT(
				    "/uploads/sites/",
				    z_cover_default.siteid,
				    "/img/4_",
				    z_cover_default.url
				  )) AS `cover`,
				  CONCAT(
					    "/uploads/sites/",
					    z_tracks.siteid,
					    "/mp3/",
					    z_mp3.file_name
					  ) AS mp3,
  				  z_mp3.id AS mp3id
				FROM
				  z_tracks 
				  LEFT JOIN
				  z_cover 
				  ON z_cover.id = z_tracks.coverid 
				  LEFT JOIN
				  z_cover z_cover_default
				  ON z_cover_default.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_cover_default.major=1
				  LEFT JOIN z_mp3
				  ON  z_mp3.id=z_tracks.fileid
				WHERE z_tracks.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_tracks.active=1
				ORDER BY z_tracks.date_create DESC
				LIMIT '.$start.','.$end.'
				');
	if($result){
	return $result;
	}
	
}
public function getTrackInner($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
	SELECT 
				  z_tracks.id,
				  z_tracks.active,
				  z_tracks.name,
				  MONTH(z_tracks.date_start) AS month,
		  		  DAYOFWEEK(z_tracks.date_start) AS dayinweek,
				  DAYOFMONTH(z_tracks.date_start) AS dayinmonth,
				  YEAR(z_tracks.date_start) AS year,
				  DATE_FORMAT(z_tracks.date_start,"%d.%m.%Y") AS date_start,
				  z_cover.id AS coverid,
				  CONCAT(
				    "/uploads/sites/",
				    z_cover.siteid,
				    "/img/4_",
				    z_cover.url) AS `cover`,
				  CONCAT(
					    "/uploads/sites/",
					    z_tracks.siteid,
					    "/mp3/",
					    z_mp3.file_name
					  ) AS mp3,
  				  z_mp3.id AS mp3id
				FROM
				  z_tracks 
				  LEFT JOIN
				  z_cover 
				  ON z_cover.id = z_tracks.coverid 
				  LEFT JOIN z_mp3
				  ON  z_mp3.id=z_tracks.fileid
				WHERE z_tracks.id = '.tools::int($id).'
	');
	if($result)
	return $result;
}
public function updateTrack($bg){
		$db=db::init();
		$bg['date_start']=explode('.', $bg['date_start']);
		if($bg['delete']){
		   if($bg['coverid']>0){
			   $db->exec('DELETE FROM z_cover WHERE id='.tools::int($bg['coverid']).' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
			   tools::delImg($bg['cover']);
		   }
		   if($bg['mp3id']>0){
		   	   $db->exec('DELETE FROM z_mp3 WHERE id='.tools::int($bg['mp3id']).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
			   tools::delMp3($bg['mp3']);
		   }
		   $db->exec('DELETE FROM z_tracks WHERE id='.tools::int($bg['id']).' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
		}
		
		if($bg['deleted']['coverid']>0){
			$db->exec('DELETE FROM z_cover WHERE id='.tools::int($bg['deleted']['coverid']).' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
			tools::delImg($bg['deleted']['cover']);
		}
	
		if(!$bg['mp3id'] && $bg['mp3']){
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['mp3']."";
				if(file_exists($tempfile)){
					$bg['mp3']=pathinfo($bg['mp3']);
					$newfile=md5(uniqid().microtime()).'.'.$bg['mp3']['extension'];
					if($bg['mp3']['extension']='mp3'){
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/mp3/".$newfile."");
					$result=$db->exec('
					INSERT INTO z_mp3 
					(file_name,siteid)
					VALUES
					("'.$newfile.'",'.tools::int($_SESSION['Site']['id']).')
					');
					$bg['mp3id']=$db->lastInsertId();
					}
				}
		}
		if(!$bg['mp3id'])
		$bg['mp3id']="NULL";
		
		if($bg['cover'] && !$bg['coverid']){
				$bg['cover']=str_replace('4_', '', $bg['cover']);
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['cover']."";
				if(file_exists($tempfile)){
					$bg['cover']=pathinfo($bg['cover']);
					$newfile=md5(uniqid().microtime()).'.'.$bg['cover']['extension'];
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
					$result=$db->exec('
					INSERT INTO z_cover 
					(url, siteid, active, userid, major)
					VALUES
					("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).', 0)
					');
					$bg['coverid']=$db->lastInsertId();
				}
		}
		 if(!$bg['coverid'])
		 $bg['coverid']="NULL";
		
		if($bg['id']>0){
					$db->exec('
					UPDATE z_tracks
					SET 
					name="'.tools::str($bg['name']).'",
					active="'.$bg['active'].'",
					coverid='.$bg['coverid'].',
					date_start="'.tools::getSqlDate($bg['date_start'][2],$bg['date_start'][1],$bg['date_start'][0]).'"
					WHERE
					id='.tools::int($bg['id']).'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
		}
		if($bg['id']<1){
			    $db->exec('
				INSERT INTO z_tracks 
				(name, active, siteid, userid, fileid, coverid, stream, socialid,date_start)
				VALUES
				("'.tools::str($bg['name']).'", '.$bg['active'].', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', '.$bg['mp3id'].', '.$bg['coverid'].', "'.tools::str($bg['stream']).'", '.tools::int($bg['socialid']).',"'.tools::getSqlDate($bg['date_start'][2],$bg['date_start'][1],$bg['date_start'][0]).'")
				');
				return $db->lastInsertId();
		}
		
	
	/*if(is_array($deleted))
	foreach($deleted as $delbg){
		if($delbg['id']>0){
				$db->exec('
				DELETE FROM z_musictypelink
				WHERE linkid='.tools::int($bg['id']).' AND datatypeid=7
				');
			
				$db->exec('
				DELETE FROM 
				z_tracks
				WHERE 
				z_tracks.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_tracks.userid='.tools::int($_SESSION['User']['id']).'
				AND z_tracks.id='.tools::int($delbg['id']).'
				');
				
				if($delbg['fileid']){
					$result=$db->queryFetchRowAssoc('
					SELECT CONCAT(
				    "/uploads/sites/",
				    z_mp3.siteid,
				    "/mp3/",
				    z_mp3.file_name
				  	) AS url
				  	FROM z_mp3
					WHERE id='.tools::int($delbg['fileid']).' AND siteid='.tools::int($_SESSION['Site']['id']).'
					');
					tools::delMp3($result['url']);
					$db->exec('
					DELETE FROM z_mp3
					WHERE id='.tools::int($delbg['fileid']).' AND siteid='.tools::int($_SESSION['Site']['id']).'
					');
				}
		}
	}*/
}
}
?>