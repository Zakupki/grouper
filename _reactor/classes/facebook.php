<?
require_once 'modules/report/models/Social.php';
Class Facebook {
	
	public function __construct(){
		$this->app_id="756878814325462";
		$this->app_secret = "980780222bd8aef33b654fded7567be5";
		$this->canvas_page="http://grouper.reactor.ua/social/fbconnect/";
		$this->my_url="http://grouper.reactor.ua/social/fbconnect/";
	}
	public function connect2(){
		
		   /*session_start();
		   $code = $_REQUEST["code"];
		
		   if(empty($code)) {
		     $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
		     $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
		       . $this->app_id . "&redirect_uri=" . urlencode($this->my_url) . "&state="
		       . $_SESSION['state']."&scope=email,user_about_me";
		
		     echo("<script> top.location.href='" . $dialog_url . "'</script>");
		   }
		
		   if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
		     $token_url = "https://graph.facebook.com/oauth/access_token?"
		       . "client_id=" . $this->app_id . "&redirect_uri=" . urlencode($this->my_url)
		       . "&client_secret=" . $this->app_secret . "&code=" . $code;
		
		     $response = file_get_contents($token_url);
		     $params = null;
		     parse_str($response, $params);
			 $graph_url = "https://graph.facebook.com/me?access_token=" 
		       . $params['access_token'];
		
		     $user = json_decode(file_get_contents($graph_url));
			 if($user->id>0 && $user->email){
			 	
				
			 	$this->User=new User;
				$this->User->loginUserByEmail($user->email);
				if($_SESSION['User']['id']>0){
						$this->User->linkFacebookUser($user,$params);
						return $_SESSION['User']['id'];
				}else{
					
					if($this->User->addFacebookUser($user,$params)){
					$this->User->loginUserByEmail($user->email);
					$this->Social=new Social;
					$sdata=$this->Social->findSocial($user->link);
					$db=db::init();
					$db->exec('
					INSERT INTO z_user_social
						(socialid, url, active, userid, sort)
					VALUES 
					  	('.tools::int($sdata['id']).', "'.tools::str($user->link).'", 1, '.tools::int($_SESSION['User']['id']).', 0 )');
					
					return $_SESSION['User']['id'];
					}
				}
				
			 }
		   }
		   else {
		     
		   }*/
	}
	public function connect($params=array()){
		   session_start();
           $db=db::init();
		   $code = $_REQUEST["code"];
		   
		   if(empty($code)) {
		     $urlArr=parse_url($_SERVER['HTTP_REFERER']);
			 if($url && $sescode){
				 $_SESSION['ref']=$url;
				 $_SESSION['scode']=$sescode;
			 }
			 $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
		     $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
		       . $this->app_id . "&redirect_uri=" . urlencode($this->my_url) . "&state="
		       . $_SESSION['state']."&scope=read_insights,email,user_about_me,manage_pages";
		
		     echo("<script> top.location.href='" . $dialog_url . "'</script>");
		   }

		   if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
             //die('1');
		   	 $token_url = "https://graph.facebook.com/oauth/access_token?"
		       . "client_id=" . $this->app_id . "&redirect_uri=" . urlencode($this->my_url)
		       . "&client_secret=" . $this->app_secret . "&code=" . $code;
		
		     $response = file_get_contents($token_url);
		     $params = null;
		     parse_str($response, $params);
			 $graph_url = "https://graph.facebook.com/me?access_token=" 
		       . $params['access_token'];
		     //tools::print_r($params);
             $user = json_decode(file_get_contents($graph_url));
             //tools::print_r($user);

             if($user->id>0 && $user->email){
			 	$this->User=new User;



                 //$newuserdata=$this->User->loginByFacebookEmail($user->email,$_SESSION['ref'],$this->siteid);

                 /*if($newuserdata['userid']>0){
                         echo 22;
                         $this->User->linkFacebookUser($user,$params,$newuserdata['userid']);
                         return $newuserdata;
                 }else{
                         echo 33;
                     if($this->User->addFacebookUser($user,$params)){
                         $newuserdata=$this->User->loginByFacebookEmail($user->email,$_SESSION['ref'],$this->siteid);
                         $this->Social=new Social;
                         $sdata=$this->Social->findSocial($user->link);
                         $db=db::init();
                         $db->exec('
                         INSERT INTO z_user_social
                             (socialid, url, active, userid, sort)
                         VALUES
                               ('.tools::int($sdata['id']).', "'.tools::str($user->link).'", 1, '.tools::int($newuserdata['userid']).', 0 )');

                         return $newuserdata;
                     }
                 }*/

                 if(!$newfile)
                     $newfile='NULL';

                 $res=$db->queryFetchRow('SELECT * FROM z_social_account WHERE socialid=255 AND accountid='.tools::int($user->id).'');
                 if($res){
                    $db->exec('
                    UPDATE z_social_account
                    SET
                        token="'.$params['access_token'].'",
                        tokenexpires='.tools::int($params['expires']).',
                        name="'.$user->first_name.'",
                        last_name="'.$user->last_name.'",
                        date_update=NOW(),
                        file_name="'.$newfile.'"
                    WHERE id='.tools::int($res['id']).' AND accountid='.tools::int($user->id).'
                    ');
                     if($res['userid'])
                         $_SESSION['User']['id']=$res['userid'];
                 }else{
                    $newuserdata=$this->User->loginByFacebookEmail($user->email);
                    if($newuserdata['userid']>0){
                        $userid=$newuserdata['userid'];
                    }
                    else{
                        $userid=$this->User->addFacebookUser($user,$params);
                    }

                    $db->exec('
                    INSERT INTO z_social_account
                        (userid, socialid, accountid,token,tokenexpires,name,last_name,date_update,file_name)
                    VALUES
                        ('.$userid.',
                        255,
                        '.$user->id.',
                        "'.$params['access_token'].'",
                        '.tools::int($params['expires']).',
                        "'.$user->first_name.'",
                        "'.$user->last_name.'",
                        NOW(),
                        "'.$newfile.'"
                    )');
                 }
                 if($_SESSION['User']['id']<1)
                     $_SESSION['User']['id']=$userid;
				
			 }
             //die('1');
		   }
		   else {
		     
		   }
        //return array('userid'=>$userid,'newuser'=>$newuser);
	}
	public function disconnect($id){
		$db=db::init();
		$db->exec('delete from z_social_account where accountid='.tools::int($id).' AND userid='.tools::int($_SESSION['User']['id']).'');
	}
	
}
?>