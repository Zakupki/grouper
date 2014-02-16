<?
require_once 'modules/report/models/Social.php';
Class Vk {
	
	public function __construct(){
		$this->ApplicationId = '4007856';
    	$this->Key ='GY0WgQxCfie2XY9hgk4t';
		$this->redirect_uri='http://grouper.com.ua/social/vkconnect/';
	}

	public function connect($params=array()){
		   session_start();
           if(empty($params['code'])) {
                $urlArr=parse_url($_SERVER['HTTP_REFERER']);
                $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
                $dialog_url='https://oauth.vk.com/authorize?client_id='.$this->ApplicationId.'&scope=stats,offline,wall&redirect_uri='.$this->redirect_uri.'&response_type=code';
                echo("<script> top.location.href='" . $dialog_url . "'</script>");
		   }else{
             //die('2');
		     $token_url = 'https://oauth.vk.com/oauth/access_token?client_id='.$this->ApplicationId.'&client_secret='.$this->Key.'&code='.$params['code'].'&redirect_uri='.$this->redirect_uri.'';
		     $user = json_decode(file_get_contents($token_url));
             //print_r($user);
             $user_url = 'https://api.vk.com/method/getProfiles?uid='.$user->user_id.'&access_token='.$user->access_token.'&fields=photo_50';
			 $profile = json_decode(file_get_contents($user_url));
			 //print_r($profile->response[0]);
			 if($user->user_id>0){
			 	$this->User=new User;
                    //$data
                	if(self::addAccount(array('user'=>$user,'profile'=>$profile->response[0])))
						return true;
			 }
		   }
		  
	}
	public function disconnect($id){
		$db=db::init();
		$db->exec('delete from z_social_account where id='.tools::int($id).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
	}
	function addAccount($params=array()){
				$db=db::init();
				/*$avatar=tools::GetImageFromUrl($params->photo_50);
								$tempfile="".$_SERVER['DOCUMENT_ROOT'].$avatar."";
								if(file_exists($tempfile)){
									$image=pathinfo($avatar);
									$newfile=md5(uniqid().microtime()).'.'.$image['extension'];
									rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".$siteid."/img/".$newfile."");
				}*/
				
				
								
				if(!$newfile)
				$newfile='NULL';
				
				/*
				$apprequest_url = "https://graph.facebook.com/me/feed";
								$parameters = "?access_token=" . $params['access_token'] . "&link=http://".$_SESSION['ref']."/";
								$myurl = $apprequest_url . $parameters;
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_POST, 1);
								curl_setopt($ch,CURLOPT_URL,$myurl);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								$result=curl_exec($ch);*/

        $res=$db->queryFetchRow('
        SELECT z_social_account.*,
        z_user.email,
        if(CHAR_LENGTH(z_user.password)>3,1,0) as haspassword
        FROM z_social_account
        INNER JOIN z_user
            ON z_user.id=z_social_account.userid
        WHERE z_social_account.socialid in(226,257)
        AND z_social_account.accountid='.tools::int($params['user']->user_id).'');
        if($res){
            if(!$_SESSION['User']['id']){
                $userid=$res['userid'];
                $_SESSION['User']['id']=$res['userid'];
                $_SESSION['User']['haspassword']=$res['haspassword'];

                if(strlen($res['email'])<4)
                $_SESSION['User']['noemail']=true;
                else
                $_SESSION['User']['email']=$res['email'];
            }
            $db->exec('
            UPDATE z_social_account
            SET
                token="'.$params['user']->access_token.'",
                tokenexpires='.$params['user']->expires_in.',
                name="'.$params['profile']->first_name.'",
                last_name="'.$params['profile']->last_name.'",
                date_update=NOW(),
                file_name="'.$newfile.'"
            WHERE id='.tools::int($res['id']).' AND accountid='.tools::int($params['user']->user_id).'
            ');
        }else{
            if($_SESSION['User']['id'])
                $userid=$_SESSION['User']['id'];
            else{
                $ress=$db->exec('
                    INSERT INTO z_user
                    (firstName,familyName) VALUES
                    ("'.tools::str($params['profile']->first_name).'","'.tools::str($params['profile']->last_name).'")
                ');
                /*echo ('
                    INSERT INTO z_user
                    (firstName,familyName) VALUES
                    ("'.tools::str($params['profile']->first_name).'","'.tools::str($params['profile']->last_name).'")
                ');*/
                $userid=$db->lastInsertId();
                if($userid>0){
                    mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/users/'.$userid.'/');
                    mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/users/'.$userid.'/img/');
                }
                if($userid>0){
                    $_SESSION['User']['id']=$userid;
                    $_SESSION['User']['noemail']=true;
                }
                /*echo $ress;*/
            }

            $db->exec('
            INSERT INTO z_social_account
                (userid, socialid, accountid,token,tokenexpires,name,last_name,date_update,file_name)
            VALUES
                ('.tools::int($userid).',
                257,
                '.$params['user']->user_id.',
                "'.$params['user']->access_token.'",
                '.$params['user']->expires_in.',
                "'.$params['profile']->first_name.'",
                "'.$params['profile']->last_name.'",
                NOW(),
                "'.$newfile.'"
            )');
                $Vkapi = new Vkapi;
                $resp = $Vkapi->api('groups.get',
                array('uid'=>$params['user']->user_id,
                    'access_token'=>$params['user']->access_token,
                    'extended'=>1,
                    'filter'=>'admin'
                ));
                //tools::print_r($resp);
                //die();
                $socialArr=array();
                if(count($resp['response'])>1){
                    foreach($resp['response'] as $r){
                        if($r['gid']>0)
                        $socialArr[$r['gid']]=$r['gid'];
                    }
                    if(count($socialArr)>0)
                    $db->exec('UPDATE z_group SET notconnected=0 WHERE userid='.tools::int($_SESSION['User']['id']).' AND socialid=257 AND gid IN('.implode(',',$socialArr).')');
                }

        }
	}
	
}
?>