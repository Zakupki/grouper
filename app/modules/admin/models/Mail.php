<?
require_once 'modules/base/models/Basemodel.php';

Class Mail Extends Basemodel {
	
	
	public function getMailList(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_mail.id,
					  z_mail.subject
					FROM
					  z_mail 
					');
		if($result)
		return $result;	
	}
	public function getMailInner($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  z_mail.id,
					  z_mail.subject,
					  z_mail.detail_text
					FROM
					  z_mail 
					WHERE z_mail.id='.tools::int($id).'
					');
		if($result)
		return $result;
	}
	public function updateMailInner($data){
		if($data['id']>0){
			$db=db::init();
			$db->exec('UPDATE z_mail SET subject="'.tools::str($data['subject']).'",  detail_text="'.tools::str($data['detail_text']).'"
			WHERE z_mail.id='.tools::int($data['id']).'');
		}
	}	
}
?>