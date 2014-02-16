<?
require_once 'modules/base/models/Basemodel.php';
require_once 'modules/artist/models/Social.php';

Class Compilation Extends Basemodel {


public function getAdminCompilation(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_compilation.id,
				  z_compilation.name,
				  z_compilation.active,
				  z_compilation.author,
				  z_compilation.download,
				  z_compilation.sort,
				  z_compilation.fileid,
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
				  z_compilation 
				  LEFT JOIN
				  z_cover 
				  ON z_cover.id = z_compilation.coverid 
				  LEFT JOIN
				  z_musictypelink 
				  ON z_musictypelink.linkid = z_compilation.id 
				  AND z_musictypelink.datatypeid = 8 
				  LEFT JOIN
				  z_musictype 
				  ON z_musictype.id = z_musictypelink.musictypeid
				  LEFT JOIN z_tracklist
				  ON z_tracklist.fileid=z_compilation.fileid 
				WHERE z_compilation.siteid = '.tools::int($_SESSION['Site']['id']).' 
				  AND z_compilation.userid = '.tools::int($_SESSION['User']['id']).'  
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

public function updateCompilation($data,$deleted,$delplay){
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
		if($bg['coverid']<1)
		$bg['coverid']="NULL";
		if($bg['id']>0){
					
					#Добавление в треклист
					if(tools::int($bg['inplaylist'])>0){
						$db->exec('
						UPDATE z_tracklist
						SET
						name="'.tools::str($bg['name']).'",
						author="'.tools::str($bg['author']).'",
						style="'.tools::str($bg['musictype']).'",
						coverid='.$bg['coverid'].',
						fileid='.tools::int($bg['fileid']).',
						download='.tools::int($bg['download']).'
						WHERE id='.$bg['inplaylist'].' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'
						');
					}
					elseif($bg['inplaylist']=='new'){
						$db->exec('
						INSERT INTO z_tracklist 
						(author, name, style, coverid, fileid, siteid, userid, download)
						VALUES 
						("'.tools::str($bg['author']).'", "'.tools::str($bg['name']).'", "'.tools::str($bg['musictype']).'", '.$bg['coverid'].', '.tools::int($bg['fileid']).', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', '.tools::int($bg['download']).')
						');
					}
					
					$db->exec('
					DELETE FROM z_musictypelink
					WHERE linkid='.tools::int($bg['id']).' AND datatypeid=8
					');
					
					$musictypeArr=array();
					$musictypeArr=explode(',',trim($bg['musictype']));
					foreach($musictypeArr as $mtype){
						if(strlen(trim($mtype))>0){
							$result=$db->queryFetchRowAssoc('
							SELECT id from z_musictype
							where name="'.tools::str($mtype).'"
							');
							if($result['id']>0){
							$bg['musictypeid']=$result['id'];
							}
							else{
							$db->exec('
							INSERT INTO z_musictype 
							(name)
							VALUES
							("'.tools::str($mtype).'")
							');
							$bg['musictypeid']=$db->lastInsertId();
							}
							if($bg['musictypeid']>0){
							$db->exec('
							INSERT INTO z_musictypelink 
							(musictypeid, linkid, datatypeid)
							VALUES
							('.$bg['musictypeid'].','.$bg['id'].', 8)
							');
							}
						}
					}
					$db->exec('
					UPDATE z_compilation
					SET 
					name="'.tools::str($bg['name']).'",
					active="'.tools::int($bg['active']).'",
					author="'.tools::str($bg['author']).'",
					download='.tools::int($bg['download']).',
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
				INSERT INTO z_compilation 
				(name, active, author, download, siteid, userid, sort, fileid, coverid, stream, socialid)
				VALUES
				("'.tools::str($bg['name']).'", '.tools::str($bg['active']).', "'.tools::str($bg['author']).'", '.tools::int($bg['download']).', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', '.$cnt.', '.$bg['fileid'].', '.$bg['coverid'].', "'.tools::str($bg['stream']).'", '.$bg['socialid'].')
				');
				$bg['id']=$db->lastInsertId();
				#Добавление в треклист
				if($bg['inplaylist']=='new'){
					$db->exec('
					INSERT INTO z_tracklist 
					(author, name, style, coverid, fileid, siteid, userid, download)
					VALUES 
					("'.tools::str($bg['author']).'", "'.tools::str($bg['name']).'", "'.tools::str($bg['musictype']).'", '.$bg['coverid'].', '.tools::int($bg['fileid']).', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', '.tools::int($bg['download']).')
					');
				}
				$musictypeArr=array();
				$musictypeArr=explode(',',trim($bg['musictype']));
				foreach($musictypeArr as $mtype){
					if(strlen(trim($mtype))>0){
						$result=$db->queryFetchRowAssoc('
						SELECT id from z_musictype
						where name="'.tools::str($mtype).'"
						');
						if($result['id']>0){
						$bg['musictypeid']=$result['id'];
						}
						else{
						$db->exec('
						INSERT INTO z_musictype 
						(name)
						VALUES
						("'.trim($mtype).'")
						');
						$bg['musictypeid']=$db->lastInsertId();
						}
						if($bg['musictypeid']>0){
						$db->exec('
						INSERT INTO z_musictypelink 
						(musictypeid, linkid, datatypeid)
						VALUES
						('.$bg['musictypeid'].','.$bg['id'].', 8)
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
				WHERE linkid='.tools::int($bg['id']).' AND datatypeid=8
				');
			
				$db->exec('
				DELETE FROM 
				z_compilation
				WHERE 
				z_compilation.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_compilation.userid='.tools::int($_SESSION['User']['id']).'
				AND z_compilation.id='.tools::int($delbg['id']).'
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
public function getCompilation(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_compilation.id,
				  z_compilation.name,
				  z_compilation.active,
				  z_compilation.author,
				  z_compilation.download,
				  z_compilation.inplaylist,
				  z_compilation.sort,
				  z_compilation.fileid,
				  z_compilation.date_create,
				  z_compilation.stream,
				  z_compilation.socialid,
				  z_cover.id AS coverid,
				  z_mp3.id AS mp3id,
				  if(z_cover.id>0,CONCAT(
				    "/uploads/sites/",
				    z_compilation.siteid,
				    "/img/2_",
				    z_cover.url
				  ),
				  CONCAT(
				    "/uploads/sites/",
				    z_compilation.siteid,
				    "/img/2_",
				    z_cover_default.url
				  )) AS `cover`,				  
				  CONCAT(
					    "/uploads/sites/",
					    z_compilation.siteid,
					    "/mp3/",
					    z_mp3.file_name
					  ) AS mp3,
  				  z_musictype.name AS musictype,
				  z_musictype.id AS mtypeid
				FROM
				  z_compilation 
				  LEFT JOIN
				  z_cover 
				  ON z_cover.id = z_compilation.coverid
				  LEFT JOIN
				  z_cover z_cover_default
				  ON z_cover_default.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_cover_default.major=1
				  LEFT JOIN
				  z_musictypelink 
				  ON z_musictypelink.linkid = z_compilation.id 
				  AND z_musictypelink.datatypeid = 8 
				  LEFT JOIN
				  z_musictype 
				  ON z_musictype.id = z_musictypelink.musictypeid 
				  LEFT JOIN z_mp3
				  ON  z_mp3.id=z_compilation.fileid
				WHERE z_compilation.siteid = '.tools::int($_SESSION['Site']['id']).'
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
}
?>