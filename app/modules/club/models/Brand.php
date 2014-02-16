<?
require_once 'modules/base/models/Basemodel.php';

Class Brand Extends Basemodel {

	public function getBrandList(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT
					id,
					name
					FROM z_brand
					where type=1
					');
		
		if($result)
		return $result;
	}
	public function findBrand($name){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  id,
					  name as value,
					  name as label
					FROM
					  z_brand 
					WHERE z_brand.NAME LIKE "%'.tools::str($name).'%"
					ORDER BY z_brand.NAME
					');
		if($result)
		return $result;
		}
	
	public function createBrand($name){
		$db=db::init();
		$result=$db->exec('
					INSERT INTO z_brand
					(name) VALUES
					("'.tools::str($name).'")
					');
		if($result)
		return $db->lastInsertId();
	}
	public function getSiteBrands(){
		$db=db::init();
		$result=$db->queryFetchAllFirst('
		SELECT brandid FROM z_brand_site WHERE siteid='.tools::int($_SESSION['Site']['id']).'');
		if($result)
		return $result;
	}
	public function getSiteBrandList(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
			z_brand.id,
			z_brand.name			
		FROM z_brand_site 
		INNER JOIN z_brand
		ON z_brand.id=z_brand_site.brandid
		WHERE z_brand_site.siteid='.tools::int($_SESSION['Site']['id']).'
		');
		if($result)
		return $result;
	}
}
?>