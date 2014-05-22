<?
require_once 'modules/base/controllers/BaseReport_Controller.php';
require_once 'modules/report/models/Group.php';
require_once 'modules/report/models/Geo.php';
require_once 'modules/report/models/Event.php';
require_once 'modules/report/models/Stats.php';
require_once 'modules/report/models/Request.php';


Class Groups_Controller Extends BaseReport_Controller {
		public $registry;
		public $error;
		public $take=20;
		public $takeevents=10;
		public $takeposters=12;
        public $postprice=0.001;
        public $postpriceadd=15;
        public $currencyprice=4;
        public $comission=10;
        
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
            $this->Group=new Group;
            $this->Request= new Request;
            $this->newrequests=$this->Request->getRequestcnt();
		}

        function indexAction() {
            $this->listtype=1;
        	$this->clubs=$this->Group->getGroups(array('take'=>$this->take,'listtype'=>$this->listtype));
			$this->clubsnum=$this->Group->getGroupscount(1);
			$this->clubsfav=$this->Group->getGroupsfav();
			$this->grouptypes=$this->Group->getGroupTypes();
			$this->clublist=$this->view->AddView('moregroups', $this);
			$this->content=$this->view->AddView('groups', $this);
			$this->view->renderLayout('layout', $this);
          
		}
		 function groupinnerAction() {
            $this->groupdata=$this->Group->getGroupInner($this->registry->rewrites[1]);
            $db=db::init();
            $date=$db->queryFetchFirst(' SELECT id FROM `z_vkage_visitors` WHERE z_vkage_visitors.`groupid` = '.tools::int($this->registry->rewrites[1]).' limit 0,1');
            if($date)
            $this->hasdata=1;
            $this->graphData=$this->Group->getGraphData($this->registry->rewrites[1]);
        	$this->content=$this->view->AddView('groups/groupinner', $this);
			$this->view->renderLayout('layout', $this);
		}
		function getclubAction(){
			$this->Stats=new Stats;
			header('Content-Type: application/json; charset=utf-8');
			$data = array(
				'*data*' => $this->Stats->getStats($_GET['id'], $_GET['type'])
			);
			echo str_replace('*','"',(str_replace('"', '', json_encode($data))));
		}
		function findgroupAction(){
			header('Content-Type: application/json; charset=utf-8');
			$this->Group=new Group;
			$this->clublist=$this->Group->findGroup($_GET['term']);
			echo json_encode($this->clublist);
		}
		function favouritesAction() {
			$this->listtype=3;
            if(!$_SESSION['User']['id'])
			$this->registry->get->redirect('/');
        	$this->Group=new Group;
			$this->clubs=$this->Group->getGroups(array('take'=>$this->take,'listtype'=>$this->listtype));

            $this->clubsnum=$this->Group->getGroupscount(2);
            $this->clubsfav=$this->Group->getGroupsfav();
			$this->Geo=new Geo;
            $this->grouptypes=$this->Group->getGroupTypes(array('listtype'=>$this->listtype));
			$this->clublist=$this->view->AddView('moregroups', $this);
			$this->content=$this->view->AddView('groups', $this);
			$this->view->renderLayout('layout', $this);
		}
		function getmoreAction() {
            $this->listtype=$_GET['listtype'];
        	$this->clubs=$this->Group->getGroups(array('start'=>$_GET['start'],'take'=>$_GET['take'],'listtype'=>$this->listtype,'sort'=>$_GET['sort'],'dir'=>$_GET['dir'],'groupsubject'=>$_GET['groupsubject']));
			$this->content=$this->view->AddView('moregroups', $this);
			$this->view->renderLayout('blank', $this);
		}
		
		function addtofavAction(){
			$this->Group=new Group;
			$this->Group->addToFav($_GET);
		}
		function offersAction() {
			if(!$_SESSION['User']['id'])
			$this->registry->get->redirect('/');
			self::eventsAction(3);
		}
		function faveventsAction() {
			if(!$_SESSION['User']['id'])
			$this->registry->get->redirect('/');
			self::eventsAction(2);
		}
		function eventsAction($typeid=1) {
			$this->typeid=$typeid;
			$this->Club=new Club;
			$this->clubs=$this->Club->getGroups(0,$this->take,2,$_GET);
			$this->clubsnum=$this->Club->getGroupscount(2);
			$this->clubsfav=$this->Club->getGroupsfav();
			$this->Event=new Event;
			$this->startlimit=0;
			$this->events=$this->Event->getAllClubEvents($this->startlimit,$this->takeevents,$typeid,$_GET);
			$this->offerlist=$this->view->AddView('moreoffers', $this);
        	$this->content=$this->view->AddView('offers', $this);
			$this->view->renderLayout('layout', $this);
		}
		function moreeventsAction() {
        	$this->Event=new Event;
			$this->startlimit=$_GET['start'];
			$this->events=$this->Event->getAllClubEvents($this->startlimit,$_GET['take'],$_GET['type']);
			$this->content=$this->view->AddView('moreoffers', $this);
			$this->view->renderLayout('blank', $this);
		}
		
		function postersAction() {
			if(!$_SESSION['User']['id'])
			$this->registry->get->redirect('/');
			$this->Club=new Club;
			$this->clubs=$this->Club->getGroups(0,$this->take,2,$_GET);
			$this->clubsnum=$this->Club->getGroupscount(2);
			$this->clubsfav=$this->Club->getGroupsfav();
			$this->Event=new Event;
			$this->events=$this->Event->getAllClubPosters(0,$this->takeposters);
			$this->posterlist=$this->view->AddView('moreposters', $this);
			$this->content=$this->view->AddView('posters', $this);
			$this->view->renderLayout('layout', $this);
		}
		function morepostersAction() {
        	$this->Event=new Event;
			$this->events=$this->Event->getAllClubPosters($_GET['start'],$_GET['take']);
			$this->content=$this->view->AddView('moreposters', $this);
			$this->view->renderLayout('blank', $this);
		}
		function approveeventAction() {
			if(!tools::IsAjaxRequest() || !$_GET['id'])
			$this->registry->get->redirect('/');
			if(tools::int($_GET['id'])>0){
			$this->Event=new Event;
			echo $this->Event->approvePoster($_GET['id'],$_GET['action']);
			}
		}
        function createAction() {
            if(!$_SESSION['User']['id'])
            $this->registry->get->redirect('/');
            $this->clubsnum=$this->Group->getGroupscount(2);
            $this->clubsfav=$this->Group->getGroupsfav();
            $this->content=$this->view->AddView('/groups/create', $this);
            $this->view->renderLayout('layout', $this);
        }
        function updateAction() {
            if(!$_SESSION['User']['id'])
            $this->registry->get->redirect('/');

            $this->Geo=new Geo;
            $this->countrylist=$this->Geo->getCountries();
            $this->grouptypes=$this->Group->getGroupTypes();
            $this->clubsnum=$this->Group->getGroupscount(2);
            $this->membernum=$this->Group->loadGroupMemberNum(urldecode($_REQUEST['url']));
            
            if(tools::IsAjaxRequest()){
                if(isset($_GET['delete'])){
                   $this->Group->delete($_GET['delete']);
                }    
                else{  
                echo json_encode(array('id'=>$this->Group->save($_REQUEST,$_FILES)));
                }
            }else{
                if($_GET['id']>0){
                    $this->groupdata=$this->Group->find(array('t.id'=>$_GET['id']));
                    $this->groupdata->remote=0;
                } 
                else{
                        $this->groupdata=$this->Group->checkGroup($_REQUEST);

                        if($this->groupdata->socialid==257){
                            #ДОПОЛНИТЕЛЬНЫЕ ДАННЫЕ
                            $Vkapi=new Vkapi;
                            #Пользователи группы
                            $resp = $Vkapi->api('groups.getMembers',
                                array('gid'=>$this->groupdata->gid,
                                    'access_token'=>$this->groupdata->token
                                ));
                            $userids=implode(',',$resp['response']['users']);

                            $userArrs=array_chunk($resp['response']['users'],300);
                            $sexArr=array();
                            $countryArr=array();
                            $ageTotal=0;
                            $cnt=0;
                            $ageCnt=0;
                            #Данные поьзователей
                            foreach($userArrs as $ur){
                                $resp2 = $Vkapi->api('users.get',
                                    array("uids"=>implode(',',$ur),
                                        'access_token'=>"4dc42f74b6591c828ebb86859d9f9f788cc1fe2ce96f247011129af7f2c6731637f1fc35dd190f0786184",
                                        'fields'=>'sex,country,bdate'
                                    ));
                                foreach($resp2['response'] as $user){
                                    $sexArr[$user['sex']]++;
                                    $countryArr[$user['country']]++;
                                    $birthDate = explode(".", $user['bdate']);
                                    if(count($birthDate)==3){
                                        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y")-$birthDate[2])-1):(date("Y")-$birthDate[2]));
                                        $ageTotal=$ageTotal+$age;
                                        $ageCnt++;
                                    }
                                    $cnt++;
                                }
                            }
                            $maxs = array_keys($sexArr, max($sexArr));
                            #Возраст
                            if($maxs[0]==2)
                                $maxs[0]=1;
                            else
                                $maxs[0]=0;
                            $this->groupdata->gender=$maxs[0];
                            $maxcountry =array_keys($countryArr, max($countryArr));
                            #vkCountries
                            $vkCountries=array(2=>112);
                            $this->groupdata->countryid=$vkCountries[$maxcountry[0]];
                            #Возраст
                            $this->groupdata->age=intval($ageTotal/$ageCnt);

                            $this->groupdata->url=$_REQUEST['url'];
                            $this->groupdata->remote=1;
                        }elseif($this->groupdata->socialid==255){
                            $this->groupdata->remote=1;
                            //print_r($this->groupdata);
                        }

                }
                $this->content=$this->view->AddView('/groups/update', $this);
                $this->view->renderLayout('layout', $this);
            }
        }
        function checkAction() {
            if(!tools::IsAjaxRequest() || !$_REQUEST['url'])
            $this->registry->get->redirect('/');

            /*$group=$this->Group->checkGroup($_POST);
            if(($group->type=='group' || $group->type=='page') && $group->socialid==257)
                echo 'true';
            elseif($group->socialid==255)*/
                echo 'true';
            /*else {
                echo '"Ссылка не является группой"';
            }*/
            
        }
}
?>