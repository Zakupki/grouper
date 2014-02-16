<?
require_once 'modules/base/models/Basemodel.php';

Class Event Extends Basemodel {
public function getEvents($data){
	if(tools::int($data['take'])<1)
		$data['take']=10;
		
	if($data['take']>20)
		$data['take']=20;
	if(tools::int($data['clubid'])>0)
		$whereSql=' AND z_site.id='.tools::int($data['clubid']);
	if($data['cityid']>0)
		$whereSql=' AND z_site.cityid='.tools::int($data['cityid']).' ';
	if($data['countryid']>0)
		$whereSql.=' AND z_city.countryid='.tools::int($data['countryid']).' ';
	
	$db=db::init();
		$resultcount=$db->queryFetchAllFirst('SELECT 
		  COUNT(z_event.id) AS cnt
		FROM
		  z_event 
		INNER JOIN z_site
			ON z_site.id=z_event.siteid
		LEFT JOIN z_city
			ON z_city.id=z_site.cityid
		LEFT JOIN z_country
			ON z_country.id=z_city.countryid
		WHERE z_site.sitetypeid = 7 
		  AND z_site.recommend = 1
		'.$whereStr.'
		');
	
				$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_event.id,
				  z_event.name,
				  z_event.itemid,
				  z_event.date_start,
				  z_event.date_create,
				  z_event.detail_text,
				  z_event.siteid AS clubid,
				  z_site.name AS clubname,
				  z_city.countryid,
				  z_country.name_ru AS countryname,
				  z_site.cityid,
				  z_city.name as cityname,
				  if(z_cover.id>0,CONCAT(
				    "http://reactor.ua/uploads/sites/",
				    z_event.siteid,
				    "/img/",
				    z_cover.url
				  ),CONCAT(
				    "http://reactor.ua/uploads/sites/",
				    z_event.siteid,
				    "/img/",
				    z_cover2.url
				  )) AS avatar
				FROM
				  z_event 
				INNER JOIN z_site
				ON z_site.id=z_event.siteid
				LEFT JOIN z_cover
				ON z_cover.id=z_event.coverid
				LEFT JOIN z_cover z_cover2
				ON z_cover2.siteid = z_event.siteid AND z_cover2.major=1
				LEFT JOIN z_city
				ON z_city.id=z_site.cityid
				LEFT JOIN z_country
				ON z_country.id=z_city.countryid
				WHERE z_event.active=1'.$whereSql.'
				ORDER BY z_event.date_start DESC
				LIMIT '.tools::int($data['start']).','.tools::int($data['take']).'
				');
	
	if($result)
	return array('totalevents'=>$resultcount[0], 'start'=>$data['start'], 'take'=>$data['take'], 'events'=>$result);
}
public function getEventInner($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_event.id,
				  z_event.itemid,
				  z_event.name,
				  z_event.detail_text,
				  z_event.date_start,
				  z_event.date_create,
				  CONCAT(
				    "http://reactor.ua/uploads/sites/",
				    z_event.siteid,
				    "/img/",
				    z_cover.url
				  ) AS avatar,
				  if(z_poster.id>0,CONCAT(
				    "http://reactor.ua/uploads/sites/",
				    z_event.siteid,
				    "/img/",
				    z_poster.url
				  ),CONCAT(
				    "/uploads/sites/",
				    z_event.siteid,
				    "/img/",
				    z_poster2.url
				  )) AS poster
				FROM
				  z_event 
				LEFT JOIN z_cover
				ON z_cover.id=z_event.coverid
				LEFT JOIN z_poster
				ON z_poster.id=z_event.posterid
				LEFT JOIN z_poster z_poster2
				ON z_poster2.siteid = z_event.siteid AND z_poster2.major=1
				WHERE z_event.id='.tools::int($id).'
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
	return array('event'=>$result, 'artists'=>$artists, 'socials'=>$socials);
}
}
?>