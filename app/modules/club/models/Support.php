<?
require_once 'modules/base/models/Basemodel.php';

Class Support Extends Basemodel {
	
	public function getSupporttype($type=0){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  id,
					  name 
					FROM
					  z_supporttype 
					WHERE place='.$type.'
					');
		return $result;
	}
	public function readNew(){
		$db=db::init();
		$db->exec('
					UPDATE 
					  z_support
					SET z_support.new=0
					WHERE z_support.userid='.$_SESSION['User']['id'].' AND z_support.new=1
					');
		return;
	}
	public function getQuestions(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_support.id,
					  DATE_FORMAT(
					    z_support.date_create,
					    "%d.%m.%Y / %h:%i"
					  ) AS date_create,
					  z_support.question,
					  z_support.answer,
					  z_support.new,
					  z_support.status,
					  z_supporttype.NAME AS supporttype 
					FROM
					  z_support 
					  INNER JOIN
					  z_supporttype 
					  ON z_supporttype.id = z_support.supporttypeid
					WHERE z_support.userid='.$_SESSION['User']['id'].'
					ORDER BY z_support.date_create DESC
					');
		return $result;
	}
	public function addQuestion($data){
		$db=db::init();
		if($_SESSION['User']['id']>0){
			
			$subject = "Обращение службы поддержки от пользователя ".$_SESSION['User']['id'].": ".$data['subject']."";
			$message = $data['message'];
			$smtp=new smtp;
			$smtp->Connect(SMTP_HOST);
			$smtp->Hello(SMTP_HOST);
			$smtp->Authenticate('reactor@reactor-pro.ru', '123qwe123');
			$smtp->Mail('reactor@reactor-pro.ru');
			$smtp->Recipient('dmitriy.bozhok@gmail.com');
			$smtp->Data($message, $subject);
			
			$db->exec('
			INSERT INTO z_support
			(question,userid,supporttypeid) 
			VALUES 
			("'.mysql_escape_string(trim($data['message'])).'", '.$_SESSION['User']['id'].', '.$data['subject'].')
			');
		return true;
		}
		
	}
	public function sendFeedback($data){
			$subject = "Обратная связь Reactor";
			$message = "Сообщение от пользователя: ".$data['email']."
Текст обращения: ".$data['message'];
			$smtp=new smtp;
			$smtp->Connect(SMTP_HOST);
			$smtp->Hello(SMTP_HOST);
			$smtp->Authenticate('reactor@reactor-pro.ru', '123qwe123');
			$smtp->Mail('reactor@reactor-pro.ru');
			$smtp->Recipient('dmitriy.bozhok@gmail.com');
			$smtp->Data($message, $subject);
		return true;
	}
	public function getHelp($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  name,
					  text
					FROM
					  z_help 
					WHERE z_help.id='.tools::int($id).' and active=1
					');
		if($result)
		return $result;
	}
}
?>