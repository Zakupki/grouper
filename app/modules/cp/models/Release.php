<?
require_once 'modules/base/models/Basemodel.php';

Class Release Extends Basemodel {
	
	
	public function getReleaseCount(){
		$db=db::init();
		$result=$db->queryFetchAllFirst('
					SELECT 
					  COUNT(z_releasetype.id) 
					FROM
					  z_releasetype 
					');
		if($result[0])
		return $result[0];	
	}
	
	
	public function getReleaseTypeList($start=0,$total=50){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_releasetype.id,
					  z_releasetype.name,
					  z_releasetype.author,
					  z_releasetype.siteid,
					  z_releasetype.recommend,
					  z_user.id AS userid,
					  z_user.login,
					  if(z_cover.id>0,CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/img/3_",
					    z_cover.url
					  ),
					  CONCAT(
					    "/uploads/sites/",
					    z_releasetype.siteid,
					    "/img/3_",
					    z_cover_default.url
					  )) AS `url` 
					FROM
					  z_releasetype 
					  LEFT JOIN
					  z_user 
					  ON z_releasetype.userid = z_user.id
					  LEFT JOIN
					  z_cover 
					  ON z_cover.id = z_releasetype.coverid 
					  LEFT JOIN
					  z_cover z_cover_default
					  ON z_cover_default.major=1 AND z_cover_default.siteid=z_releasetype.siteid
					GROUP BY z_releasetype.id 
					ORDER BY z_releasetype.date_start DESC
					LIMIT '.$start.','.$total.'
					');
		if($result)
		return $result;	
	}
	public function getReleaseTypeInner($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  z_releasetype.id,
					  z_releasetype.name,
					  z_releasetype.recommend
					FROM
					  z_releasetype 
					WHERE z_releasetype.id='.tools::int($id).'
					');
		if($result)
		return $result;
	}
	public function updateReleaseTypeInner($data){
		if($data['id']>0){
			$db=db::init();
			$db->exec('UPDATE z_releasetype SET name="'.tools::str($data['name']).'", recommend='.tools::int($data['recommend']).'
			WHERE z_releasetype.id='.tools::int($data['id']).'');
		}
	}	
}
?>