<?

final class client{
	function _construct($registry){
		$this->registry=$registry;
	}
	function isSubdomain($subdomain){
		$db=db::init();
		$db->query('select * from z_domain where z_domain.name='.$subdomain.'');
		
	}
	function getSiteid($subdomain){
		$db=db::init();
		$row=$db->queryFetchRow('SELECT 
					z_site.id,
					z_site.socialmodeid,
					z_site.twitter,
					z_site.name,
					z_site.about,
					z_site.autoplay,
					z_site.active,
					z_site.userid,
					z_site.recommend,
					z_site.languageid,
					z_site.metatitle,
					z_site.metakeywords,
					z_site.metadescription
					FROM
					  z_domain 
					INNER JOIN z_site
					ON z_site.id=z_domain.siteid
					WHERE z_domain.name = "'.mysql_escape_string($subdomain).'" AND z_domain.active=1
					LIMIT 0,1');
		$_SESSION['Site']=$row;
		$_SESSION['langid']=$row['languageid'];
		$this->registry->langid=$row['languageid'];
		if($row['id']>0)
		return $row['id'];
	}
	function isServiceid($id){
		$db=db::init();
		$row=$db->queryFetchRow('SELECT id,socialmodeid,twitter,name,autoplay,active,about,userid,recommend,languageid,metatitle,metakeywords,metadescription FROM z_site WHERE z_site.id='.tools::int($id).'');
		$_SESSION['Site']=$row;
		$_SESSION['langid']=$row['languageid'];
		$this->registry->langid=$row['languageid'];
		if($row['id']>0)
			return $row['id'];
	}
	function getClienttype($id){
		$db=db::init();
		$row=$db->queryFetchRow('
		SELECT
		  IF(
		    z_sitetype.parentid,
		    z_sitetype.parentid,
		    z_site.sitetypeid
		  ) AS sitetypeid,
		  IF(
		    z_sitetype.parentid,
		    z_sitetype2.CODE,
		    z_sitetype.CODE
		  ) AS sitetypecode
		FROM
		  z_site 
		  LEFT JOIN
		  z_sitetype 
		  ON z_sitetype.id = z_site.sitetypeid
		  LEFT JOIN z_sitetype z_sitetype2
		  ON z_sitetype2.id=z_sitetype.parentid
		WHERE z_site.id = '.tools::int($id).'
		');
		if($row['sitetypeid']>0)
			return $row['sitetypecode'];
	}
	
}

?>