<?
require_once 'modules/base/models/Basemodel.php';

Class Event Extends Basemodel {

public function getEvents($start=0,$end=8){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_event.id,
				  z_event.name,
				  z_event.itemid,
				  DATE_FORMAT(z_event.date_start,"%Y%m%d") AS date_start,
				  MONTH(z_event.date_start) AS month,
  				  DAYOFWEEK(z_event.date_start) AS dayinweek,
				  DAYOFMONTH(z_event.date_start) AS dayinmonth,
				  z_event.detail_text,
				  CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/9_",
				    z_cover.url
				  ) AS avatar,
				   CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/2_",
				    z_cover.url
				  ) AS avatar2,
				  z_site.name AS sitename,
				  z_site.address,
				  z_site.maplink
				FROM
				  z_event 
				LEFT JOIN z_cover
				ON z_cover.id=z_event.coverid
				INNER JOIN z_site
				ON z_site.id=z_event.siteid
				WHERE z_event.active = 1 
				ORDER BY z_event.date_start ASC
				LIMIT '.$start.','.$end.'
				');
	if($result){
		foreach($result as $item)
		$itemArr[$item['itemid']]=$item['itemid'];
		$artistres=$db->queryFetchAllAssoc('SELECT id,name,comment,support,itemid FROM z_artist WHERE itemid IN('.implode(',',$itemArr).') ORDER BY sort ASC');
		if(is_array($artistres))
		foreach($artistres as $artist)
		$artislist[$artist['itemid']][$artist['id']]=$artist;
	}
	if($result)
	return array('events'=>$result, 'artists'=>$artislist);
}
public function getEventInner($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_event.id,
				  z_event.itemid,
				  z_event.name,
				  z_event.detail_text,
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
				  z_poster.id AS posterid,
				  z_site.name AS sitename,
				  z_site.address,
				  z_site.maplink
				FROM
				  z_event 
				LEFT JOIN z_cover
				ON z_cover.id=z_event.coverid
				LEFT JOIN z_poster
				ON z_poster.id=z_event.posterid
				INNER JOIN z_site
				ON z_site.id=z_event.siteid
				WHERE z_event.id='.tools::int($id).' 
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
}
?>