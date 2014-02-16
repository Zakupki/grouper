<?
require_once 'modules/base/models/Basemodel.php';
require_once 'modules/artist/models/Social.php';

Class Release Extends Basemodel {


public function getAdminReleaseType(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  COUNT(z_release.id) AS cnt,
				  z_releasetype.id,
				  z_releasetype.name,
				  z_releasetype.active,
				  z_releasetype.author,
				  z_releasetype.sort,
				  z_releasetype.itemid,
				  IF(z_cover.id>0, 0, 1) AS majorcover,
				  MD5(CONCAT(z_releasetype.sort,"/",z_releasetype.active)) AS compare,
				  MD5(CONCAT(z_releasetype.name,"/",
				  			 z_releasetype.author,"/",
							 DATE_FORMAT(z_releasetype.date_start, "%d.%m.%Y"),"/",
							 z_releasetype.label,"/",
							 IF(z_cover.id>0,z_cover.id,0)
							 )) AS compare2,
				  z_release.remix,
				  DATE_FORMAT(z_releasetype.date_start, "%d.%m.%Y") as date_start,
				  z_releasetype.label,
				  z_cover.id AS coverid,
				  if(z_cover.id>0,CONCAT(
				    "/uploads/sites/",
				    z_releasetype.siteid,
				    "/img/2_",
				    z_cover.url
				  ),
				  CONCAT(
				    "/uploads/sites/",
				    z_releasetype.siteid,
				    "/img/2_",
				    z_cover_default.url
				  )) AS `url` 
				FROM
				  z_releasetype 
				  LEFT JOIN
				  z_cover 
				  ON z_cover.id = z_releasetype.coverid 
				  LEFT JOIN
				  z_cover z_cover_default
				  ON z_cover_default.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_cover_default.major=1
				  LEFT JOIN
				  z_release
				  ON z_release.releasetypeid = z_releasetype.id 
				WHERE z_releasetype.siteid = '.tools::int($_SESSION['Site']['id']).'
				GROUP BY z_releasetype.id 
				ORDER BY z_releasetype.sort
				');
	$mtyperesult=$db->queryFetchAllAssoc('
				SELECT 
				  z_musictype.name,
				  z_releasetype.id AS releaseid,
				  z_musictype.id 
				FROM
				  z_releasetype
				INNER JOIN z_release
				ON z_release.releasetypeid=z_releasetype.id
				INNER JOIN z_musictypelink
				ON z_musictypelink.linkid=z_release.id
				AND z_musictypelink.datatypeid=6
				INNER JOIN z_musictype
				ON z_musictype.id=z_musictypelink.musictypeid
				WHERE z_releasetype.siteid = '.tools::int($_SESSION['Site']['id']).'
				');
	if(is_array($mtyperesult))
	foreach($mtyperesult as $mt){
		if(count($mtypearr[$mt['releaseid']])<2)
		$mtypearr[$mt['releaseid']][$mt['id']]=$mt['name'];
	}
	 
	if(is_array($result))
	foreach($result as $row){
	if($mtypearr[$row['id']])
	$row['musictypes']=implode(',',$mtypearr[$row['id']]);
	$out[$row['id']]=$row;
	}
	
	function my_custom_sort_function($a, $b) {
	    return $a['sort'] - $b['sort'];
	}
	if(is_array($out))
	usort($out, "my_custom_sort_function");
		
	if($out)
	return $out;
}

public function getAdminReleaseTypeLinks($typeid){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				 z_release_links.id,
				 z_release_links.socialid,
				 z_release_links.releasetypeid,
				 z_release_links.url,
				 md5(z_release_links.url) AS compare
				FROM
				  z_releasetype 
				  INNER JOIN
				  z_release_links 
				  ON z_release_links.releasetypeid = z_releasetype.id 
				WHERE z_release_links.releasetypeid='.tools::int($typeid).' AND z_releasetype.siteid = '.tools::int($_SESSION['Site']['id']).'');
	if($result)
	return $result;
}

public function updateReleaseType($data, $deleted){
	$db=db::init();
	$cnt=0;
	foreach($data as $k=>$bg){
		if($bg['id']>0){
					if(md5($cnt."/".$bg['active'])!=$bg['compare']){
						$result=$db->exec('
						UPDATE z_releasetype
						SET
						active='.$bg['active'].',
						sort='.$cnt.'
						WHERE
						id='.tools::int($bg['id']).'
						AND siteid='.tools::int($_SESSION['Site']['id']).'
						AND userid='.tools::int($_SESSION['User']['id']).'
						');
					}
		}
	$cnt++;
	}
	if(is_array($deleted))
	foreach($deleted as $delbg){
		if($delbg['id']>0){
				$result=$db->queryFetchAllAssoc('SELECT 
				  z_release.id,
				  z_mp3.id as fileid,
				  CONCAT(
				    "/uploads/sites/",
				    z_mp3.siteid,
				    "/mp3/",
				    z_mp3.file_name
				  ) AS url 
				FROM
				  z_release 
				  LEFT JOIN
				  z_mp3 
				  ON z_mp3.id = z_release.fileid 
				WHERE z_release.releasetypeid = '.$delbg['id'].'');
				
				foreach($result as $f){
					$relArr[$f['id']]=$f['id'];
					if($f['fileid']>0){
						$fileidArr[$f['fileid']]=$f['fileid'];
						tools::delMp3($f['url']);
					}
				}
				if(is_array($relArr)){
					$db->exec('
					DELETE FROM 
					z_musictypelink
					WHERE 
					linkid IN ('.implode(',',$relArr).') AND datatypeid=6
					');
				}
				
				$db->exec('
				DELETE FROM 
				z_releasetype
				WHERE 
				z_releasetype.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_releasetype.userid='.tools::int($_SESSION['User']['id']).'
				AND z_releasetype.id='.tools::int($delbg['id']).'
				');
				
				$db->exec('
				DELETE FROM 
				_items
				WHERE 
				siteid='.tools::int($_SESSION['Site']['id']).'
				AND userid='.tools::int($_SESSION['User']['id']).'
				AND id='.tools::int($delbg['itemid']).'
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
public function updateReleaseTypeInner($data){
	$db=db::init();
	$this->Social=new Social;
	    $date_start=$data['date_start'];
		$data['date_start']=explode('.', $data['date_start']);
		
		if($data['url'] && !$data['coverid'] && !$data['majorcover']){
				$data['url']=str_replace('2_', '', $data['url']);
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['url']."";
				if(file_exists($tempfile)){
					$data['url']=pathinfo($data['url']);
					$newfile=md5(uniqid().microtime()).'.'.$data['url']['extension'];
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
					$result=$db->exec('
					INSERT INTO z_cover 
					(url, siteid, active, userid, major)
					VALUES
					("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).', 0)
					');
					$data['coverid']=$db->lastInsertId();
				}
		}
		if(!$data['coverid'])
		$data['coverid']="NULL";
		
		if($data['id']>0){
					
					$linkidArr=array();
					if(count($data['links'])>0){
						foreach($data['links'] as $link){
							if($link['url']){
							   if(md5($link['url'])==$link['compare']){
							   		$linkidArr[$link['id']]=$link['id'];
							   }
							   else {
							   		$socialid=$this->Social->findSocial($link['url']);
							   		
									if($link['id']){
								   		if($socialid){
											$stmt=$db->prepare("UPDATE z_release_links
											set releasetypeid=?,socialid=?,url=? WHERE id=?");
											$stmt->execute(array($data['id'],$socialid['id'],tools::str($link['url']),$link['id']));
										}
									}
									else{
										if($socialid){
											$stmt=$db->prepare("INSERT INTO z_release_links
											(releasetypeid,socialid,url) VALUES (?,?,?)");
											$stmt->execute(array($data['id'],$socialid['id'],tools::str($link['url'])));
											$link['id']=$db->lastInsertId();
										}
									}
									$linkidArr[$link['id']]=$link['id'];
							   }						   
							   								
							  
							}
						}
						$stmt=$db->prepare("DELETE FROM z_release_links
						WHERE releasetypeid=? AND id not in(".implode(',',$linkidArr).")");
						$stmt->execute(array(tools::int($data['id'])));
					}
					else{
						$stmt=$db->prepare("DELETE FROM z_release_links
						WHERE releasetypeid=?");
						$stmt->execute(array(tools::int($data['id'])));
					}
					if($data['coverid']<1)
					$coverid=0;
					else
					$coverid=$data['coverid'];
					
					if($data['compare2']!=md5(tools::str($data['name']).'/'.tools::str($data['author']).'/'.$date_start.'/'.tools::str($data['label']).'/'.$coverid)){
						$result=$db->exec('
						UPDATE z_releasetype
						SET 
						name="'.tools::str($data['name']).'",
						author="'.tools::str($data['author']).'",
						label="'.tools::str($data['label']).'",
						coverid='.$data['coverid'].',
						date_start="'.tools::getSqlDate($data['date_start'][2],$data['date_start'][1],$data['date_start'][0]).'"
						WHERE
						id='.tools::int($data['id']).'
						AND siteid='.tools::int($_SESSION['Site']['id']).'
						AND userid='.tools::int($_SESSION['User']['id']).'
						');
					}
					
		}
		if($data['id']<1){
				$db->exec('
				INSERT INTO _items 
				(datatypeid, siteid, userid)
				VALUES
				(6,'.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).')
				');
				$data['itemid']=$db->lastInsertId();
				
			    $db->exec('
				INSERT INTO z_releasetype 
				(sort, itemid, name, author, label, active, coverid, siteid, userid, date_start, recommend)
				VALUES
				('.$data['sort'].', '.$data['itemid'].', "'.tools::str($data['name']).'", "'.tools::str($data['author']).'", "'.tools::str($data['label']).'", 1, '.$data['coverid'].', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', "'.tools::getSqlDate($data['date_start'][2],$data['date_start'][1],$data['date_start'][0]).'", '.tools::int($_SESSION['Site']['recommend']).')
				');
				$data['id']=$db->lastInsertId();
				
				if(is_array($data['links'])){
						
						foreach($data['links'] as $link){
							if(!$link['socialid'] && $link['url']){
									$socialid=$this->Social->findSocial($link['url']);
									if($socialid)
									$db->exec('
									INSERT INTO z_release_links
									(releasetypeid,socialid,url)
									VALUES ('.$data['id'].','.$socialid['id'].',"'.tools::str($link['url']).'")
									');
							}
									
						}
				}
				if($data['id']>0)
				return $data['id'];
				
		}
}
public function getAdminReleaseInner($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_release.id,
				  z_release.name,
				  z_release.active,
				  z_release.author,
				  z_release.remix,
				  z_release.promocut,
				  z_release.download,
				  z_release.releasetypeid,
				  z_release.sort,
				  z_releasetype.coverid,
				  z_release.fileid,
				  MD5(CONCAT(z_release.sort,"/",z_release.active)) AS compare,
				  z_releasetype.label,
				  DATE_FORMAT(
				    z_releasetype.date_start,
				    "%d.%m.%Y"
				  ) AS date_start,
				  z_musictype.id as mtypeid,
				  z_musictype.name AS musictype,
				  z_tracklist.id AS inplaylist 
				FROM
				  z_release 
				  INNER JOIN
				  z_releasetype 
				  ON z_releasetype.id = z_release.releasetypeid 
				  LEFT JOIN
				  z_musictypelink 
				  ON z_musictypelink.linkid = z_release.id 
				  AND z_musictypelink.datatypeid = 6 
				  LEFT JOIN
				  z_musictype 
				  ON z_musictype.id = z_musictypelink.musictypeid
				  LEFT JOIN z_tracklist
				  ON z_tracklist.fileid=z_release.fileid
				WHERE z_release.releasetypeid = '.tools::int($id).' 
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

public function getAdminReleaseTypeInfo($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_releasetype.name,
				  z_releasetype.label,
				  z_releasetype.itemid,
				  if(z_releasetype.coverid>0,z_releasetype.coverid,"null") AS coverid,
				  if(z_cover.id>0,CONCAT(
				    "/uploads/sites/",
				    z_releasetype.siteid,
				    "/img/2_",
				    z_cover.url
				  ),
				  CONCAT(
				    "/uploads/sites/",
				    z_releasetype.siteid,
				    "/img/2_",
				    z_cover_default.url
				  )) AS `url`,
				  DATE_FORMAT(
				    z_releasetype.date_start,
				    "%d.%m.%Y"
				  ) AS date_start,
				  z_releasetype.author
				FROM
				  z_releasetype 
				  LEFT JOIN
				  z_cover 
				  ON z_cover.id = z_releasetype.coverid
				  LEFT JOIN
				  z_cover z_cover_default
				  ON z_cover_default.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_cover_default.major=1
				WHERE z_releasetype.id='.tools::int($id).'
				AND z_releasetype.siteid = '.tools::int($_SESSION['Site']['id']).'
				');
	if($result)
	return $result;
}

public function getAdminReleaseInfo($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_release.id,
				  z_release.name,
				  z_release.author,
				  z_release.remix,
				  z_release.releasetypeid,
				  6 AS datatypeid,
				  CONCAT(
				    "/uploads/sites/",
				    z_releasetype.siteid,
				    "/img/2_",
				    z_cover.url
				  ) AS url,
				  z_releasetype.label,
				  DATE_FORMAT(
				    z_releasetype.date_start,
				    "%d.%m.%Y"
				  ) AS date_start
				FROM
				  z_release 
				  INNER JOIN
				  z_releasetype 
				  ON z_releasetype.id = z_release.releasetypeid 
				  LEFT JOIN
				  z_cover 
				  ON z_cover.id = z_releasetype.coverid 
				WHERE z_release.id = '.tools::int($id).' 
				');
	if($result)
	return $result;
}
public function getAdminRelByItem($itemid){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_release.id,
				  z_release.name,
				  z_release.author,
				  z_release.remix,
				  z_release.releasetypeid,
				  z_item_track.id AS linkid,
				  z_item_track.datatypeid,
				  CONCAT(
				    "/uploads/sites/",
				    z_releasetype.siteid,
				    "/img/2_",
				    z_cover.url
				  ) AS url,
				  z_releasetype.label,
				  DATE_FORMAT(
				    z_releasetype.date_start,
				    "%d.%m.%Y"
				  ) AS date_start 
				FROM
				  z_item_track 
				  INNER JOIN
				  z_release 
				  ON z_release.id = z_item_track.trackid 
				  INNER JOIN
				  z_releasetype 
				  ON z_releasetype.id = z_release.releasetypeid 
				  LEFT JOIN
				  z_cover 
				  ON z_cover.id = z_releasetype.coverid 
				WHERE z_item_track.itemid = '.tools::int($itemid).'
				');
	if($result)
	return $result;
}

public function updateRelease($data,$deleted,$delplay){
	$db=db::init();
	$cnt=0;
	if(is_array($data))
	foreach($data as $k=>$bg){
		if($bg['id']>0 && md5($cnt.'/'.$bg['active'])!=$bg['compare']){
			$stmt=$db->prepare("UPDATE z_release
			SET active=?,sort=? WHERE id=? AND userid=? AND siteid=?");
			$stmt->execute(array($bg['active'],$cnt,$bg['id'],tools::int($_SESSION['User']['id']),tools::int($_SESSION['Site']['id'])));		
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
				z_release
				WHERE 
				z_release.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_release.userid='.tools::int($_SESSION['User']['id']).'
				AND z_release.id='.tools::int($delbg['id']).'
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
public function updateReleaseInner($data){
	$db=db::init();
	if(is_array($data)){
		$data['date_start']=explode('.', $data['date_start']);
		if(!$data['coverid'])
		$data['coverid']='null';
		if($data['id']>0){
						
					#Добавление в треклист
					if(tools::int($data['inplaylist'])>0){
						$db->exec('
						UPDATE z_tracklist
						SET
						name="'.tools::str($data['name']).'",
						author="'.tools::str($data['author']).'",
						remix="'.tools::str($data['remix']).'",
						style="'.tools::str($data['musictype']).'",
						coverid='.$data['coverid'].',
						fileid='.$data['fileid'].',
						download='.$data['download'].',
						label="'.tools::str($data['label']).'",
						date_start="'.tools::getSqlDate($data['date_start'][2],$data['date_start'][1],$data['date_start'][0]).'"
						WHERE id='.$data['inplaylist'].' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'
						');
					}
					if($data['inplaylist']=='new' && tools::int($data['inplaylist'])<1 && $data['delplay']<1){
						if($data['fileid']>0)
						$db->exec('
						INSERT INTO z_tracklist 
						(author, name, remix, style, coverid, fileid, siteid, userid, download, label, date_start)
						VALUES 
						("'.tools::str($data['author']).'", "'.tools::str($data['name']).'", "'.tools::str($data['remix']).'", "'.tools::str($data['musictype']).'", '.$data['coverid'].', '.$data['fileid'].', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', '.$data['download'].',
						"'.tools::str($data['label']).'","'.tools::getSqlDate($data['date_start'][2],$data['date_start'][1],$data['date_start'][0]).'")
						');
					}
					elseif($data['delplay']>0){
						$stmt=$db->prepare("DELETE FROM z_tracklist
						WHERE id=?");
						$stmt->execute(array(tools::int($data['delplay'])
											));
					}
					
					$db->exec('
					DELETE FROM z_musictypelink
					WHERE linkid='.tools::int($data['id']).' AND datatypeid=6
					');
					
					$musictypeArr=array();
					$musictypeArr=explode(',',trim($data['musictype']));
					foreach($musictypeArr as $mtype){
						if(strlen(trim($mtype))>0){
							$result=$db->queryFetchRowAssoc('
							SELECT id from z_musictype
							where name="'.tools::str(trim($mtype)).'"
							');
							if($result['id']>0){
							$data['musictypeid']=$result['id'];
							}
							else{
							$db->exec('
							INSERT INTO z_musictype 
							(name)
							VALUES
							("'.tools::str(trim($mtype)).'")
							');
							$data['musictypeid']=$db->lastInsertId();
							}
							if($data['musictypeid']>0){
							$db->exec('
							INSERT INTO z_musictypelink 
							(musictypeid, linkid, datatypeid)
							VALUES
							('.$data['musictypeid'].','.$data['id'].', 6)
							');
							}
						}
					}
					$db->exec('
					UPDATE z_release
					SET 
					name="'.tools::str($data['name']).'",
					promocut='.$data['promocut'].',
					releasetypeid='.$data['typeid'].',
					remix="'.tools::str($data['remix']).'",
					author="'.tools::str($data['author']).'",
					download='.$data['download'].'
					WHERE
					id='.tools::int($data['id']).'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
		}
		if($data['id']<1){
				if(!$data['fileid'] && $data['mp3']){
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['mp3']."";
				if(file_exists($tempfile)){
					$data['mp3']=pathinfo($data['mp3']);
					$newfile=md5(uniqid().microtime()).'.'.$data['mp3']['extension'];
						if($bg['mp3']['extension']='mp3'){
						rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/mp3/".$newfile."");
						$result=$db->exec('
						INSERT INTO z_mp3 
						(file_name,siteid)
						VALUES
						("'.$newfile.'",'.tools::int($_SESSION['Site']['id']).')
						');
						$data['fileid']=$db->lastInsertId();
						}
					}
				}
			    if($data['fileid']>0){
					$colnames=', fileid';
					$colvalues=', '.$data['fileid'].'';
				}
				if($data['stream'] && $data['socialid']){
					$colnames.=', stream, socialid';
					$colvalues.=', "'.$data['stream'].'", '.$data['socialid'];
				}
				$db->exec('
				INSERT INTO z_release 
				(name, promocut, active, releasetypeid, remix, author, download, siteid, userid, sort'.$colnames.')
				VALUES
				("'.tools::str($data['name']).'", 
				 '.$data['promocut'].', 
				 1, 
				 '.$data['typeid'].', 
				 "'.tools::str($data['remix']).'", 
				 "'.tools::str($data['author']).'", 
				 '.$data['download'].', 
				 '.tools::int($_SESSION['Site']['id']).', 
				 '.tools::int($_SESSION['User']['id']).', 
				 '.$data['sort'].'
				 '.$colvalues.')
				');
				
				$data['id']=$db->lastInsertId();
				
				#Добавление в треклист
				if($data['inplaylist']=='new' && $data['fileid']>0){
					$db->exec('
					INSERT INTO z_tracklist 
					(author, name, remix, style, coverid, fileid, siteid, userid, download,label,date_start)
					VALUES 
					("'.tools::str($data['author']).'", "'.tools::str($data['name']).'", "'.tools::str($data['remix']).'", "'.tools::str($data['musictype']).'", '.$data['coverid'].', '.$data['fileid'].', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', '.$data['download'].'
					,"'.tools::str($data['label']).'","'.tools::getSqlDate($data['date_start'][2],$data['date_start'][1],$data['date_start'][0]).'")
					');
				}
				
				
				$musictypeArr=array();
				$musictypeArr=explode(',',trim($data['musictype']));
				foreach($musictypeArr as $mtype){
					if(strlen(trim($mtype))>0){
						$result=$db->queryFetchRowAssoc('
						SELECT id from z_musictype
						where name="'.tools::str(trim($mtype)).'"
						');
						if($result['id']>0){
						$data['musictypeid']=$result['id'];
						}
						else{
						$db->exec('
						INSERT INTO z_musictype 
						(name)
						VALUES
						("'.tools::str(trim($mtype)).'")
						');
						$data['musictypeid']=$db->lastInsertId();
						}
						if($data['musictypeid']>0){
						$db->exec('
						INSERT INTO z_musictypelink 
						(musictypeid, linkid, datatypeid)
						VALUES
						('.$data['musictypeid'].','.$data['id'].', 6)
						');
						}
					}
				}
				
		}	
	}
	
}
public	function getSiteReleases($siteid){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
	SELECT 
	  z_releasetype.id AS releasetypeid,
	  z_releasetype.name AS releasetypename,
	  z_release.id,
	  z_release.name 
	FROM
	  z_releasetype 
	  INNER JOIN
	  z_release 
	  ON z_release.releasetypeid = z_releasetype.id 
	WHERE z_releasetype.siteid = '.tools::int($siteid).' 
	');
	
	if($result){
		foreach($result as $row){
			$releaseArr=$out[$row['releasetypeid']]['releases'];
			$out[$row['releasetypeid']]['name']=$row['releasetypename'];
			$out[$row['releasetypeid']]['releases']=$releaseArr;
			if($row['id']>0)
			$out[$row['releasetypeid']]['releases'][$row['id']]=$row;
			
		}
	return $out;
	}
	
}
public function getReleaseType(){
	{
		$db=db::init();
		
		
		$typeresult=$db->queryFetchAllAssoc('
					SELECT '.$this->no_cache.' DISTINCT 
					  (z_releasetype.id) AS id,
					  z_releasetype.name,
					  z_releasetype.author,
					  z_releasetype.date_start,
					  z_releasetype.label,
					  z_releasetype.itemid,
					  IF(DATE_ADD(z_releasetype.date_start, INTERVAL 1 MONTH)>NOW(),1,0) AS fresh,
					  if(z_cover.id>0,CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/img/2_",
					    z_cover.url
					  ),
					  CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/img/2_",
					    z_cover_default.url
					  )) AS `url`
					FROM
					  z_releasetype 
					  INNER JOIN
					  z_release 
					  ON z_release.releasetypeid = z_releasetype.id 
					  LEFT JOIN
					  z_cover 
					  ON z_cover.id = z_releasetype.coverid
					  LEFT JOIN
				  	  z_cover z_cover_default
				      ON z_cover_default.siteid = z_releasetype.siteid AND z_cover_default.major=1
					WHERE z_releasetype.active = 1 
					  AND z_release.active = 1
					  AND z_releasetype.siteid='.$_SESSION['Site']['id'].'
					ORDER BY z_releasetype.sort DESC
					');
		if(is_array($typeresult)){
			foreach($typeresult as $rel)
				$itemidArr[$rel['itemid']]=$rel['itemid'];
			
			if(count($itemidArr)>0)
			$urlresult=$db->queryFetchAllAssoc('
				SELECT 
				 z_release_links.id,
				 z_release_links.releasetypeid,
				 z_release_links.url,
				  CONCAT(
				    "/uploads/social/",
				    z_file.file_name
				  ) AS image 
				FROM
				  z_releasetype 
				  INNER JOIN
				  z_release_links 
				  ON z_release_links.releasetypeid = z_releasetype.id 
				  LEFT JOIN
				  z_social 
				  ON z_social.id = z_release_links.socialid 
				  LEFT JOIN
				  z_file 
				  ON z_file.id = z_social.preview_image 
				WHERE z_releasetype.itemid IN ('.implode(',',$itemidArr).') 
				');
			$urlArr=array();
			if(is_array($urlresult))
			foreach($urlresult as $url)
			$urlArr[$url['releasetypeid']][$url['id']]=$url;
				
				if(count($itemidArr)>0)
				$relresult=$db->queryFetchAllAssoc('
				SELECT '.$this->no_cache.' DISTINCT
				  (z_release.id) AS id,
				  z_releasetype.itemid,
				  z_release.name,
				  z_release.remix,
				  z_musictype.id AS musictypeid,
				  z_musictype.NAME AS musictype
				FROM
				  z_release 
				  INNER JOIN
				  z_releasetype 
				  ON z_releasetype.id = z_release.releasetypeid 
				  LEFT JOIN
				  z_musictypelink 
				  ON z_musictypelink.linkid = z_release.id 
				  AND z_musictypelink.datatypeid = 6 
				  LEFT JOIN
				  z_musictype 
				  ON z_musictype.id = z_musictypelink.musictypeid 
				WHERE z_releasetype.itemid IN ('.implode(',',$itemidArr).') 
				ORDER BY z_release.releasetypeid 
				');
			
			foreach($relresult as $r){
				$releasedata[$r['itemid']]['data'][$r['id']]=$r['id'];
				
				if(strlen($r['remix'])>0){
					if(strtolower(trim($r['remix']))!=='original mix'){
					$releasedata[$r['itemid']]['remixes'][md5($r['remix'])]['sort']++;
					$releasedata[$r['itemid']]['remixes'][md5($r['remix'])]['name']=$r['remix'];
					}
				}
				
				if(strlen($r['musictype'])>0){
					$releasedata[$r['itemid']]['musictype'][$r['musictypeid']]['sort']++;
					$releasedata[$r['itemid']]['musictype'][$r['musictypeid']]['name']=$r['musictype'];
				}
			}
		
		return array('releasetype'=>$typeresult, 'releasedata'=>$releasedata, 'url'=>$urlArr);
		}
	}
	
	
	
	/* OLD */
	
	/*$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  COUNT(z_release.id) AS cnt,
				  z_releasetype.id,
				  z_releasetype.name,
				  z_releasetype.active,
				  z_releasetype.author,
				  z_releasetype.sort,
				  z_releasetype.itemid,
				  z_release.remix,
				  z_releasetype.date_start,
				  z_releasetype.label,
				  z_cover.id AS coverid,
				  if(z_cover.id>0,CONCAT(
				    "/uploads/sites/",
				    z_releasetype.siteid,
				    "/img/2_",
				    z_cover.url
				  ),
				  CONCAT(
				    "/uploads/sites/",
				    z_releasetype.siteid,
				    "/img/2_",
				    z_cover_default.url
				  )) AS `url`
				FROM
				  z_releasetype 
				  LEFT JOIN
				  z_cover 
				  ON z_cover.id = z_releasetype.coverid 
				  LEFT JOIN
				  z_cover z_cover_default
				  ON z_cover_default.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_cover_default.major=1
				  INNER JOIN
				  z_release
				  ON z_release.releasetypeid = z_releasetype.id 
				WHERE z_releasetype.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_releasetype.active=1
				GROUP BY z_releasetype.id
				');
	$urlresult=$db->queryFetchAllAssoc('
				SELECT 
				 z_release_links.id,
				 z_release_links.socialid,
				 z_release_links.releasetypeid,
				 z_release_links.url,
				  CONCAT(
				    "/uploads/social/",
				    z_file.file_name
				  ) AS image 
				FROM
				  z_releasetype 
				  INNER JOIN
				  z_release_links 
				  ON z_release_links.releasetypeid = z_releasetype.id 
				  LEFT JOIN
				  z_social 
				  ON z_social.id = z_release_links.socialid 
				  LEFT JOIN
				  z_file 
				  ON z_file.id = z_social.preview_image 
				WHERE z_releasetype.siteid = '.tools::int($_SESSION['Site']['id']).'
				');
	$mtyperesult=$db->queryFetchAllAssoc('
				SELECT 
				  z_musictype.name,
				  z_releasetype.id AS releaseid,
				  z_musictype.id 
				FROM
				  z_releasetype
				INNER JOIN z_release
				ON z_release.releasetypeid=z_releasetype.id
				INNER JOIN z_musictypelink
				ON z_musictypelink.linkid=z_release.id
				AND z_musictypelink.datatypeid=6
				INNER JOIN z_musictype
				ON z_musictype.id=z_musictypelink.musictypeid
				WHERE z_releasetype.siteid = '.tools::int($_SESSION['Site']['id']).'
				');
	if(is_array($mtyperesult))
	foreach($mtyperesult as $mt){
		if(count($mtypearr[$mt['releaseid']])<2 && trim($mt['name'])!=='Original mix')
		$mtypearr[$mt['releaseid']][$mt['id']]=$mt['name'];
	}
	$urlArr=array();
	if(is_array($urlresult))
	foreach($urlresult as $url)
	$urlArr[$url['releasetypeid']][$url['id']]=$url;
	
	if(is_array($result)){
		foreach($result as $row){
			$row['links']=$urlArr[$row['id']];
			
			if(trim($row['remix'])=='Original mix' || trim($row['remix'])=='Original')
			unset($row['remix']);
			
			if($mtypearr[$row['id']])
			$row['musictypes']=implode(',',$mtypearr[$row['id']]);
			$out[$row['id']]=$row;
		}
	}
	
	function my_custom_sort_function($a, $b) {
	    return $b['sort']-$a['sort'];
	}
	if(is_array($out))
	usort($out, "my_custom_sort_function");
		
	if($out)
	return $out;*/
}
public function getReleaseTypeInner($id, $siteid){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
					  z_release.id AS id,
					  z_release.NAME AS releasename,
					  z_release.promocut,
					  z_release.remix,
					  z_release.sort,
					  z_release.stream,
					  z_release.socialid,
					  if(z_cover.id>0,CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/img/3_",
					    z_cover.url
					  ),
					  CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/img/3_",
					    z_cover_default.url
					  )) AS `url`,
					  if(z_mp3.id>0,CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/mp3/",
					    z_mp3.file_name
					  ),z_release.stream) AS mp3,
					  z_releasetype.label,
					  z_releasetype.date_create,
					  z_release.author,
					  z_releasetype.id AS releasetypeid,
					  z_releasetype.NAME AS title,
					  z_musictype.NAME AS musictypename ,
					  z_musictype.NAME AS musictypename,
					  z_release.download,
					  z_mp3.id AS mp3id
					FROM
					  z_release 
					  INNER JOIN
					  z_releasetype 
					  ON z_releasetype.id = z_release.releasetypeid 
					  LEFT JOIN
					  z_cover 
					  ON z_cover.id = z_releasetype.coverid
					  LEFT JOIN
				  	  z_cover z_cover_default
				      ON z_cover_default.siteid = '.tools::int($siteid).' AND z_cover_default.major=1
					  LEFT JOIN
					  z_musictypelink 
					  ON z_musictypelink.linkid = z_release.id 
					  AND z_musictypelink.datatypeid = 6 
					  LEFT JOIN
					  z_musictype 
					  ON z_musictype.id = z_musictypelink.musictypeid 
					  LEFT JOIN
					  z_mp3 
					  ON z_mp3.id = z_release.fileid 
					WHERE z_release.active = 1 
					  AND z_releasetype.active = 1 
					  AND z_releasetype.id = '.tools::int($id).' 
					  AND z_releasetype.siteid = '.tools::int($siteid).'
	');
	if($result)
	return $result;
}
public function getReleaseShops($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
		SELECT 
		  z_release_links.url,
		  CONCAT(
		    "/uploads/",
		    z_file.subdir,
		    "/",
		    z_file.file_name
		  ) AS image 
		FROM
		  z_release_links 
		  LEFT JOIN
		  z_social 
		  ON z_social.id = z_release_links.socialid 
		  LEFT JOIN
		  z_file 
		  ON z_file.id = z_social.preview_image  
		WHERE z_release_links.releasetypeid = '.tools::int($id).' 
	');
	if($result)
	return $result;
}
}
?>