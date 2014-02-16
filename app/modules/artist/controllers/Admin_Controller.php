<?php
require_once 'modules/base/controllers/BaseArtistAdmin_Controller.php';
require_once 'modules/artist/models/Radioshow.php';
require_once 'modules/artist/models/Design.php';
require_once 'modules/artist/models/News.php';
require_once 'modules/artist/models/Release.php';
require_once 'modules/artist/models/Pressrelease.php';
require_once 'modules/artist/models/File.php';
require_once 'modules/artist/models/Reccount.php';
require_once 'modules/artist/models/Tracks.php';
require_once 'modules/artist/models/Compilation.php';
require_once 'modules/artist/models/Gigs.php';
require_once 'modules/artist/models/Gallery.php';
require_once 'modules/artist/models/Contacts.php';

Class Admin_Controller Extends BaseArtistAdmin_Controller {
		private $registry;
		
		public function __construct($registry){
			$this->registry=$registry;
			parent::__construct($registry);
			if(!$this->Session->User['id'])
			$this->registry->get->redirect('/');
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->mainmenu=$this->Menu->getAdminMenuItems();
			$this->Radioshow= new Radioshow;
			$this->Design= new Design;
			$this->favicon=$this->Design->getFavicon();
			$this->messageum=$this->registry->user->getMessages($this->Session->User['id']);
			$this->Release= new Release;
			if(!tools::IsAjaxRequest())
			$this->color=$this->Design->getSitecolor();
			}

        function indexAction() {
        		$this->registry->get->redirect('/reccount/menu/');
				$this->content =$this->view->AddView('index', $this);
				$this->view->renderLayout('layout', $this);
		}
		function aboutAction() {
			$this->Reccount = new Reccount;
			$this->about=addslashes(json_encode(array('token'=>$this->registry->token->getToken(), 'about'=>$this->Reccount->getAbout())));
			$this->content =$this->view->AddView('adminabout', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateaboutAction() {
			$data = json_decode(str_replace(array("\r\n", "\n", "\r"),'',stripslashes($_POST['data'])),true);
			$this->Reccount= new Reccount;
			if ($this->registry->token->checkToken($data['token'])){
			$this->Reccount->updateAbout($data);
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'about'=>$this->Reccount->getAbout()));
			}
			else{
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'about'=>$this->Reccount->getAbout()));
			}
		}
		function newsAction() {
			$this->News= new News;
			$newsArr=$this->News->getAdminNews($this->registry->rewrites[1]);
			if(!$newsArr)
			$newsArr=null;
			$this->newslist=tools::toJSON(array('token'=>$this->registry->token->getToken(), 'news'=>$newsArr));
			$this->content =$this->view->AddView('adminnews', $this);
			$this->view->renderLayout('admin', $this);
		}
		function addnewsAction() {
			
			$this->News= new News;
			$this->releaselist=$this->Release->getSiteReleases($_SESSION['Site']['id']);
			$this->newsdata=$this->News->getAdminNewsInner($this->registry->rewrites[1]);
			$this->newsinner=tools::toJSON(array('token'=>$this->registry->token->getToken(), 'itemid'=>$this->registry->rewrites[1], 'images'=>$this->newsdata['images'], 'tracks'=>$this->newsdata['tracks'], 'news'=>$this->newsdata['news']));
			$this->content =$this->view->AddView('adminaddnews', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatenewsAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
			$this->News= new News;
			$this->News->updateNews($data['news'], $data['deleted']);
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'news'=>array_merge(array(),$this->News->getAdminNews($this->registry->rewrites[1]))));
			}else{
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'news'=>array_merge(array(),$this->News->getAdminNews($this->registry->rewrites[1]))));
			}
		}
		function updatenewsinnerAction() {
			$data = json_decode(str_replace(array("\r\n", "\n", "\r"),'',stripslashes($_POST['data'])),true);
			if ($this->registry->token->checkToken($data['token'])){
			$this->News= new News;
			$newitemid=$this->News->updateInnerNews($data);
			if(!$data['itemid'])
			$data['itemid']=$newitemid;
			$this->newsdata=$this->News->getAdminNewsInner($data['itemid']);
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'itemid'=>$data['itemid'], 'images'=>$this->newsdata['images'], 'news'=>$this->newsdata['news']));
			}else{
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'itemid'=>$data['itemid'], 'images'=>$this->newsdata['images'], 'news'=>$this->newsdata['news']));
			}
		}
		function radioshowAction() {
			$this->coverlist=$this->Design->getCover();
			$this->defaultcover=$this->Design->getDefaultCover($_SESSION['Site']['id']);
			$this->radioshow=tools::toJSON(array('token'=>$this->registry->token->getToken(), 'radioshow'=>$this->Radioshow->getAdminRadioshows()));
			$this->content =$this->view->AddView('adminradioshow', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateradioshowAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
				$this->Radioshow->updateRadioshows($data['radioshow'], $data['deleted']);
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'radioshow'=>$this->Radioshow->getAdminRadioshows()));
			}else{
			echo json_encode(array('token'=>$this->registry->token->getToken(), 'radioshow'=>$this->Radioshow->getAdminRadioshows()));	
			}
		}
		
		
		function radioshowinnerAction() {
			$this->radioshowtype=$this->Radioshow->getAdminRadioshowTypeInfo($this->registry->rewrites[1]);
			$this->radioshowlist=tools::toJSON(array('token'=>$this->registry->token->getToken(), 'typeid'=>$this->registry->rewrites[1], 'radioshow'=>$this->Radioshow->getAdminRadioshowInner($this->registry->rewrites[1])));
			$this->content =$this->view->AddView('adminradioshowinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateradioshowinnerAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
				$this->Radioshow->updateRadioshowinner($data['radioshow'], $data['deleted'], $data['delplay']);
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'typeid'=>$data['typeid'], 'radioshow'=>$this->Radioshow->getAdminRadioshowInner($data['typeid'])));
			}else{
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'typeid'=>$data['typeid'], 'radioshow'=>$this->Radioshow->getAdminRadioshowInner($data['typeid'])));	
			}
		}
		/*
		 * 
		 * ReleaseType
		 * 
		 */
		
		function releaseAction() {
			//tools::print_r($this->Release->getAdminReleaseType());
			$this->coverlist=$this->Design->getCover();
			$this->defaultcover=$this->Design->getDefaultCover($_SESSION['Site']['id']);
			$this->release=tools::toJSON(array('token'=>$this->registry->token->getToken(3), 'release'=>$this->Release->getAdminReleaseType()));
			//echo $this->release;
			$this->content =$this->view->AddView('adminrelease', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatereleasetypeAction (){
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'],3)){
				$this->Release->updateReleaseType($data['release'], $data['deleted']);
				echo  json_encode(array('token'=>$this->registry->token->getToken(3), 'release'=>$this->Release->getAdminReleaseType()));
			}else{
				echo json_encode(array('token'=>$this->registry->token->getToken(3), 'errorid'=>1, 'errormessage'=>'Сессия устарела'));	
			}
		}
		function getreleaselinksAction() {
			if(isset($_POST['id'])){
				echo json_encode(array('token'=>$this->registry->token->getToken(4), 'links'=>$this->Release->getAdminReleaseTypeLinks($_POST['id'])));
			}
			else
			{
				echo json_encode(array('token'=>$this->registry->token->getToken(4), 'links'=>null));
			}
		}
		function updatereleasetypeinnerAction (){
			$data = json_decode(stripslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'],4)){
				$this->Release->updateReleaseTypeInner($data);
				echo json_encode(array('token'=>$this->registry->token->getToken(3), 'release'=>$this->Release->getAdminReleaseType()));
			}else{
				echo json_encode(array('token'=>$this->registry->token->getToken(3), 'errorid'=>1, 'errormessage'=>'Сессия устарела'));	
			}
		}
		
		/*
		 * 
		 * Release
		 * 
		 */
		function releaseinnerAction() {
			$this->Pressrelease= new Pressrelease;
			$this->releasetype=$this->Release->getAdminReleaseTypeInfo($this->registry->rewrites[1]);
			$data=array('token'=>$this->registry->token->getToken(), 'itemid'=>$this->releasetype['itemid'], 'typeid'=>$this->registry->rewrites[1], 'release'=>$this->Release->getAdminReleaseInner($this->registry->rewrites[1]), 'pressrelease'=>$this->Pressrelease->getAdminPressrelease($this->releasetype['itemid']));
			$this->release=tools::toJSON($data);
			$this->content =$this->view->AddView('adminreleaseinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function getreleasetokenAction() {
			echo $this->registry->token->getToken();
		}
		
		function updatereleaseAction (){
			$this->Pressrelease= new Pressrelease;
			$data = json_decode(str_replace(array("\r\n", "\n", "\r"),'',stripslashes($_POST['data'])),true);
			if ($this->registry->token->checkToken($data['token'])){
				$this->Release->updateRelease($data['release'], $data['deleted'], $data['delplay']);
				$this->Pressrelease->updatePressrelease($data['pressrelease'], $data['itemid']);
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'itemid'=>$data['itemid'], 'typeid'=>$data['typeid'], 'release'=>$this->Release->getAdminReleaseInner($data['typeid']), 'pressrelease'=>$this->Pressrelease->getAdminPressrelease($data['itemid'])));
			}else{
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'itemid'=>$data['itemid'], 'typeid'=>$data['typeid'], 'release'=>$this->Release->getAdminReleaseInner($data['typeid']), 'pressrelease'=>$this->Pressrelease->getAdminPressrelease($data['itemid'])));
			}
		}
		function updatereleaseinnerAction (){
			$this->Pressrelease= new Pressrelease;
			$data = json_decode(str_replace(array("\r\n", "\n", "\r"),'',stripslashes($_POST['data'])),true);
			if ($this->registry->token->checkToken($data['token'])){
				$this->Release->updateReleaseInner($data);
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'itemid'=>$data['itemid'], 'typeid'=>$data['typeid'], 'release'=>$this->Release->getAdminReleaseInner($data['typeid']), 'pressrelease'=>$this->Pressrelease->getAdminPressrelease($data['itemid'])));
			}else{
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'itemid'=>$data['itemid'], 'typeid'=>$data['typeid'], 'release'=>$this->Release->getAdminReleaseInner($data['typeid']), 'pressrelease'=>$this->Pressrelease->getAdminPressrelease($data['itemid'])));
			}
		}
		
		function messagesAction() {
				$this->token=$this->registry->token->writeToken();
				$db=db::init();
				$this->messages=$db->queryFetchAllAssoc('SELECT * FROM z_messages WHERE active=1 AND userid='.$this->Session->User['id'].'');
				$this->content =$this->view->AddView('messages', $this);
				$this->view->renderLayout('admin', $this);
        }
		function videoAction() {
				$this->coverlist=$this->Design->getVideopreview();
				$this->defaultpreview=$this->Design->getDefaultPreview($_SESSIOM['Site']['id']);
				$this->File= new File;
				$this->videos=tools::toJSON(array('token'=>$this->registry->token->getToken(),  'videos'=>$this->File->getAdminVideos()));
				$this->content =$this->view->AddView('adminvideo', $this);
				$this->view->renderLayout('admin', $this);
        }
		function updatevideoAction() {
			$this->File= new File;
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
				$this->File->updateVideos($data['videos'], $data['deleted']);
				echo json_encode(array('token'=>$this->registry->token->getToken(),  'videos'=>$this->File->getAdminVideos()));
			}else{
				echo json_encode(array('token'=>$this->registry->token->getToken(),  'videos'=>$this->File->getAdminVideos()));
			}
        }
		function filesAction() {
				$this->File= new File;
				$this->files=tools::toJSON(array('token'=>$this->registry->token->getToken(),  'files'=>$this->File->getAdminFiles()));
				$this->content =$this->view->AddView('adminfiles', $this);
				$this->view->renderLayout('admin', $this);
        }
		function updatefilesAction() {
			$this->File= new File;
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
				$this->File->updateFiles($data['files'], $data['deleted']);
				echo json_encode(array('token'=>$this->registry->token->getToken(),  'files'=>$this->File->getAdminFiles()));
			}else{
				echo json_encode(array('token'=>$this->registry->token->getToken(),  'files'=>$this->File->getAdminFiles()));
			}
		}
		function tracksAction() {
			$this->coverlist=$this->Design->getCover();
			$this->Tracks= new Tracks;
			$this->Reccount = new Reccount();
			$this->author=$this->Reccount->getTitle($_SESSION['Site']['id']->siteid);
			$this->defaultcover=$this->Design->getDefaultCover($_SESSION['Site']['id']);
			$this->tracklist=tools::toJSON(array('token'=>$this->registry->token->getToken(), 'tracks'=>$this->Tracks->getAdminTracks()));
			$this->content =$this->view->AddView('admintracks', $this);
			$this->view->renderLayout('admin', $this);
        }
		function updatetracksAction() {
			$this->Tracks= new Tracks;
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
				$this->Tracks->updateTracks($data['tracks'], $data['deleted'], $data['delplay']);
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'tracks'=>$this->Tracks->getAdminTracks()));
			}else{
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'errorid'=>1, 'errormessage'=>'Сессия устарела'));	
			}	
        }
		function compilationAction() {
			$this->coverlist=$this->Design->getCover();
			$this->Compilation= new Compilation;
			$this->Reccount = new Reccount();
			$this->author=$this->Reccount->getTitle($_SESSION['Site']['id']);
			$this->defaultcover=$this->Design->getDefaultCover($_SESSION['Site']['id']);
			$this->compilationlist=tools::toJSON(array('token'=>$this->registry->token->getToken(), 'compilation'=>$this->Compilation->getAdminCompilation()));
			$this->content =$this->view->AddView('admincompilation', $this);
			$this->view->renderLayout('admin', $this);
        }
		function updateCompilationAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			$this->Compilation= new Compilation;
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
				$this->Compilation->updateCompilation($data['compilation'], $data['deleted'], $data['delplay']);
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'compilation'=>$this->Compilation->getAdminCompilation()));
			}else{
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'compilation'=>$this->Tracks->getAdminTracks()));
			}	
        }
		function galleryAction() {
			$this->coverlist=$this->Design->getVideopreview();
			$this->defaultpreview=$this->Design->getDefaultPreview($_SESSION['Site']['id']);
			$this->Gallery= new Gallery;
			$this->gallery=tools::toJSON(array('token'=>$this->registry->token->getToken(), 'gallery'=>$this->Gallery->getAdminGalleryType()));
			$this->content =$this->view->AddView('admingallery', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updategalleryAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			$this->Gallery= new Gallery;
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
				$this->Gallery->updateGalleryType($data['gallery'], $data['deleted']);
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'gallery'=>$this->Gallery->getAdminGalleryType()));
			}else{
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'gallery'=>$this->Gallery->getAdminGalleryType()));
			}	
        }
		function galleryinnerAction() {
			$this->Gallery= new Gallery;
			$this->userid=$_SESSION['User']['id'];
			$this->gallerytypeid=$this->registry->rewrites[1];
			$this->gallery=tools::toJSON(array('token'=>$this->registry->token->getToken(), 'gallerytypeid'=>$this->registry->rewrites[1], 'gallery'=>$this->Gallery->getAdminGalleryInner($this->registry->rewrites[1])));
			$this->content =$this->view->AddView('admingalleryinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updategalleryinnerAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			$this->Gallery= new Gallery;
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
				$this->Gallery->updateGalleryInner($data['gallery'], $data['deleted']);
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'gallerytypeid'=>$data['gallerytypeid'], 'gallery'=>$this->Gallery->getAdminGalleryInner($data['gallerytypeid'])));
			}else{
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'gallerytypeid'=>$data['gallerytypeid'], 'gallery'=>$this->Gallery->getAdminGalleryInner($data['gallerytypeid'])));
			}	
        }
		
		function gigsAction() {
			$this->Gigs= new Gigs;
			$this->giglist=tools::toJSON(array('token'=>$this->registry->token->getToken(), 'gigs'=>$this->Gigs->getAdminGigs()));
			$this->content =$this->view->AddView('admingigs', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updategigsAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			$this->Gigs= new Gigs;
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
				$this->Gigs->updateGigs($data['gigs'], $data['deleted']);
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'gigs'=>$this->Gigs->getAdminGigs()));
			}else{
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'gigs'=>$this->Gigs->getAdminGigs()));
			}	
		}
		function contactsAction() {
			$this->Contacts= new Contacts;
			$this->contacts=json_encode(array('token'=>$this->registry->token->getToken(), 'contacts'=>$this->Contacts->getAdminContacts()));
			$this->content =$this->view->AddView('admincontacts', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatecontactsAction() {
			$data = json_decode(stripcslashes($_POST['data']),true);
			$this->Contacts= new Contacts;
			$data = json_decode(stripcslashes($_POST['data']),true);
			if ($this->registry->token->checkToken($data['token'])){
				$this->Contacts->updateContacts($data['contacts'], $data['deleted']);
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'contacts'=>$this->Contacts->getAdminContacts()));
			}else{
				echo json_encode(array('token'=>$this->registry->token->getToken(), 'contacts'=>$this->Contacts->getAdminContacts()));
			}	
		}
}


?>