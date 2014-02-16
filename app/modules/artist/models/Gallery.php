<?
require_once 'modules/base/models/Basemodel.php';

Class Gallery Extends Basemodel {

public function getAdminGalleryType(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				 COUNT(z_gallery.id) AS cnt,
				  z_gallerytype.id,
				  z_gallerytype.itemid,
				  z_gallerytype.name,
				  z_gallerytype.active,
				  z_gallerytype.previewid,
				  CASE
				    WHEN z_gallery2.id > 0 
				    THEN CONCAT(
				      "/uploads/sites/",
				      z_gallerytype.siteid,
				      "/img/1_",
				      z_gallery2.file_name
				    )
				    WHEN z_gallery.id > 0 
				    THEN CONCAT(
				      "/uploads/sites/",
				      z_gallerytype.siteid,
				      "/img/1_",
				      z_gallery.file_name
				    )
				  END AS preview
				FROM
				  z_gallerytype 
				  LEFT JOIN
				  z_gallery 
				  ON z_gallery.gallerytypeid = z_gallerytype.id 
				  LEFT JOIN
				  z_gallery z_gallery2
				  ON z_gallery2.gallerytypeid = z_gallerytype.id AND z_gallery2.sort=(SELECT MAX(sort) FROM z_gallery WHERE gallerytypeid=z_gallerytype.id)
				  LEFT JOIN
				  z_videopreview 
				  ON z_videopreview.id = z_gallerytype.previewid   
				WHERE z_gallerytype.siteid = '.tools::int($_SESSION['Site']['id']).' 
				  AND z_gallerytype.userid = '.tools::int($_SESSION['User']['id']).' 
				GROUP BY z_gallerytype.id
				ORDER BY z_gallerytype.sort
				');
	if($result)
	return $result;
}
public function getGalleryTypeNum($siteid){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  COUNT(DISTINCT z_gallerytype.id) AS cnt 
				FROM
				  z_gallerytype 
				  INNER JOIN
				  z_gallery 
				  ON z_gallery.gallerytypeid = z_gallerytype.id 
				WHERE z_gallerytype.siteid = '.tools::int($siteid).' AND z_gallerytype.active=1
				GROUP BY z_gallerytype.id
				');
	if($result['cnt'])
	return $result['cnt'];
}
public function getGalleryType($siteid){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  COUNT(DISTINCT z_gallery2.id) AS cnt,
				  z_gallerytype.id AS `id`,
				  z_gallerytype.name,
				  z_gallerytype.active,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallerytype.siteid,
				    "/img/1_",
				    z_gallery.file_name
				  ) AS preview 
				FROM
				  z_gallerytype 
				  LEFT JOIN
				  z_gallery 
				  ON z_gallery.gallerytypeid = z_gallerytype.id AND z_gallery.sort=(SELECT MAX(sort) FROM z_gallery WHERE gallerytypeid=z_gallerytype.id)
				  INNER JOIN z_gallery z_gallery2
				  ON z_gallery2.gallerytypeid = z_gallerytype.id
				WHERE z_gallerytype.siteid = '.tools::int($siteid).' AND z_gallerytype.active=1
				GROUP BY z_gallerytype.id
				ORDER BY z_gallerytype.sort DESC
				');
	if($result)
	return $result;
}
public function updateGalleryType($data,$deleted){
	$db=db::init();
	
	$cnt=0;
	if(is_array($data))
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
		
		if($bg['id']<1){
				$db->exec('
				INSERT INTO _items (datatypeid,siteid,userid) VALUES (11,'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).')');
				$itemid=$db->lastInsertId();
			    $db->exec('
				INSERT INTO z_gallerytype 
				(name, siteid, userid, sort, previewid, active, itemid)
				VALUES
				("'.tools::str($bg['name']).'", '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', '.$cnt.', '.$bg['previewid'].', '.$bg['active'].','.$itemid.')
				');
		}
		if($bg['id']>0){
				$db->exec('
				UPDATE z_gallerytype
				SET 
				name="'.tools::str($bg['name']).'",
				active="'.$bg['active'].'",
				previewid='.$bg['previewid'].',
				sort='.$cnt.'
				WHERE
				id='.tools::int($bg['id']).'
				AND siteid='.tools::int($_SESSION['Site']['id']).'
				AND userid='.tools::int($_SESSION['User']['id']).'
				');
		}
	$cnt++;
	
	}
	if(is_array($deleted)){
		foreach($deleted as $delbg){
			if($delbg['id']>0){
			$delItemArr[$delbg['itemid']]=$delbg['itemid'];
			$delArr[$delbg['id']]=$delbg['id'];
						$result=$db->queryFetchAllAssoc('
						SELECT 
						  CONCAT(
						    "/uploads/sites/",
						    z_gallery.siteid,
						    "/img/",
						    z_gallery.file_name
						  ) AS url,
						   CONCAT(
						    "/uploads/sites/",
						    z_gallery.siteid,
						    "/img/",
						    z_gallery.big_file
						  ) AS bigurl
						FROM
						  z_gallery 
						WHERE z_gallery.gallerytypeid='.tools::int($delbg['id']).'
						');
						if(count($result)>0)
						foreach($result as $delgal){
						tools::delImg($delgal['url']);
						tools::delImg($delgal['bigurl']);
						}
			}
		}
						if(is_array($delItemArr))
						$db->exec('
						DELETE FROM _items
						WHERE id in('.implode(',', $delItemArr).') AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'
						');
						if(is_array($delArr))
						$db->exec('
						DELETE FROM z_gallerytype
						WHERE id in('.implode(',', $delArr).') AND siteid='.tools::int($_SESSION['Site']['id']).'
						');
	}
}
public function updateGalleryInner($data,$deleted){
	$db=db::init();
	
	$cnt=0;
	if(is_array($data))
	foreach($data as $k=>$bg){
		if($bg['url'] && !$bg['id']){
				$bg['url']=str_replace('1_', '', $bg['url']);
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['url']."";
				$bigtempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['bigurl']."";
				if(file_exists($tempfile)){
					$bg['url']=pathinfo($bg['url']);
					$newfile=md5(uniqid().microtime()).'.'.$bg['url']['extension'];
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
				}
				if(file_exists($bigtempfile)){
					$bg['bigurl']=pathinfo($bg['bigurl']);
					$newbigfile=md5(uniqid().microtime()).'.'.$bg['bigurl']['extension'];
					rename($bigtempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newbigfile."");
				}
					$db->exec('
					INSERT INTO z_gallery 
					(file_name, big_file, siteid, active, userid, sort, gallerytypeid)
					VALUES
					("'.$newfile.'", "'.$newbigfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).', '.$cnt.', '.$bg['gallerytypeid'].')
					');
		}
		
		if($bg['id']>0){
					$db->exec('
					UPDATE z_gallery
					SET 
					sort='.$cnt.'
					WHERE
					id='.tools::int($bg['id']).'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
		}
	$cnt++;
	
	}
	if(is_array($deleted)){
		foreach($deleted as $delbg){
			if($delbg['id']>0){
			$delArr[$delbg['id']]=$delbg['id'];
			$delbg['url']=str_replace('1_', '', $delbg['url']);
			tools::delImg($delbg['url']);
			tools::delImg($delbg['bigurl']);
			}
		}
						if(is_array($delArr))
						$db->exec('
						DELETE FROM z_gallery
						WHERE id in('.implode(',', $delArr).')
						');
	}
}
public function getAdminGalleryInner($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_gallery.id,
				  z_gallery.gallerytypeid,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallerytype.siteid,
				    "/img/",
				    z_gallery.file_name
				  ) AS url,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallerytype.siteid,
				    "/img/",
				    z_gallery.big_file
				  ) AS bigurl
				FROM
				  z_gallerytype 
				  INNER JOIN
				  z_gallery 
				  ON z_gallery.gallerytypeid = z_gallerytype.id 
				WHERE z_gallerytype.id = '.tools::int($id).' 				
				  AND z_gallery.siteid = '.tools::int($_SESSION['Site']['id']).' 
				  AND z_gallery.userid = '.tools::int($_SESSION['User']['id']).' 
				ORDER BY z_gallery.sort ASC
				');
	if($result)
	return $result;
}
public function getGalleryInner($id,$siteid){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_gallery.id,
				  z_gallery.gallerytypeid,
				  z_gallerytype.name,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallerytype.siteid,
				    "/img/",
				    z_gallery.big_file
				  ) AS srcurl,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallerytype.siteid,
				    "/img/1_",
				    z_gallery.file_name
				  ) AS url
				FROM
				  z_gallerytype 
				  INNER JOIN
				  z_gallery 
				  ON z_gallery.gallerytypeid = z_gallerytype.id 
				WHERE z_gallerytype.id = '.tools::int($id).' 				
				  AND z_gallery.siteid = '.tools::int($siteid).'
				ORDER BY z_gallery.sort DESC
				');
	if($result)
	return $result;
}
}
?>