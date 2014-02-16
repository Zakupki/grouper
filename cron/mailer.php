<?
	ini_set("memory_limit", "132M");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	ini_set('display_errors', 1);
	define ('DIRSEP', DIRECTORY_SEPARATOR);
	$lib_paths = array();
	$lib_paths[] = "{$_SERVER['DOCUMENT_ROOT']}/app/";
	$lib_paths[] = "{$_SERVER['DOCUMENT_ROOT']}/_reactor/";
	$inc_path = implode(PATH_SEPARATOR, $lib_paths);
	set_include_path($inc_path);
	$site_path = $_SERVER['DOCUMENT_ROOT'].'/';
	define ('site_path', $site_path);
	define('MD5_KEY', 'osdgkadhgk');
	define('SMTP_HOST', 'ds139.mirohost.net');
	define('MAIN_HOST','grouper.com.ua');
	define('MAIN_NAME', 'Grouper.com.ua');
	define('MAIN_DEBUG', true);
		
	include_once "classes/loader.php";
	Loader::initialize();
	$db=db::init();
	
	$result=$db->queryFetchAllAssoc('
	SELECT 
      z_user.email
    FROM
      `z_public_group`
    INNER JOIN z_group
    ON z_group.id=z_public_group.`groupid`
    INNER JOIN z_user
    ON z_user.id=z_group.`userid`
    WHERE (z_public_group.date_create BETWEEN DATE_ADD(NOW(), INTERVAL -5 MINUTE) AND NOW()) AND z_group.`notconnected`=0  AND z_public_group.`new`=1
    GROUP BY z_user.id
	');
	
	

		$smtp=new smtp;
		$smtp->Connect(SMTP_HOST);
		$smtp->Hello(SMTP_HOST);
		$smtp->Authenticate('reactor@reactor-pro.ru', '123qwe123');
		$cnt=0;
	foreach($result as $user){
		$subject = "Новые заявки на Grouper.com.ua!";
		$message = "Уважаемый пользователь, у Вас есть не проcмотренные заявки на сайте grouper.com.ua\n\n";
		$smtp->Mail('reactor@reactor-pro.ru');
		$smtp->Recipient($user['email']);
		$smtp->Data($message, $subject);	
		$cnt++;
		
	}
	//tools::print_r($users);
	echo $cnt;
	
	
	
?>