<?php
class cache
{
	static private $CacheInstance;
	static private $Instance;
	
	static function init()
    {
       if(!self::$Instance) {
			try {
			$memcache_obj = new Memcache;
			$memcache_obj->connect('127.0.0.1', 11211) or die("Could not connect");	
			self::$CacheInstance = $memcache_obj;
			self::$Instance=new cache;
			} catch (Exception $e) {
			die("PDO CONNECTION ERROR: " . $e->getMessage() . "<br/>");
			}
	   }
       return self::$Instance;
    }
	
	public function get($key) {
		try {	
		$data = self::$CacheInstance->get($key);
		} catch (Exception $e) {
		  die("CACHE CONNECTION ERROR: " . $e->getMessage() . "<br/>");
		}
		return $data;
	}
	public function set($key, $val, $false,$time=86400){
		self::$CacheInstance->set($key, $val, false, $time);
	}
	
	public function __destruct(){
		self::$CacheInstance->close();
	}	
}
?>