<?
class user {
	function __construct(){
	$this->adminemail='admin@reactor.ua';	
	}
	function getByActCode($code){
		$db=db::init();
		if($code)
		$res=$db->queryFetchRow(
		'SELECT id,email FROM z_user WHERE activationcode="'.tools::str($code).'" AND activation=0');
        if($res)
		return $res;
		
	}
	function activatebrandUser($data){
		if($data['password'] && $data['password']==$data['passwordrepeat'])	
		{
			$db=db::init();
			$res=$db->queryFetchRow(
			'SELECT id,email FROM z_user WHERE activationcode="'.tools::str($data['code']).'" AND activation=0');
			if($res['id']>0)
			{
			$data['password']=md5($data['password'].MD5_KEY);
			$res2=$db->exec('UPDATE z_user SET activationcode="NULL", activation=1, password="'.$data['password'].'" WHERE id='.$res['id'].'');
			if($res2){
				$subject = "Регистрация в системе Clubsreport завершена";
				$message = "Здравствуйте!\n\nВы успешно создали пароль для входа в систему Clubsreport.\n\nС уважением, Администрация сайта Clubsreport";
				$smtp=new smtp;
				$smtp->Connect(SMTP_HOST);
				$smtp->Hello(SMTP_HOST);
				$smtp->Authenticate('support@clubsreport.com', 'Z1IRldqU');
				$smtp->Mail('support@clubsreport.com');
				$smtp->Recipient($res['email']);
				$smtp->Data($message, $subject);
			}
			
			}
			return $res2;
		}
			return false;
	}
	
