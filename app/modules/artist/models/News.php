<?
require_once 'modules/base/models/Basemodel.php';
require_once 'modules/artist/models/Release.php';

Class News Extends Basemodel {

public function getAdminNewsInner($itemid){
	$db=db::init();
	$this->Release= new Release;
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_news.id,
				  z_news.itemid,
				  z_news.name,
				  z_news.preview_text,
				  z_news.detail_text,
				  z_news.active,
				  DATE_FORMAT(
				    z_news.date_start,
				    "%d.%m.%Y"
				  ) AS date_start,
				  z_news.incut,
				  z_news.video
				FROM
				  z_news 
				WHERE z_news.itemid = '.tools::int($itemid).' 
				AND z_news.siteid='.tools::int($_SESSION['Site']['id']).'
				LIMIT 0,1
				');
	$tagresult=$db->queryFetchAllAssoc('
				SELECT 
				  z_news.id,
				  z_news.itemid,
				  z_tags.id AS tagid,
				  z_tags.name,
				  z_image.id AS imageid,
				  CONCAT(
				    "/uploads/sites/",
				    z_image.siteid,
				    "/img/1_",
				    z_image.file_name
				  ) AS url 
				FROM
				  z_news 
				  LEFT JOIN
				  z_tags_owner 
				  ON z_tags_owner.ownerid = z_news.id 
				  LEFT JOIN
				  z_tags 
				  ON z_tags.id = z_tags_owner.tagid 
				  LEFT JOIN
				  z_image 
				  ON z_image.itemid = z_news.itemid 
				WHERE z_news.itemid = '.tools::int($itemid).' 
				');
	 foreach($tagresult as $tag){
	 if($tag['tagid']>0)
	 $tagArr[$tag['id']][$tag['tagid']]=$tag['name'];
	 if($tag['imageid']>0)
	 $imageArr[$tag['imageid']]=array('id'=>$tag['imageid'], 'itemid'=>$tag['itemid'], 'url'=>$tag['url']);
	 }
	 if($result['id']>0){
		 if(is_array($tagArr[$result['id']]))
		 $result['tags']=implode(',',$tagArr[$result['id']]);
		 else
		 $result['tags']=''; 
	 }
	
	if(is_array($result))	
	return array('news'=>$result, 'images'=>$imageArr, 'tracks'=>$this->Release->getAdminRelByItem($itemid));
	
}
public function getAdminNews($itemid){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_news.id,
				  z_news.itemid,
				  z_news.name,
				  z_news.active,
				  z_news.incut,
				  DATE_FORMAT(
				    z_news.date_start,
				    "%d.%m.%Y"
				  ) AS date_start,
				  CONCAT(
				    "/uploads/sites/",
				    z_image.siteid,
				    "/img/3_",
				    z_image.file_name
				  ) AS url 
				FROM
				  z_news 
				  LEFT JOIN
				  z_image 
				  ON z_image.itemid = z_news.itemid 
				WHERE z_news.siteid = '.tools::int($_SESSION['Site']['id']).'
				GROUP BY z_news.id 
				ORDER BY z_news.date_start DESC
				');
	/*$out=array();
	if(is_array($result)){
	foreach($result as $news){
		if(!array_key_exists($news['itemid'],$out) && $news['reactorlangid']==2)
		$out[$news['itemid']]=$news;
		elseif($news['reactorlangid']==1)
		$out[$news['itemid']]=$news;
		
	}
	}*/
	//$out=array();
	return $result;	
}
public function updateNews($data, $deleted){
	if(is_array($data)){
		$db=db::init();
		$cnt=0;
		foreach($data as $k=>$n){
			if($n['itemid']>0){
							$result=$db->exec('
							UPDATE z_news
							SET active='.$n['active'].',
							sort='.$cnt.'
							WHERE
							itemid='.$n['itemid'].'
							AND siteid='.tools::int($_SESSION['Site']['id']).'
							AND userid='.tools::int($_SESSION['User']['id']).'
							');
			}
		$cnt++;
		}
	}
	if(is_array($deleted)){
			$db=db::init();
		foreach($deleted as $del)
			$dellArr[$del['itemid']]=$del['itemid'];
		if(is_array($dellArr))
			$dellids=implode(',',$dellArr);
		
			$result=$db->queryFetchAllAssoc('
			SELECT 
			CONCAT("/uploads/sites/",z_file.siteid,"/img/3_",z_file.file_name) AS url FROM z_file
			WHERE itemid in('.$dellids.');
			AND siteid='.tools::int($_SESSION['Site']['id']).'
			');
			foreach($result as $delfile){
				if(file_exists($_SERVER['DOCUMENT_ROOT'].$delfile['url']))
				unlink($_SERVER['DOCUMENT_ROOT'].$delfile['url']);
				$delfile['url']=str_replace('3_', '', $delfile['url']);
				if(file_exists($_SERVER['DOCUMENT_ROOT'].''.$delfile['url']))
				unlink($_SERVER['DOCUMENT_ROOT'].''.$delfile['url']);				
			}
							$db->exec('
							DELETE FROM _items WHERE id in('.$dellids.')
							AND siteid='.tools::int($_SESSION['Site']['id']).'
							AND userid='.tools::int($_SESSION['User']['id']).'
							');
		
		
	}
}
public function updateInnerNews($data){
	$db=db::init();
	$newsdata=$data['news'];
	$newsdata['date_start']=explode('.', $newsdata['date_start']);
	if($newsdata['itemid']){
		
			if($newsdata['name'] && $newsdata['preview_text']){
				$db->exec('
					UPDATE z_news
					SET 
					name="'.tools::str($newsdata['name']).'",
					preview_text="'.tools::str($newsdata['preview_text']).'",
					detail_text="'.tools::str($newsdata['detail_text']).'",
					active='.$newsdata['active'].',
					incut='.$newsdata['incut'].',
					video="'.tools::str($newsdata['video']).'",
					date_start="'.tools::getSqlDate($newsdata['date_start'][2],$newsdata['date_start'][1],$newsdata['date_start'][0]).'"
					WHERE id='.$newsdata['id'].'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
					#Теги
					$db->exec('
					DELETE FROM z_tags_owner
					WHERE ownerid='.$newsdata['id'].'
					');
					if($newsdata['tags']){
						$newsdata['tags']=explode(',',trim($newsdata['tags']));
						foreach($newsdata['tags'] as $tag){
							$result=$db->queryFetchRowAssoc('
							SELECT id FROM z_tags WHERE name="'.tools::str($tag).'"
							');
							if($result['id'])
								$tagid=$result['id'];
							else{
								$db->exec('
								INSERT INTO z_tags (name) VALUES ("'.tools::str($tag).'")
								');
								$tagid=$db->lastInsertId();
							}
							$db->exec('
							INSERT INTO z_tags_owner (ownerid,tagid) VALUES ('.$newsdata['id'].','.$tagid.')
							');
						}
						
					}					
			}
	}
	else{
		if($newsdata['name'] &&  $newsdata['preview_text']){
			$db->exec('
			INSERT INTO _items
			(datatypeid,siteid,userid)
			VALUES
			(5,'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).')
			');
			$newid=$db->lastInsertId();
			$db->exec('
				INSERT INTO z_news
				(itemid,name,preview_text,detail_text,siteid,userid,active,incut,video,date_start,recommend)
				VALUES
				('.$newid.',"'.tools::str($newsdata['name']).'","'.tools::str($newsdata['preview_text']).'","'.tools::str($newsdata['detail_text']).'",'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).','.$newsdata['active'].','.$newsdata['incut'].',"'.tools::str($newsdata['video']).'","'.tools::getSqlDate($newsdata['date_start'][2],$newsdata['date_start'][1],$newsdata['date_start'][0]).'",'.tools::int($_SESSION['Site']['recommend']).')
			');
			$newsid=$db->lastInsertId();
					#Теги
					if($newsdata['tags']){
						$newsdata['tags']=explode(',',trim($newsdata['tags']));
						foreach($newsdata['tags'] as $tag){
							$result=$db->queryFetchRowAssoc('
							SELECT id FROM z_tags WHERE name="'.tools::str($tag).'"
							');
							if($result['id'])
								$tagid=$result['id'];
							else{
								$db->exec('
								INSERT INTO z_tags (name) VALUES ("'.tools::str($tag).'")
								');
								$tagid=$db->lastInsertId();
							}
							$db->exec('
							INSERT INTO z_tags_owner (ownerid,tagid) VALUES ('.$newsid.','.$tagid.')
							');
						}
						
					}
		}
		$data['itemid']=$newid;
	}
	
	if(is_array($data['images']))
		foreach($data['images'] as $bg){
			if($bg['id']<1){
				$bg['url']=str_replace('1_', '', $bg['url']);
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['url']."";
				if(file_exists($tempfile)){
					$bg['url']=pathinfo($bg['url']);
					$newfile=md5(uniqid().microtime()).'.'.$bg['url']['extension'];
					
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
					$result=$db->exec('
					INSERT INTO z_image 
					(file_name, siteid, itemid)
					VALUES
					("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).','.$data['itemid'].')
					');
				}
			}
	}
	
	if(is_array($data['tracks']))
		foreach($data['tracks'] as $track){
			if($track['linkid']<1){
				$db->exec('
					INSERT INTO z_item_track 
					(itemid, datatypeid, trackid)
					VALUES
					('.$data['itemid'].', '.$track['datatypeid'].','.$track['id'].')
					');
			}
		}
	if(is_array($data['tracksdeleted'])){
		foreach($data['tracksdeleted'] as $deltrack)
			if($deltrack['linkid']>0)
			$deltrackArr[$deltrack['linkid']]=$deltrack['linkid'];
			if(is_array($deltrackArr))
			$db->exec('
					DELETE FROM z_item_track 
					WHERE itemid='.$data['itemid'].' AND id IN ('.implode(',',$deltrackArr).')
					');
			
	}
	
	if(is_array($data['deleted']))
	foreach($data['deleted'] as $delbg){
		if($delbg['id']>0){
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$delbg['url']))
			unlink($_SERVER['DOCUMENT_ROOT'].$delbg['url']);
			
			$delbg['url']=str_replace('1_', '6_', $delbg['url']);
			
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$delbg['url']))
			unlink($_SERVER['DOCUMENT_ROOT'].$delbg['url']);
			
			$delbg['url']=str_replace('6_', '', $delbg['url']);
			
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$delbg['url']))
			unlink($_SERVER['DOCUMENT_ROOT'].$delbg['url']);
			
			$db->exec('
				DELETE FROM 
				z_image
				WHERE 
				z_image.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_image.id='.$delbg['id'].' 
				AND z_image.itemid='.$delbg['itemid'].'
				');
		}
	}
	return $newid;
}
public function getLatestNews($siteid){
		$db=db::init();
		
				if(tools::int($_SESSION['User']['id'])>0){
					$visitJoin='LEFT JOIN
								z_commentvisit 
								ON z_commentvisit.itemid = z_news.itemid 
								AND z_commentvisit.userid = '.tools::int($_SESSION['User']['id']).'';
					$visitSelect=' z_commentvisit.date_visit,';
				}
		
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_news.id,
					  z_news.itemid,
					  z_news.name,
					  z_news.preview_text,
					  z_news.detail_text,
					  z_news.date_start,
					  z_news.userid,
					  z_user.login,
					  IF(
					    z_user.siteid > 0,
					    z_site.NAME,
					    IFNULL(z_user.displayname,z_user.login)
					  ) AS `displayname`,
					  '.$visitSelect.'
					  CONCAT(
					    "/uploads/sites/",
					    z_image.siteid,
					    "/img/1_",
					    z_image.file_name
					  ) AS url,
					  CONCAT(
					    "/uploads/sites/",
					    z_image.siteid,
					    "/img/6_",
					    z_image.file_name
					  ) AS url2
					FROM
					  z_news 
					  INNER JOIN
					  z_user 
					  ON z_user.id = z_news.userid 
					  LEFT JOIN
					  z_image 
					  ON z_image.itemid = z_news.itemid 
					  LEFT JOIN
					  z_site 
					  ON z_site.id = z_user.siteid
					  '.$visitJoin.'
					WHERE z_news.siteid='.tools::int($siteid).'
					  AND z_news.active = 1 
					GROUP BY z_news.itemid 
					ORDER BY z_news.sort ASC
					');
		if(is_array($result))
		{
			foreach($result as $row)
			if($row['itemid']>0)
			$itemidArr[$row['itemid']]=$row['itemid'];
			
			if(is_array($itemidArr)){
				
				if(tools::int($_SESSION['User']['id'])>0){
					$visitJoin2='LEFT JOIN
								z_commentvisit 
								ON z_commentvisit.itemid = z_comments.itemid 
								AND z_commentvisit.userid = '.tools::int($_SESSION['User']['id']).' 
								AND z_commentvisit.date_visit < z_comments.date_create';
					$visitSelect2=' COUNT(z_commentvisit.id) AS comvisnum,';
				}
				
				$comresult=$db->queryFetchAllAssoc('
				SELECT 
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
				SELECT 
				  SUM(z_rate.rate) AS rate,
				  z_rate.itemid 
				FROM
				  z_rate 
				WHERE z_rate.itemid IN ('.implode(',',$itemidArr).')
				GROUP BY z_rate.itemid');
				
				foreach($rateresult as $rate)
				$rates[$rate['itemid']]=$rate['rate'];
		 }
		}		
		return array('news'=>$result, 'comments'=>$comments, 'rate'=>$rates);
	}
}
?>