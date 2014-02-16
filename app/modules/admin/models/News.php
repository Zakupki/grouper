<?
require_once 'modules/base/models/Basemodel.php';

Class News Extends Basemodel {
	
	
	public function getNewsList(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_news.id,
					  z_news.name,
					  z_news.userid,
					  z_news.recommend,
					  z_news.itemid,
					  z_user.login,
					  z_news.siteid,
					  IF(
					    z_image.id > 0,
					    CONCAT(
					      "/uploads/sites/",
					      z_news.siteid,
					      "/img/3_",
					      z_image.file_name
					    ),
					    CONCAT(
					      "/uploads/sites/",
					      z_news.siteid,
					      "/img/3_",
					      z_cover_default.url
					    )
					  ) AS `url` 
					FROM
					  z_news 
					  INNER JOIN
					  z_user 
					  ON z_user.id = z_news.userid 
					  LEFT JOIN
					  z_image 
					  ON z_image.itemid = z_news.itemid 
					  LEFT JOIN
					  z_cover z_cover_default 
					  ON z_cover_default.major = 1 
					  AND z_cover_default.siteid = z_news.siteid 
					GROUP BY z_news.id 
					ORDER BY z_news.date_start DESC
					');
		if($result)
		return $result;	
	}
	public function getNewsInner($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  z_news.id,
					  z_news.name,
					  z_news.recommend
					FROM
					  z_news 
					WHERE z_news.id='.tools::int($id).'
					');
		if($result)
		return $result;
	}
	public function updateNewsInner($data){
		if($data['id']>0){
			$db=db::init();
			$db->exec('UPDATE z_news SET name="'.tools::str($data['name']).'", recommend='.tools::int($data['recommend']).'
			WHERE z_news.id='.tools::int($data['id']).'');
		}
	}	
}
?>