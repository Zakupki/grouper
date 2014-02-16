<?
require_once 'modules/base/models/Basemodel.php';

Class Group Extends Basemodel {

	private $registry;
	public function __construct($registry){
		$this->registry=$registry;
	}
	public function getClubInner($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_site.id,
		  z_site.name,
		  if(DATE_ADD(z_site.date_create,INTERVAL 1 MONTH)<=NOW(),0,1) AS new,
		  z_site.address,
		  z_site.maplink,
		  z_clubform.espresso + z_clubform.mohito + z_clubform.longisland AS checks,
		  z_clubform.age,
		  z_clubform.visits,
		  z_clubform.bar,
		  IF(
		    z_domain.id > 0,
		    z_domain.NAME,
		    CONCAT("r", z_site.id, ".reactor.ua")
		  ) AS domain,
		  CONCAT(
		    "/uploads/sites/",
		    z_clublogo.siteid,
		    "/img/12_",
		    z_clublogo.file_name
		  ) AS logo,
		  CONCAT(
		    "/uploads/sites/",
		    z_clublogo.siteid,
		    "/img/13_",
		    z_clublogo.file_name
		  ) AS logogray,
		  z_favclubs.id AS favourite,
		  SUM(z_social_stats.VALUE) AS likes 
		FROM
		  z_site 
		  LEFT JOIN
		  z_clubform 
		  ON z_clubform.siteid = z_site.id 
		  LEFT JOIN
		  z_domain 
		  ON z_domain.siteid = z_site.id 
		  LEFT JOIN
		  z_clublogo 
		  ON z_clublogo.siteid = z_site.id 
		  LEFT JOIN
		  z_favclubs 
		  ON z_favclubs.siteid = z_site.id 
		  AND z_favclubs.userid = '.tools::int($_SESSION['User']['id']).' 
		  LEFT JOIN
		  z_social_stats 
		  ON z_social_stats.siteid = z_site.id 
		  AND z_social_stats.statstypeid IN (4, 5, 6) 
		  AND z_social_stats.VALUE > 0 
		  AND z_social_stats.DATE = 
		  (SELECT 
		    MAX(z_social_stats.DATE) 
		  FROM
		    z_social_stats) 
		WHERE z_site.sitetypeid = 7 
		  AND z_site.recommend = 1 
		  AND z_site.id = '.tools::int($id).' 
		GROUP BY z_site.id,
		  z_social_stats.DATE 
		');
		if($result)
		return $result;
	}
	
	public function getClubs($start=0, $take=50, $type=1, $data){
		$favjoin=array(1=>'LEFT',2=>'INNER');
		
		
		$oderStr='ORDER BY z_site.date_create DESC';
		$take=$take+1;
		$db=db::init();
		if($data['sort']=="age"){
			if($data['dir']=='asc')
			$oderStr='ORDER BY z_clubform.age ASC';
			if($data['dir']=='desc')
			$oderStr='ORDER BY z_clubform.age DESC';
		}
		if($data['sort']=="check"){
			if($data['dir']=='asc')
			$oderStr='ORDER BY z_clubform.espresso+z_clubform.mohito+z_clubform.longisland ASC';
			if($data['dir']=='desc')
			$oderStr='ORDER BY z_clubform.espresso+z_clubform.mohito+z_clubform.longisland DESC';
		}
		if($data['sort']=="visits"){
			if($data['dir']=='asc')
			$oderStr='ORDER BY z_clubform.visits ASC';
			if($data['dir']=='desc')
			$oderStr='ORDER BY z_clubform.visits DESC';
		}
		if($data['sort']=="likes"){
			if($data['dir']=='asc')
			$oderStr='ORDER BY z_social_stats.value ASC';
			if($data['dir']=='desc')
			$oderStr='ORDER BY z_social_stats.value DESC';
		}
		if($data['sort']=="recard"){
			if($data['dir']=='asc')
			$oderStr='ORDER BY `ga` ASC';
			if($data['dir']=='desc')
			$oderStr='ORDER BY `ga` DESC';
		}
		if($data['city']>0){
			$whereStr=' AND z_site.cityid='.tools::int($data['city']).' ';
		}
		
		$result=$db->queryFetchAllAssoc('SELECT 
                      z_site_social.url as name 
                    FROM
                      z_site_social 
                    WHERE socialid IN(257,226)
                    LIMIT '.$start.','.$take.'
                    ');
        
		
		/*$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_site.id,
					  z_site.name,
					  z_site.address,
					  z_site.maplink,
					  if(DATE_ADD(z_site.date_create,INTERVAL 1 MONTH)<=NOW(),0,1) AS new,
					  z_clubform.espresso+z_clubform.mohito+z_clubform.longisland AS checks,
					  z_clubform.age,
					  z_clubform.visits,
					  z_social_stats.value AS likes,
					  (SELECT 
						  SUM(z_analytics_day.`visits`) 
						FROM
						  `z_analytics_day` 
						WHERE z_analytics_day.siteid=z_site.id AND z_analytics_day.`date_start` BETWEEN DATE_ADD(NOW(), INTERVAL - 8 DAY) 
						  AND DATE_ADD(NOW(), INTERVAL - 1 DAY) 
						GROUP BY z_analytics_day.`siteid`) AS `ga`,
					  if(z_domain.id>0,z_domain.name,CONCAT("r",z_site.id,".reactor.ua")) AS domain,
					  CONCAT(
						   "/uploads/sites/",
						   z_clublogo.siteid,
						   "/img/12_",
						   z_clublogo.file_name
						 ) AS logo,
					  CONCAT(
						   "/uploads/sites/",
						   z_clublogo.siteid,
						   "/img/13_",
						   z_clublogo.file_name
						 ) AS logogray,
					   z_favclubs.id AS favourite
					FROM
					  z_site 
					LEFT JOIN z_social_stats 
				    ON z_social_stats.`siteid` = z_site.id 
				    AND z_social_stats.`statstypeid` = 2 
				    AND z_social_stats.DATE = 
				    (SELECT 
				      MAX(z_social_stats.DATE) 
				    FROM
				      z_social_stats) 
					LEFT JOIN z_clubform
					ON z_clubform.siteid=z_site.id
					LEFT JOIN z_domain
					ON z_domain.siteid=z_site.id
					LEFT JOIN z_clublogo
					ON z_clublogo.siteid=z_site.id
					'.$favjoin[$type].' JOIN z_favclubs
					ON z_favclubs.siteid=z_site.id AND z_favclubs.userid='.tools::int($_SESSION['User']['id']).'
					WHERE z_site.sitetypeid = 7 
					AND z_site.recommend=1
					'.$whereStr.'
					'.$oderStr.'
					LIMIT '.$start.','.$take.'
					');*/
		
		if(count($result)>($take-1)){
		$hasmore=1;
		unset($result[count($result)-1]);
		}
		
		foreach($result as $club){
			$clubid[$club['id']]=$club['id'];
		}
		#События
		/*
		if(count($clubid)>0)
				$data=$db->queryFetchAllAssoc('
				SELECT 
				  COUNT(z_event.id) AS eventnum,
				  z_event.siteid
				FROM
				  z_event 
				  LEFT JOIN z_eventoffer
				  ON z_eventoffer.eventid=z_event.id AND z_eventoffer.brandid='.tools::int($_SESSION['User']['brandid']).'
				WHERE z_event.siteid IN('.implode(',',$clubid).')
				  AND z_event.active = 1 
				  AND DATE_FORMAT(
					DATE_ADD(
					  z_event.date_start,
					  INTERVAL 1 DAY
					),
					"%Y%m%d"
				  ) >= DATE_FORMAT(NOW(), "%Y%m%d")
				  AND (z_event.`offertype`<1 OR z_eventoffer.id>0)
				GROUP BY z_event.siteid');
				
				foreach($data as $row){
					$out[$row['siteid']]=$row;
				}	*/
		
		/*
		#РџРѕСЃРµС‰Р°РµРјРѕСЃС‚СЊ
				if(count($clubid)>0){
					$visitdata=$db->queryFetchAllAssoc('
					SELECT 
					  SUM(z_analytics_day.`visits`) AS visits,
					  z_analytics_day.`siteid` 
					FROM
					  `z_analytics_day` 
					WHERE z_analytics_day.siteid IN('.implode(',',$clubid).')
					  AND z_analytics_day.`date_start` BETWEEN DATE_ADD(NOW(), INTERVAL - 8 DAY) 
					  AND DATE_ADD(NOW(), INTERVAL - 1 DAY) 
					GROUP BY z_analytics_day.`siteid`
					');
					foreach($visitdata as $visdata)
					$visits[$visdata['siteid']]=$visdata['visits'];
				}*/
		
		
		
		
		if($result)
		return array('sites'=>$result,'data'=>$out, 'likesmax'=>self::likesmax(), 'visitsmax'=>self::visitsmax(), 'checksmax'=>self::checkmax(),'hasmore'=>$hasmore);
		
	}
	public function checkmax(){
		$db=db::init();
		$checkmax=$db->queryFetchAllFirst('
		SELECT 
			MAX(espresso + mohito + longisland) 
		FROM
			z_clubform 
		');
		if($checkmax[0])
		return $checkmax[0]/5;
	}
	public function likesmax(){
		
		$db=db::init();
				$likesmax=$db->queryFetchAllFirst('
				SELECT MAX(VALUE) FROM z_social_stats WHERE z_social_stats.`statstypeid` = 2 
				');
		
		if($likesmax[0])
		return $likesmax[0]/5;
	}
	public function visitsmax(){
		$db=db::init();
		$visitsmax=$db->queryFetchAllFirst('
		SELECT 
			MAX(visits) 
		FROM
			z_clubform 
		');
	if($visitsmax[0])
		return $visitsmax[0]/5;
	}
	
	public function getClubscount($type=1){
		$favjoin=array(1=>'LEFT',2=>'INNER');
		$db=db::init();
		$result=$db->queryFetchAllFirst('
					SELECT 
					  COUNT(z_site.id)
					FROM
					  z_site 
					'.$favjoin[$type].' JOIN z_favclubs
					ON z_favclubs.siteid=z_site.id AND z_favclubs.userid='.tools::int($_SESSION['User']['id']).'
					WHERE z_site.sitetypeid = 7 
					AND z_site.recommend=1
					');
		if($result[0])
		return $result[0];
	}
	public function getClubsfav(){
		$db=db::init();
		$result=$db->queryFetchAllFirst('
					SELECT 
					  COUNT(z_favclubs.siteid)
					FROM
					  z_favclubs 
					WHERE z_favclubs.userid='.tools::int($_SESSION['User']['id']).'
					');
		if($result[0])
		return $result[0];
	}
	public function findClub($name){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  id,
					  name as value,
					  name as label
					FROM
					  z_site 
					WHERE z_site.sitetypeid = 7 
					  AND z_site.recommend = 1 
					 AND z_site.NAME LIKE "%'.tools::str($name).'%"
					ORDER BY z_site.NAME
					');
		if($result)
		return $result;
	}
	public function getClubsGa($id){
		$db=db::init();
		if($id)
		$result=$db->queryFetchAllFirst('
					SELECT 
					  SUM(z_analytics_day.visits) 
					FROM
					  z_analytics_day 
					WHERE z_analytics_day.`siteid` IN ('.$id.') 
					  AND z_analytics_day.`date_start` = 
					  (SELECT 
					    MAX(z_analytics_day.date_start) 
					  FROM
					    z_analytics_day)
					');
		if($result[0])
		return $result[0];
	}
	public function getClubsGrp($id){
		$db=db::init();
		if($id)
		$result=$db->queryFetchAllFirst('
					SELECT 
					  SUM(z_social_stats.value)
					FROM
					  z_social_stats 
					WHERE z_social_stats.`siteid` IN ('.$id.') 
					 AND z_social_stats.statstypeid IN (4, 5, 6) 
					 AND z_social_stats.date = 
					 (SELECT 
					   MAX(z_social_stats.date) 
					 FROM
					   z_social_stats) 
					');
		if($result[0])
		return $result[0];
	}
	public function addToFav($data){
		$db=db::init();
		if($data['action']=='add')
		$db->exec('INSERT INTO z_favclubs (siteid,userid) VALUES ('.tools::int($data['id']).','.tools::int($_SESSION['User']['id']).')');
		elseif($data['action']=='remove')
		$db->exec('DELETE FROM z_favclubs WHERE  siteid='.tools::int($data['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
	}
	public function getVistors(){
		$db=db::init();
		$result=$db->queryFetchAllFirst('
		SELECT SUM(visits) FROM `z_clubform`');
		if($result[0])
		return $result[0];
	}
	public function getFollowers(){
		$db=db::init();
		$result=$db->queryFetchAllFirst('
		SELECT 
		  SUM(VALUE) 
		FROM
		  `z_social_stats` 
		WHERE `date` IN 
		  (SELECT 
		    MAX(`date`) 
		  FROM
		    `z_social_stats`)');
		if($result[0])
		return $result[0];
	}		
}
?>