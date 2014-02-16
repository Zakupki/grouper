<?
require_once 'modules/base/models/Basemodel.php';

Class Gigs Extends Basemodel {


public function getAdminGigs(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_gigs.id,
				  DATE_FORMAT(z_gigs.date_start, "%d.%m.%Y") as date_start,
				  z_gigs.city,
				  z_gigs.place,
				  z_gigs.active 
				FROM
				  z_gigs 
				WHERE z_gigs.siteid = '.tools::int($_SESSION['Site']['id']).' 
				  AND z_gigs.userid = '.tools::int($_SESSION['User']['id']).'
				ORDER BY z_gigs.date_start ASC
				');
	if($result)
	return $result;
	
}

public function getGigs(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_gigs.id,
				  DATE_FORMAT(z_gigs.date_start, "%d.%m.%Y") as date_start,
				  z_gigs.city,
				  z_gigs.place				  
				FROM
				  z_gigs 
				WHERE z_gigs.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_gigs.active=1 AND DATE_FORMAT(DATE_ADD(z_gigs.date_start,INTERVAL 1 DAY), "%Y%m%d")>DATE_FORMAT(NOW(), "%Y%m%d")
				ORDER BY z_gigs.date_start ASC
				');
	if($result)
	return $result;
	
}

public function updateGigs($data,$deleted){
	$db=db::init();
	
	$cnt=0;
	if(is_array($data))
	foreach($data as $k=>$bg){
		if($bg['id']>0)
		$dellArr[$bg['id']]=$bg['id'];
		$bg['date_start']=explode('.', $bg['date_start']);
		if($bg['id']<1){
			    $db->exec('
				INSERT INTO z_gigs (date_start, city, place, active, siteid, userid)
				VALUES
				("'.tools::getSqlDate($bg['date_start'][2],$bg['date_start'][1],$bg['date_start'][0]).'", "'.tools::str($bg['city']).'", "'.tools::str($bg['place']).'", '.$bg['active'].', '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).')
				');
				$newid=$db->lastInsertId();
				if($newid>0)
				$dellArr[$newid]=$newid;
				unset($newid);
		}
		if($bg['id']>0){
					$db->exec('
					UPDATE z_gigs
					SET 
					active="'.$bg['active'].'",
					date_start="'.tools::getSqlDate($bg['date_start'][2],$bg['date_start'][1],$bg['date_start'][0]).'",
					city="'.tools::str($bg['city']).'",
					place="'.tools::str($bg['place']).'"
					WHERE
					id='.tools::int($bg['id']).'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
		}
	$cnt++;
	
	}
	if(is_array($dellArr))
	$delStr='z_gigs.id not in('.implode(',',$dellArr).') AND ';
		$db->exec('
				DELETE FROM 
				z_gigs
				WHERE 
				'.$delStr.' z_gigs.userid='.tools::int($_SESSION['User']['id']).'
				AND z_gigs.siteid='.tools::int($_SESSION['Site']['id']).'
				');
	
}
}
?>