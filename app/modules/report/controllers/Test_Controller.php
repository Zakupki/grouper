<?
require_once 'modules/base/controllers/BaseReport_Controller.php';
require_once 'modules/report/models/Club.php';
require_once 'modules/report/models/System.php';
require_once 'modules/main/models/Geo.php';

Class Test_Controller Extends BaseReport_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
		}

        function indexAction() {
        	
        	//echo tools::getSqlDate(date('Y'),date('m'),date('d'));
		}
		function testAction() {
			tools::print_r($_SESSION['User']);	
			echo apache_note("GEOIP_COUNTRY_CODE");
			tools::print_r($_SESSION['languageid']);
			tools::print_r($_SESSION['countryid']);
        	//echo tools::getSqlDate(date('Y'),date('m'),date('d'));
        	
        	
		}
		function my_mb_ucfirst($str, $e='utf-8') {
		    $fc = mb_strtoupper(mb_substr($str, 0, 1, $e), $e); 
		    return $fc.mb_substr($str, 1, mb_strlen($str, $e), $e);
		}
		
		function test2Action() {
			
			$db=db::init();
			$result=$db->queryFetchAllAssoc('SELECT siteid,trademarks from z_clubform WHERE CHAR_LENGTH(trademarks)>0');
        	//tools::print_r($result);
			$cnt=0;
			$tcnt=0;
			foreach($result as $form){
				$sitebrandsArr=explode(',',$form['trademarks']);
				
				foreach($sitebrandsArr as $br){
					if(strlen(trim($br))>0){
						echo $br;
						echo "<br>";
						#2	
						$result=null;
						$result=$db->queryFetchRowAssoc('
						SELECT 
						  id,
						  name as value,
						  name as label
						FROM
						  z_brand 
						WHERE z_brand.NAME LIKE "%'.tools::str(self::my_mb_ucfirst($br)).'%"
						');
						
						
						$brandnames2[$cnt]['id']=$result['id'];
						$brandnames2[$cnt]['name']=self::my_mb_ucfirst($br);
						$brandnames2[$cnt]['siteid']=$form['siteid'];
						$cnt++;
						
						$brandnames[mb_strtolower(trim($br), 'UTF-8')]['name']=mb_strtolower(trim($br), 'UTF-8');
						$brandnames[mb_strtolower(trim($br), 'UTF-8')]['cnt']=$brandnames[mb_strtolower(trim($br), 'UTF-8')]['cnt']+1;
						$brandnames[mb_strtolower(trim($br), 'UTF-8')]['siteid']=$form['siteid'];
					}
				$tcnt++;
				}
			}
			 
			 echo $cnt.'-'.$tcnt.'-'.count($brandnames2);
			 
			#1
			foreach($brandnames as $newbrand){
				//echo self::my_mb_ucfirst($newbrand['name']);
				//echo "<br>";
				//echo $db->exec('INSERT INTO z_brand (name) values ("'. self::my_mb_ucfirst($newbrand['name']).'")');
			}
			#2
			foreach($brandnames2 as $link){
			//$db->exec('INSERT INTO z_brand_site (brandid,siteid) values ('.tools::int($link['id']).','.tools::int($link['siteid']).')');
			}
			tools::print_r($brandnames2);
			//tools::print_r($brandnames);
		}
		function testfbAction(){
            $sUrl='https://graph.facebook.com/v1.0/hromadsketv';
            //создадим объект, содержащий ответ сервера Вконтакте, который приходит в формате JSON
            $oResponce=null;
            $oResponce = json_decode(file_get_contents($sUrl));
            echo $oResponce->id;

            $picUrl='https://graph.facebook.com/'.$oResponce->id.'/?fields=picture.type(large)';
            //создадим объект, содержащий ответ сервера Вконтакте, который приходит в формате JSON
            $picResponce=null;
            $picResponce = json_decode(file_get_contents($picUrl));



            echo tools::GetImageFromUrl($picResponce->picture->data->url);

            echo "<pre>";
            //print_r($picResponce->picture->data->url);
            echo "</pre>";
        }
        public function odAction(){
            /*
            Этот код необходимо добавить один раз перед первым использованием SDK, указав в директиве require путь к файлу с SDK.
            Он подключает SDK и проверяет, установлена ли необходимая для работы SDK библиотека curl.
            */
            //require("./odnoklassniki_sdk.php");
            /*if (!odnoklassnikisdk::checkCurlSupport()){
                print "У вас не установлен модуль curl, который требуется для работы с SDK одноклассников.  Инструкция по установке есть, например, <a href=\">.";
                return;
            }*/
            //$data=odnoklassnikisdk::makeRequest("group.getInfo", array("uids" => "optimizmmm"));
            ?>
                <a href="http://www.odnoklassniki.ru/oauth/authorize?client_id=1090049792&scope=VALUABLE_ACCESS&response_type=code&redirect_uri=http://reactor-pro.com/test/od">логин</a>
            <?
            //print_r(odnoklassnikisdk::getCode());
            //print_r(odnoklassnikisdk::changeCodeToToken(odnoklassnikisdk::getCode()));
            if (!is_null(odnoklassnikisdk::getCode())){

                if(odnoklassnikisdk::changeCodeToToken(odnoklassnikisdk::getCode())){

                }
            }
            $data=odnoklassnikisdk::makeRequest("group.getInfo",array('uids'=>'zhemch','fields'=>'name'));
            tools::print_r($data);

        }
}
?>