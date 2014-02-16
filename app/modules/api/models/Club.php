<?
require_once 'modules/base/models/Basemodel.php';

Class Club Extends Basemodel {

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
		  z_site.address,
		  z_site.maplink,
		  z_city.countryid,
		  z_country.name_ru AS countryname,
		  z_site.cityid,
		  z_city.name as cityname,
		  IF(
		    z_domain.id > 0,
		    CONCAT("http://",z_domain.NAME),
		    CONCAT("http://r", z_site.id, ".reactor.ua")
		  ) AS domain,
		  CONCAT(
		    "http://reactor.ua/uploads/sites/",
		    z_clublogo.siteid,
		    "/img/12_",
		    z_clublogo.file_name
		  ) AS logo,
		  CONCAT(
		    "http://reactor.ua/uploads/sites/",
		    z_clublogo.siteid,
		    "/img/13_",
		    z_clublogo.file_name
		  ) AS logogray
		FROM
		  z_site 
		  LEFT JOIN
		  z_domain 
		  ON z_domain.siteid = z_site.id 
		  LEFT JOIN
		  z_clublogo 
		  ON z_clublogo.siteid = z_site.id
		  LEFT JOIN z_city
		  ON z_city.id=z_site.cityid
		  LEFT JOIN z_country
		  ON z_country.id=z_city.countryid
					
		WHERE z_site.sitetypeid = 7 
		  AND z_site.recommend = 1 
		  AND z_site.id = '.tools::int($id).' 
		GROUP BY z_site.id
		');
		if($result)
		return array('club'=>$result);
	}
	
	public function getClubs($data){
			
		if(tools::int($data['take'])<1)
		$data['take']=10;
		
		if($data['take']>20)
		$data['take']=20;
		
		$oderStr='ORDER BY z_site.date_create DESC';
		$db=db::init();
		if($data['cityid']>0){
			$whereStr=' AND z_site.cityid='.tools::int($data['cityid']).' ';
		}
		if($data['countryid']>0){
			$whereStr.=' AND z_city.countryid='.tools::int($data['countryid']).' ';
		}
		
		$resultcount=$db->queryFetchAllFirst('SELECT 
		  COUNT(z_site.id) AS cnt
		FROM
		  z_site 
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
					  z_site.id,
					  z_site.name,
					  z_site.address,
					  z_site.maplink,
					  z_city.countryid,
					  z_country.name_ru AS countryname,
					  z_site.cityid,
					  z_city.name as cityname,
					  if(z_domain.id>0,concat("http://",z_domain.name),CONCAT("http://r",z_site.id,".reactor.ua")) AS domain,
					  CONCAT(
						   "http://reactor.ua/uploads/sites/",
						   z_clublogo.siteid,
						   "/img/",
						   z_clublogo.file_name
						 ) AS logo
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
					LEFT JOIN z_city
					ON z_city.id=z_site.cityid
					LEFT JOIN z_country
					ON z_country.id=z_city.countryid
					WHERE z_site.sitetypeid = 7 
					AND z_site.recommend=1
					'.$whereStr.'
					'.$oderStr.'
					LIMIT '.tools::int($data['start']).','.tools::int($data['take']).'
					');
		
		foreach($result as $club){
			$clubid[$club['id']]=$club['id'];
		}
		if($result)
		return array('totalclubs'=>$resultcount[0], 'start'=>$data['start'], 'take'=>$data['take'], 'clubs'=>$result);
		
	}
}
?>