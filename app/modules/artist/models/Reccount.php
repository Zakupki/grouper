<?
require_once 'modules/base/models/Basemodel.php';

Class Reccount Extends Basemodel {
	
	public function getTitle($siteid){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  z_site.name
					FROM
					  z_site 
					WHERE z_site.id = '.tools::int($siteid).'
					AND z_site.userid = '.tools::int($_SESSION['User']['id']).'
					LIMIT 0,1
					');
		if($result['name'])
		return $result['name'];
	}
	public function updateTitle($data){
		$db=db::init();
		if(strlen(trim($data['title']))<1)
		$data['title']='Реккаунт '.tools::int($_SESSION['Site']['id']);
		$_SESSION['Site']['name']=$data['title'];
		$db->exec('
					UPDATE
						z_site 
					SET z_site.name="'.tools::str($data['title']).'"
					WHERE z_site.id = '.tools::int($_SESSION['Site']['id']).'
					AND z_site.userid = '.tools::int($_SESSION['User']['id']).'
					');
		return;
	}
	public function getAbout($siteid){
		if(!$siteid)
		$siteid=tools::int($_SESSION['Site']['id']);
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  z_site.about
					FROM
					  z_site 
					WHERE z_site.id = '.$siteid.'
					LIMIT 0,1
					');
		if($result['about'])
		return $result['about'];
	}
	public function updateAbout($data){
		$db=db::init();
		$db->exec('
					UPDATE
						z_site 
					SET z_site.about="'.tools::str(strip_tags($data['about'])).'"
					WHERE z_site.id = '.tools::int($_SESSION['Site']['id']).'
					AND z_site.userid = '.tools::int($_SESSION['User']['id']).'
					');
		return;
	}
	
	public function getDomains(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_domain.name as url,
					  z_domain.id
					FROM
					  z_domain 
					WHERE z_domain.siteid = '.tools::int($_SESSION['Site']['id']).' 
					LIMIT 0,1
					');
		if($result)
		return $result;
	}
	public function updateDomain($domains){
		$db=db::init();
		if($domains)
		
		foreach($domains as $d){
			$d['url']=str_replace('http://','',$d['url']);
			$dom=parse_url('http://'.$d['url']);
			$d['url']=str_replace('www.','',($dom['host']));
			
			if($d['id']>0 && strlen(trim($d['url']))>3){
				$db->exec("UPDATE z_domain SET name='".tools::str($d['url'])."' WHERE z_domain.id=".tools::int($d['id'])." AND siteid=".$_SESSION['Site']['id']."");
			}
			elseif($d['id']>0 && strlen(trim($d['url']))<4){
				$db->exec("DELETE FROM z_domain WHERE z_domain.id=".tools::int($d['id'])." AND siteid=".$_SESSION['Site']['id']."");
			}
			elseif(!$d['id'] && strlen(trim($d['url']))>3){
				$db->exec("DELETE FROM z_domain WHERE siteid=".$_SESSION['Site']['id']."");
				$db->exec("INSERT INTO z_domain (name,siteid,active) VALUES ('".tools::str($d['url'])."',".$_SESSION['Site']['id'].",1)");
				//$db->exec("INSERT INTO z_site_domain (domainid,siteid) VALUES (".$db->lastInsertId().",".$_SESSION['Site']['id'].")");
			}
			elseif(!$d['id'] && strlen(trim($d['url']))<4){
				
			}
			
			
		}
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_domain.name as url
					FROM
					  z_domain 
					WHERE z_domain.siteid = '.tools::int($_SESSION['Site']['id']).' 
					LIMIT 0,1
					');
		if($result)
		return $result;
	}
	public function getSiteStatus($siteid){
		$db=db::init();
		if($siteid==tools::int($_SESSION['Site']['id'])){
			$result=$db->queryFetchRowAssoc('
			SELECT 
			  z_site.active
			FROM
			  z_site 
			WHERE z_site.id = '.tools::int($siteid).' 
			LIMIT 0,1
			');
		}
		return $result['active'];
	}
	public function setSiteStatus($siteid, $active){
		$db=db::init();
		if($siteid==tools::int($_SESSION['Site']['id'])){
			$db->exec('
			UPDATE
			  z_site
			SET active='.tools::int($active).'
			WHERE z_site.id = '.tools::int($siteid).' 
			AND z_site.userid = '.tools::int($_SESSION['User']['id']).'
			');
			$_SESSION['Site']['active']=tools::int($active);
			echo tools::int($active);
		}
	}
	
}
?>