<?
final class valid{
	
	function isEmail($email){
		return (preg_match("/^(\w+((-\w+)|(\w.\w+))*)\@(\w+((\.|-)\w+)*\.\w+$)/",$email));
	} 
	function emailExists($email){
		$db=db::init();
		$row=$db->queryFetchRow('
					SELECT 
					  id 
					FROM
					  z_user 
					WHERE email = "'.mysql_escape_string($email).'"
					LIMIT 0,1');
		if($row['id']>0)
			return false;
		else 
			return true;
	}
	function isLogin($login){
		return (preg_match("/^[a-zA-Z0-9]+?([_.-])?[a-zA-Z0-9]+?$/",$login));
	}
	function loginExists($login){
		$db=db::init();
		$row=$db->queryFetchRow('
					SELECT 
					  id 
					FROM
					  z_user 
					WHERE login = "'.mysql_escape_string($login).'"
					LIMIT 0,1');
		if($row['id']>0)
			return false;
		else 
			return true;
	}
}

?>