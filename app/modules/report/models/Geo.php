<?
require_once 'modules/base/models/Basemodel.php';

Class Geo Extends Basemodel {
	
	
	public function getCountries(){
	$db=db::init();
	
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_country.id,
				  z_country.name_ru AS name 
				FROM
				  z_country 
				WHERE z_country.active=1
				  ');
	if($result)
	return $result;
}
	public function getCities(){
	$db=db::init();
	
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_city.id,
				  z_city.name
				FROM
				  z_city
				  ');
	if($result)
	return $result;
}
public function getClubCities(){
	$db=db::init();
	
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_city.id,
				  z_city.name
				FROM
				  z_city
				INNER JOIN z_site
				ON z_site.cityid=z_city.id AND z_site.recommend=1
				group by z_city.id
				  ');
	if($result)
	return $result;
}
	
}
?>