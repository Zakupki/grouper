<?
require_once 'modules/base/models/Basemodel.php';

Class Geo Extends Basemodel {
	
	public function getCounties($langid=1){
		if($_SESSION['langid']>0)
		$langid=$_SESSION['langid'];
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  id,
		  if('.$langid.'=1,name_ru,name_en) AS name_ru,
		  code 
		FROM
		  z_country
		WHERE active=1
		ORDER BY name_ru');
		if($result)
		return $result;
	}
}
?>