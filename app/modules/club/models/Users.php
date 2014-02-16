<?
require_once 'modules/base/models/Basemodel.php';
require_once 'modules/club/models/Social.php';

Class Users Extends Basemodel {
	
	
	public function getUserProfile($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  z_user.id,
					  z_user.website,
					  IF(
					    z_user.siteid > 0,
					    z_site.name,
					    IFNULL(z_user.displayname,z_user.login)
					  ) AS `displayname`,
					  IF(
					  	z_user.siteid > 0,
						z_site.about,
						z_user.preview_text
					  ) AS preview_text,
					  z_user.login,
					  if(z_site2.id,1,0) AS pro,
					  z_user.siteid,
					  if(z_user.file_name,CONCAT(
					    "/uploads/users/4_",
					    z_user.file_name
					  ),"/img/reactor/profile/image-na.jpg") AS url 
					FROM
					  z_user 
					  LEFT JOIN
					  z_site 
					  ON z_site.id = z_user.siteid
					  LEFT JOIN z_site z_site2
					  ON z_site2.userid=z_user.id
					  WHERE z_user.id="'.tools::int($id).'"
					  GROUP BY z_user.id
					');
		if($result['siteid']>0){
			$this->Social=new Social;
			$result['socilalist']=$this->Social->getUserSocial($result['siteid']);
		}
		else {
			$result['socilalist']=self::getUserProfileSocial($result['id']);
		}				
		return $result;
	}
	public function getUserMinInfo($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
			SELECT
			  id,
			  countryid,
			  login,
			  email,
			  notifyreply,
			  notifycomment
			FROM
			  z_user
			WHERE id='.tools::int($id).'
			');
		if($result)
		return $result;
	}
	function getUserSocialAccounts(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
			SELECT 
			  z_social_account.id,
			  z_social_account.NAME,
			  z_social_account.socialid,
			  z_social_account.accountid,
			  z_social_account.token,
			  z_social_account.tokenexpires,
			  z_social_account.userid,
			  z_user.file_name 
			FROM
			  z_social_account 
			  INNER JOIN
			  z_user 
			  ON z_user.id = z_social_account.userid 
			WHERE z_social_account.userid = '.tools::int($_SESSION['User']['id']).'
			');	
		if($result)
		return $result;
	}
		public function getUserProfileSocial($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_social.id AS socialid,
				  if(z_file.id,CONCAT(
				    "/uploads/",
				    z_file.subdir,
				    "/",
				    z_file.file_name
				  ),"/img/reactor/link.png") AS img,
				  z_user_social.url,
				  z_user_social.active 
				FROM
				  z_user_social 
				  INNER JOIN
				  z_social 
				  ON z_social.id = z_user_social.socialid 
				  LEFT JOIN
				  z_file 
				  ON z_social.preview_image = z_file.id 
				WHERE z_user_social.userid = '.tools::int($id).' 
				ORDER BY z_user_social.sort ');
	if($result)
	return $result;
}
public function getUserFullProfile($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  z_user.id,
					  z_user.login,
					  z_user.displayname,
					  z_user.preview_text,
					  z_user.pro,
					  z_user.siteid,
					  z_user.website,
					  CONCAT(
					    "/uploads/users/4_",
					    z_user.file_name
					  ) AS url
					  FROM
					  z_user
					  WHERE z_user.id='.tools::int($id).'
					');
		$linkresult=$db->queryFetchAllAssoc('
					SELECT
					  id, 
					  url,
					  active 
					FROM
					  z_user_social
					 WHERE userid='.tools::int($id).'
					');
		if($linkresult)
		$result['links']=$linkresult;
		return $result;
	}
public function updateUserProfile($data){
		$db=db::init();
		if($_SESSION['User']['id']==$data['id'] && $_SESSION['User']['id']>0 ){
			if(trim($data['displayname'])!=$data['login'] && strlen(trim($data['displayname']))>0){
			$nameStr=' displayname="'.mysql_escape_string(trim($data['displayname'])).'", ';
			$_SESSION['User']['displayname']=$data['displayname'];
			}
			else
			{
			$_SESSION['User']['displayname']=$data['login'];	
			$nameStr=' displayname=NULL, ';
			}
			
			if($data['url_deleted']){
				tools::delImg($data['url_deleted']);
				$fileStr=' file_name=NULL,';
				$_SESSION['User']['file_name']=NULL;
			}
			if($data['url']){
				if($data['url_new'] || $data['url_deleted']){
				$data['url']=str_replace('4_', '', $data['url']);
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['url']."";
				if(file_exists($tempfile)){
					$data['url']=pathinfo($data['url']);
					$newfile=md5(uniqid().microtime()).'.'.$data['url']['extension'];
					
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/users/".$newfile."");
					$data['url']=$newfile;
					
					
					if(file_exists($_SERVER['DOCUMENT_ROOT'].$data['image_current']))
					unlink($_SERVER['DOCUMENT_ROOT'].$data['image_current']);
					
					
					$data['image_current']=str_replace('4_', '3_', $data['image_current']);
					
					if(file_exists($_SERVER['DOCUMENT_ROOT'].$data['image_current'])){
					unlink($_SERVER['DOCUMENT_ROOT'].$data['image_current']);
					}
					
					$data['image_current']=str_replace('3_', '', $data['image_current']);
					
					if(file_exists($_SERVER['DOCUMENT_ROOT'].$data['image_current']))
					unlink($_SERVER['DOCUMENT_ROOT'].$data['image_current']);
					
				}
				$fileStr=' file_name="'.$data['url'].'",';
				$_SESSION['User']['file_name']=$data['url'];
				}
			}
			$db->exec('UPDATE z_user SET 
			'.$fileStr.'
			'.$nameStr.'
			preview_text="'.tools::str(stripslashes($data['preview_text'])).'"
			WHERE id='.tools::int($data['id']).'');
			$this->Social= new Social;
			$linkIdArr=array();
			foreach($data['links'] as $ref){
				if($ref['id']>0){
					
					$socilaArr=$this->Social->findSocial($ref['url']);
					$db->exec('UPDATE z_user_social SET 
					url="'.tools::str(str_replace('http://','',$ref['url'])).'", 
					socialid='.$socilaArr['id'].'
					WHERE id='.tools::int($ref['id']).' AND userid='.$_SESSION['User']['id'].'');
					$linkIdArr[$ref['id']]=$ref['id'];
				}
				else{
					$socilaArr=$this->Social->findSocial($ref['url']);
					if($socilaArr['id']>0){
						$db->exec('INSERT INTO z_user_social
						(url, userid, socialid, active)
						VALUES (
						"'.tools::str(str_replace('http://','',$ref['url'])).'",
						'.$_SESSION['User']['id'].',
						'.$socilaArr['id'].',
						1
						)
						');
						$newid=$db->lastInsertId();
						$linkIdArr[$newid]=$newid;
					}
				}
			}
			if(count($linkIdArr)>0)
			$db->exec('DELETE FROM z_user_social WHERE id NOT IN('.implode(',',$linkIdArr).') AND userid='.$_SESSION['User']['id'].'');
			
		}
		
		return $result;
	}
	public function updateRegisterInfo($data){
		$db=db::init();
		$this->user=new user;
		$db->exec('UPDATE z_user SET notifyreply='.tools::int($data['notifyreply']).', notifycomment='.tools::int($data['notifycomment']).' WHERE id='.tools::int($_SESSION['User']['id']).'');
		//$userData=self::getUserCurrencyInfo(tools::int($_SESSION['User']['id']));
		//$_SESSION['User']['countryid']=tools::int($data['country']);
		//$_SESSION['User']['currencyid']=$userData['currencyid'];
		//$_SESSION['User']['currency']=$userData['currency'];
		//$_SESSION['User']['currencylocal']=$userData['currencylocal'];
		
		
		$this->user->changePassword($data['password_old'],$data['password'],$data['password_check']);
		return true;
	}
	public function getSitevisitors(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT
					  z_user.id,
					  z_user_login.`date_create`,
					  z_user.`displayname` as name,
					  z_user.`email`,
					  z_user.`phone`,
					  CONCAT(
					    "/uploads/users/2_",
					    z_user.file_name
					  ) AS avatar,
					  CONCAT(
					    "/uploads/users/9_",
					    z_user.file_name
					  ) AS avatar2
					FROM
					  z_user_login
					INNER JOIN z_user
					ON z_user.id=z_user_login.`userid`
					WHERE z_user_login.`siteid` = '.tools::int($_SESSION['Site']['id']).'
					GROUP BY z_user_login.`userid`
					');
		if($result)
		return $result;
	}
	public function getSitevisitorsShort(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT
					  z_user.id,
					  z_user.`email` AS name
					FROM
					  z_user_login
					INNER JOIN z_user
					ON z_user.id=z_user_login.`userid`
					WHERE z_user_login.`siteid` = '.tools::int($_SESSION['Site']['id']).'
					GROUP BY z_user_login.`userid`
					');
		if($result)
		return $result;
	}
	public function applyCard($data){
		$db=db::init();	
		if($data['clubcardid']>0){
			
			if($data['state']==3)
			$stateSql=', state=1';
			
			$db->exec('UPDATE z_clubcard SET 
			name="'.tools::str($data['firstname']).'",
			lastname="'.tools::str($data['lastname']).'"
			'.$stateSql.'
			WHERE id='.tools::int($data['clubcardid']).' 
			AND siteid='.tools::int($_SESSION['Site']['id']).' 
			AND userid='.tools::int($_SESSION['User']['id']).'
			');
		}else{
			$filename='NULL';
			if($data['url']){
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['url']."";
				if(file_exists($tempfile)){
					$data['url']=pathinfo($data['url']);
					$newfile=md5(uniqid().microtime()).'.'.$data['url']['extension'];
					copy($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/users/".$newfile."");
					$data['url']=$newfile;
				}
				$filename=$data['url'];
			}
			$db->exec('INSERT INTO z_clubcard
			(name,lastname,siteid,userid,file_name,state) VALUES(
			"'.tools::str($data['firstname']).'",
			"'.tools::str($data['lastname']).'",
			'.tools::int($_SESSION['Site']['id']).',
			'.tools::int($_SESSION['User']['id']).',
			"'.$filename.'",
			1
			)
			');
		}
	}
	public function getUserCard($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  z_user.id AS userid,
					  if(z_clubcard.id>0,z_clubcard.name,z_user.displayname) as firstname,
					  z_clubcard.lastname,
					  if(z_clubcard.id>0,z_clubcard.phone,z_user.phone) AS phone,
					  z_clubcard.gender,
					  z_clubcard.date_birthday,
					  z_clubcard.id AS clubcardid,
					  if(z_clubcard.state,z_clubcard.state,0) AS state,
					  if(CHAR_LENGTH(z_clubcard.file_name)>4,
					  CONCAT(
					    "/uploads/users/4_",
					    z_clubcard.file_name
					  ),
					  CONCAT(
					    "/uploads/users/4_",
					    z_user.file_name
					  )) as url,
					  z_clubcard.discount,
					  z_clubcard.number
					  FROM
					  z_user
					  LEFT JOIN z_clubcard
					  ON z_clubcard.userid=z_user.id
					  AND z_clubcard.siteid='.tools::int($_SESSION['Site']['id']).'
					  WHERE z_user.id='.tools::int($id).'
					');
		return $result;
	}
}
?>