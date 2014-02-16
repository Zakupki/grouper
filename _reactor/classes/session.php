<?

class session
{
	static private $Instance;
	private $Session;
	
	static function init()
    {
    	
       if(!self::$Instance) {
       	self::$Instance = new session();
	   }
	   return self::$Instance;
    }
	public function __construct(){
		session_start();
	}
	
	function __get($arg){
		return $_SESSION[$arg];
	}
	function __set($arg,$val){
		$_SESSION[$arg]=$val;
		$this->$arg=$val;
	}
	public function __destruct(){
	}
	
}


?>