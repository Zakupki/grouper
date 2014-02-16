<?
class token
{
   public  $action=0; // action page the script is good for
   public  $life = 180; // minutes for which key is good
   private $table = 'z_token';
   private $sid; // session id of user

public function token() {
	$sid = session_id();
	$this->sid  = preg_replace('/[^a-z0-9]+/i','',$sid);
	}
function checkToken($key=null, $action=null) {
	if(!$key)
	$key=$_POST['token'];
 	if($action)
	$this->action=$action;
 	$this->cleanOld();
    $cleanKey = preg_replace('/[^a-z0-9]+/','',$key);
    if (strcmp($key,$cleanKey) != 0) {
        return false;
        } else {
        $db=db::init();
		$stmt=$db->prepare("SELECT id FROM $this->table WHERE sid=? AND mykey=? AND action=?");
        $stmt->execute(array($this->sid,$cleanKey,$this->action));
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$valid = $row['id'];
		}
		if (!isset($valid)) {
            return false;
            } else {
            	$db=db::init();
				$stmt=$db->prepare("DELETE FROM $this->table WHERE id = ?");
				$stmt->execute(array(tools::int($valid)));
				return true;
            }
        }	
	}
function getToken($action=null) {
	if($action)
	$this->action=$action;
	$key = md5(microtime() . $this->sid . rand());
    $stamp = time() + (60 * $this->life);
    $db=db::init();
	$stmt=$db->prepare("INSERT INTO $this->table (sid,mykey,stamp,action) VALUES (?,?,?,?)");
	$stmt->execute(array($this->sid,$key,$stamp,$this->action));
	return $key;
	}	
function writeToken($action=null) {
	if($action)
	$this->action=$action;
	$key = md5(microtime() . $this->sid . rand());
    $stamp = time() + (60 * $this->life);
    $db=db::init();
	$stmt=$db->prepare("INSERT INTO $this->table (sid,mykey,stamp,action) VALUES (?,?,?,?)");
	$stmt->execute(array($this->sid,$key,$stamp,$this->action));
	return '<input id="token" name="token" type="hidden" value="' .$key. '">';
	}
private function cleanOld() {
    // remove expired keys
	$exp = time();
    $db=db::init();
	$stmt=$db->prepare("DELETE FROM $this->table WHERE stamp < ?");
	$stmt->execute(array(tools::int($exp)));
	return true;
    }
public function logout() {
    $db=db::init();
	$stmt=$db->prepare("DELETE FROM $this->table WHERE sid=?");
	$stmt->execute(array($this->sid));
	return true;
    }
}
?>