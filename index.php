<?
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		$starttime = $mtime;
		/*---------------------------------------------------------------------------------*/
		$ipArr=array('91.209.51.1572');
		if(in_array($_SERVER['REMOTE_ADDR'], $ipArr)){
			//require_once 'atelier.html';
			//die();
		}else{
            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
            ini_set('display_errors', 1);
        }
		ini_set("memory_limit", "132M");
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
		define('MAIN_HOST','reactor.ua');
        define('MAIN_NAME','Grouper.com.ua');
		define('MAIN_DEBUG', true);
		include_once "classes/loader.php";
		Loader::initialize();
		
		$registry = new Registry;
		
		
		$sitedomains[1]=array(0=>'en.clubsreport.com',1=>'report',2=>2);
		$sitedomains[2]=array(0=>'grouper.com.ua',1=>'report',2=>1);
        //$sitedomains[12]=array(0=>'grouper.com.ua',1=>'report',2=>1);
		$sitedomains[3]=array(0=>'test.clubsreport.com',1=>'report',2=>1);
		$sitedomains[4]=array(0=>'reactor-pro.ru',1=>'main',2=>1);
		$sitedomains[5]=array(0=>'reactor.ua',1=>'main',2=>1);
		$sitedomains[6]=array(0=>'reactor-pro.com',1=>'main',2=>2);
		$sitedomains[7]=array(0=>'test.reactor.ua',1=>'main',2=>1);
		$sitedomains[8]=array(0=>'test.reactor-pro.com',1=>'main',2=>2);
		$sitedomains[9]=array(0=>'reparty.ru',1=>'reparty',2=>1);
		$sitedomains[10]=array(0=>'test.reparty.ru',1=>'reparty',2=>1);
		$sitedomains[11]=array(0=>'api.reactor.ua',1=>'api',2=>1);
		
		$registry->sitedomains=$sitedomains;
		$registry->sitehost='http://'.$_SERVER['HTTP_HOST'];
		$registry->sitetitle='Reactor PRO';
		$registry->sitedesc='«Реактор» — профессиональное комьюнити саунд-продюсеров. Профайлами здесь служат персональные сайты, созданные на базе шаблонов (Reccount) и размещенные на личных доменах пользователей.';
		$registry->publiccoef=0.15;
		$registry->contactprice=0.25;
        $registry->bannerprice=0.15;
		
		$router = new Router($registry);
		#Rewrite
		//$router->addRewrite('first',"^index\/(\w+)?$", array('index', 'about'));
		//$router->addRewrite('first',"^index\/(\w+)?$", array('index', 'about'));
		/*
		$router->addRewrite('releasetype2',"^releases\/(\d+)?$", array('releases', 'index'));
		$router->addRewrite('gallerytype',"^gallery\/(\d+)?$", array('gallery', 'galleryinner'));
		*/
		

		#reportrewrites
		$router->addRewrite('reppublicinner',"^public\/(\d+)?$", array('report','public','publicinner'));
        $router->addRewrite('groupinner',"^group\/(\d+)?$", array('report','groups','groupinner'));

		#main admin rewrites
		$router->addRewrite('adminreleasepageing',"^admin\/releases\/(\d+)?$", array('admin','releases','index'));
		$router->addRewrite('adminreleasetype',"^admin\/release\/(\d+)?$", array('admin','releases','releaseinner'));
		$router->addRewrite('adminnews',"^admin\/new\/(\d+)?$", array('admin','news','newsinner'));
		$router->addRewrite('adminusernew',"^admin\/user\/?$", array('admin','users','userinner'));
		$router->addRewrite('adminuserpageing',"^admin\/users\/(\d+)?$", array('admin','users','index'));
		$router->addRewrite('adminuser',"^admin\/user\/(\d+)?$", array('admin','users','userinner'));
		$router->addRewrite('adminsitenew',"^admin\/site\/\?type=(\w+)?$", array('admin','sites','siteinner'));
		$router->addRewrite('adminsite',"^admin\/site\/(\d+)?$", array('admin','sites','siteinner'));
		$router->addRewrite('adminsocial',"^admin\/social\/(\d+)?$", array('admin','social','socialinner'));
		$router->addRewrite('adminmail',"^admin\/mail\/(\d+)?$", array('admin','mail','mailinner'));
		$router->addRewrite('admingeocitynew',"^admin\/geo\/city\/?$", array('admin','geo','city'));
		$router->addRewrite('admingeo',"^admin\/geo\/city\/(\d+)?$", array('admin','geo','city'));
		$router->addRewrite('adminrecard',"^admin\/recard\/(\d+)?$", array('admin','recards','recardinner'));
		$router->addRewrite('adminclubcards',"^admin\/recards\/(\d+)?$", array('admin','recards','clubscards'));
		$router->addRewrite('adminclubcard',"^admin\/card\/(\d+)?$", array('admin','recards','clubscardinner'));
		$router->addRewrite('adminbrandoffer',"^admin\/brands\/offer\/(\d+)?$", array('admin','brands','offerinner'));
		$router->addRewrite('adminbrandnew',"^admin\/brand\/?$", array('admin','brands','brandinner'));
		$router->addRewrite('adminbrand',"^admin\/brand\/(\d+)?$", array('admin','brands','brandinner'));
		$router->addRewrite('404',"404$", array('report','index','notfound'));
		$router->addRewrite('index',"^$", array('main','releases','index'));
		
		
		
		$registry->router->$router;
		$router->setPath (site_path .'app/modules');
		$router->delegate();
		
   /*---------------------------------------------------------------------------------*/	
   $mtime = microtime();
   $mtime = explode(" ",$mtime);
   $mtime = $mtime[1] + $mtime[0];
   $endtime = $mtime;
   $totaltime = ($endtime - $starttime);
   if(!tools::IsAjaxRequest() && $_SESSION['debug']=='123')
   echo "<!--<br/>This page was created in ".round($totaltime,4)." seconds-->";
?>