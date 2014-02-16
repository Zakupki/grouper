<?
final class Loader{
	private function __construct(){
	}
	static function initialize(){
		function __autoload($class_name) {

	        $filename = strtolower($class_name) . '.php';
	
	        $file = site_path . '/_reactor/classes' . DIRSEP . $filename;
	
			if (file_exists($file) == false) {
	
				return false;

	        }

			include ($file);
		
			}
	}
}
?>