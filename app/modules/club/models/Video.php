<?
require_once 'modules/base/models/Basemodel.php';
require_once 'modules/club/models/Social.php';

Class Video Extends Basemodel {
	public function getVideoList(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  z_video.id,
		  z_video.itemid,
		  z_video.name,
		  z_video.url,
		  z_video.socialid,
		  z_video.date_start as date_create,
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
		ORDER BY z_video.date_start DESC
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
		return array('videos'=>$result, 'comments'=>$comments, 'rate'=>$rates);
	}
	public function getAdminVideoInner($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_video.id,
		  z_video.name,
		  z_video.url,
		  z_video.active,
		  z_video.itemid,
		  MONTH(z_video.date_start) AS month,
  		  DAYOFWEEK(z_video.date_start) AS dayinweek,
		  DAYOFMONTH(z_video.date_start) AS dayinmonth,
		  YEAR(z_video.date_start) AS year,
		  DATE_FORMAT(z_video.date_start,"%d.%m.%Y") AS date_start,
		  z_video.previewid,
		CONCAT(
				    "/uploads/sites/",
				    z_video.siteid,
				    "/img/1_",
				    z_videopreview.url
		) AS `preview`
		FROM
		  z_video 
		  LEFT JOIN
		  z_videopreview 
		  ON z_videopreview.id = z_video.previewid 
		WHERE z_video.id='.tools::int($id).' AND z_video.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_video.userid= '.tools::int($_SESSION['User']['id']).'
		');
		if($result)
		return $result;
	}
	public function getVideoInner($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_video.id,
		  z_video.name,
		  z_video.url,
		  z_video.active,
		  z_video.itemid,
		  z_video.socialid,
		  MONTH(z_video.date_start) AS month,
  		  DAYOFWEEK(z_video.date_start) AS dayinweek,
		  DAYOFMONTH(z_video.date_start) AS dayinmonth,
		  YEAR(z_video.date_start) AS year,
		  DATE_FORMAT(z_video.date_start,"%d.%m.%Y") AS date_start,
		  z_video.previewid,
		CONCAT(
				    "/uploads/sites/",
				    z_video.siteid,
				    "/img/1_",
				    z_videopreview.url
		) AS `preview`
		FROM
		  z_video 
		  LEFT JOIN
		  z_videopreview 
		  ON z_videopreview.id = z_video.previewid 
		WHERE z_video.id='.tools::int($id).' AND z_video.siteid = '.tools::int($_SESSION['Site']['id']).'
		');
		if($result)
		return $result;
	}
	public function getVideoOptions($start=0,$end=5){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  z_video.id,
		  z_video.name
		FROM
		  z_video 
		WHERE z_video.siteid = '.tools::int($_SESSION['Site']['id']).'
		LIMIT '.$start.','.$end.'
		');
		if($result)
		return $result;
	}
	public function updateVideo($bg){
	$bg['url']=urldecode($bg['url']);
	$db=db::init();
	
	if(!$bg['socialid']){
		$this->Social=new Social;
		$socialdata=$this->Social->findSocial($bg['url']);
		if($socialdata['id']>0)
		$bg['socialid']=$socialdata['id'];
		else
		$bg['socialid']='NULL';
	}
	
	if($bg['delete']){
		if($bg['previewid']>0){
			tools::delImg($bg['preview']);
			$db->exec('
				DELETE FROM 
				z_videopreview
				WHERE 
				z_videopreview.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_videopreview.userid='.tools::int($_SESSION['User']['id']).'
				AND z_videopreview.id='.tools::int($bg['previewid']).'
				');
			
		}
		$db->exec('DELETE FROM _items WHERE id='.tools::int($bg['itemid']).' AND siteid='.tools::int($_SESSION['Site']['id']).'
				AND userid='.tools::int($_SESSION['User']['id']).'');
		$db->exec('DELETE FROM z_video WHERE id='.tools::int($bg['id']).' AND siteid='.tools::int($_SESSION['Site']['id']).'
				AND userid='.tools::int($_SESSION['User']['id']).'');
		return;
	}
	
	if($bg['deleted']){
		if($bg['deleted']['previewid']>0){
			tools::delImg($bg['deleted']['preview']);
			$db->exec('
				DELETE FROM 
				z_videopreview
				WHERE 
				z_videopreview.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_videopreview.userid='.tools::int($_SESSION['User']['id']).'
				AND z_videopreview.id='.tools::int($bg['deleted']['previewid']).'
				');
			
		}
	}
	
	$date_start=$bg['date_start'];
	$bg['date_start']=explode('.', $bg['date_start']);
	if(!$bg['previewid'] && $bg['preview']){
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
		
		if($bg['id']>0){
					$result=$db->exec('
					UPDATE z_video
					SET name="'.tools::str($bg['name']).'",
					previewid='.$bg['previewid'].',
					socialid='.tools::int($bg['socialid']).',
					date_start="'.tools::getSqlDate($bg['date_start'][2],$bg['date_start'][1],$bg['date_start'][0]).'"
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
				(name, active, previewid, siteid, userid, url, date_start, socialid, itemid)
				VALUES
				("'.tools::str($bg['name']).'", 1, '.$bg['previewid'].', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', "'.tools::str($bg['url']).'","'.tools::getSqlDate($bg['date_start'][2],$bg['date_start'][1],$bg['date_start'][0]).'", '.tools::str($bg['socialid']).', '.$itemid.')
				');
				return $db->lastInsertId();
		}
	
}
public function getCommentVideo($itemid){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT '.$this->no_cache.' DISTINCT 
					  (z_video.id) AS id,
					  z_video.itemid,
					  z_video.name,
					  z_video.siteid,
					  z_video.date_start,
					  z_video.userid,
					  z_rate.rate
					FROM
					  z_video
					  LEFT JOIN z_rate
					  ON z_rate.itemid=z_video.itemid AND z_rate.userid='.tools::int($_SESSION['User']['id']).'
					WHERE z_video.active = 1 
					  AND z_video.itemid = '.tools::int($itemid).'
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