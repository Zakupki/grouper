<?
require_once 'modules/base/models/Basemodel.php';

Class Gallery Extends Basemodel {

public function getGalleryType($start=0, $end=4){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				COUNT(DISTINCT z_gallery.id) AS cnt,
				  z_gallerytype.id,
				  z_gallerytype.itemid,
				  z_gallerytype.name,
				  z_gallerytype.date_start,
				  z_gallerytype.active,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallerytype.siteid,
				    "/img/1_",
				    z_gallery.file_name
				  ) AS preview 
				FROM
				  z_gallerytype 
				  INNER JOIN
				  z_gallery 
				  ON z_gallery.gallerytypeid = z_gallerytype.id AND z_gallery.sort=(SELECT 
				    MAX(sort) 
				  FROM
				    z_gallery 
				  WHERE gallerytypeid = z_gallerytype.id)
				WHERE z_gallerytype.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_gallerytype.active=1
				GROUP BY z_gallerytype.id
				ORDER BY z_gallerytype.date_start DESC
				LIMIT '.$start.','.$end.'
				');
				if($result){
		foreach($result as $item)
		$itemidArr[$item['itemid']]=$item['itemid'];
		
		if(tools::int($_SESSION['User']['id'])>0){
					$visitJoin2='LEFT JOIN
								z_commentvisit 
								ON z_commentvisit.itemid = z_comments.itemid 
								AND z_commentvisit.userid = '.tools::int($_SESSION['User']['id']).' 
								AND z_commentvisit.date_visit < z_comments.date_create';
					$visitSelect2=' COUNT(z_commentvisit.id) AS comvisnum,';
		}
				
				$comresult=$db->queryFetchAllAssoc('
				SELECT '.$this->no_cache.'
				  COUNT(DISTINCT z_comments.id) AS comnum,
				  '.$visitSelect2.'
				  _items.id AS itemid 
				FROM
				  _items 
				  LEFT JOIN
				  z_comments 
				  ON z_comments.itemid = _items.id 
				  '.$visitJoin2.'
				WHERE _items.id IN ('.implode(',',$itemidArr).')
				GROUP BY _items.id ');
				foreach($comresult as $comment)
				$comments[$comment['itemid']]=$comment;
				
				
				$rateresult=$db->queryFetchAllAssoc('
				SELECT '.$this->no_cache.'
				  SUM(z_rate.rate) AS rate,
				  z_rate.itemid 
				FROM
				  z_rate 
				WHERE z_rate.itemid IN ('.implode(',',$itemidArr).')
				GROUP BY z_rate.itemid');
				
				foreach($rateresult as $rate)
				$rates[$rate['itemid']]=$rate['rate'];
		
		}
	if($result)
	return array('gallery'=>$result, 'comments'=>$comments, 'rate'=>$rates);
}
public function getGalleryTypeOptions(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_gallerytype.id,
				  z_gallerytype.name
				FROM
				  z_gallerytype 
				WHERE z_gallerytype.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_gallerytype.active=1
				');
	if($result)
	return $result;
}
public function getGalleryInner($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_gallery.id,
				  z_gallery.gallerytypeid,
				  z_gallerytype.name,
				  z_gallerytype.itemid,
				  z_gallerytype.date_start,
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
				  AND z_gallery.siteid = '.tools::int($_SESSION['Site']['id']).'
				ORDER BY z_gallery.sort DESC
				');
	if($result)
	return $result;
}
public function getAdminGallery($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_gallery.id,
				  z_gallery.sort,
				  z_gallerytype.id AS gallerytypeid,
				  z_gallerytype.itemid,
				  z_gallerytype.name,
				  z_gallerytype.date_start,
				  z_gallerytype.active,
				  DATE_FORMAT(z_gallerytype.date_start,"%d.%m.%Y") AS date_start,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallerytype.siteid,
				    "/img/",
				    z_gallery.big_file
				  ) AS bigurl,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallerytype.siteid,
				    "/img/1_",
				    z_gallery.file_name
				  ) AS url
				FROM
				  z_gallerytype 
				  LEFT JOIN
				  z_gallery 
				  ON z_gallery.gallerytypeid = z_gallerytype.id 
				WHERE z_gallerytype.id = '.tools::int($id).' 				
				  AND z_gallerytype.siteid = '.tools::int($_SESSION['Site']['id']).'
				  AND z_gallerytype.userid = '.tools::int($_SESSION['User']['id']).'
				ORDER BY z_gallery.sort ASC
				');
	foreach($result as $row){
		$gallerytype=array('id'=>$row['gallerytypeid'],'name'=>$row['name'],'date_start'=>$row['date_start'],'active'=>$row['active'],'itemid'=>$row['itemid']);
		if($row['id']>0)
		$gallery[]=array('id'=>$row['id'],'sort'=>$row['sort'],'bigurl'=>$row['bigurl'],'url'=>$row['url']);
	}
	if($result)
	return array('gallerytype'=>$gallerytype, 'gallery'=>$gallery);
	
}
public function updateGalleryInner($gallerytype,$gallery,$deleted){
	$db=db::init();
	$gallerytype['date_start']=explode('.', $gallerytype['date_start']);
	
	
	if($gallerytype['delete']){
		   if(is_array($gallery)){
			   foreach($gallery as $gl)
			   if($gl['id']>0){
				  tools::delImg($gl['bigurl']);
			      tools::delImg($gl['url']);
			   }
		   }
		   $db->exec('DELETE FROM _items WHERE id='.tools::int($gallerytype['itemid']).' AND siteid='.tools::int($_SESSION['Site']['id']).'
				AND userid='.tools::int($_SESSION['User']['id']).'');
		   $db->exec('DELETE FROM z_gallerytype WHERE id='.tools::int($gallerytype['id']).' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
	return;
	}
	
	
	if($gallerytype['id']>0){
	   $db->exec('UPDATE z_gallerytype SET
	   name="'.tools::str($gallerytype['name']).'",
	   date_start="'.tools::getSqlDate($gallerytype['date_start'][2],$gallerytype['date_start'][1],$gallerytype['date_start'][0]).'",
	   active='.tools::int($gallerytype['active']).'
	   WHERE id='.tools::int($gallerytype['id']).' 
	   AND z_gallerytype.siteid = '.tools::int($_SESSION['Site']['id']).' 
	   AND z_gallerytype.userid = '.tools::int($_SESSION['User']['id']).'');	
	}
	else{
	   $db->exec('
		INSERT INTO _items (datatypeid,siteid,userid) VALUES (11,'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).')');
		$itemid=$db->lastInsertId();
	   $db->exec('INSERT INTO z_gallerytype 
	   (name,active,siteid,userid,date_start,itemid) VALUES 
	   ("'.tools::str($gallerytype['name']).'",
	   '.tools::int($gallerytype['active']).',
	   '.tools::int($_SESSION['Site']['id']).',
	   '.tools::int($_SESSION['User']['id']).',
	   "'.tools::getSqlDate($gallerytype['date_start'][2],$gallerytype['date_start'][1],$gallerytype['date_start'][0]).'",'.$itemid.')
	   ');
	   $newgalleryid=$db->lastInsertId();
	   $gallerytype['id']=$newgalleryid;
	}
	
	$cnt=0;
	$this->Image=new Image;
	if(is_array($gallery))
	foreach($gallery as $k=>$bg){
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
					$this->Image->thumb($bigtempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newbigfile."", 1024, 1024, false);
					unlink($bigtempfile);
				}
					$db->exec('
					INSERT INTO z_gallery 
					(file_name, big_file, siteid, active, userid, sort, gallerytypeid)
					VALUES
					("'.$newfile.'", "'.$newbigfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).', '.$cnt.', '.$gallerytype['id'].')
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
	if($newgalleryid>0)
	return $newgalleryid;
}
public function getCommentGallery($itemid){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT '.$this->no_cache.' DISTINCT 
					  (z_gallerytype.id) AS id,
					  z_gallerytype.itemid,
					  z_gallerytype.name,
					  z_gallerytype.siteid,
					  z_gallerytype.date_start,
					  z_gallerytype.userid,
					  z_rate.rate
					FROM
					  z_gallerytype
					  LEFT JOIN z_rate
					  ON z_rate.itemid=z_gallerytype.itemid AND z_rate.userid='.tools::int($_SESSION['User']['id']).'
					WHERE z_gallerytype.active = 1 
					  AND z_gallerytype.itemid = '.tools::int($itemid).'
					  LIMIT 0,1
					');
		if($result){
			$rateresult=$db->queryFetchRowAssoc('
				SELECT '.$this->no_cache.'
				  SUM(z_rate.rate) AS rate
				FROM
				  z_rate 
				WHERE z_rate.itemid='.tools::int($result['itemid']).'');
			$result['totalrate']=$rateresult['rate'];
		}
		return $result;
	}
}
?>