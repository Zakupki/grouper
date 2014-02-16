<?
require_once 'modules/base/models/Basemodel.php';
require_once 'modules/artist/models/Social.php';

Class Tracks Extends Basemodel {


public function getAdminTracks(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_tracks.id,
				  z_tracks.name,
				  z_tracks.active,
				  z_tracks.author,
				  z_tracks.remix,
				  z_tracks.download,
				  z_tracks.promocut,
				  z_tracks.sort,
				  z_tracks.fileid,
				  z_cover.id AS coverid,
				  CONCAT(
				    "/uploads/sites/",
				    z_cover.siteid,
				    "/img/2_",
				    z_cover.url
				  ) AS cover,
  				  z_musictype.name AS musictype,
				  z_musictype.id AS mtypeid,
				  z_tracklist.id AS inplaylist
				FROM
				  z_tracks 
				  LEFT JOIN
				  z_cover 
				  ON z_cover.id = z_tracks.coverid 
				  LEFT JOIN
				  z_musictypelink 
				  ON z_musictypelink.linkid = z_tracks.id 
				  AND z_musictypelink.datatypeid = 7 
				  LEFT JOIN
				  z_musictype 
				  ON z_musictype.id = z_musictypelink.musictypeid
				  LEFT JOIN z_tracklist
				  ON z_tracklist.fileid=z_tracks.fileid 
				WHERE z_tracks.siteid = '.tools::int($_SESSION['Site']['id']).' 
				  AND z_tracks.userid = '.tools::int($_SESSION['User']['id']).'  
				');
	if($result){
	foreach($result as $row){
		if($row['mtypeid'])
		$mtype[$row['id']][$row['mtypeid']]=$row['musictype'];
	}
	foreach($result as $r){
		if(is_array($mtype[$r['id']]))
		$r['musictype']=implode(',',$mtype[$r['id']]);
		$out[$r['id']]=$r;
	}
	function my_custom_sort_function($a, $b) {
	    return $a['sort'] - $b['sort'];
	}
	usort($out, "my_custom_sort_function");
	return $out;
	}
	
}

public function updateTracks($data,$deleted,$delplay){
	$db=db::init();
					if($delplay){
						$db->exec('
						DELETE FROM z_tracklist WHERE id IN('.implode(',',$delplay).') AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
					}
					
	
	$cnt=0;
	if(is_array($data))
	foreach($data as $k=>$bg){
		if(!$bg['fileid'] && $bg['url']){
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['url']."";
				if(file_exists($tempfile)){
					$bg['url']=pathinfo($bg['url']);
					$newfile=md5(uniqid().microtime()).'.'.$bg['url']['extension'];
					if($bg['url']['extension']='mp3'){
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
		if($bg['cover'] && !$bg['coverid']){
				$bg['cover']=str_replace('2_', '', $bg['cover']);
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
					#Добавление в треклист
					if(tools::int($bg['inplaylist'])>0){
						$db->exec('
						UPDATE z_tracklist
						SET
						name="'.tools::str($bg['name']).'",
						author="'.tools::str($bg['author']).'",
						remix="'.tools::str($bg['remix']).'",
						style="'.tools::str($bg['musictype']).'",
						coverid='.$bg['coverid'].',
						fileid='.$bg['fileid'].',
						download='.$bg['download'].'
						WHERE id='.$bg['inplaylist'].' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'
						');
					}
					elseif($bg['inplaylist']=='new'){
						$db->exec('
						INSERT INTO z_tracklist 
						(author, name, remix, style, coverid, fileid, siteid, userid, download)
						VALUES 
						("'.tools::str($bg['author']).'", "'.tools::str($bg['name']).'", "'.tools::str($bg['remix']).'", "'.tools::str($bg['musictype']).'", '.$bg['coverid'].', '.$bg['fileid'].', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', '.$bg['download'].')
						');
					}
					
					
					$db->exec('
					DELETE FROM z_musictypelink
					WHERE linkid='.tools::int($bg['id']).' AND datatypeid=7
					');
					
					$musictypeArr=array();
					$musictypeArr=explode(',',trim($bg['musictype']));
					foreach($musictypeArr as $mtype){
						if(strlen(trim($mtype))>0){
							$result=$db->queryFetchRowAssoc('
							SELECT id from z_musictype
							where name="'.tools::str(trim($mtype)).'"
							');
							if($result['id']>0){
							$bg['musictypeid']=$result['id'];
							}
							else{
							$db->exec('
							INSERT INTO z_musictype 
							(name)
							VALUES
							("'.tools::str(trim($mtype)).'")
							');
							$bg['musictypeid']=$db->lastInsertId();
							}
							if($bg['musictypeid']>0){
							$db->exec('
							INSERT INTO z_musictypelink 
							(musictypeid, linkid, datatypeid)
							VALUES
							('.$bg['musictypeid'].','.$bg['id'].', 7)
							');
							}
						}
					}
					$db->exec('
					UPDATE z_tracks
					SET 
					name="'.tools::str($bg['name']).'",
					active="'.$bg['active'].'",
					remix="'.tools::str($bg['remix']).'",
					author="'.tools::str($bg['author']).'",
					download='.$bg['download'].',
					promocut='.$bg['promocut'].',
					sort='.$cnt.',
					coverid='.$bg['coverid'].'
					WHERE
					id='.tools::int($bg['id']).'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
		}
		if($bg['id']<1){
				if($bg['fileid']<1 && strlen(trim($bg['stream']))>0){
					$bg['fileid']="NULL";
				}
				else {
					$bg['socialid']="NULL";
				}
			    $db->exec('
				INSERT INTO z_tracks 
				(name, active, remix, author, download, promocut, siteid, userid, sort, fileid, coverid, stream, socialid)
				VALUES
				("'.tools::str($bg['name']).'", 
				'.$bg['active'].', 
				"'.tools::str($bg['remix']).'", 
				"'.tools::str($bg['author']).'", 
				'.tools::int($bg['download']).', 
				'.tools::int($bg['promocut']).', 
				'.tools::int($_SESSION['Site']['id']).', 
				'.tools::int($_SESSION['User']['id']).', 
				'.$cnt.', 
				'.$bg['fileid'].', 
				'.$bg['coverid'].', 
				"'.tools::str($bg['stream']).'", 
				'.$bg['socialid'].')
				');
				$bg['id']=$db->lastInsertId();
				$musictypeArr=array();
				$bg['style']=$bg['musictype'];
				
				#Добавление в треклист
				if($bg['inplaylist']=='new'){
					$db->exec('
					INSERT INTO z_tracklist 
					(author, name, remix, style, coverid, fileid, siteid, userid, download)
					VALUES 
					("'.tools::str($bg['author']).'", "'.tools::str($bg['name']).'", "'.tools::str($bg['remix']).'", "'.tools::str($bg['musictype']).'", '.$bg['coverid'].', '.$bg['fileid'].', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).',  '.$bg['download'].')
					');
				}
				
				
				$musictypeArr=explode(',',trim($bg['musictype']));
				
				foreach($musictypeArr as $mtype){
					if(strlen(trim($mtype))>0){
						$result=$db->queryFetchRowAssoc('
						SELECT id from z_musictype
						where name="'.tools::str(trim($mtype)).'"
						');
						if($result['id']>0){
						$bg['musictypeid']=$result['id'];
						}
						else{
						$db->exec('
						INSERT INTO z_musictype 
						(name)
						VALUES
						("'.tools::str(trim($mtype)).'")
						');
						$bg['musictypeid']=$db->lastInsertId();
						}
						if($bg['musictypeid']>0){
						$db->exec('
						INSERT INTO z_musictypelink 
						(musictypeid, linkid, datatypeid)
						VALUES
						('.$bg['musictypeid'].','.$bg['id'].', 7)
						');
						}
					}
				}
				
		}
	$cnt++;
	
	}
	if(is_array($deleted))
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
	}
}
public function getTracks($siteid){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_tracks.id,
				  z_tracks.name,
				  z_tracks.author,
				  z_tracks.remix,
				  z_tracks.download,
				  z_tracks.promocut,
				  z_tracks.sort,
				  z_tracks.fileid,
				  z_tracks.date_create,
				  z_tracks.stream,
				  z_tracks.socialid,
				  if(z_cover.id>0,CONCAT(
				    "/uploads/sites/",
				    z_cover.siteid,
				    "/img/2_",
				    z_cover.url
				  ),
				  CONCAT(
				    "/uploads/sites/",
				    z_cover_default.siteid,
				    "/img/2_",
				    z_cover_default.url
				  )) AS `cover`,
				  CONCAT(
					    "/uploads/sites/",
					    z_tracks.siteid,
					    "/mp3/",
					    z_mp3.file_name
					  ) AS mp3,
  				  z_musictype.name AS musictype,
				  z_musictype.id AS mtypeid,
				  z_mp3.id AS mp3id
				FROM
				  z_tracks 
				  LEFT JOIN
				  z_cover 
				  ON z_cover.id = z_tracks.coverid 
				  LEFT JOIN
				  z_cover z_cover_default
				  ON z_cover_default.siteid = '.tools::int($siteid).' AND z_cover_default.major=1
				  LEFT JOIN
				  z_musictypelink 
				  ON z_musictypelink.linkid = z_tracks.id 
				  AND z_musictypelink.datatypeid = 7 
				  LEFT JOIN
				  z_musictype 
				  ON z_musictype.id = z_musictypelink.musictypeid
				  LEFT JOIN z_mp3
				  ON  z_mp3.id=z_tracks.fileid
				WHERE z_tracks.siteid = '.tools::int($siteid).' AND z_tracks.active=1
				');
	if($result){
	foreach($result as $row){
		if($row['mtypeid'])
		$mtype[$row['id']][$row['mtypeid']]=$row['musictype'];
	}
	foreach($result as $r){
		if(is_array($mtype[$r['id']]))
		$r['musictype']=implode(',',$mtype[$r['id']]);
		$out[$r['id']]=$r;
	}
	function my_custom_sort_function($a, $b) {
	    return $a['sort'] - $b['sort'];
	}
	usort($out, "tools::sortDesc");
	return $out;
	}
	
}
}
?>