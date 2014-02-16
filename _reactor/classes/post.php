<?
final class Post {

	/**
	 * @param string $name
	 * @return string
	 */

	public function __get($name) {
		if(isset($this->$name)) {
			return $this->$name;
		}
		if(isset($_POST[$name])) {
			$this->$name = str_replace("\r", '', trim($_POST[$name]));
			return $this->$name;
		}
		if(isset($_FILES[$name])) {
			return $this->$name = new TClass($_FILES[$name]);
		}
	}
	
	/**
	 * @return TPost
	 */

	public function asIterator() {
		foreach ((array)$_POST as $f=>$r) {
			$this->$f = $this->__get($f);
		}
		foreach ((array)$_FILES as $f=>$r) {
			$this->$f = $this->__get($f);
		}
		return (array)$this;
	}
	
	/**
	 * @return boolean
	 */

	public function isSent() {
		if(count((array)$_POST) || count((array)$_FILES)) {
			return true;
		}
	}

}
?>