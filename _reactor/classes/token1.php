<?
class token
{
	function guid(){
	    if (function_exists('com_create_guid')){
	        return com_create_guid();
	    }else{
	        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
	        $charid = strtoupper(md5(uniqid(rand(), true)));
	        $hyphen = chr(45);// "-"
	        $uuid = chr(123)// "{"
	                .substr($charid, 0, 8).$hyphen
	                .substr($charid, 8, 4).$hyphen
	                .substr($charid,12, 4).$hyphen
	                .substr($charid,16, 4).$hyphen
	                .substr($charid,20,12)
	                .chr(125);// "}"
	        return $uuid;
	    }
	}
	function checkToken($token=null) {
	$this->Session=session::init();
	//echo $token;
	/*****************************************************************************************
	* Check the posted token for correctness
	* ### CHANGE THE PATH TO THE 403 FORBIDDEN PAGE ###
	******************************************************************************************/
	$oldToken="";
	$testToken="";
	$tokenStr="";
	$page=$_SERVER["SCRIPT_NAME"];
	/********************************************************
    * NO NEED FOR FILTERING INPUT AS IT WILL NEVER BE OUTPUT
    *********************************************************/
	if(!$token)
	$oldToken=$_POST["token"];
	else
	$oldToken=$token;
	//$tokenStr = "IP:" . $this->Session->ip . ",SESSIONID:" . session_id() . ",GUID:" . $this->Session->guid;
	$testToken=sha1("IP:".$this->Session->ip.",SESSIONID:".session_id().",GUID:");
	//$testToken=sha1(($tokenStr&$this->Session->salt).$this->Session->salt);
	
	$checkToken=False;
	/*echo $oldToken.'<br/>';
	echo $testToken.'<br/>';
	echo $_COOKIE["token"].'<br/>';*/
	if($oldToken===$testToken) {
	    $diff = time() - $this->Session->time; 
		If ($diff<=300) { // Five minutes max
			#temp solution
			return true;
			If ($this->Session->usecookie) {
				
			    If ($_COOKIE["token"]==$oldToken) {
			    	setcookie("token", '', time()-42000);
					return true;
				}else{
					//$_SESSION = array();
		  			if (isset($_COOKIE[session_name()])) {
	    				setcookie(session_name(), '', time()-42000, '/');
					}
					$_SESSION['token']=null;
					//session_destroy();
					return false;
					//header("Location: http://reactor.ua/1/");
				}
			}else{	
	  			return true;
	  		}	
	  	}else{
	  		///$_SESSION = array();
	  		if (isset($_COOKIE[session_name()])) {
    			setcookie(session_name(), '', time()-42000, '/');
			}
			$_SESSION['token']=null;
			//session_destroy();
			//header("Location: http://reactor.ua/2/");
			return false;
		}
	}else{
		//$_SESSION = array();
		/*if (isset($_COOKIE[session_name()])) {
    		setcookie(session_name(), '', time()-42000, '/');
		}*/
		//session_destroy();
		$_SESSION['token']=null;
		//header("Location: http://reactor.ua/wrong_token/");
		return false;
	}
	
}
function getToken() {
	$this->Session=session::init();
	/*****************************************************************************************
	* Create and set a new token for CSRF protection
	* on initial entry or after form errors and we are going to redisplay the form.
	* ### CHANGE THE VALUE OF THE SALT
	******************************************************************************************/
	$salt="123";
	$tokenStr="";
	$salt = sha1("your_random_salt");
	//session_start();
	setcookie("token", "", time()-42000);
	
	$this->Session->salt=$salt;
	$this->Session->guid = self::guid();
	$this->Session->ip= $_SERVER["REMOTE_ADDR"];
	$this->Session->time = time();
	
	
	//$tokenStr = "IP:" . $this->Session->ip . ",SESSIONID:" . session_id() . ",GUID:" . $this->Session->guid;
	
	$this->Session->token=sha1("IP:".$this->Session->ip.",SESSIONID:".session_id().",GUID:");
	//$this->Session->token=222;
	//$this->Session->token=sha1(($tokenStr&$this->Session->salt).$this->Session->salt);
	//$this->Session->token=sha1(time());
	if (setcookie("token", $this->Session->token, time()+60*60*60)) {
		//echo 'ks<br/>';
		$this->Session->usecookie=True;
	}
	
	/*echo $this->Session->token.'<br/>';
	echo $_COOKIE["token"];*/
	return $this->Session->token;
}	
function writeToken() {
	$this->Session=session::init();
	/*****************************************************************************************
	* Create and set a new token for CSRF protection
	* on initial entry or after form errors and we are going to redisplay the form.
	* ### CHANGE THE VALUE OF THE SALT
	******************************************************************************************/
	$salt="123";
	$tokenStr="";
	$salt = sha1("your_random_salt");
	//session_start();
	setcookie("token", "", time()-42000);
	
	$this->Session->salt=$salt;
	$this->Session->guid = self::guid();
	$this->Session->ip= $_SERVER["REMOTE_ADDR"];
	$this->Session->time = time();
	
	
	//$tokenStr = "IP:" . $this->Session->ip . ",SESSIONID:" . session_id() . ",GUID:" . $this->Session->guid;
	
	$this->Session->token=sha1("IP:".$this->Session->ip.",SESSIONID:".session_id().",GUID:");
	//$this->Session->token=222;
	//$this->Session->token=sha1(($tokenStr&$this->Session->salt).$this->Session->salt);
	//$this->Session->token=sha1(time());
	if (setcookie("token", $this->Session->token, time()+500)) {
		//echo 'ks<br/>';
		$this->Session->usecookie=True;
	}
	
	/*echo $this->Session->token.'<br/>';
	echo $_COOKIE["token"];*/
	return '<input id="token" name="token" type="hidden" value="' .$this->Session->token. '">';
}
}
?>