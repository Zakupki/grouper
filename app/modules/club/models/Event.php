<?
require_once 'modules/base/models/Basemodel.php';
require_once 'modules/club/models/Social.php';

Class Event Extends Basemodel {

public function getEvents($start=0,$end=8,$eventtype=null){
	if($eventtype=='eventpast'){
		$whereSql=' AND DATE_FORMAT(DATE_ADD(z_event.date_start,INTERVAL 1 DAY), "%Y%m%d")<=DATE_FORMAT(NOW(), "%Y%m%d")';
		$orderSql=' ORDER BY z_event.date_start DESC';
	}
	else{
		$whereSql=' AND DATE_FORMAT(DATE_ADD(z_event.date_start,INTERVAL 1 DAY), "%Y%m%d")>=DATE_FORMAT(NOW(), "%Y%m%d")';
		$orderSql=' ORDER BY z_event.date_start ASC';
	}
	if($_SESSION['Site']['userid']!=$_SESSION['User']['id'])
	$whereSql.=' AND z_event.offertype=0 ';
	
	$db=db::init();
				$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_event.id,
				  z_event.name,
				  z_event.itemid,
				  z_social_item.url AS concertua,
				  DATE_FORMAT(z_event.date_start,"%Y%m%d") AS date_start,
				  MONTH(z_event.date_start) AS month,
  				  DAYOFWEEK(z_event.date_start) AS dayinweek,
				  DAYOFMONTH(z_event.date_start) AS dayinmonth,
				  z_event.detail_text,
				  if(z_cover.id>0,CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/9_",
				    z_cover.url
				  ),CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/9_",
				    z_cover2.url
				  )) AS avatar,
				  if(z_cover.id>0,
				  CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/2_",
				    z_cover.url
				  ),CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/2_",
				    z_cover2.url
				  )) AS avatar2
				FROM
				  z_event 
				LEFT JOIN z_cover
				ON z_cover.id=z_event.coverid
				LEFT JOIN z_cover z_cover2
				ON z_cover2.siteid = z_event.siteid AND z_cover2.major=1
				LEFT JOIN z_social_item 
				ON z_social_item.itemid=z_event.itemid AND z_social_item.socialid=354
				WHERE z_event.siteid = '.tools::int($_SESSION['Site']['id']).'
				  AND z_event.active = 1 '.$whereSql.'
				'.$orderSql.'
				LIMIT '.$start.','.$end.'
				');
	if($result){
		foreach($result as $item)
		$itemidArr[$item['itemid']]=$item['itemid'];
		$artistres=$db->queryFetchAllAssoc('SELECT id,name,comment,support,itemid FROM z_artist WHERE itemid IN('.implode(',',$itemidArr).') ORDER BY sort ASC');
		if(is_array($artistres))
		foreach($artistres as $artist)
		$artislist[$artist['itemid']][$artist['id']]=$artist;
		
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
	return array('events'=>$result, 'artists'=>$artislist, 'comments'=>$comments, 'rate'=>$rates);
}
public function getEventInner($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_event.id,
				  z_event.itemid,
				  z_event.name,
				  z_event.detail_text,
				  IF(DATE_FORMAT(DATE_ADD(z_event.date_start,INTERVAL 1 DAY), "%Y%m%d")<=DATE_FORMAT(NOW(), "%Y%m%d"),1,0) AS oldevent,
				  DATE_FORMAT(z_event.date_start,"%d.%m.%Y") AS date_start,
				  z_event.date_start AS date_title,
				  MONTH(z_event.date_start) AS month,
  				  DAYOFWEEK(z_event.date_start) AS dayinweek,
				  DAYOFMONTH(z_event.date_start) AS dayinmonth,
				  z_city.name as city,
				  CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/2_",
				    z_cover.url
				  ) AS avatar,
				  z_cover.id AS avatarid,
				  if(z_poster.id>0,CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/8_",
				    z_poster.url
				  ),CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/8_",
				    z_poster2.url
				  )) AS poster,
				  z_poster.id AS posterid
				FROM
				  z_event 
				INNER JOIN z_site
				ON z_site.id=z_event.siteid
				LEFT JOIN z_city
				ON z_city.id=z_site.cityid
				LEFT JOIN z_cover
				ON z_cover.id=z_event.coverid
				LEFT JOIN z_poster
				ON z_poster.id=z_event.posterid
				LEFT JOIN z_poster z_poster2
				ON z_poster2.siteid = z_event.siteid AND z_poster2.major=1
				WHERE z_event.id='.tools::int($id).'
				  AND z_event.siteid = '.tools::int($_SESSION['Site']['id']).'
				LIMIT 0,1
				');
	if($result['itemid'])
	$artists=$db->queryFetchAllAssoc('
				SELECT 
				  id,
				  name,
				  comment,
				  support 
				FROM
				  z_artist 
				WHERE itemid = '.$result['itemid'].'
				ORDER BY sort ASC
				');
	if(count($artists)<1)
	$artists=null;
	if($result['itemid'])
	$socials=$db->queryFetchAllAssoc('
				SELECT 
				  z_social_item.url,
				  CONCAT(
				    "/uploads/",
				    z_file.subdir,
				    "/",
				    z_file.file_name
				  ) AS img 
				FROM
				  z_social_item 
				  INNER JOIN
				  z_social 
				  ON z_social.id = z_social_item.socialid 
				  LEFT JOIN
				  z_file 
				  ON z_social.preview_image = z_file.id 
				WHERE z_social_item.itemid = '.$result['itemid'].'
				ORDER BY z_social_item.sort ASC
				');
	if(count($socials)<1)
	$socials=null;
	if($result)
	return array('data'=>$result, 'artists'=>$artists, 'socials'=>$socials);
}
public function getAdminEvent($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_event.id,
				  z_event.itemid,
				  z_event.name,
				  z_event.detail_text,
				  z_event.offertype AS brandOfferType,
				  DATE_FORMAT(z_event.date_start,"%d.%m.%Y") AS date_start,
				  MONTH(z_event.date_start) AS month,
  				  DAYOFWEEK(z_event.date_start) AS dayinweek,
				  DAYOFMONTH(z_event.date_start) AS dayinmonth,
				  CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/2_",
				    z_cover.url
				  ) AS avatar,
				  z_cover.id AS avatarid,
				  CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/8_",
				    z_poster.url
				  ) AS poster,
				  z_poster.id AS posterid
				FROM
				  z_event 
				LEFT JOIN z_cover
				ON z_cover.id=z_event.coverid
				LEFT JOIN z_poster
				ON z_poster.id=z_event.posterid
				WHERE z_event.id='.tools::int($id).'
				  AND z_event.siteid = '.tools::int($_SESSION['Site']['id']).' 
				  AND z_event.userid = '.tools::int($_SESSION['User']['id']).'
				LIMIT 0,1
				');
	if($result['brandOfferType']==2)
	$brandoffer=$db->queryFetchAllFirst('
				SELECT 
				  brandid 
				FROM
				  z_eventoffer 
				WHERE eventid = '.tools::int($id).'
				');
				
	if($result['itemid'])
	$artists=$db->queryFetchAllAssoc('
				SELECT 
				  id,
				  name,
				  comment,
				  support 
				FROM
				  z_artist 
				WHERE itemid = '.$result['itemid'].'
				ORDER BY sort ASC
				');
	if(count($artists)<1)
	$artists=null;
	if($result['itemid'])
	$socials=$db->queryFetchAllAssoc('
				SELECT 
				  id,
				  url
				FROM
				  z_social_item
				WHERE itemid = '.$result['itemid'].'
				ORDER BY sort ASC
				');
	if(count($socials)<1)
	$socials=null;
	if($result)
	{
		if($brandoffer)
		$result['brands']=$brandoffer;
	return array('data'=>$result, 'artists'=>$artists, 'socials'=>$socials);
	}
}
public function updateEvent($data,$artist,$social){
	$db=db::init();
	//tools::print_r($data);
	$date_start=$data['date_start'];
	$data['date_start']=explode('.', $data['date_start']);
	
	if($data['deleted']){
		if($data['deleted']['avatarid']>0){
			tools::delImg($data['deleted']['avatar']);
			$db->exec('
				DELETE FROM 
				z_cover
				WHERE 
				z_cover.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_cover.userid='.tools::int($_SESSION['User']['id']).'
				AND z_cover.id='.tools::int($data['deleted']['avatarid']).'
				');
			
		}
		if($data['deleted']['posterid']>0){
			tools::delImg($data['deleted']['poster']);
			$db->exec('
				DELETE FROM 
				z_poster
				WHERE 
				z_poster.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_poster.userid='.tools::int($_SESSION['User']['id']).'
				AND z_poster.id='.tools::int($data['deleted']['posterid']).'
				');
			
		}
	}
	
	
	if($data['delete']){
		
		if($data['posterid']>0){
			tools::delImg($data['poster']);
			$db->exec('
				DELETE FROM 
				z_poster
				WHERE 
				z_poster.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_poster.userid='.tools::int($_SESSION['User']['id']).'
				AND z_poster.id='.tools::int($data['posterid']).'
				');
			
		}
		if($data['avatarid']>0){
			tools::delImg($data['avatar']);
			$db->exec('
				DELETE FROM 
				z_cover
				WHERE 
				z_cover.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_cover.userid='.tools::int($_SESSION['User']['id']).'
				AND z_cover.id='.tools::int($data['avatarid']).'
				');			
		}
		
		$db->exec('DELETE FROM _items WHERE id='.tools::int($data['itemid']).' AND siteid='.tools::int($_SESSION['Site']['id']).'
				AND userid='.tools::int($_SESSION['User']['id']).'');
		return;
	}
	
	
	#Постер
	if(!$data['posterid'] && $data['poster']){
				$data['poster']=str_replace('8_', '', $data['poster']);
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['poster']."";
				if(file_exists($tempfile)){
					$data['poster']=pathinfo($data['poster']);
					$newfile=md5(uniqid().microtime()).'.'.$data['poster']['extension'];
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
					$result=$db->exec('
					INSERT INTO z_poster 
					(url, siteid, active, userid, major)
					VALUES
					("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).', 0)
					');
					$data['posterid']=$db->lastInsertId();
				}
			
	}
	if(!$data['posterid'])
	$data['posterid']='NULL';
	
	#Аватар
	if(!$data['avatarid'] && $data['avatar']){
				
				$data['avatar']=str_replace('2_', '', $data['avatar']);
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['avatar']."";
				if(file_exists($tempfile)){
					$data['avatar']=pathinfo($data['avatar']);
					$newfile=md5(uniqid().microtime()).'.'.$data['avatar']['extension'];
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
					$result=$db->exec('
					INSERT INTO z_cover 
					(url, siteid, active, userid, major)
					VALUES
					("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).', 0)
					');
					$data['avatarid']=$db->lastInsertId();
				}
			
	}
	if(!$data['avatarid'])
	$data['avatarid']='NULL';
	
	
	if($data['id']>0){
		$db->exec('UPDATE z_event SET 
		name="'.tools::str($data['name']).'",
		detail_text="'.tools::str($data['detail_text']).'",
		date_start="'.tools::getSqlDate($data['date_start'][2],$data['date_start'][1],$data['date_start'][0]).'",
		coverid='.$data['avatarid'].',
		posterid='.$data['posterid'].',
		offertype='.tools::int($data['brandOfferType']).'
		WHERE id='.tools::int($data['id']).'
		AND siteid = '.tools::int($_SESSION['Site']['id']).' 
		AND userid = '.tools::int($_SESSION['User']['id']).'
		');
		$evid=$data['id'];
	}else{
		$db->exec('INSERT INTO _items
		(datatypeid,siteid,userid) VALUES (9,'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).')');
		$data['itemid']=$db->lastInsertId();
		$db->exec('INSERT INTO z_event
		(name,date_start,detail_text, active,userid,siteid,itemid,coverid,posterid,offertype) VALUES
		("'.tools::str($data['name']).'","'.tools::getSqlDate($data['date_start'][2],$data['date_start'][1],$data['date_start'][0]).'","'.tools::str($data['detail_text']).'",1,'.tools::int($_SESSION['User']['id']).','.tools::int($_SESSION['Site']['id']).','.$data['itemid'].', '.$data['avatarid'].', '.$data['posterid'].','.tools::int($data['brandOfferType']).')');
		$newevent=$db->lastInsertId();
		$evid=$newevent;
	}
	
	#Артисты
	if(count($artist)>0){
		$cnt=0;
		foreach($artist as $ar){
			if($ar['id']>0){
				$db->exec('UPDATE z_artist SET
				name="'.tools::str($ar['name']).'",
				comment="'.tools::str($ar['comment']).'",
				support='.tools::int($ar['support']).',
				sort='.$cnt.'
				WHERE id='.tools::int($ar['id']).' AND itemid='.$data['itemid'].' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
				$artistidArr[$ar['id']]=$ar['id'];
			} else {
				$db->exec('INSERT INTO z_artist
				(name,comment,itemid,siteid,userid,sort,support) VALUES ("'.tools::str($ar['name']).'", "'.tools::str($ar['comment']).'", '.tools::int($data['itemid']).', '.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).','.$cnt.','.tools::int($ar['support']).')');
				$newartistid=$db->lastInsertId();
				$artistidArr[$newartistid]=$newartistid;
			}
			$cnt++;
		}
	}
		if(count($artistidArr)>0)
		$dellWhere='id NOT IN('.implode(',',$artistidArr).') AND';
		$db->exec('DELETE FROM z_artist WHERE '.$dellWhere.' itemid='.tools::int($data['itemid']).' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');

	#Соцсети
	if(count($social)>0){
		$this->Social=new Social;
		$cnt=0;
		foreach($social as $val){
			if(strlen($val['url'])>0){
				$this->socialdata=$this->Social->findSocial($val['url']);
				if($val['id']>0){
					$db->exec('UPDATE z_social_item SET
					url="'.tools::str($val['url']).'",
					socialid='.tools::int($this->socialdata['id']).',
					sort='.$cnt.'
					WHERE id='.tools::int($val['id']).' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');	
					$socialidArr[$val['id']]=$val['id'];
				}elseif(tools::int($this->socialdata['id'])>0){
					$db->exec('INSERT INTO z_social_item
					(url,siteid,itemid,socialid,userid,sort) VALUES 
					("'.tools::str($val['url']).'", '.tools::int($_SESSION['Site']['id']).', '.$data['itemid'].', '.tools::int($this->socialdata['id']).', '.tools::int($_SESSION['User']['id']).', '.$cnt.')');	
					$newsocialid=$db->lastInsertId();
					$socialidArr[$newsocialid]=$newsocialid;
				}
			}
			$cnt++;
		}
	}
	#Предложение для бренда
	
	if($data['id']>0){
	  $existoffers=$db->queryFetchAllFirst('SELECT brandid from z_eventoffer WHERE eventid='.tools::int($data['id']).'');
	}
	
/*
	tools::print_r($existoffers);
	tools::print_r($existoffers);*/

	
	if($data['brandOfferType']==1){
		$brandresult=$db->queryFetchAllFirst('SELECT id FROM z_brand');
		foreach($brandresult as $brand)
		{
			if(!in_array($brand,$existoffers))
			$brandsql[]='('.$evid.','.$brand.')';
		}
		if(count($brandsql)>0)
		$db->exec('INSERT INTO z_eventoffer (eventid,brandid) VALUES '.implode(',',$brandsql).'');
	}elseif($data['brandOfferType']==2){
		if(count($existoffers)>0 && count($data['brands'])>0){
		$db->exec('DELETE FROM z_eventoffer WHERE eventid='.tools::int($evid).' AND brandid NOT IN ('.implode(',',$data['brands']).')');
		}
		elseif(count($existoffers)<1 || count($data['brands'])<1)
		$db->exec('DELETE FROM z_eventoffer WHERE eventid='.tools::int($evid).'');
		
		if(count($data['brands'])>0)
		foreach($data['brands'] as $br)
		if(!in_array($br,$existoffers))
		$brsql[]='('.$evid.','.$br.')';
		if(count($brsql)>0)
		$db->exec('INSERT INTO z_eventoffer (eventid,brandid) VALUES '.implode(',',$brsql).'');
		
	}else{
		if($data['id']>0)
		$db->exec('DELETE FROM z_eventoffer where eventid='.tools::int($data['id']).'');
	}
	
	
	if(count($socialidArr)>0)
	$dellSocWhere='id NOT IN('.implode(',',$socialidArr).') AND';
	$db->exec('DELETE FROM z_social_item WHERE '.$dellSocWhere.' itemid='.$data['itemid'].' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
	return $newevent;
}
	public function getCommentEvent($itemid){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT '.$this->no_cache.' DISTINCT 
					  (z_event.id) AS id,
					  z_event.itemid,
					  z_event.name,
					  z_event.siteid,
					  z_event.date_start,
					  z_event.userid,
					  z_rate.rate
					FROM
					  z_event
					  LEFT JOIN z_rate
					  ON z_rate.itemid=z_event.itemid AND z_rate.userid='.tools::int($_SESSION['User']['id']).'
					  LEFT JOIN z_pressrelease
					  ON z_pressrelease.itemid=z_event.itemid
					WHERE z_event.active = 1 
					  AND z_event.itemid = '.tools::int($itemid).'
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