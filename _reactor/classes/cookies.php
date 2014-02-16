<?

class cookies
{
	static private $Instance;
	private $cookies;
	
	static function init()
    {
       if(!self::$Instance) {
       	self::$Instance = new cookies();
	   }
	   return self::$Instance;
    }
	public function __construct(){
		
	}
	
	function __get($arg){
		return $_COOKIES[$arg];
	}
	function set($arg,$val,$time){
		session_start();
		setcookie($arg, $val, $time);
		$this->$arg=$val;
	}
	public function __destruct(){
	}
	
}


?>