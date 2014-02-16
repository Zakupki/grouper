<?php

require_once 'modules/base/controllers/BaseClub_Controller.php';
require_once 'modules/club/models/Comments.php';
require_once 'modules/club/models/Event.php';
require_once 'modules/club/models/Video.php';
require_once 'modules/club/models/Gallery.php';

Class Comments_Controller Extends BaseClub_Controller {
		public $registry;
		public $error;
		public $language=2;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->registry->token=new token;
			$this->Comments=new Comments($this->registry);
		}

        function indexAction() {
		}
		function showeventAction() {
			/* header('Content-Type: application/json; charset=utf-8'); */
			
			
			
			if($_GET['id'])
			$itemid=$_GET['id'];
			else
			$itemid=false;
			
			$this->Event=new Event;
			$this->event=$this->Event->getCommentEvent($itemid);
			$this->comments=$this->Comments->getComments($itemid,$this->event['incut']);
			
			
			$data = array(
			    'error' => false,
			    'status' => '',
			    'token' =>$this->registry->token->getToken()
			);
			if(count($this->comments) <= 0){
				$comments_disabled='comments-type-disabled ';
				$comments_tree_empty='comments-tree-empty ';
			}
			
			$comemntTree=tools::getComments($this->comments, $this->event['incut'], $this->event['userid']);
			
			if(!$this->event['totalrate'])
			  $this->event['totalrate'] = 0;
			
			if ($this->Session->User['id'])
			  $rateAct[$this->event['rate']] = 'act ';
			else
			  $rateClosed='auth-popup-link ';
			
			
			 if (tools::int($_SESSION['User']['id']) < 1) { 
			 	
			 }
			 if (tools::int($_SESSION['User']['id']) > 0) {
			 	$submitB='<div class="button"><div class="r"><div class="l"><button type="submit">'.$this->registry->trans['add'].'</button></div></div></div>';
			 } else { 
			 	//$submittext='<div class="note">Только зарегистрированые пользователи могут оставлять комментарии.</div>';
			 	$submitB='<div class="button"><div class="r"><div class="l"><button type="button" class="auth-popup-link">'.$this->registry->trans['add'].'</button></div></div></div>';
			 }
			
			if ($this->event['totalrate']>0)
			$totelalrate='+'.$this->event['totalrate'].'';
			else
			$totelalrate=$this->event['totalrate'];
			
			
			$data['content'] = '
            <div class="comments-header">
                <div class="comments-title">
                  <h2>'.$this->registry->trans['comments'].'</h2>
                  <div class="i-pointer"></div>
                </div>

                <div class="post-share">
                  <input name="url" value="_share.php" type="hidden" />
                  <input name="item_id" value="'.$itemid.'" type="hidden" />
                  <div class="i"></div>
                  <div class="links">
                    <div class="r">
                      <div class="l">
                        <ul>
                         <li class="link-twitter"><a href="http://twitter.com/home?status='.MAIN_NAME.'%20http%3A%2F%2F'.MAIN_HOST.'%2F" rel="twitter" target="_blank"><span class="total">'.tools::getTwCount(MAIN_HOST).'</span></a></li>
                        <li class="link-facebook"><a href="http://facebook.com/sharer.php?t='.$this->event['author'].' - '.$this->event['name'].'&amp;u=%20http%3A%2F%2F'.$_SERVER['HTTP_HOST'].'/release/'.$this->event['id'].'/" rel="facebook" target="_blank"><span class="total">'.tools::getFbCount(MAIN_HOST).'</span></a></li>
                        <li class="link-vkontakte"><a href="http://vkontakte.ru/share.php?url=%20http%3A%2F%2F'.$_SERVER['HTTP_HOST'].'/release/'.$this->event['id'].'/" rel="vkontakte" target="_blank"><span class="total">'.tools::getVkCount(MAIN_HOST).'</span></a></li>
                        <!--li class="link-gplus"><a href="http://www.google.com/buzz/post?url=http%3A%2F%2'.MAIN_HOST.'%2F" rel="gplus" target="_blank"><span class="total">12</span></a></li-->
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="post-rate">
                  <input name="url" value="/comments/rate/" type="hidden">
                  <input name="item_id" value="'.$itemid.'" type="hidden">
                  <input name="total" value="'.$this->event['totalrate'].'" type="hidden">
                  <input name="current" value="'.$this->event['rate'].'" type="hidden">
                  <div class="title">'.$this->registry->trans['rating'].' <span class="total">('.$totelalrate.')</span> &nbsp;<!--a href="_help.php" target="_blank" class="help-link"><img src="img/px.gif" alt=""></a--></div>
                  <div class="'.$rateAct[1].' '.$rateClosed.' like-link"><i class="i"></i></div>
                  <div class="'.$rateAct[-1].' '.$rateClosed.' dislike-link"><i class="i"></i></div>
                </div>
              </div>

			  <div class="'.$comments_tree_empty.'comments-tree">
			    <input name="remove_url" value="/comments/remove/" type="hidden" />
			    <input name="quote_url" value="/comments/quote/" type="hidden" />
			    <input name="unquote_url" value="/comments/unquote/" type="hidden" />
			    
				'.$comemntTree.'
				
			  </div>
			
			  <div class="comments-add">
			    <div class="add-link"><span>'.$this->registry->trans['addcomment'].'</span></div>
			    <div class="comments-form">
			      <form action="/comments/addcomment/" method="post" enctype="multipart/form-data">
			        <input name="parent_id" value="0" type="hidden" />
			        <input name="itemid" value="'.$this->event['itemid'].'" type="hidden" />
			        <input name="siteid" value="'.$this->event['siteid'].'" type="hidden" />
			        <input name="authorid" value="'.$this->event['userid'].'" type="hidden" />
			        <input name="incut" value="'.$this->event['incut'].'" type="hidden" />
			        <input name="datatype" value="releases" type="hidden" />
			        <div class="field-message field">
			          <label for="comments-form-message" class="placeholder">'.$this->registry->trans['message'].'</label>
			          <div class="textarea">
			            <textarea name="message" id="comments-form-message" cols="" rows="" title="'.$this->registry->trans['message'].'" class="required">'.$this->registry->trans['message'].'</textarea>
			<!--
			            <div class="input-file">
			              <div class="pick">
			                <div class="browse-link"><i class="i"></i></div>
			                <div class="title">Прикрепить файл (до 1 МБ) <a href="/help/" target="_blank" class="help-link"><img src="/img/reactor/px.gif" alt="" /></a></div>
			                <div class="input"><input name="attach" type="file" /></div>
			              </div>
			              <div class="hidden info">
			                <div class="name"></div>
			                <div class="clear-link"><i class="i"></i></div>
			              </div>
			            </div>
			-->
			            <div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div>
			          </div>
			        </div>
			        <div class="submit">
			         '.$submittext.'
					 '.$submitB.'
			        </div>
			      </form>
			    </div>
			  </div>
			';
			
			echo json_encode($data);
		}
		function showvideoAction() {
			/* header('Content-Type: application/json; charset=utf-8'); */
			
			
			
			if($_GET['id'])
			$itemid=$_GET['id'];
			else
			$itemid=false;
			
			$this->Video=new Video;
			$this->video=$this->Video->getCommentVideo($itemid);
			$this->comments=$this->Comments->getComments($itemid,$this->video['incut']);
			
			
			$data = array(
			    'error' => false,
			    'status' => '',
			    'token' =>$this->registry->token->getToken()
			);
			if(count($this->comments) <= 0){
				$comments_disabled='comments-type-disabled ';
				$comments_tree_empty='comments-tree-empty ';
			}
			
			$comemntTree=tools::getComments($this->comments, $this->video['incut'], $this->video['userid']);
			
			if(!$this->video['totalrate'])
			  $this->video['totalrate'] = 0;
			
			if ($this->Session->User['id'])
			  $rateAct[$this->video['rate']] = 'act ';
			else
			  $rateClosed='auth-popup-link ';
			
			
			 if (tools::int($_SESSION['User']['id']) < 1) { 
			 	
			 }
			 if (tools::int($_SESSION['User']['id']) > 0) {
			 	$submitB='<div class="button"><div class="r"><div class="l"><button type="submit">'.$this->registry->trans['add'].'</button></div></div></div>';
			 } else { 
			 	//$submittext='<div class="note">Только зарегистрированые пользователи могут оставлять комментарии.</div>';
			 	$submitB='<div class="button"><div class="r"><div class="l"><button type="button" class="auth-popup-link">'.$this->registry->trans['add'].'</button></div></div></div>';
			 }
			
			if ($this->video['totalrate']>0)
			$totelalrate='+'.$this->video['totalrate'].'';
			else
			$totelalrate=$this->video['totalrate'];
			
			
			$data['content'] = '
            <div class="comments-header">
                <div class="comments-title">
                  <h2>'.$this->registry->trans['comments'].'</h2>
                  <div class="i-pointer"></div>
                </div>

                <div class="post-share">
                  <input name="url" value="_share.php" type="hidden" />
                  <input name="item_id" value="'.$itemid.'" type="hidden" />
                  <div class="i"></div>
                  <div class="links">
                    <div class="r">
                      <div class="l">
                        <ul>
                         <li class="link-twitter"><a href="http://twitter.com/home?status='.MAIN_NAME.'%20http%3A%2F%2F'.MAIN_HOST.'%2F" rel="twitter" target="_blank"><span class="total">'.tools::getTwCount(MAIN_HOST).'</span></a></li>
                        <li class="link-facebook"><a href="http://facebook.com/sharer.php?t='.$this->video['author'].' - '.$this->video['name'].'&amp;u=%20http%3A%2F%2F'.$_SERVER['HTTP_HOST'].'/release/'.$this->video['id'].'/" rel="facebook" target="_blank"><span class="total">'.tools::getFbCount(MAIN_HOST).'</span></a></li>
                        <li class="link-vkontakte"><a href="http://vkontakte.ru/share.php?url=http%3A%2F%2F'.MAIN_HOST.'%2F" rel="vkontakte" target="_blank"><span class="total">'.tools::getVkCount(MAIN_HOST).'</span></a></li>
                        <!--li class="link-gplus"><a href="http://www.google.com/buzz/post?url=http%3A%2F%2'.MAIN_HOST.'%2F" rel="gplus" target="_blank"><span class="total">12</span></a></li-->
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="post-rate">
                  <input name="url" value="/comments/rate/" type="hidden">
                  <input name="item_id" value="'.$itemid.'" type="hidden">
                  <input name="total" value="'.$this->video['totalrate'].'" type="hidden">
                  <input name="current" value="'.$this->video['rate'].'" type="hidden">
                  <div class="title">'.$this->registry->trans['rating'].' <span class="total">('.$totelalrate.')</span> &nbsp;<!--a href="_help.php" target="_blank" class="help-link"><img src="img/px.gif" alt=""></a--></div>
                  <div class="'.$rateAct[1].' '.$rateClosed.' like-link"><i class="i"></i></div>
                  <div class="'.$rateAct[-1].' '.$rateClosed.' dislike-link"><i class="i"></i></div>
                </div>
              </div>

			  <div class="'.$comments_tree_empty.'comments-tree">
			    <input name="remove_url" value="/comments/remove/" type="hidden" />
			    <input name="quote_url" value="/comments/quote/" type="hidden" />
			    <input name="unquote_url" value="/comments/unquote/" type="hidden" />
			    
				'.$comemntTree.'
				
			  </div>
			
			  <div class="comments-add">
			    <div class="add-link"><span>'.$this->registry->trans['addcomment'].'</span></div>
			    <div class="comments-form">
			      <form action="/comments/addcomment/" method="post" enctype="multipart/form-data">
			        <input name="parent_id" value="0" type="hidden" />
			        <input name="itemid" value="'.$this->video['itemid'].'" type="hidden" />
			        <input name="siteid" value="'.$this->video['siteid'].'" type="hidden" />
			        <input name="authorid" value="'.$this->video['userid'].'" type="hidden" />
			        <input name="incut" value="'.$this->video['incut'].'" type="hidden" />
			        <input name="datatype" value="releases" type="hidden" />
			        <div class="field-message field">
			          <label for="comments-form-message" class="placeholder">'.$this->registry->trans['message'].'</label>
			          <div class="textarea">
			            <textarea name="message" id="comments-form-message" cols="" rows="" title="'.$this->registry->trans['message'].'" class="required">'.$this->registry->trans['message'].'</textarea>
			<!--
			            <div class="input-file">
			              <div class="pick">
			                <div class="browse-link"><i class="i"></i></div>
			                <div class="title">Прикрепить файл (до 1 МБ) <a href="/help/" target="_blank" class="help-link"><img src="/img/reactor/px.gif" alt="" /></a></div>
			                <div class="input"><input name="attach" type="file" /></div>
			              </div>
			              <div class="hidden info">
			                <div class="name"></div>
			                <div class="clear-link"><i class="i"></i></div>
			              </div>
			            </div>
			-->
			            <div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div>
			          </div>
			        </div>
			        <div class="submit">
			         '.$submittext.'
					 '.$submitB.'
			        </div>
			      </form>
			    </div>
			  </div>
			';
			
			echo json_encode($data);
		}
		function showgalleryAction() {
			/* header('Content-Type: application/json; charset=utf-8'); */
			
			
			
			if($_GET['id'])
			$itemid=$_GET['id'];
			else
			$itemid=false;
			
			$this->Gallery=new Gallery;
			$this->gallery=$this->Gallery->getCommentGallery($itemid);
			$this->comments=$this->Comments->getComments($itemid,$this->gallery['incut']);
			
			
			$data = array(
			    'error' => false,
			    'status' => '',
			    'token' =>$this->registry->token->getToken()
			);
			if(count($this->comments) <= 0){
				$comments_disabled='comments-type-disabled ';
				$comments_tree_empty='comments-tree-empty ';
			}
			
			$comemntTree=tools::getComments($this->comments, $this->gallery['incut'], $this->gallery['userid']);
			
			if(!$this->gallery['totalrate'])
			  $this->gallery['totalrate'] = 0;
			
			if ($this->Session->User['id'])
			  $rateAct[$this->gallery['rate']] = 'act ';
			else
			  $rateClosed='auth-popup-link ';
			
			
			 if (tools::int($_SESSION['User']['id']) < 1) { 
			 	
			 }
			 if (tools::int($_SESSION['User']['id']) > 0) {
			 	$submitB='<div class="button"><div class="r"><div class="l"><button type="submit">'.$this->registry->trans['add'].'</button></div></div></div>';
			 } else { 
			 	//$submittext='<div class="note">Только зарегистрированые пользователи могут оставлять комментарии.</div>';
			 	$submitB='<div class="button"><div class="r"><div class="l"><button type="button" class="auth-popup-link">'.$this->registry->trans['add'].'</button></div></div></div>';
			 }
			
			if ($this->gallery['totalrate']>0)
			$totelalrate='+'.$this->gallery['totalrate'].'';
			else
			$totelalrate=$this->gallery['totalrate'];
			
			
			$data['content'] = '
            <div class="comments-header">
                <div class="comments-title">
                  <h2>'.$this->registry->trans['comments'].'</h2>
                  <div class="i-pointer"></div>
                </div>

                <div class="post-share">
                  <input name="url" value="_share.php" type="hidden" />
                  <input name="item_id" value="'.$itemid.'" type="hidden" />
                  <div class="i"></div>
                  <div class="links">
                    <div class="r">
                      <div class="l">
                        <ul>
                         <li class="link-twitter"><a href="http://twitter.com/home?status='.MAIN_NAME.'%20http%3A%2F%2F'.MAIN_HOST.'%2F" rel="twitter" target="_blank"><span class="total">'.tools::getTwCount(MAIN_HOST).'</span></a></li>
                        <li class="link-facebook"><a href="http://facebook.com/sharer.php?t='.$this->gallery['author'].' - '.$this->gallery['name'].'&amp;u=%20http%3A%2F%2F'.$_SERVER['HTTP_HOST'].'/release/'.$this->gallery['id'].'/" rel="facebook" target="_blank"><span class="total">'.tools::getFbCount(MAIN_HOST).'</span></a></li>
                        <li class="link-vkontakte"><a href="http://vkontakte.ru/share.php?url=http%3A%2F%2F'.MAIN_HOST.'%2F" rel="vkontakte" target="_blank"><span class="total">'.tools::getVkCount(MAIN_HOST).'</span></a></li>
                        <!--li class="link-gplus"><a href="http://www.google.com/buzz/post?url=http%3A%2F%2'.MAIN_HOST.'%2F" rel="gplus" target="_blank"><span class="total">12</span></a></li-->
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="post-rate">
                  <input name="url" value="/comments/rate/" type="hidden">
                  <input name="item_id" value="'.$itemid.'" type="hidden">
                  <input name="total" value="'.$this->gallery['totalrate'].'" type="hidden">
                  <input name="current" value="'.$this->gallery['rate'].'" type="hidden">
                  <div class="title">'.$this->registry->trans['rating'].' <span class="total">('.$totelalrate.')</span> &nbsp;<!--a href="_help.php" target="_blank" class="help-link"><img src="img/px.gif" alt=""></a--></div>
                  <div class="'.$rateAct[1].' '.$rateClosed.' like-link"><i class="i"></i></div>
                  <div class="'.$rateAct[-1].' '.$rateClosed.' dislike-link"><i class="i"></i></div>
                </div>
              </div>

			  <div class="'.$comments_tree_empty.'comments-tree">
			    <input name="remove_url" value="/comments/remove/" type="hidden" />
			    <input name="quote_url" value="/comments/quote/" type="hidden" />
			    <input name="unquote_url" value="/comments/unquote/" type="hidden" />
			    
				'.$comemntTree.'
				
			  </div>
			
			  <div class="comments-add">
			    <div class="add-link"><span>'.$this->registry->trans['addcomment'].'</span></div>
			    <div class="comments-form">
			      <form action="/comments/addcomment/" method="post" enctype="multipart/form-data">
			        <input name="parent_id" value="0" type="hidden" />
			        <input name="itemid" value="'.$this->gallery['itemid'].'" type="hidden" />
			        <input name="siteid" value="'.$this->gallery['siteid'].'" type="hidden" />
			        <input name="authorid" value="'.$this->gallery['userid'].'" type="hidden" />
			        <input name="incut" value="'.$this->gallery['incut'].'" type="hidden" />
			        <input name="datatype" value="releases" type="hidden" />
			        <div class="field-message field">
			          <label for="comments-form-message" class="placeholder">'.$this->registry->trans['message'].'</label>
			          <div class="textarea">
			            <textarea name="message" id="comments-form-message" cols="" rows="" title="'.$this->registry->trans['message'].'" class="required">'.$this->registry->trans['message'].'</textarea>
			<!--
			            <div class="input-file">
			              <div class="pick">
			                <div class="browse-link"><i class="i"></i></div>
			                <div class="title">Прикрепить файл (до 1 МБ) <a href="/help/" target="_blank" class="help-link"><img src="/img/reactor/px.gif" alt="" /></a></div>
			                <div class="input"><input name="attach" type="file" /></div>
			              </div>
			              <div class="hidden info">
			                <div class="name"></div>
			                <div class="clear-link"><i class="i"></i></div>
			              </div>
			            </div>
			-->
			            <div class="lt"></div><div class="rt"></div><div class="rb"></div><div class="lb"></div>
			          </div>
			        </div>
			        <div class="submit">
			         '.$submittext.'
					 '.$submitB.'
			        </div>
			      </form>
			    </div>
			  </div>
			';
			
			echo json_encode($data);
		}
		function addcommentAction() {
			header('Content-type: text/plain; charset=utf-8');
			echo json_encode($this->Comments->addComment($_POST));	
		}
		function removeAction() {
			header('Content-type: text/plain; charset=utf-8');
			echo json_encode($this->Comments->removeComment($_POST));
		}
		function quoteAction(){
			header('Content-type: text/plain; charset=utf-8');
			echo json_encode($this->Comments->quoteComment($_POST));
		}
		function unquoteAction(){
			header('Content-type: text/plain; charset=utf-8');
			echo json_encode($this->Comments->unquoteComment($_POST));
		}
		function rateAction(){
			header('Content-type: text/plain; charset=utf-8');
			echo json_encode($this->Comments->rateItem($_POST));
		}
		
}


?>