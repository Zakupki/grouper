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
				  z_city.name,
				  z_country.name_ru AS country 
				FROM
				  z_city 
				  INNER JOIN
				  z_country 
				  ON z_country.id = z_city.countryid 
				  ');
	if($result)
	return $result;
}
	public function getCity($id){
	$db=db::init();
	
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_city.id,
				  z_city.name,
				  z_city.countryid
				FROM
				  z_city 
				WHERE z_city.id='.tools::int($id).'
				  ');
	if($result)
	return $result;
}
	public function updateCityinner($data){
	$db=db::init();
	if($data['id']>0){
		$db->exec('
		UPDATE z_city
		SET name="'.$data['name'].'", countryid='.$data['countryid'].'
		WHERE id='.tools::int($data['id']).'
		');
	}else{
		$db->exec('
		INSERT INTO 
		z_city
		(name,countryid) VALUES ("'.$data['name'].'",'.$data['countryid'].')
		');
	}
}
}
?>