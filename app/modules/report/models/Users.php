<?
require_once 'modules/base/models/Basemodel.php';
require_once 'modules/artist/models/Social.php';
require_once 'modules/main/models/Reccount.php';

Class Users Extends Basemodel {
	
	private $Reccount;
	
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
					  CONCAT(
					    "/uploads/users/4_",
					    z_user.file_name
					  ) AS url 
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
	
	public function getUserProfileSocial($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_social.id AS socialid,
				  CONCAT(
				    "/uploads/",
				    z_file.subdir,
				    "/",
				    z_file.file_name
				  ) AS img,
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
	
	public function getUserReccounts(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_site.id,
					  z_site.name 
					FROM
					  z_site 
					WHERE z_site.userid = '.$_SESSION['User']['id'].' 
					  AND z_site.active = 1 
					');
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
		if($_SESSION['User']['id']==$data['userid'] && $_SESSION['User']['id']>0 ){
			if(trim($data['name'])!=$data['login'] && strlen(trim($data['name']))>0){
			$nameStr=' displayname="'.mysql_escape_string(trim($data['name'])).'", ';
			$_SESSION['User']['displayname']=$data['name'];
			}
			else
			{
			$_SESSION['User']['displayname']=$data['login'];	
			$nameStr=' displayname=NULL, ';
			}
			
			if($data['image_new']!==$data['image_current'] && !$data['image_removed']){
				$data['image_new']=str_replace('4_', '', $data['image_new']);
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['image_new']."";
				if(file_exists($tempfile)){
					$data['image_new']=pathinfo($data['image_new']);
					$newfile=md5(uniqid().microtime()).'.'.$data['image_new']['extension'];
					
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/users/".$newfile."");
					$data['image_new']=$newfile;
					
					
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
			$fileStr=' file_name="'.$data['image_new'].'",';
			$_SESSION['User']['file_name']=$data['image_new'];
			}elseif($data['image_current'] && $data['image_removed']){
				if(file_exists($_SERVER['DOCUMENT_ROOT'].$data['image_current']))
					unlink($_SERVER['DOCUMENT_ROOT'].$data['image_current']);
					$fileStr=' file_name=NULL,';
					$_SESSION['User']['file_name']=NULL;
			}
			
			if($data['reccount_info']>0 && $data['use_reccount_info']){
			$this->Reccount = new Reccount;
			$_SESSION['User']['displayname']=$this->Reccount->getTitle($data['reccount_info']);
			$reccountStr=' siteid='.tools::int($data['reccount_info']).', ';
			$nameStr=' displayname=NULL, ';
			}
			else 
			$reccountStr=' siteid=NULL, ';
			$db->exec('UPDATE z_user SET 
			website="'.mysql_escape_string(trim($data['site'])).'",
			'.$fileStr.'
			'.$nameStr.'
			'.$reccountStr.' 
			preview_text="'.tools::str(stripslashes($data['about'])).'"
			WHERE id='.tools::int($data['userid']).'');
			$this->Social= new Social;
			$linkIdArr=array();
			foreach($data['ref_id'] as $rk=>$ref){
				if($ref>0){
					
					$socilaArr=$this->Social->findSocial($data['ref'][$rk]);
					$active=1;
					if($data['ref_hide'][$rk]=='on')
					$active=0;
					$db->exec('UPDATE z_user_social SET 
					url="'.str_replace('http://','',$data['ref'][$rk]).'", 
					active='.$active.',
					socialid='.$socilaArr['id'].'
					WHERE id='.tools::int($ref).' AND userid='.$_SESSION['User']['id'].'');
					$linkIdArr[$ref]=$ref;
				}
				else{
					$socilaArr=$this->Social->findSocial($data['ref'][$rk]);
					if($socilaArr['id']>0){
						$active=1;
						if($data['ref_hide'][$rk]=='on')
						$active=0;
						$db->exec('INSERT INTO z_user_social
						(url, userid, socialid, active)
						VALUES (
						"'.str_replace('http://','',$data['ref'][$rk]).'",
						'.$_SESSION['User']['id'].',
						'.$socilaArr['id'].',
						'.$active.'
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
    public function updateProfile($data){
        $db=db::init();
        $res=$db->queryFetchRowAssoc('SELECT id FROM z_user WHERE email="'.tools::str($data['email']).'"');
        $return=array('error'=>false,'status'=>'Вы успешно обновили данные вашего профиля');
        if($res){
            $return=array('error'=>true,'status'=>'Такой email уже зарегистрирован в системе');
        }
        if(!$res && !$data['ajax']){
            $r=$db->exec('UPDATE z_user SET email="'.tools::str($data['email']).'" WHERE id='.tools::int($_SESSION['User']['id']).'');
            if($r){
                $_SESSION['User']['noemail']=null;
                $_SESSION['User']['email']=$data['email'];
            }
        }
        return json_encode($return);
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
	public function getUserCurrencyInfo($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
			SELECT
			  if(z_currency.id,z_currency.id,z_currency_default.id) as currencyid,
			  if(z_currency.id,z_currency.code, z_currency_default.code) as currency,
			  if(z_currency.id,z_currency.localname, z_currency_default.localname) as currencylocal
			FROM
			  z_user
			 LEFT JOIN z_country_currency
			 ON z_country_currency.countryid=z_user.countryid
			 LEFT JOIN z_currency
			 ON z_currency.id=z_country_currency.currencyid
			 LEFT JOIN z_currency z_currency_default
			 ON z_currency_default.default=1
			WHERE z_user.id='.tools::int($id).'
			');
		if($result)
		return $result;
	}
	function checkLoginMail($login,$email){
		$db=db::init();
		$row=$db->queryFetchRow(
		'SELECT 
			id
		FROM z_user 
		WHERE z_user.email="'.tools::str($email).'" LIMIT 0,1'
		);
		if($row['id']>0)
		return $row['id'];
	}
	function getBalance(){
		$db=db::init();
		$result=$db->queryFetchRow('
			SELECT 
			  SUM(z_operation.VALUE) AS total
			FROM
			  z_operation 
			WHERE z_operation.userid = '.tools::int($_SESSION['User']['id']).' 
			  AND z_operation.status = 2 
			');	
		if($result['total']>0)
		return $result['total'];
	}
	function getUserSocialAccounts(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
			SELECT 
			  z_social_account.id,
			  z_social_account.name,
			  z_social_account.last_name,
			  z_social_account.socialid,
			  z_social_account.accountid,
			  z_social_account.token,
			  z_social_account.tokenexpires,
			  z_social_account.userid
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
    function getUserSocialGroups(){
        $db=db::init();

        $Vkapi = new Vkapi();
        $Fbapi = new Fbapi();

        $db=db::init();
        $accounts=$db->queryFetchAllAssoc('SELECT * FROM z_social_account WHERE userid='.tools::int($_SESSION['User']['id']));
        foreach($accounts as $acc){
            if(in_array($acc['socialid'],array(257,226))){
                $resp = $Vkapi->api('groups.get',
                    array('uid'=>$acc['accountid'],
                        'access_token'=>$acc['token'],
                        'extended'=>1,
                        'filter'=>'admin',
                        'fields'=>'members_count,can_post,activity,description,city,country'
                    ));
                //$sUrl='https://api.vk.com/method/groups.getMembers?gid='.$r['gid'].'&access_token='.$acc['token'];
                //создадим объект, содержащий ответ сервера Вконтакте, который приходит в формате JSON
                /*$oResponce=null;
                $oResponce = json_decode(file_get_contents($sUrl));*/
                //tools::print_r($resp['response']);

                if(count($resp['response'])>1){
                    foreach($resp['response'] as $r){
                        if(is_array($r)){
                           /* $resp2 = $Vkapi->api('groups.getMembers',
                                array('gid'=>$r['gid'],
                                    'access_token'=>$acc['token']
                                ));
                            tools::print_r($resp2);*/
                            $socialArr[257][$r['gid']]=array('id'=>$r['gid'],'name'=>$r['name'],'img'=>$r['photo_big'],'count'=>$r['members_count'],'url'=>'http://vk.com/'.$r['screen_name'],'accountid'=>$acc['accountid'],'token'=>$acc['token']);
                        }
                    }
                }
                //tools::print_r($resp);
            }elseif($acc['socialid']==255){
                $graph_url="https://graph.facebook.com/".$acc['accountid']."/accounts?access_token=". $acc['token'];
                $user = json_decode(file_get_contents(utf8_encode($graph_url)));
                if(count($user->data)>1){
                    foreach($user->data as $r){
                        $graph_url="https://graph.facebook.com/".$r->id."?fields=picture&&access_token=". $acc['token'];
                        $picture = json_decode(file_get_contents(utf8_encode($graph_url)));
                        $socialArr[255][$r->id]=array('id'=>$r->id,'name'=>$r->name,'img'=>$picture->picture->data->url);
                    }
                }
                //tools::print_r($user);
            }
            //https://api.vk.com/method/groups.get?user_id=66748&v=5.4&access_token=533bacf01e11f55b536a565b57531ac114461ae8736d6506a3
        }
        //tools::print_r($socialArr);
        if($socialArr)
            return $socialArr;
    }
	function getUnseen($datatypeid){
		$db=db::init();
		if($_SESSION['User']['id']<1)
		return;
		if($datatypeid==6){
		$result=$db->queryFetchAllFirst('
		SELECT DISTINCT 
		  COUNT(DISTINCT z_releasetype.id) 
		FROM
		  z_releasetype 
		  INNER JOIN
		  z_release 
		  ON z_release.releasetypeid = z_releasetype.id 
		  INNER JOIN
		  z_page_visit 
		  ON z_page_visit.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_page_visit.userid='.tools::int($_SESSION['User']['id']).'
		WHERE z_releasetype.active = 1 
		  AND z_release.active = 1 
		  AND z_page_visit.date_visit < z_releasetype.date_create
		  AND z_page_visit.datatypeid='.tools::int($datatypeid).'');
		}elseif($datatypeid==5){
		$result=$db->queryFetchAllFirst('
		SELECT DISTINCT 
		  COUNT(DISTINCT z_news.id) 
		FROM
		  z_news 
		  INNER JOIN
		  z_page_visit 
		  ON z_page_visit.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_page_visit.userid='.tools::int($_SESSION['User']['id']).' 
		WHERE z_news.active = 1 
		  AND z_page_visit.date_visit < z_news.date_create
		  AND z_page_visit.datatypeid = '.tools::int($datatypeid).'');	
		}
		return $result[0];
	}
	function pageVisit($datatypeid){
		$db=db::init();
		if($_SESSION['User']['id']<1)
		return;
		$db->exec('DELETE FROM z_page_visit WHERE siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).' AND datatypeid='.tools::int($datatypeid).'');
		$db->exec('INSERT INTO z_page_visit (siteid,userid,datatypeid) VALUES ('.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).','.tools::int($datatypeid).')');
	}
	
}
?>