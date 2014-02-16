<?
require_once 'modules/base/models/Basemodel.php';

Class Contacts Extends Basemodel {

public function getAdminContacts(){
	$db=db::init();	
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  id,
				  name,
				  phone,
				  email,
				  active
				  FROM z_contacts
				WHERE z_contacts.siteid = '.tools::int($_SESSION['Site']['id']).' 
				  AND z_contacts.userid = '.tools::int($_SESSION['User']['id']).'
				ORDER BY z_contacts.sort
				');
	if($result){
	return $result;
	}
}

public function getContacts(){
	$db=db::init();	
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  name,
				  phone,
				  email
				  FROM z_contacts
				WHERE z_contacts.siteid = '.tools::int($_SESSION['Site']['id']).'
				  AND z_contacts.active=1
				ORDER BY sort DESC
				');
	if($result){
	return $result;
	}
}

public function updateContacts($data,$deleted){
	$db=db::init();		
	
	$cnt=0;
	if(is_array($data))
	foreach($data as $k=>$bg){
		
		if($bg['id']>0){
			
					$stmt=$db->prepare("UPDATE z_contacts SET name=?, phone=?, email=?, active=?, sort=? WHERE id=? AND siteid=? AND userid=?");
					$res=$stmt->execute(array(
					  mysql_escape_string($bg['name']),
					  mysql_escape_string($bg['phone']),
					  mysql_escape_string($bg['email']),
					  tools::int($bg['active']),
					  $cnt,
					  tools::int($bg['id']),
					  tools::int($_SESSION['Site']['id']),
					  tools::int($_SESSION['User']['id'])
					  ));
					
		}
		if($bg['id']<1){
					$stmt=$db->prepare("INSERT INTO z_contacts (name,phone,email,active,sort,siteid,userid) VALUES (?,?,?,?,?,?,?)");
					$res=$stmt->execute(array(
					  mysql_escape_string($bg['name']),
					  mysql_escape_string($bg['phone']),
					  mysql_escape_string($bg['email']),
					  tools::int($bg['active']),
					  $cnt,
					  tools::int($_SESSION['Site']['id']),
					  tools::int($_SESSION['User']['id'])
					  ));
		}
	$cnt++;
	
	}
	if(is_array($deleted)){
	   				$idArr=implode(',',$deleted);
	   				$stmt=$db->prepare("delete from z_contacts where id in(".$idArr.") AND siteid=? AND userid=?");
					$res=$stmt->execute(array(
					  tools::int($_SESSION['Site']['id']),
					  tools::int($_SESSION['User']['id'])
					  ));
	}
}
}
?>