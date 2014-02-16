<?
require_once 'modules/base/models/Basemodel.php';

Class Brand Extends Basemodel {

	private $registry;
	public function __construct($registry){
		$this->registry=$registry;
	}
	
	public function getBrandByCode($code){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT
		  CONCAT("/uploads/brands/",z_brand.id,"/",z_brand.logo) AS logo
		FROM
		  z_brand
		WHERE z_brand.urlcode="'.tools::str($code).'"
		LIMIT 0,1
		');
		if($result)
		return $result;
	}
	public function getBrandData(){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT
		  CONCAT("/uploads/brands/",z_brand.id,"/",z_brand.logo) AS logo,
		  z_brand.name,
		  z_user.email
		FROM
		  z_brand
		INNER JOIN z_brand_user
		ON z_brand_user.brandid=z_brand.id AND z_brand_user.userid='.tools::int($_SESSION['User']['id']).'
		INNER JOIN z_user
		ON z_user.id=z_brand_user.userid
		WHERE z_brand.id='.tools::int($_SESSION['User']['brandid']).'
		LIMIT 0,1
		');
		if($result)
		return $result;
	}
	public function updateBrandProfile($data){
		$db=db::init();
		$result=$db->exec('
		UPDATE z_brand
		INNER JOIN z_brand_user
		ON z_brand_user.brandid=z_brand.id AND z_brand_user.userid='.tools::int($_SESSION['User']['id']).'
		SET z_brand.name="'.tools::str($data['name']).'"
		WHERE z_brand.id='.tools::int($_SESSION['User']['brandid']).'');
		if($result)
		return $result;
	}
	public function getUserBrands(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT
		  CONCAT("/uploads/brands/",z_brand.id,"/",z_brand.logo) AS logo,
		  z_brand.name,
		  z_brand.id 
		FROM z_brand
		');
		if($result)
		return $result;
	}
}
?>