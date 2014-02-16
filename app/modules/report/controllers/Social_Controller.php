<?php
require_once 'modules/report/models/Social.php';
require_once 'modules/base/controllers/BaseReport_Controller.php';

Class Social_Controller Extends BaseReport_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
            //if(!isset($this->Social))
            $this->Social=new Social;
		}

        function indexAction() {
            $Vkapi=new Vkapi;
            #Пользователи группы
            $resp = $Vkapi->api('groups.getMembers',
                array('gid'=>1698287,
                    'access_token'=>"4dc42f74b6591c828ebb86859d9f9f788cc1fe2ce96f247011129af7f2c6731637f1fc35dd190f0786184"
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
            echo $cnt;
            $maxs = array_keys($sexArr, max($sexArr));

            echo "<br/>";
            echo "Sex: ";
            echo $maxs[0];
            $maxcountry =array_keys($countryArr, max($countryArr));

            echo "<br/>";
            echo "Страна: ";
            echo $maxcountry[0];
            print_r($Vkapi->api('places.getCountryById',
                array("cids"=>$maxcountry[0],
                    'access_token'=>"4dc42f74b6591c828ebb86859d9f9f788cc1fe2ce96f247011129af7f2c6731637f1fc35dd190f0786184"
                ))
            );

            echo "<br/>";
            echo "Возраст: ";
            echo intval($ageTotal/$ageCnt);


        }
        function disconnectAction(){
            $this->Social->disconnect($_GET['id']);
        }
        function vkconnectAction() {
            $userid=$_SESSION['User']['id'];
            $this->Vk=new Vk;
            $returndata=$this->Vk->connect(array('code'=>$_GET['code']));
            if($userid){
                $this->registry->get->redirect('/user/accounts/');
            }
            else{
                $this->registry->get->redirect('/');
            }
		}
        function fbconnectAction() {
            $userid=$_SESSION['User']['id'];
            $this->Facebook=new Facebook;
            $returndata=$this->Facebook->connect(array('code'=>$_GET['code']));

            //print_r($returndata);
            /*if($returndata>0)
                $this->registry->get->redirect('http://'.$_SESSION['ref'].'/admin/account/?sescode='.$_SESSION['scode'].'&authkey='.$returndata['key'].'');*/
            if($userid)
                $this->registry->get->redirect('/user/accounts/');
            else
                $this->registry->get->redirect('/');
        }
        function getgroupsAction(){
            $Vkapi = new Vkapi();
            $Fbapi = new Fbapi();

            $db=db::init();
            $accounts=$db->queryFetchAllAssoc('SELECT * FROM z_social_account WHERE userid=30');
            foreach($accounts as $acc){
                if(in_array($acc['socialid'],array(257,226))){
                    $resp = $Vkapi->api('groups.get',
                        array('uid'=>$acc['accountid'],
                            'access_token'=>$acc['token'],
                            'extended'=>1,
                            'filter'=>'admin',
                            'fields'=>'members_count,can_post,activity,description,city,country'
                        ));
                    tools::print_r($resp);
                }elseif($acc['socialid']==255){
                    $graph_url="https://graph.facebook.com/".$acc['accountid']."/accounts?&access_token=". $acc['token'];
                    $user = json_decode(file_get_contents(utf8_encode($graph_url)));
                    tools::print_r($user);
                    /*$response = $Fbapi->api(
                        '/'.$acc['accountid'].'/accounts/?&access_token='. $acc['token'].''
                    );*/
                    //$user_id = $Fbapi->getUser();
                    tools::print_r($response);
                }
                //https://api.vk.com/method/groups.get?user_id=66748&v=5.4&access_token=533bacf01e11f55b536a565b57531ac114461ae8736d6506a3
            }

            tools::print_r($accounts);
        }
    public function testAction(){
        echo date('Y-m-d', strtotime(' -1 day'));
        $Vkapi = new Vkapi();
        $resp = $Vkapi->api('stats.get',
            array('gid'=>24249701,
                'access_token'=>'f91015d4914f3b0de4cc229fe4e694b5974ca5f2b9dac7e7a2186cca17a014174af4da31f9b23e0d6285e',
                'date_from'=>'2013-12-09',
                'date_to'=>'2013-12-10'
            ));
        tools::print_r($resp);
    }

}?>