	function activateUser($code){
		$db=db::init();
		$res=$db->queryFetchRow(
		'SELECT id FROM z_user WHERE activationcode="'.tools::str($code).'" AND activation=0');
		if($res['id']>0)
		{
			$db->exec("UPDATE z_user SET activationcode='NULL', activation=1 WHERE id=".$res['id']."");
			
			$row=$db->queryFetchRow(
			'SELECT 
			  z_user.id,
			  z_usertype_user.usertypeid,
			  z_user.login,
			  z_user.countryid,
			  z_user.file_name,
			  if(z_user.password,1,0) as haspassword,
			  if(z_currency.id,z_currency.id,z_currency_default.id) as currencyid,
			  if(z_currency.id,z_currency.code, z_currency_default.code) as currency,
			  if(z_currency.id,z_currency.localname, z_currency_default.localname) as currencylocal,
			  IF(
			    z_user.siteid > 0,
				z_site.NAME,
				IFNULL(z_user.displayname,z_user.login)
				) AS `displayname`,
			  if(SUM(z_operation.VALUE)>0,SUM(z_operation.VALUE),0) AS money,
			  z_user.email,
			  z_user.file_name
			FROM
			  z_user 
			  LEFT JOIN
			  z_site 
			  ON z_site.id = z_user.siteid
			  INNER JOIN
			  z_usertype_user 
			  ON z_usertype_user.userid = z_user.id 
			  LEFT JOIN
			  z_operation 
			  ON z_operation.userid = z_user.id AND z_operation.status=2
			  LEFT JOIN z_country_currency
			  ON z_country_currency.countryid=z_user.countryid
			  LEFT JOIN z_currency
			  ON z_currency.id=z_country_currency.currencyid
			  LEFT JOIN z_currency z_currency_default
			  ON z_currency_default.default=1
			WHERE z_user.id='.$res['id'].'
			GROUP BY z_user.id 
			LIMIT 0,1
			');
			if($row['id']>0){
				if($remember){
					$key=md5($_SESSION['Site']['id'].$email.$password.microtime());
					$db->exec('UPDATE z_user SET authkey="'.$key.'" WHERE z_user.id='.$row['id'].'');
					setcookie("react", $key, time()+60*60*24*15, '/');
				}
				$sites=$db->queryFetchAllFirst('
				SELECT distinct(id) FROM z_site WHERE z_site.userid='.$row['id'].'');
				if(count($sites)>0){
				$row['reccounts']=$sites;
				}
				$_SESSION['User']=$row;

            }
            return $res;
		}
		else
		return false;
	}
	function addUser($data){
		
		$data['activationcode']=md5(microtime(). $data['email'].MD5_KEY . rand());
		$data['password']=md5($data['password'].MD5_KEY);
		

		$subject = "Подтверждение регистрации";
		$message = "Здравствуйте! Спасибо за регистрацию на сайте ".$_SERVER['HTTP_HOST']."\n\nДля того чтобы войти в свой аккуант его нужно активировать.\n\nЧтобы активировать ваш аккаунт, перейдите по ссылке:\n\nhttp://".$_SERVER['HTTP_HOST']."/activate/?act=".$data['activationcode']."\n\nС уважением, Администрация сайта ".$_SERVER['HTTP_HOST']."";
		$smtp=new smtp;
		$smtp->Connect(SMTP_HOST);
		$smtp->Hello(SMTP_HOST);
        $smtp->Authenticate('info@group.reactor.ua', 'gykTNpbG');
        $smtp->Mail('info@group.reactor.ua');
		$smtp->Recipient($data['email']);
		$smtp->Data($message, $subject);
		
		$db=db::init();
		$db->exec('INSERT INTO z_user (login, password, firstName, email, familyName, secondName, country, city, phone, question, answer, cash, activation, activationcode)
		 values ("'.$data['login'].'", "'.$data['password'].'", "'.$data['firstName'].'", "'.$data['email'].'", "'.$data['familyName'].'", "'.$data['secondName'].'", 
		 "'.$data['country'].'", "'.$data['city'].'", "'.$data['phone'].'", "'.$data['question'].'", "'.$data['answer'].'", "'.$data['cash'].'", 0, "'.$data['activationcode'].'")');
		$newuserid=$db->lastInsertId();
		//$db->exec('INSERT INTO z_usertype_user (userid, usertypeid) VALUES ('.$newuserid.',2)');
		if($newuserid>0){

            $message3 = "В системе grouper.com.ua был зарегистрирован новый пользователь с ID ".$newuserid.", email: ".$data['email'].".\n\nПросмотреть всех пользователей: http://".$_SERVER['HTTP_HOST']."/admin/users/";
            $subject3 = "Регистрация нового пользователя";
            $smtp3=new smtp;
            $smtp3->Connect(SMTP_HOST);
            $smtp3->Hello(SMTP_HOST);
            $smtp3->Authenticate('info@group.reactor.ua', 'gykTNpbG');
            $smtp3->Mail('info@group.reactor.ua');
            $smtp3->Recipient('support@grouper.com.ua');
            $smtp3->Data($message3, $subject3);

		    mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/users/'.$newuserid.'/');
            mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/users/'.$newuserid.'/img/');
        }
		
	}
	function AdminAddUser($data){
		if($data['email'] && $data['password']==$data['passwordagain']){
		$data['password']=md5($data['password'].MD5_KEY);
		$db=db::init();
		$db->exec('INSERT INTO z_user (login, password, firstName, email, familyName, secondName, country, city, phone, question, answer, cash, activation)
		 values ("'.$data['login'].'", "'.$data['password'].'", "'.$data['firstName'].'", "'.$data['email'].'", "'.$data['familyName'].'", "'.$data['secondName'].'", 
		 "'.$data['country'].'", "'.$data['city'].'", "'.$data['phone'].'", "'.$data['question'].'", "'.$data['answer'].'", "'.$data['cash'].'", 1)');
		$db->exec('INSERT INTO z_usertype_user (userid, usertypeid) VALUES ('.$db->lastInsertId().',2)');
		}
	}
	
	function addFacebookUser($data, $params){
		$db=db::init();
		/*$avatar=tools::GetFacebookImageFromUrl('http://graph.facebook.com/'.$data->id.'/picture?type=large');
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$avatar."";
				if(file_exists($tempfile)){
					$image=pathinfo($avatar);
					$newfile=md5(uniqid().microtime()).'.'.$image['extension'];
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/users/".$newfile."");
				}*/
		
		
		if(!$newfile)
		$newfile='NULL';
		
		$db->exec('INSERT INTO z_user (login, email, preview_text, file_name, activation)
		 values ("'.$data->name.'", "'.$data->email.'", "'.$data->bio.'", "'.$newfile.'", 1)');
		$newuserid=$db->lastInsertId();
		
		$apprequest_url = "https://graph.facebook.com/me/feed";
		$parameters = "?access_token=" . $params['access_token'] . "&link=http://".$_SESSION['ref']."/";
		$myurl = $apprequest_url . $parameters;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_URL,$myurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result=curl_exec($ch);
		
		/*$db->exec('INSERT INTO z_social_account (socialid, accountid,token,tokenexpires,userid)
		VALUES (255,'.$data->id.',"'.$params['access_token'].'",'.$params['expires'].','.$newuserid.')');*/
		
		$db->exec('INSERT INTO z_usertype_user (userid, usertypeid) VALUES ('.$newuserid.',2)');
		if($newuserid>0)
		return $newuserid;
	}
	function linkFacebookUser($data, $params, $userid){
		$db=db::init();
		$res=$db->queryFetchAllAssoc('SELECT * from z_social_account where accountid='.$data->id.' AND socialid=255 AND userid='.tools::int($userid).'');
        echo ('SELECT * from z_social_account where accountid='.$data->id.' AND socialid=255 AND userid='.tools::int($userid).'');
        tools::print_r($res);
        //if(!$res)
        /*$db->exec('INSERT INTO z_social_account (socialid, accountid,token,tokenexpires,userid)
		VALUES (255,'.$data->id.',"'.$params['access_token'].'",'.$params['expires'].','.tools::int($userid).')');*/
	}
	
	function loginAdmin($email, $password, $remember=null){
		$password=md5($password.MD5_KEY);
		$db=db::init();
		$row=$db->queryFetchRow(
		'SELECT 
			z_user.id,
			z_user.pro,
			z_user.file_name,
			z_usertype_user.usertypeid,
			if(z_user.password,1,0) as haspassword,
			z_user.login,
			z_user.email,
			IF(
			    z_user.siteid > 0,
				z_site.NAME,
				IFNULL(z_user.displayname,z_user.login)
				) AS `displayname`
		FROM z_user 
		INNER JOIN z_usertype_user 
			ON z_usertype_user.userid=z_user.id
		LEFT JOIN
			  z_site 
			  ON z_site.id = z_user.siteid
		WHERE z_user.email="'.mysql_escape_string($email).'" AND z_user.PASSWORD="'.$password.'"
		GROUP BY z_user.id 
		LIMIT 0,1'
		);
		if($row['id']>0)
		{
			if($remember){
				$key=md5($_SESSION['Site']['id'].$email.$password.microtime());
				$db->exec('UPDATE z_user SET authkey="'.$key.'" WHERE z_user.id='.$row['id'].'');
				setcookie("reactlog", $key, time()+60*60*24*15);
			}
		return $row;
		}
	}
	function loginUser($email, $password, $remember){
        $password=md5($password.MD5_KEY);
        $db=db::init();
		$row=$db->queryFetchRow(
		'SELECT 
		  z_user.id,
		  z_usertype_user.usertypeid,
		  z_user.login,
		  z_user.countryid,
		  z_user.file_name,
		  if(z_user.password,1,0) as haspassword,
		  if(z_currency.id,z_currency.id,z_currency_default.id) as currencyid,
		  if(z_currency.id,z_currency.code, z_currency_default.code) as currency,
		  if(z_currency.id,z_currency.localname, z_currency_default.localname) as currencylocal,
		  IF(
		    z_user.siteid > 0,
			z_site.NAME,
			IFNULL(z_user.displayname,z_user.login)
			) AS `displayname`,
		  if(SUM(z_operation.VALUE)>0,SUM(z_operation.VALUE),0) AS money,
		  z_user.email,
		  z_user.file_name
		FROM
		  z_user 
		  LEFT JOIN
		  z_site 
		  ON z_site.id = z_user.siteid
		  LEFT JOIN
		  z_usertype_user 
		  ON z_usertype_user.userid = z_user.id 
		  LEFT JOIN
		  z_operation 
		  ON z_operation.userid = z_user.id AND z_operation.status=2
		  LEFT JOIN z_country_currency
		  ON z_country_currency.countryid=z_user.countryid
		  LEFT JOIN z_currency
		  ON z_currency.id=z_country_currency.currencyid
		  LEFT JOIN z_currency z_currency_default
		  ON z_currency_default.default=1
		WHERE z_user.email="'.tools::str($email).'" AND z_user.PASSWORD="'.$password.'" AND z_user.activation=1
		GROUP BY z_user.id 
		LIMIT 0,1
		');
        //echo
		if($row['id']>0){
			if($remember){
				$key=md5($_SESSION['Site']['id'].$email.$password.microtime());
				$db->exec('DELETE FROM z_auth WHERE userid='.$row['id'].' AND siteid='.tools::int($_SESSION['Site']['id']).'');
				$db->exec('INSERT INTO z_auth (authkey,siteid,userid) VALUES ("'.$key.'",'.tools::int($_SESSION['Site']['id']).','.$row['id'].')');
				setcookie("react", $key, time()+60*60*24*15, '/');
			}
			/*$sites=$db->queryFetchAllFirst('
			SELECT distinct(z_site.id) FROM 
			z_site 
			INNER JOIN
			  z_timeorder 
			  ON z_timeorder.siteid = z_site.id 
			  AND z_timeorder.date_end > NOW()
			WHERE z_site.userid='.$row['id'].'');
			if(count($sites)>0){
			$row['reccounts']=$sites;
			if($row['id']!=$_SESSION['Site']['userid'] && in_array($_SESSION['Site']['id'],$sites))
			$_SESSION['Site']['userid']=$row['id'];
			}*/
		}
		else
		{
			setcookie("react", $key, time()-61*60*24*15, '/');	
		}
		
		if($row['id']>0)
		return $row;
	}
	function loginReportUser($email, $password, $remember,$brandcode){
		if(strlen($brandcode)>0 && $email==$this->adminemail)
		return self::loginReporAdmin($email,$password,$brandcode,$remember);
		
		$password=md5($password.MD5_KEY);
		$db=db::init();
		
		if(strlen($brandcode)>0)
		$WhereSQL=' AND z_brand.urlcode="'.tools::str($brandcode).'"';
		
		$row=$db->queryFetchRow(
		'SELECT 
		  z_user.id,
		  z_usertype_user.usertypeid,
		  z_user.login,
		  z_user.file_name,
		  z_user.email,
		  z_user.file_name,
		  z_brand_user.brandid,
		  z_brand.name as brandname,
		  if(z_user.password,1,0) as haspassword,
		  CONCAT("/uploads/brands/",z_brand.id,"/",z_brand.logo) AS brandlogo
		FROM
		  z_user 
		  INNER JOIN
		  z_usertype_user 
		  ON z_usertype_user.userid = z_user.id AND z_usertype_user.usertypeid=3
		  INNER JOIN z_brand_user
		  ON z_brand_user.userid=z_user.id
		  INNER JOIN z_brand
		  ON z_brand.id=z_brand_user.brandid
		WHERE z_user.email="'.tools::str($email).'" AND z_user.PASSWORD="'.$password.'" '.$WhereSQL.'
		GROUP BY z_user.id 
		LIMIT 0,1
		');
		if($row['id']>0){
			if($remember){
				$key=md5("3".$email.$password.microtime());
				$db->exec('DELETE FROM z_auth WHERE userid='.$row['id'].' AND siteid=3');
				$db->exec('INSERT INTO z_auth (authkey,siteid,userid) VALUES ("'.$key.'",3,'.$row['id'].')');
				setcookie("report", $key, time()+60*60*24*15, '/');
			}
		}
		else
		{
			setcookie("report", $key, time()-61*60*24*15, '/');	
		}
		
		if($row['id']>0)
		return $row;
	}
	function loginReporAdmin($email,$password,$brandcode,$remember){
		$password=md5($password.MD5_KEY);
		$db=db::init();
		
		$rw=$db->queryFetchRowAssoc('
		SELECT 
		  z_user.id
		FROM
		  z_user
		WHERE z_user.email="'.$this->adminemail.'" AND z_user.PASSWORD="'.$password.'" 
		LIMIT 0,1
		');
		if($rw['id']>0){
		$row=$db->queryFetchRow(
		'SELECT 
		  z_user.id,
		  z_usertype_user.usertypeid,
		  z_user.login,
		  z_user.file_name,
		  z_user.email,
		  z_user.file_name,
		  z_brand_user.brandid,
		  z_brand.name as brandname,
		  if(z_user.password,1,0) as haspassword,
		  CONCAT("/uploads/brands/",z_brand.id,"/",z_brand.logo) AS brandlogo
		FROM
		  z_user 
		  INNER JOIN
		  z_usertype_user 
		  ON z_usertype_user.userid = z_user.id AND z_usertype_user.usertypeid=3
		  INNER JOIN z_brand_user
		  ON z_brand_user.userid=z_user.id
		  INNER JOIN z_brand
		  ON z_brand.id=z_brand_user.brandid
		WHERE z_brand.urlcode="'.tools::str($brandcode).'"
		GROUP BY z_user.id 
		LIMIT 0,1
		');
		if($row['id']>0){
			if($remember){
				$key=md5("3".$email.$password.microtime());
				$db->exec('DELETE FROM z_auth WHERE userid='.$row['id'].' AND siteid=3');
				$db->exec('INSERT INTO z_auth (authkey,siteid,userid) VALUES ("'.$key.'",3,'.$row['id'].')');
				setcookie("report", $key, time()+60*60*24*15, '/');
			}
		}
		else
		{
			setcookie("report", $key, time()-61*60*24*15, '/');	
		}
		
		if($row['id']>0)
		return $row;
		}
	}
	
	function loginUserByEmail($email, $remember=true){
		$db=db::init();
		$row=$db->queryFetchRow(
		'SELECT 
		  z_user.id,
		  z_usertype_user.usertypeid,
		  z_user.login,
		  z_user.countryid,
		  z_user.file_name,
		  if(z_user.password,1,0) as haspassword,
		  if(z_currency.id,z_currency.id,z_currency_default.id) as currencyid,
		  if(z_currency.id,z_currency.code, z_currency_default.code) as currency,
		  if(z_currency.id,z_currency.localname, z_currency_default.localname) as currencylocal,
		  IF(
		    z_user.siteid > 0,
			z_site.NAME,
			IFNULL(z_user.displayname,z_user.login)
			) AS `displayname`,
		  if(SUM(z_operation.VALUE)>0,SUM(z_operation.VALUE),0) AS money,
		  z_user.email,
		  z_user.file_name
		FROM
		  z_user 
		  LEFT JOIN
		  z_site 
		  ON z_site.id = z_user.siteid
		  INNER JOIN
		  z_usertype_user 
		  ON z_usertype_user.userid = z_user.id 
		  LEFT JOIN
		  z_operation 
		  ON z_operation.userid = z_user.id AND z_operation.status=2
		  LEFT JOIN z_country_currency
		  ON z_country_currency.countryid=z_user.countryid
		  LEFT JOIN z_currency
		  ON z_currency.id=z_country_currency.currencyid
		  LEFT JOIN z_currency z_currency_default
		  ON z_currency_default.default=1
		WHERE z_user.email="'.tools::str($email).'"
		GROUP BY z_user.id 
		LIMIT 0,1
		');
		
		if($row['id']>0){
			if($remember){
				$key=md5($_SESSION['Site']['id'].$email.$email.microtime());
				$db->exec('DELETE FROM z_auth WHERE userid='.$row['id'].' AND siteid='.tools::int($_SESSION['Site']['id']).'');
				$db->exec('INSERT INTO z_auth (authkey,siteid,userid) VALUES ("'.$key.'",'.tools::int($_SESSION['Site']['id']).','.$row['id'].')');
				setcookie("react", $key, time()+60*60*24*15, '/');
			}
			/*$sites=$db->queryFetchAllFirst('
			SELECT distinct(z_site.id) FROM 
			z_site 
			INNER JOIN
			  z_timeorder 
			  ON z_timeorder.siteid = z_site.id 
			  AND z_timeorder.date_end > NOW()
			WHERE z_site.userid='.$row['id'].'');
			if(count($sites)>0){
			$row['reccounts']=$sites;
			if($row['id']!=$_SESSION['Site']['userid'] && in_array($_SESSION['Site']['id'],$sites))
			$_SESSION['Site']['userid']=$row['id'];
			}*/
		}
		else
		{
			setcookie("react", $key, time()-61*60*24*15, '/');	
		}
		
		if($row['id']>0){
		$_SESSION['User']=$row;
		return $row;
		}
	}
	function loginUserById($id, $remember=true){
		$db=db::init();
		$row=$db->queryFetchRow(
		'SELECT 
		  z_user.id,
		  z_usertype_user.usertypeid,
		  z_user.login,
		  z_user.countryid,
		  z_user.file_name,
		  if(z_user.password,1,0) as haspassword,
		  if(z_currency.id,z_currency.id,z_currency_default.id) as currencyid,
		  if(z_currency.id,z_currency.code, z_currency_default.code) as currency,
		  if(z_currency.id,z_currency.localname, z_currency_default.localname) as currencylocal,
		  IF(
		    z_user.siteid > 0,
			z_site.NAME,
			IFNULL(z_user.displayname,z_user.login)
			) AS `displayname`,
		  if(SUM(z_operation.VALUE)>0,SUM(z_operation.VALUE),0) AS money,
		  z_user.email,
		  z_user.file_name
		FROM
		  z_user 
		  LEFT JOIN
		  z_site 
		  ON z_site.id = z_user.siteid
		  INNER JOIN
		  z_usertype_user 
		  ON z_usertype_user.userid = z_user.id 
		  LEFT JOIN
		  z_operation 
		  ON z_operation.userid = z_user.id AND z_operation.status=2
		  LEFT JOIN z_country_currency
		  ON z_country_currency.countryid=z_user.countryid
		  LEFT JOIN z_currency
		  ON z_currency.id=z_country_currency.currencyid
		  LEFT JOIN z_currency z_currency_default
		  ON z_currency_default.default=1
		WHERE z_user.id='.tools::int($id).'
		GROUP BY z_user.id 
		LIMIT 0,1
		');
		
		if($row['id']>0){
			if($remember){
				$key=md5($_SESSION['Site']['id'].$email.$email.microtime());
				$db->exec('DELETE FROM z_auth WHERE userid='.$row['id'].' AND siteid='.tools::int($_SESSION['Site']['id']).'');
				$db->exec('INSERT INTO z_auth (authkey,siteid,userid) VALUES ("'.$key.'",'.tools::int($_SESSION['Site']['id']).','.$row['id'].')');
				setcookie("react", $key, time()+60*60*24*15, '/');
			}
			$sites=$db->queryFetchAllFirst('
			SELECT distinct(z_site.id) FROM 
			z_site 
			INNER JOIN
			  z_timeorder 
			  ON z_timeorder.siteid = z_site.id 
			  AND z_timeorder.date_end > NOW()
			WHERE z_site.userid='.$row['id'].'');
			if(count($sites)>0){
			$row['reccounts']=$sites;
				if($row['id']!=$_SESSION['Site']['userid'] && in_array($_SESSION['Site']['id'],$sites)){
					$size = new Tools;
$_SESSION['Site']['disk']=$size->size($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$_SESSION['Site']['id'].'/');
					$_SESSION['Site']['userid']=$row['id'];
				}
			}
		}
		else
		{
			setcookie("react", $key, time()-61*60*24*15, '/');	
		}
		
		if($row['id']>0){
		$_SESSION['User']=$row;
		$db->exec('INSERT INTO z_user_login (userid,siteid) VALUES ('.tools::int($row['id']).','.tools::int($_SESSION['Site']['id']).')');
		return $row;
		}
	}
	
	function loginByFacebookEmail($email){
		$db=db::init();
		$row=$db->queryFetchRow(
		'SELECT 
		  z_user.id
		FROM
		  z_user 
		  INNER JOIN
		  z_usertype_user 
		  ON z_usertype_user.userid = z_user.id 
		WHERE z_user.email="'.tools::str($email).'"
		');
		$data['userid']=$row['id'];
		/*if($row['id']>0){
			$key=md5($siteid.$email.microtime());
			$data['key']=$key;
			$db->exec('DELETE FROM z_auth WHERE userid='.$row['id'].' AND siteid='.tools::int($siteid).'');
			$db->exec('INSERT INTO z_auth (authkey,siteid,userid,ip,expires) VALUES ("'.$key.'",'.tools::int($siteid).','.$row['id'].',INET_ATON("'.$_SERVER['REMOTE_ADDR'].'"), UNIX_TIMESTAMP(DATE_ADD(NOW(), INTERVAL 30 SECOND)))');
		}*/

		if($data['userid']>0){
        return $data;
		}
	}
	
	function loginAsAdmin($password,$remember){
		$db=db::init();
		$password=md5($password.MD5_KEY);
		$rw=$db->queryFetchRowAssoc('
		SELECT 
		  z_user.id
		FROM
		  z_user
		WHERE z_user.email="'.$this->adminemail.'" AND z_user.PASSWORD="'.$password.'" 
		LIMIT 0,1
		');
		if($rw['id']>0){
			$row=$db->queryFetchRowAssoc(
		'SELECT 
		  z_user.id,
		  z_usertype_user.usertypeid,
		  z_user.login,
		  z_user.file_name,
		  if(z_user.password,1,0) as haspassword,
		  IF(
		    z_user.siteid > 0,
			z_site.NAME,
			IFNULL(z_user.displayname,z_user.login)
			) AS `displayname`,
		  SUM(z_operation.VALUE) AS money,
		  z_user.email
		FROM
		  z_site
		  INNER JOIN
		  z_user 
		  ON z_site.userid = z_user.id
		  INNER JOIN
		  z_usertype_user 
		  ON z_usertype_user.userid = z_user.id 
		  LEFT JOIN
		  z_operation 
		  ON z_operation.userid = z_user.id
		WHERE z_site.id='.tools::int($_SESSION['Site']['id']).'
		GROUP BY z_user.id 
		LIMIT 0,1'
		);
		if($row['id']>0){
			/*if($remember){
				$key=md5($_SESSION['Site']['id'].$email.$password.microtime());
				$db->exec('DELETE FROM z_auth WHERE userid='.$row['id'].' AND siteid='.tools::int($_SESSION['Site']['id']).'');
				$db->exec('INSERT INTO z_auth (authkey,siteid,userid) VALUES ("'.$key.'",'.tools::int($_SESSION['Site']['id']).','.$row['id'].')');
				setcookie("react", $key, time()+60*60*24*15, '/');
			}*/
			$sites=$db->queryFetchAllFirst('
			SELECT distinct(z_site.id) FROM
			z_site 
			INNER JOIN
			  z_timeorder 
			  ON z_timeorder.siteid = z_site.id 
			  AND z_timeorder.date_end > NOW()
			WHERE z_site.userid='.$row['id'].'');
		}
		if(count($sites)>0){
			$row['reccounts']=$sites;
			if($row['id']!=$_SESSION['Site']['userid'] && in_array($_SESSION['Site']['id'],$sites))
			$_SESSION['Site']['userid']=$row['id'];
		}
		if($row['id']>0)
		return $row;
		}
	}
	
	function loginReccountUser($email, $password, $remember){
		if(trim($email)==$this->adminemail){
		return self::loginAsAdmin($password,$remember);
		}
		$password=md5($password.MD5_KEY);
		$db=db::init();
		$row=$db->queryFetchRowAssoc(
		'SELECT 
		  z_user.id,
		  z_usertype_user.usertypeid,
		  z_user.login,
		  z_user.file_name,
		  if(z_user.password,1,0) as haspassword,
		  IF(
		    z_user.siteid > 0,
			z_site.NAME,
			IFNULL(z_user.displayname,z_user.login)
			) AS `displayname`,
		  SUM(z_operation.VALUE) AS money,
		  z_user.email
		FROM
		  z_user 
		  INNER JOIN
		  z_site 
		  ON z_site.userid = z_user.id  AND z_site.id='.tools::int($_SESSION['Site']['id']).'
		  INNER JOIN
		  z_usertype_user 
		  ON z_usertype_user.userid = z_user.id 
		  LEFT JOIN
		  z_operation 
		  ON z_operation.userid = z_user.id
		WHERE z_user.email="'.mysql_escape_string($email).'" AND z_user.PASSWORD="'.$password.'" 
		GROUP BY z_user.id 
		LIMIT 0,1'
		);
		if($row['id']>0){
			if($remember){
				$key=md5($_SESSION['Site']['id'].$email.$password.microtime());
				$db->exec('DELETE FROM z_auth WHERE userid='.$row['id'].' AND siteid='.tools::int($_SESSION['Site']['id']).'');
				$db->exec('INSERT INTO z_auth (authkey,siteid,userid) VALUES ("'.$key.'",'.tools::int($_SESSION['Site']['id']).','.$row['id'].')');
				setcookie("react", $key, time()+60*60*24*15, '/');
			}
			$sites=$db->queryFetchAllFirst('
			SELECT distinct(z_site.id) FROM
			z_site 
			INNER JOIN
			  z_timeorder 
			  ON z_timeorder.siteid = z_site.id 
			  AND z_timeorder.date_end > NOW()
			WHERE z_site.userid='.$row['id'].'');
			if($row['id']!=$_SESSION['Site']['userid'] && in_array($_SESSION['Site']['id'],$sites))
			$_SESSION['Site']['userid']=$row['id'];
		}
		if(count($sites)>0){
			$row['reccounts']=$sites;
		}
		if($row['id']>0)
		return $row;
	}
	function loginClubUser($email, $password, $remember){
		if(trim($email)==$this->adminemail){
			$size = new Tools;
			$_SESSION['Site']['disk']=$size->size($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$_SESSION['Site']['id'].'/');
			return self::loginAsAdmin($password,$remember);
		}
		$password=md5($password.MD5_KEY);
		$db=db::init();
		$row=$db->queryFetchRowAssoc(
		'SELECT 
		  z_user.id,
		  z_usertype_user.usertypeid,
		  z_user.login,
		  z_user.file_name,
		  if(z_user.password,1,0) as haspassword,
		  IF(
		    z_user.siteid > 0,
			z_site.NAME,
			IFNULL(z_user.displayname,z_user.login)
			) AS `displayname`,
		  SUM(z_operation.VALUE) AS money,
		  z_user.email
		FROM
		  z_user 
		  LEFT JOIN
		  z_site 
		  ON z_site.id = z_user.siteid
		  INNER JOIN
		  z_usertype_user 
		  ON z_usertype_user.userid = z_user.id 
		  LEFT JOIN
		  z_operation 
		  ON z_operation.userid = z_user.id
		WHERE z_user.email="'.mysql_escape_string($email).'" AND z_user.PASSWORD="'.$password.'" 
		GROUP BY z_user.id 
		LIMIT 0,1'
		);
        if($row['id']>0){
			if($remember){
				$key=md5($_SESSION['Site']['id'].$email.$password.microtime());
				$db->exec('DELETE FROM z_auth WHERE userid='.$row['id'].' AND siteid='.tools::int($_SESSION['Site']['id']).'');
				$db->exec('INSERT INTO z_auth (authkey,siteid,userid) VALUES ("'.$key.'",'.tools::int($_SESSION['Site']['id']).','.$row['id'].')');
				setcookie("react", $key, time()+60*60*24*15, '/');
			}
			$sites=$db->queryFetchAllFirst('
			SELECT distinct(z_site.id) FROM
			z_site 
			INNER JOIN
			  z_timeorder 
			  ON z_timeorder.siteid = z_site.id 
			  AND z_timeorder.date_end > NOW()
			WHERE z_site.userid='.$row['id'].'');
            if($row['id']==$_SESSION['Site']['userid'] && in_array($_SESSION['Site']['id'],$sites)){
				$size = new Tools;
                $_SESSION['Site']['disk']=$size->size($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$_SESSION['Site']['id'].'/');	
				$_SESSION['Site']['userid']=$row['id'];
			}
		}
		if(count($sites)>0){
			$row['reccounts']=$sites;
		}
		if($row['id']>0){
			$db->exec('INSERT INTO z_user_login (userid,siteid) VALUES ('.tools::int($row['id']).','.tools::int($_SESSION['Site']['id']).')');
		return $row;
		}
	}
	function loginByCookie($authkey){
		$db=db::init();
		$row=$db->queryFetchRow(
		'SELECT 
		  z_user.id,
		  z_usertype_user.usertypeid,
		  z_user.login,
		  z_user.countryid,
		  z_user.file_name,
		  if(z_user.password,1,0) as haspassword,
		  if(z_currency.id,z_currency.id,z_currency_default.id) as currencyid,
		  if(z_currency.id,z_currency.code, z_currency_default.code) as currency,
		  if(z_currency.id,z_currency.localname, z_currency_default.localname) as currencylocal,
		  IF(
		    z_user.siteid > 0,
			z_site.NAME,
			IFNULL(z_user.displayname,z_user.login)
			) AS `displayname`,
		  if(SUM(z_operation.VALUE)>0,SUM(z_operation.VALUE),0) AS money,
		  z_user.email,
		  z_user.file_name
		FROM
		  z_auth
		  INNER JOIN z_user
		  ON z_auth.userid=z_user.id
		  LEFT JOIN
		  z_site 
		  ON z_site.id = z_user.siteid
		  INNER JOIN
		  z_usertype_user 
		  ON z_usertype_user.userid = z_user.id 
		  LEFT JOIN
		  z_operation 
		  ON z_operation.userid = z_user.id AND z_operation.status=2
		  LEFT JOIN z_country_currency
		  ON z_country_currency.countryid=z_user.countryid
		  LEFT JOIN z_currency
		  ON z_currency.id=z_country_currency.currencyid
		  LEFT JOIN z_currency z_currency_default
		  ON z_currency_default.default=1
		WHERE z_auth.authkey="'.mysql_escape_string($authkey).'" AND z_auth.siteid='.tools::int($_SESSION['Site']['id']).'
		GROUP BY z_user.id
		LIMIT 0,1'
		);
		if($row['id']>0)
		{
				$key=md5($_SESSION['Site']['id'].$email.$password.microtime());
				$db->exec('UPDATE z_auth SET authkey="'.$key.'" WHERE z_auth.userid='.$row['id'].' AND z_auth.siteid='.tools::int($_SESSION['Site']['id']).'');
				setcookie("react", $key, time()+60*60*24*15, '/');
				unset($row['password']);
				
			$sites=$db->queryFetchAllFirst('
			SELECT distinct(z_site.id) FROM
			z_site 
			INNER JOIN
			  z_timeorder 
			  ON z_timeorder.siteid = z_site.id 
			  AND z_timeorder.date_end > NOW()
			WHERE z_site.userid='.$row['id'].'');
			if(count($sites)>0){
				$row['reccounts']=$sites;
				if($row['id']!=$_SESSION['Site']['userid'] && in_array($_SESSION['Site']['id'],$sites)){
					$_SESSION['Site']['userid']=$row['id'];
					$size = new Tools;
					$_SESSION['Site']['disk']=$size->size($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$_SESSION['Site']['id'].'/');
				}
			}
		}
		else
		{
			setcookie("react", '', time()-61*60*24*15, '/');	
		}
		
		return $row;
	}
	function loginReportByCookie($authkey){
		$db=db::init();
		$row=$db->queryFetchRow(
		'
		SELECT 
		  z_user.id,
		  z_usertype_user.usertypeid,
		  z_user.login,
		  z_user.file_name,
		  z_user.email,
		  z_user.file_name,
		  z_brand_user.brandid,
		  z_brand.name as brandname,
		  CONCAT("/uploads/brands/",z_brand.id,"/",z_brand.logo) AS brandlogo
		FROM
		  z_auth
		  INNER JOIN z_user
		  ON z_auth.userid=z_user.id
		  INNER JOIN
		  z_usertype_user 
		  ON z_usertype_user.userid = z_user.id AND z_usertype_user.usertypeid=3
		  INNER JOIN z_brand_user
		  ON z_brand_user.userid=z_user.id
		  INNER JOIN z_brand
		  ON z_brand.id=z_brand_user.brandid
		WHERE z_auth.authkey="'.mysql_escape_string($authkey).'" AND z_auth.siteid=3
		GROUP BY z_user.id 
		LIMIT 0,1
		');
		if($row['id']>0)
		{
				$key=md5($_SESSION['Site']['id'].$email.$password.microtime());
				$db->exec('UPDATE z_auth SET authkey="'.$key.'" WHERE z_auth.userid='.$row['id'].' AND z_auth.siteid=3');
				setcookie("report", $key, time()+60*60*24*15, '/');
		}
		else
		{
			setcookie("report", '', time()-61*60*24*15, '/');	
		}
		
		return $row;
	}
	function loginOut(){
		$db=db::init();
		setcookie("react", '', time()-42000);
		if($_SESSION['User']['id']>0){
		$db->exec('DELETE FROM z_auth WHERE userid='.$_SESSION['User']['id'].' AND siteid='.$_SESSION['Site']['id'].'');
		}
		$_SESSION['User']=null;
	}
	function changePassword($new, $new_conf,$old){
		$db=db::init();
		$row=$db->queryFetchRow(
		'SELECT 
		  password
		FROM
		  z_user
		WHERE z_user.id='.tools::int($_SESSION['User']['id']).' LIMIT 0,1');
		
            if($row['password'] && $row['password']==md5($old.MD5_KEY) && $new==$new_conf || !$_SESSION['User']['haspassword']){
                if($db->exec('UPDATE z_user SET password="'.md5($new.MD5_KEY).'" WHERE z_user.id='.tools::int($_SESSION['User']['id']).''))
                {
                    $_SESSION['User']['haspassword']=1;
                    return true;
                }
		}
	}
	function addPassword($new, $new_conf){
		if($new==$new_conf){
		$db=db::init();
		$db->exec('UPDATE z_user SET password="'.md5($new.MD5_KEY).'" WHERE z_user.id='.tools::int($_SESSION['User']['id']).'');
		return true;
		}
	}
	function passwordretrieve($email){
		$this->Valid=new valid;
		if($this->Valid->isEmail($email)){
			$db=db::init();
			$row=$db->queryFetchRow('
			SELECT 
			  id
			FROM
			  z_user
			WHERE z_user.email="'.tools::str($email).'" LIMIT 0,1
			');
			if($row['id']>0 && $row['id']!==1){
				$key=md5(microtime(). $email.MD5_KEY . rand());
				$db->exec('DELETE FROM z_keys WHERE userid='.$row['id'].'');
				$db->exec('INSERT INTO z_keys
				(token,userid,siteid) VALUES ("'.$key.'",'.$row['id'].','.tools::int($_SESSION['Site']['id']).')');
				$subject = "Восстановление пароля!";
				$message = "Здравствуйте! На сайте ".$_SERVER['HTTP_HOST']." был выполнен запрос на восстановление пароля. Если это сделали Вы, то перейдите по ссылке в конце письма, после чего на Ваш email прийдет новый пароль для входа.\n\n Если Вы этого не делали, то просто проигнорируйте это письмо.\n\n Ссылка для восстановления пароля: http://".$_SERVER['HTTP_HOST']."/user/getnewpassword?key=".$key."\n\nС уважением, Администрация сайта GROUPER";
				$smtp=new smtp;
				$smtp->Connect(SMTP_HOST);
				$smtp->Hello(SMTP_HOST);
                $smtp->Authenticate('info@group.reactor.ua', 'gykTNpbG');
                $smtp->Mail('info@group.reactor.ua');
				$smtp->Recipient($email);
				$smtp->Data($message, $subject);
			}
			
		}
	}
	function setnewpassword($key){
			$db=db::init();
			$row=$db->queryFetchRow('
			SELECT 
			  z_keys.id,
			  z_keys.userid,
			  z_user.email
			FROM
			  z_keys
			INNER JOIN z_user
			ON z_user.id=z_keys.userid
			WHERE z_keys.token="'.tools::str($key).'" AND DATE_ADD(z_keys.date_create, INTERVAL 5 HOUR) > NOW() LIMIT 0,1
			');
			if($row['id']>0){
				$db->exec('DELETE FROM z_keys WHERE userid='.$row['userid'].'');
				$newpassword=tools::generatePassword();
                $db->exec('UPDATE z_user SET password="'.tools::str(md5($newpassword.MD5_KEY)).'" WHERE id='.tools::int($row['userid']).'');
				$subject = "Новый пароль!";
				$message = "Здравствуйте! Ваш новый пароль для входа: ".$newpassword."\n\nВы можете сменить эго в любой момент в кабинете пользователя.\n\nС уважением, Администрация сайта GROUPER";
				$smtp=new smtp;
				$smtp->Connect(SMTP_HOST);
				$smtp->Hello(SMTP_HOST);
                $smtp->Authenticate('info@group.reactor.ua', 'gykTNpbG');
                $smtp->Mail('info@group.reactor.ua');
				$smtp->Recipient($row['email']);
				$smtp->Data($message, $subject);
				return true;
			}
			else
			return false;
	}
	function defineCountry(){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  id,
		  languageid
		FROM
		  z_country 
		WHERE CODE = "'.apache_note("GEOIP_COUNTRY_CODE").'"
		LIMIT 0,1');
		if($result)
		return $result;
	}
	
}

?>