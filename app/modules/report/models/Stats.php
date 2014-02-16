<?
require_once 'modules/base/models/Basemodel.php';

Class Stats Extends Basemodel {

	private $registry;
	public function __construct($registry){
		$this->registry=$registry;
	}

	public function getStats($siteid,$statstypeid){
		$db=db::init();
        if($statstypeid==7){
            $result=$db->queryFetchAll('
            SELECT
              UNIX_TIMESTAMP(date_add(`date_start`, INTERVAL 2 HOUR))*1000 AS `date`,
              visits AS `value`
            FROM
              z_analytics_day
            WHERE siteid='.tools::int($siteid).'
            ORDER BY z_analytics_day.date_start ASC
            ');
        } else{
		$result=$db->queryFetchAll('
		SELECT 
		  UNIX_TIMESTAMP(date_add(`date`, INTERVAL 2 HOUR))*1000 AS `date`,
		  `value` 
		FROM
		  z_social_stats 
		WHERE siteid='.tools::int($siteid).' AND statstypeid='.tools::int($statstypeid).'
		ORDER BY z_social_stats.date ASC
		');
        }
		if($result)
		return $result;
	}
	public function getStatsTypesData($siteid){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  z_social_stats.`date`,
		  z_social_stats.`value`,
		  z_social_statstype.code,
		  z_social_statstype.color,
		  z_social_statstype.name,
		  z_social_statstype.id
		FROM
		  z_social_stats 
		  INNER JOIN
		  z_social_statstype 
		  ON z_social_statstype.id = z_social_stats.statstypeid 
		WHERE z_social_stats.siteid = '.tools::int($siteid).' AND z_social_stats.value>0
		AND z_social_stats.DATE = 
		  (SELECT 
		    MAX(z_social_stats.DATE) 
		  FROM
		    z_social_stats)
		GROUP BY z_social_stats.statstypeid 
		ORDER BY z_social_statstype.id ASC
		');
		
		$ga=$db->queryFetchRowAssoc('
		SELECT 
		 z_analytics_day.`id`,
		 z_analytics_day.visits
		FROM
		  z_analytics_day 
		WHERE siteid = '.tools::int($siteid).' 
		ORDER BY date_start DESC
		LIMIT 0,1');
		if($ga['id']>0)		
        $result[]=array('id'=>7,'name'=>'Google Analytics', 'code'=>'ga','value'=>$ga['visits']);
		if($result)
		return $result;
	}
}
?>