<?php
class csrf {
   public  $action='unspecified'; // action page the script is good for
   public  $life = 1; // minutes for which key is good
   private $table = 'z_token';
   private $sid; // session id of user
   
   public function csrf() {
      $sid = session_id();
      $this->sid  = preg_replace('/[^a-z0-9]+/i','',$sid);
      }
      
   public function csrfkey() {
   	  $key = md5(microtime() . $this->sid . rand());
      $stamp = time() + (60 * $this->life);
      $db=db::init();
	  $stmt=$db->prepare("INSERT INTO $this->table (sid,mykey,stamp,action) VALUES (?,?,?,?)");
	  $stmt->execute(array($this->sid,$key,$stamp,$this->action));
	  return $key;
      }
      
   public function checkcsrf($key) {
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