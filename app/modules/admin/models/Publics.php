<?
require_once 'modules/base/models/Basemodel.php';

Class Publics Extends Basemodel {


	public function getPublicCount(){
	$db=db::init();
	$result=$db->queryFetchAllFirst('
				SELECT
				  COUNT(z_public.id)
				FROM
				  z_public
				');
	if($result[0])
	return $result[0];
}


	public function getPublicList($start=0,$take=50){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT
				z_public.id,
				z_public.detail_text,
				z_user.email,
				date_format(z_public.date_create,"%d.%m.%Y") AS date_create,
				date_format(z_public.date_start,"%d.%m.%Y") AS date_start
				FROM z_public
				INNER JOIN z_user
				ON z_user.id=z_public.userid
				Order by z_public.date_create DESC
				LIMIT '.$start.','.$take.'
				');
    foreach($result as $row){
        $publicArr[$row['id']]=$row['id'];
    }
    echo implode(',',$publicArr);

        $data['publics']=$result;

    if($data)
	return $data;
}
	public function getAllUsers(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT
				z_user.id,
				z_user.login,
				z_user.email,
				z_user.firstName,
				z_user.familyName,
				z_user.secondName,
				z_user.active,
				z_user.recommend,
				CONCAT(
					"/uploads/users/3_",
					z_user.file_name
					) AS url
				FROM z_user
				WHERE char_length(z_user.email)>0 AND z_user.id>1
				Order by z_user.email');
	if($result)
	return $result;
}
	public function getUserDiscounts(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT
				z_user.id,
				z_user.login,
				z_user.email,
				z_user.firstName,
				z_user.familyName,
				z_user.secondName,
				z_discount.value,
				z_discount.code,
				CONCAT(
					"/uploads/users/3_",
					z_user.file_name
					) AS url
				FROM z_user
				INNER JOIN z_discount
				ON z_discount.userid=z_user.id
				Order by z_user.id
				');
	if($result)
	return $result;
}
	public function getUsersBalance(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT
				z_operation.id,
				z_operationstatustype.name AS status,
				z_operation.value,
				DATE_FORMAT(z_operation.date_create,"%d.%m.%Y") AS date_create,
				z_operationtype.name AS operationtype,
				z_user.login
				FROM z_operation
				INNER JOIN z_operationtype
				ON z_operationtype.id=z_operation.operationtypeid
				INNER JOIN z_user
				ON z_user.id=z_operation.userid
				INNER JOIN z_operationstatustype
				ON z_operationstatustype.id=z_operation.status
				WHERE z_operation.status>1 AND z_operation.xml IS NOT NULL
				ORDER BY z_operation.date_create desc
				');
	if($result)
	return $result;
}
	public function getUserInner($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT
				z_user.id,
				z_user.login,
				z_user.recommend
				FROM z_user
				WHERE id='.tools::int($id).'
				');
	if($result)
	return $result;
}
	public function updateUserInner($data){
		if($data['id']>0){
			$db=db::init();
			$db->exec('UPDATE z_user SET recommend='.tools::int($data['recommend']).'
			WHERE z_user.id='.tools::int($data['id']).'');
		}else{
			$this->user=new user;
			$this->user->AdminAddUser($data);
		}

	}
	public function sendAccess($id,$type){
		$db=db::init();
		if($type=1){
			$result=$db->queryFetchRowAssoc('
				SELECT 
				z_user.id,
				z_user.activationcode,
				z_user.activation,
				z_user.password,
				z_user.email
				FROM z_user
				WHERE id='.tools::int($id).'
				');
			if($result['activationcode'] && !$result['activation'] && !$result['password']){
				$subject = "Регистрация в системе Clubsreport";
				$message = "Здравствуйте!\n\nВы были зарегистрированы в системе Clubsreport администратором.\n\nДля завершения регистрации и создания пароля перейдите по ссылке http://clubsreport.com/activate/?code=".$result['activationcode']."\n\nС уважением, Администрация сайта Clubsreport";
				$smtp=new smtp;
				$smtp->Connect(SMTP_HOST);
				$smtp->Hello(SMTP_HOST);
				$smtp->Authenticate('support@clubsreport.com', 'Z1IRldqU');
				$smtp->Mail('support@clubsreport.com');
				$smtp->Recipient($result['email']);
				$smtp->Data($message, $subject,"Clubsreport");
			}
		}
	}
}
?>