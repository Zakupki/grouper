<?
require_once 'modules/base/models/Basemodel.php';

Class Radioshow Extends Basemodel {

public function getAdminRadioshows(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  COUNT(z_radioshow.id) AS cnt,
				  z_radioshowtype.id,
				  z_radioshowtype.name,
				  z_radioshowtype.active,
				  z_radioshowtype.station,
				  z_radioshowtype.time,
				  z_radioshowtype.link,
				  z_cover.id as coverid,
				  CONCAT("/uploads/sites/",z_radioshowtype.siteid,"/img/2_",z_cover.url) AS url
				FROM
				  z_radioshowtype 
				LEFT JOIN z_cover
				ON z_cover.id=z_radioshowtype.coverid
				LEFT JOIN
				z_radioshow 
				ON z_radioshow.radioshowtypeid = z_radioshowtype.id
				WHERE z_radioshowtype.siteid='.tools::int($_SESSION['Site']['id']).'
				GROUP BY z_radioshowtype.id
				ORDER BY z_radioshowtype.sort
				');
	if($result)
	return $result;
}
public function getRadioshows($siteid){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  COUNT(z_radioshow.id) AS cnt,
				  z_radioshowtype.id,
				  z_radioshowtype.name,
				  z_radioshowtype.active,
				  z_radioshowtype.station,
				  z_radioshowtype.time,
				  z_radioshowtype.link,
				  z_cover.id as coverid,
				  if(z_cover.id>0,CONCAT(
				    "/uploads/sites/",
				    z_radioshowtype.siteid,
				    "/img/2_",
				    z_cover.url
				  ),
				  CONCAT(
				    "/uploads/sites/",
				    z_radioshowtype.siteid,
				    "/img/2_",
				    z_cover_default.url
				  )) AS `url`
				FROM
				  z_radioshowtype 
				LEFT JOIN z_cover
				ON z_cover.id=z_radioshowtype.coverid
				LEFT JOIN
				z_cover z_cover_default
				ON z_cover_default.siteid = '.tools::int($siteid).' AND z_cover_default.major=1
				INNER JOIN
				z_radioshow 
				ON z_radioshow.radioshowtypeid = z_radioshowtype.id AND z_radioshow.active=1
				WHERE z_radioshowtype.siteid='.tools::int($siteid).' AND z_radioshowtype.active=1
				GROUP BY z_radioshowtype.id
				ORDER BY z_radioshowtype.sort DESC
				');
	if($result)
	return $result;
}
public function getsRadioshowCount($siteid){
	$db=db::init();
	$result=$db->queryFetchRow('
				SELECT 
				  COUNT(DISTINCT z_radioshowtype.id) AS cnt 
				FROM
				  z_radioshowtype 
				  INNER JOIN
				  z_radioshow 
				  ON z_radioshow.radioshowtypeid = z_radioshowtype.id 
				  AND z_radioshow.active = 1 
				WHERE z_radioshowtype.siteid = '.tools::int($siteid).' 
				  AND z_radioshowtype.active = 1
				');
	if($result['cnt'])
	return $result['cnt'];
}
public function getRadioshowInner($id,$siteid){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_radioshowtype.id as typeid,
				  z_radioshowtype.name AS radioshowtypename,
				  z_radioshow.id,
				  z_radioshow.name,
				  z_radioshow.number,
				  z_radioshow.fileid,
				  z_radioshow.active,
				  z_radioshow.show_date,
				  z_radioshow.download,
				  z_radioshow.stream,
				  z_radioshow.socialid,
				  z_mp3.id AS mp3id,
				  if(z_cover.id>0,CONCAT(
				    "/uploads/sites/",
				    z_radioshowtype.siteid,
				    "/img/2_",
				    z_cover.url
				  ),
				  CONCAT(
				    "/uploads/sites/",
				    z_radioshowtype.siteid,
				    "/img/2_",
				    z_cover_default.url
				  )) AS `url`,
				  CONCAT(
					"/uploads/sites/",
					z_radioshowtype.siteid,
					"/mp3/",
					z_mp3.file_name
					) AS mp3 
				FROM
				  z_radioshowtype 
				  LEFT JOIN
				  z_cover 
				  ON z_cover.id = z_radioshowtype.coverid
				  LEFT JOIN
				  z_cover z_cover_default
				  ON z_cover_default.siteid = '.tools::int($siteid).' AND z_cover_default.major=1
				  INNER JOIN
				  z_radioshow 
				  ON z_radioshow.radioshowtypeid = z_radioshowtype.id AND z_radioshow.active=1
				  LEFT JOIN
				  z_mp3 
				  ON z_mp3.id = z_radioshow.fileid 
				WHERE z_radioshowtype.id='.tools::int($id).' AND z_radioshowtype.siteid = '.tools::int($siteid).' AND z_radioshowtype.active=1
				ORDER BY z_radioshow.sort ASC
				');
	if($result)
	return $result;
}



public function getAdminRadioshowInner($typeid){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_radioshowtype.id AS typeid,
				  z_radioshow.id,
				  z_radioshow.name,
				  z_radioshow.number,
				  z_radioshow.fileid,
				  z_radioshow.active,
				  z_radioshowtype.coverid,
				  DATE_FORMAT(
				    z_radioshow.show_date,
				    "%d.%m.%Y"
				  ) AS show_date,
				  z_radioshow.download,
				  z_tracklist.id AS inplaylist
				FROM
				  z_radioshow 
				  INNER JOIN
				  z_radioshowtype 
				  ON z_radioshow.radioshowtypeid = z_radioshowtype.id
				  LEFT JOIN z_tracklist
				  ON z_tracklist.fileid=z_radioshow.fileid 
				WHERE z_radioshowtype.id='.tools::int($typeid).' AND z_radioshowtype.siteid = '.tools::int($_SESSION['Site']['id']).'
				ORDER BY z_radioshow.sort desc
				');
	if($result)
	return $result;
	
}



public function getAdminRadioshowList($radioshowtype){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  COUNT(z_radioshow.id) AS cnt,
				  z_radioshowtype.id,
				  z_radioshowtype.name,
				  z_radioshowtype.active,
				  z_radioshowtype.station,
				  z_radioshowtype.time,
				  z_radioshowtype.link,
				  z_cover.id as coverid,
				  CONCAT("/uploads/sites/",z_radioshowtype.siteid,"/img/2_",z_cover.url) AS url
				FROM
				  z_radioshowtype 
				LEFT JOIN z_cover
				ON z_cover.id=z_radioshowtype.coverid
				LEFT JOIN
				z_radioshow 
				ON z_radioshow.radioshowtypeid = z_radioshowtype.id
				WHERE z_radioshowtype.siteid='.tools::int($_SESSION['Site']['id']).'
				GROUP BY z_radioshowtype.id
				');
	if($result)
	return $result;
	
}
public function updateRadioshows($data, $deleted){
	$db=db::init();
	$cnt=0;
	if(is_array($data))
	foreach($data as $k=>$bg){
		if(!$bg['coverid'] && $bg['url']){
				$bg['url']=str_replace('2_', '', $bg['url']);
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['url']."";
				if(file_exists($tempfile)){
					$bg['url']=pathinfo($bg['url']);
					$newfile=md5(uniqid().microtime()).'.'.$bg['url']['extension'];
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
		if($bg['coverid']<1)
		$bg['coverid']='NULL';
		
		if($bg['id']>0){
					$result=$db->exec('
					UPDATE z_radioshowtype
					SET name="'.tools::str($bg['name']).'",
					station='.tools::nulstr($bg['station']).',
					link='.tools::nulstr($bg['link']).',
					time="'.tools::str($bg['time']).'",
					active='.tools::int($bg['active']).',
					coverid='.$bg['coverid'].',
					sort='.$k.'
					WHERE
					id='.$bg['id'].'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
		}
		if($bg['id']<1){
				$result=$db->exec('
				INSERT INTO z_radioshowtype 
				(name, station, link, time, active, coverid, sort, siteid, userid)
				VALUES
				("'.tools::str($bg['name']).'", "'.tools::str($bg['station']).'", "'.tools::str($bg['link']).'", "'.tools::str($bg['time']).'", '.tools::int($bg['active']).', '.$bg['coverid'].', '.$k.', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).')
				');		
			
		}
	$cnt++;
	}
	
	
	if(is_array($deleted))
	foreach($deleted as $delbg){
		if($delbg['id']>0){
				$result=$db->queryFetchAllAssoc('SELECT 
				  z_radioshow.id,
				  z_mp3.id as fileid,
				  CONCAT(
				    "/uploads/sites/",
				    z_mp3.siteid,
				    "/mp3/",
				    z_mp3.file_name
				  ) AS url 
				FROM
				  z_radioshow 
				  LEFT JOIN
				  z_mp3 
				  ON z_mp3.id = z_radioshow.fileid 
				WHERE z_radioshow.radioshowtypeid = '.$delbg['id'].'');
				
				foreach($result as $f){
					$relArr[$f['id']]=$f['id'];
					$fileidArr[$f['fileid']]=$f['fileid'];
					tools::delMp3($f['url']);
				}
				
				$db->exec('
				DELETE FROM 
				z_radioshowtype
				WHERE 
				z_radioshowtype.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_radioshowtype.userid='.tools::int($_SESSION['User']['id']).'
				AND z_radioshowtype.id='.$delbg['id'].'
				');
		}
	}
	if(count($fileidArr)>0){
		$db->exec('
				DELETE FROM 
				z_tracklist
				WHERE 
				siteid='.tools::int($_SESSION['Site']['id']).'
				AND userid='.tools::int($_SESSION['User']['id']).'
				AND fileid IN('.implode(',',$fileidArr).')
				');
	}
}
public function updateRadioshowinner($data,$deleted,$delplay){
	
	$db=db::init();
					if($delplay){
						$db->exec('
						DELETE FROM z_tracklist WHERE id IN('.implode(',',$delplay).') AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
					}
	$cnt=0;
	if(is_array($data))
	foreach($data as $k=>$bg){
		$bg['show_date']=explode('.', $bg['show_date']);
		if(!$bg['coverid'])
		$bg['coverid']='null';
		if($bg['id']>0){
					
					#Добавление в треклист
					if(tools::int($bg['inplaylist'])>0){
						$db->exec('
						UPDATE z_tracklist
						SET
						name="#'.tools::str($bg['number']).'",
						author="'.tools::str($bg['radioshowtypename']).'",
						remix="'.tools::str($bg['remix']).'",
						coverid='.$bg['coverid'].',
						fileid='.$bg['fileid'].',
						download='.tools::int($bg['download']).'						
						WHERE id='.$bg['inplaylist'].' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'
						');
					}
					elseif($bg['inplaylist']=='new'){
						
						$db->exec('
						INSERT INTO z_tracklist 
						(author, name, remix, coverid, fileid, siteid, userid, download)
						VALUES 
						("'.tools::str($bg['radioshowtypename']).'", "#'.tools::str($bg['number']).'", "'.tools::str($bg['remix']).'", '.$bg['coverid'].', '.$bg['fileid'].', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', '.tools::int($bg['download']).')
						');
					}
					$db->exec('
					UPDATE z_radioshow
					SET 
					name="'.tools::str($bg['name']).'",
					active='.tools::int($bg['active']).',
					number="'.tools::str($bg['number']).'",
					show_date="'.tools::getSqlDate($bg['show_date'][2],$bg['show_date'][1],$bg['show_date'][0]).'",
					download="'.tools::int($bg['download']).'",
					sort='.$cnt.'
					WHERE
					id='.tools::int($bg['id']).'
					');
		}
		
		if($bg['id']<1){
			if($bg['file']){
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['file']."";
				if(file_exists($tempfile)){
					$bg['file']=pathinfo($bg['file']);
					$newfile=md5(uniqid().microtime()).'.'.$bg['file']['extension'];
					if($bg['file']['extension']='mp3'){
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/mp3/".$newfile."");
					$result=$db->exec('
					INSERT INTO z_mp3 
					(file_name,siteid)
					VALUES
					("'.$newfile.'",'.tools::int($_SESSION['Site']['id']).')
					');
					$bg['fileid']=$db->lastInsertId();
					}
				}
			}		
				
				if($bg['fileid']<1 && strlen(trim($bg['stream']))>0){
					$bg['fileid']="NULL";
				}
				else {
					$bg['socialid']="NULL";
				}
				
			    $db->exec('
				INSERT INTO z_radioshow
				(name, radioshowtypeid, active, number, show_date, fileid, download, sort, stream, socialid)
				VALUES
				("'.tools::str($bg['name']).'", '.$bg['typeid'].', '.$bg['active'].', "'.tools::str($bg['number']).'", "'.tools::getSqlDate($bg['show_date'][2],$bg['show_date'][1],$bg['show_date'][0]).'", '.$bg['fileid'].', '.tools::int($bg['download']).', '.$cnt.',
				"'.tools::str($bg['stream']).'", '.tools::int($bg['socialid']).')');
				$bg['id']=$db->lastInsertId();
				#Добавление в треклист
				if($bg['inplaylist']=='new'){
					$db->exec('
					INSERT INTO z_tracklist 
					(author, name, remix, coverid, fileid, siteid, userid, download)
					VALUES 
					("'.tools::str($bg['radioshowtypename']).'", "#'.tools::str($bg['number']).'", "'.tools::str($bg['remix']).'", '.$bg['coverid'].', '.$bg['fileid'].', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', '.tools::int($bg['download']).')
					');
				}
		}
	$cnt++;
	
	}
	if(is_array($deleted))
	foreach($deleted as $delbg){
		if($delbg['id']>0){
				$db->exec('
				DELETE FROM z_musictypelink
				WHERE linkid='.tools::int($bg['id']).' AND datatypeid=6
				');
			
				$db->exec('
				DELETE FROM 
				z_radioshow
				WHERE 
				z_radioshow.id='.tools::int($delbg['id']).'
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
	}
}
public function getAdminRadioshowTypeInfo($typeid){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_radioshowtype.id AS typeid,
				  z_radioshowtype.name AS radioshowtypename,
				  if(z_radioshowtype.coverid>0,z_radioshowtype.coverid,"null") AS coverid,
				  if(z_cover.id>0,CONCAT(
				    "/uploads/sites/",
				    z_radioshowtype.siteid,
				    "/img/2_",
				    z_cover.url
				  ),
				  CONCAT(
				    "/uploads/sites/",
				    z_radioshowtype.siteid,
				    "/img/2_",
				    z_cover_default.url
				  )) AS `url`
				FROM
				  z_radioshowtype 
				  LEFT JOIN
				  z_cover 
				  ON z_cover.id = z_radioshowtype.coverid
				  LEFT JOIN
				  z_cover z_cover_default
				  ON z_cover_default.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_cover_default.major=1 
				WHERE z_radioshowtype.id = '.tools::int($typeid).'
				LIMIT 0,1
				');
	if($result)
	return $result;
}

}
?>