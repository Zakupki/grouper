<?
require_once 'modules/base/controllers/BaseClubAdmin_Controller.php';
require_once 'modules/club/models/Event.php';
require_once 'modules/club/models/Reccount.php';
require_once 'modules/club/models/Design.php';
require_once 'modules/club/models/Gallery.php';
require_once 'modules/club/models/Video.php';
require_once 'modules/club/models/Track.php';
require_once 'modules/club/models/Card.php';
require_once 'modules/club/models/Brand.php';
require_once 'modules/club/models/Request.php';
Class Admin_Controller Extends BaseClubAdmin_Controller {
		private $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Design=new Design;
			$this->Reccount=new Reccount($this->registry);
			$this->sitedata=$this->Reccount->getSiteData();
			if($_SESSION['Site']['userid']!=$_SESSION['User']['id'])
			$this->registry->get->redirect('/');
			}

        function indexAction() {
				$this->content =$this->view->AddView('admin', $this);
				$this->view->renderLayout('admin', $this);
	    }
		function reccountAction() {
				$this->favicon=$this->Design->getFavicon();
				$this->ip='89.184.69.200';
				$this->Reccount=new Reccount;
				$this->Social=new Social;
			    $this->mainmenudata=$this->Menu->getMenuItems();
        		$this->mainmenu=$this->mainmenudata['html'];
				$this->name=tools::toJSON(array('token'=>$this->registry->token->getToken(8),'name'=>$this->Reccount->getAdminName()));
				$this->menu=tools::toJSON(array('token'=>$this->registry->token->getToken(9),'menu'=>$this->Menu->getAdminMenuItems()));
				$this->url=tools::toJSON(array('token'=>$this->registry->token->getToken(11),'domainlist'=>$this->Reccount->getDomains()));
				$this->sociallist=tools::toJSON(array('token'=>$this->registry->token->getToken(10),'social'=>$this->Social->getUserSocial($_SESSION['Site']['id'])));
				
				$this->content =$this->view->AddView('admin/reccount', $this);
				$this->view->renderLayout('admin', $this);
	    }
		function updatenameAction(){
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'],8)){
			$this->Reccount= new Reccount;
			$this->Reccount->updateName($data);
			echo json_encode(array('token'=>$this->registry->token->getToken(8),'name'=>$this->Reccount->getAdminName()));
			}else{
			echo json_encode(array('token'=>$this->registry->token->getToken(8), 'error'=>true, 'status'=>'Сессия устарела'));
			}			
		}
		function updatemenuAction(){
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'],9)){
			$this->Menu->updateMenu($data['menu']);
			echo json_encode(array('token'=>$this->registry->token->getToken(9),'menu'=>$this->Menu->getAdminMenuItems()));
			}else{
			echo json_encode(array('token'=>$this->registry->token->getToken(9), 'error'=>true, 'status'=>'Сессия устарела'));
			}
		}
		function updatesocialAction(){
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'],10)){
			$this->Social=new Social;
			$this->Social->updateSocialList($data['social']);
			echo json_encode(array('token'=>$this->registry->token->getToken(10),'social'=>$this->Social->getUserSocial($_SESSION['Site']['id'])));
			}else{
			echo json_encode(array('token'=>$this->registry->token->getToken(10), 'error'=>true, 'status'=>'Сессия устарела'));
			}
		}
		function updateurlAction(){
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'],11)){
			$this->Reccount=new Reccount;
			$this->Reccount->updateDomain($data['domainlist']);
			echo json_encode(array('token'=>$this->registry->token->getToken(11),'domainlist'=>$this->Reccount->getDomains()));
			}else{
			echo json_encode(array('token'=>$this->registry->token->getToken(11), 'error'=>true, 'status'=>'Сессия устарела'));
			}
		}
		function designAction() {
				$this->favicon=$this->Design->getFavicon();
				$this->mainmenudata=$this->Menu->getMenuItems();
        		$this->mainmenu=$this->mainmenudata['html'];
				$this->Design=new Design;
				$this->designoptions=tools::toJSON(array('token'=>$this->registry->token->getToken(13),'bg'=>$this->Design->getBackground(),'banner'=>$this->Design->getBanner(),'pattern'=>$this->Design->getPattern(),'favicon'=>$this->Design->getFavicon(),'margin'=>$this->Design->getMargin()));
				$this->color=tools::toJSON(array('token'=>$this->registry->token->getToken(12),'color'=>$this->Design->getColor()));
				//$this->margin=tools::toJSON(array('token'=>$this->registry->token->getToken(13),'margin'=>$this->Design->getMargin()));
				$this->cover=tools::toJSON(array('token'=>$this->registry->token->getToken(14), 'cover'=>$this->Design->getCover()));
				$this->videopreview=tools::toJSON(array('token'=>$this->registry->token->getToken(15), 'videopreview'=>$this->Design->getVideopreview()));
				$this->poster=tools::toJSON(array('token'=>$this->registry->token->getToken(16), 'poster'=>$this->Design->getPoster()));
				$this->clublogo=tools::toJSON(array('token'=>$this->registry->token->getToken(23), 'clublogo'=>$this->Design->getClublogo()));
				$this->content =$this->view->AddView('admin/design', $this);
				$this->view->renderLayout('admin', $this);
	    }
		function updatedesignAction(){
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'],13)){
			$this->Design=new Design;
			$this->Design->updateDesign($data);
			echo json_encode(array('token'=>$this->registry->token->getToken(13),'bg'=>$this->Design->getBackground(),'banner'=>$this->Design->getBanner(),'pattern'=>$this->Design->getPattern(),'favicon'=>$this->Design->getFavicon(),'margin'=>$this->Design->getMargin()));
			}else{
			echo json_encode(array('token'=>$this->registry->token->getToken(13), 'error'=>true, 'status'=>'Сессия устарела'));
			}
		}
		function updateclublogoAction(){
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'],23)){
			$this->Design=new Design;
			$this->Design->updateClublogo($data['clublogo'],$data['deleted']);
			echo json_encode(array('token'=>$this->registry->token->getToken(23),'clublogo'=>$this->Design->getClublogo()));
			}else{
			echo json_encode(array('token'=>$this->registry->token->getToken(23), 'error'=>true, 'status'=>'Сессия устарела'));
			}
		}
		function updatecolorAction(){
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'],12)){
			$this->Design=new Design;
			$this->Design->updateColor($data['color']);
			echo json_encode(array('token'=>$this->registry->token->getToken(12),'color'=>$this->Design->getColor()));
			}else{
			echo json_encode(array('token'=>$this->registry->token->getToken(12), 'error'=>true, 'status'=>'Сессия устарела'));
			}
		}
		
		function updatecoverAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'],14)){
			$this->Design=new Design;
			$this->Design->updateCover($data['cover'], $data['deleted']);
			echo stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(14), 'cover'=>$this->Design->getCover())));
			}
			else
			echo json_encode(array('token'=>$this->registry->token->getToken(14), 'error'=>true, 'status'=>'Сессия устарела'));
		}
		function updatevideopreviewAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'],15)){
			$this->Design=new Design;
			$this->Design->updateVideopreview($data['videopreview'], $data['deleted']);
			echo stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(15), 'videopreview'=>$this->Design->getVideopreview())));
			}
			else
			echo json_encode(array('token'=>$this->registry->token->getToken(15), 'error'=>true, 'status'=>'Сессия устарела'));
		}
		function updateposterAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'],16)){
			$this->Design=new Design;
			$this->Design->updatePoster($data['poster'], $data['deleted']);
			echo stripcslashes(json_encode(array('token'=>$this->registry->token->getToken(16), 'poster'=>$this->Design->getPoster())));
			}
			else
			echo json_encode(array('token'=>$this->registry->token->getToken(16), 'error'=>true, 'status'=>'Сессия устарела'));
		}
		function eventAction() {
				$this->defaultcover=$this->Design->getDefaultCover($_SESSION['Site']['id']);
				$this->defaultposter=$this->Design->getDefaultPoster($_SESSION['Site']['id']);
				$this->coverlist=tools::toJSON($this->Design->getCoverList());
				$this->posterlist=tools::toJSON($this->Design->getPosterList());
				$this->favicon=$this->Design->getFavicon();
				$this->mainmenudata=$this->Menu->getMenuItems();
        		$this->mainmenu=$this->mainmenudata['html'];
				$this->Brand=new Brand;
				$this->brandlist=tools::toJSON($this->Brand->getBrandList());
				$this->Event=new Event;
				$this->eventdata=$this->Event->getAdminEvent($this->registry->rewrites[1]);
				$this->eventinner=tools::toJSON(array('token'=>$this->registry->token->getToken(18), 'event'=>$this->eventdata['data'], 'artist'=>$this->eventdata['artists'], 'social'=>$this->eventdata['socials']));
				$this->content =$this->view->AddView('admin/event', $this);
				$this->view->renderLayout('admin', $this);
	    }
		function updateeventAction(){
				$data = json_decode(str_replace(array("\r\n", "\n", "\r"),'<br/>',stripslashes($_POST['data'])),true);
				//tools::print_r($data);
				if ($this->registry->token->checkToken($data['token'],18)){
				$this->Event=new Event;
				$neweventid=$this->Event->updateEvent($data['event'],$data['artist'],$data['social']);
				if(!$data['event']['id'] && $neweventid>0){
					echo json_encode(array('new'=>$neweventid));
					die();
				}
				if($data['event']['delete']){
					echo json_encode(array('reload'=>true));
					die();
				}
				
				$this->eventdata=$this->Event->getAdminEvent($data['event']['id']);
				echo json_encode(array('token'=>$this->registry->token->getToken(18), 'event'=>$this->eventdata['data'], 'artist'=>$this->eventdata['artists'], 'social'=>$this->eventdata['socials']));
				
				}
				else
				echo json_encode(array('token'=>$this->registry->token->getToken(18), 'error'=>true, 'status'=>'Сессия устарела'));
		
		}
		function placeAction() {
				$this->favicon=$this->Design->getFavicon();
				$this->Reccount=new Reccount;
				$this->Gallery=new Gallery;
				$this->Video=new Video;
				$this->mainmenudata=$this->Menu->getMenuItems();
        		$this->mainmenu=$this->mainmenudata['html'];
				$this->gallerytype=$this->Gallery->getGalleryTypeOptions();
				$this->videos=$this->Video->getVideoOptions();
				$this->place=$this->Reccount->getAdminPlace();
				$this->content =$this->view->AddView('admin/place', $this);
				$this->view->renderLayout('admin', $this);
	    }
		function teasersAction() {
				$this->favicon=$this->Design->getFavicon();
				$this->mainmenudata=$this->Menu->getMenuItems();
        		$this->mainmenu=$this->mainmenudata['html'];
				$this->Reccount=new Reccount;
				$this->teaser=tools::toJSON(array('token'=>$this->registry->token->getToken(21), 'teaser'=>$this->Reccount->getSiteAdminTeasers()));
				$this->content =$this->view->AddView('admin/teasers', $this);
				$this->view->renderLayout('admin', $this);
	    }
		function updateteasersAction(){
				$data = json_decode(stripcslashes($_POST['data']),true);
				if ($this->registry->token->checkToken($data['token'],21)){
				$this->Reccount=new Reccount;
				$this->Reccount->updateTeasers($data['teaser'], $data['deleted']);
				echo json_encode(array('token'=>$this->registry->token->getToken(21), 'teaser'=>$this->Reccount->getSiteAdminTeasers()));
				}
				else
				echo json_encode(array('token'=>$this->registry->token->getToken(21), 'error'=>true, 'status'=>'Сессия устарела'));
		}
		function updateplaceAction(){
				$this->Reccount=new Reccount;
				$this->Reccount->updatePlace($_POST);
				$this->registry->get->redirect('/admin/place/');
		}
		function contactAction() {
				$this->favicon=$this->Design->getFavicon();
				$this->mainmenudata=$this->Menu->getMenuItems();
        		$this->mainmenu=$this->mainmenudata['html'];
				$this->Reccount=new Reccount;
				$this->contact=tools::toJSON(array('token'=>$this->registry->token->getToken(17), 'contact'=>$this->Reccount->getAdminContact()));
				$this->content =$this->view->AddView('admin/contact', $this);
				$this->view->renderLayout('admin', $this);
	    }
		function updatecontactsAction(){
				$data = json_decode(stripcslashes($_POST['data']),true);
				if ($this->registry->token->checkToken($data['token'],17)){
				$this->Reccount=new Reccount;
				$this->Reccount->updateContacts($data['contact']);
				echo json_encode(array('token'=>$this->registry->token->getToken(17), 'contact'=>$this->Reccount->getAdminContact()));
				}
				else
				echo json_encode(array('token'=>$this->registry->token->getToken(17), 'error'=>true, 'status'=>'Сессия устарела'));
		}
		function galleryAction() {
				$this->favicon=$this->Design->getFavicon();
				$this->mainmenudata=$this->Menu->getMenuItems();
        		$this->mainmenu=$this->mainmenudata['html'];
				$this->Gallery=new Gallery;
				$gallerydata=$this->Gallery->getAdminGallery($this->registry->rewrites[1]);
				$this->gallery=tools::toJSON(array('token'=>$this->registry->token->getToken(20), 'gallerytype'=>$gallerydata['gallerytype'], 'gallery'=>$gallerydata['gallery']));
				$this->content =$this->view->AddView('admin/gallery', $this);
				$this->view->renderLayout('admin', $this);
	    }
		function updategalleryAction(){
				$data = json_decode(stripcslashes($_POST['data']),true);
				$this->Gallery= new Gallery;
				if ($this->registry->token->checkToken($data['token'],20)){
					$newgallerytypeid=$this->Gallery->updateGalleryInner($data['gallerytype'], $data['gallery'], $data['deleted']);
						if($data['gallerytype']['delete']){
						echo json_encode(array('reload'=>true));
						die();
						}
						if($data['gallerytype']['id']<1 && $newgallerytypeid>0){
						echo json_encode(array('new'=>$newgallerytypeid));
						die();
						}
					$gallerydata=$this->Gallery->getAdminGallery($data['gallerytype']['id']);
					echo json_encode(array('token'=>$this->registry->token->getToken(20), 'gallerytype'=>$gallerydata['gallerytype'], 'gallery'=>$gallerydata['gallery']));
				}else{
					echo json_encode(array('token'=>$this->registry->token->getToken(20), 'error'=>true, 'status'=>'Сессия устарела'));
				}
		}
		function musicAction() {
			    $this->defaultcover=$this->Design->getDefaultCover($_SESSION['Site']['id'], 4);
				$this->favicon=$this->Design->getFavicon();
				$this->mainmenudata=$this->Menu->getMenuItems();
        		$this->mainmenu=$this->mainmenudata['html'];
				$this->Track=new Track;
				$this->trackinner=tools::toJSON(array('token'=>$this->registry->token->getToken(), 'track'=>$this->Track->getTrackInner($this->registry->rewrites[1])));
				$this->content =$this->view->AddView('admin/music', $this);
				$this->view->renderLayout('admin', $this);
	    }
		function updatemusicAction(){
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
			$this->Track=new Track;
			$newtrackid=$this->Track->updateTrack($data['track']);
			if($data['track']['delete']){
			echo json_encode(array('reload'=>true));
			die();
			}
			if($data['track']['id']<1 && $newtrackid>0){
			echo json_encode(array('new'=>$newtrackid));
			die();
			}
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'track'=>$this->Track->getTrackInner($data['track']['id'])));
			}
			else
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'error'=>true, 'status'=>'Сессия устарела'));
		}
		function videoAction() {
				$this->favicon=$this->Design->getFavicon();
				$this->mainmenudata=$this->Menu->getMenuItems();
        		$this->mainmenu=$this->mainmenudata['html'];
				$this->Video=new Video;
				$this->Design=new Design;
				$this->previewlist=tools::toJSON($this->Design->getVideoPreviewList());
				$this->defaultpreview=$this->Design->getDefaultPreview($_SESSION['Site']['id']);
				$this->videoinner=tools::toJSON(array('token'=>$this->registry->token->getToken(22), 'video'=>$this->Video->getAdminVideoInner($this->registry->rewrites[1])));
				$this->content =$this->view->AddView('admin/video', $this);
				$this->view->renderLayout('admin', $this);
	    }
		function updatevideoAction(){
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'],22)){
			$this->Video=new Video;
			$newtrackid=$this->Video->updateVideo($data['video']);
			if($data['video']['delete']){
			echo json_encode(array('reload'=>true));
			die();
			}
			if($data['video']['id']<1 && $newtrackid>0){
			echo json_encode(array('new'=>$newtrackid));
			die();
			}
			echo json_encode(array('token'=>$this->registry->token->getToken(22), 'video'=>$this->Video->getAdminVideoInner($data['video']['id'])));
			}
			else
			echo json_encode(array('token'=>$this->registry->token->getToken(22), 'error'=>true, 'status'=>'Сессия устарела'));
		}
		function syncAction(){
			$this->content =$this->view->AddView('admin/sync', $this);
			$this->view->renderLayout('admin', $this);
		}
		function formAction(){
			$this->mainmenudata=$this->Menu->getMenuItems();
        	$this->mainmenu=$this->mainmenudata['html'];
			$this->Reccount= new Reccount;
			$this->form=$this->Reccount->getForm();
			$this->content =$this->view->AddView('admin/form', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateformAction(){
			$this->Reccount= new Reccount;
			$this->Reccount->updateForm($_POST);
			$this->registry->get->redirect('/admin/form/');
		}
		function recardAction(){
			$this->mainmenudata=$this->Menu->getMenuItems();
        	$this->mainmenu=$this->mainmenudata['html'];
			$this->Card= new Card;
			$this->cards=$this->Card->getAdminCards();
			$this->content =$this->view->AddView('admin/recard', $this);
			$this->view->renderLayout('admin', $this);
		}
		
		function getrecardAction() {
			$this->Card=new Card;
			if($_REQUEST['status']==2)
			$this->Card->readCard($_GET['id']);
			$this->recardinner=$this->Card->getCard($_GET['id']);
			$this->content=$this->view->AddView('admin/popups/getrecard', $this);
			$this->view->renderLayout('blank', $this);
		}
		function updaterecardAction(){
			$this->Card= new Card;
			$this->Card->updateCard($_REQUEST,$_FILES);
		}
		function requestsAction(){
			$this->mainmenudata=$this->Menu->getMenuItems();
        	$this->mainmenu=$this->mainmenudata['html'];
			$this->Request= new Request;
			$this->requests=$this->Request->getRequests();
			$this->content =$this->view->AddView('admin/requests', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updaterequestAction(){
			if(!tools::IsAjaxRequest())
			$this->registry->get->redirect('/');
			$this->Request= new Request;
			$this->Request->acceptRequest($_REQUEST['requestid'], $_REQUEST['requesttype'], $_REQUEST['action']);
		}
		function getrequestinfoAction(){
			if(!tools::IsAjaxRequest())
			$this->registry->get->redirect('/');
			$requesttype=array(1=>'banner',2=>'event',3=>'public',4=>'recard');
			$this->Request= new Request;
            if($_REQUEST['status']==2)
            $this->Request->markRead($_REQUEST['requesttype'],$_REQUEST['requestid']);
			switch ($_REQUEST['requesttype']) {
			    case 1:
                    $this->requestdata=$this->Request->getBannerRequest($_REQUEST['requestid']);
                    break;
			    case 2:
                    $this->requestdata=$this->Request->getEventRequest($_REQUEST['requestid']);
			        break;
			    case 3:
                    $this->requestdata=$this->Request->getPublicRequest($_REQUEST['requestid']);
                    break;
				case 4:
			        $this->requestdata=$this->Request->getRecardRequest($_REQUEST['requestid']);
					break;
			}
			
			$this->content=$this->view->AddView('admin/popups/'.$requesttype[$_REQUEST['requesttype']].'request', $this);
			$this->view->renderLayout('blank', $this);
		}
		function makereportAction(){
			if(!tools::IsAjaxRequest())
			$this->registry->get->redirect('/');
            $requesttype=array(1=>'banner',2=>'event',3=>'public',4=>'recard');
            $this->Request= new Request;
            switch ($_REQUEST['requesttype']) {
                case 1:

                    break;
                case 2:
                    $this->requestdata=$this->Request->getEventSiteRequest($_REQUEST['requestid']);
                    break;
                case 3:
                    $this->requestdata=$this->Request->getReportSiteRequest($_REQUEST['requestid']);
                    break;
                case 4:

                    break;
            }

            $this->content=$this->view->AddView('requests/'.$requesttype[$_REQUEST['requesttype']].'report', $this);
			$this->view->renderLayout('blank', $this);
		}
		function sendeventreport2Action(){
			tools::print_r($_POST);
			tools::print_r($_FILES);
		}
        function sendeventreportAction(){
            if(!tools::IsAjaxRequest())
            $this->registry->get->redirect('/');
            $this->Request= new Request;
			$this->Request->sendEventReport($_REQUEST,$_FILES);
        }
        function sendpublicreportAction(){
            if(!tools::IsAjaxRequest())
                $this->registry->get->redirect('/');
            $this->Request= new Request;
            $this->Request->sendPublicReport($_REQUEST);
        }

		function testAction(){
			//echo tools::getDirectorySize($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$SESSION['Site']['id'].'/');
			
			//echo $this->registry->hddtotal;			
			//echo $directory_size->sizein;
		}


}


?>