<?
require_once 'modules/base/models/Basemodel.php';

Class Menu Extends Basemodel {

public $registry;
public $pagetitle;
public function __construct($registry){
	$this->registry=$registry;
}
public function getAdminMenuItems(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				z_menu.id,
				z_menu.name,
				z_menu.active,
				z_menu.showbanner,
				z_menu.homewidget,
				z_menu.allwidget,
				z_menutype.code,
				z_menutypetrans.name AS menutypename,
				_items.id as itemid
				FROM 
				_items
				INNER JOIN z_menu
				ON z_menu.itemid=_items.id
				INNER JOIN z_menutype 
				ON z_menutype.id = z_menu.menutypeid
				INNER JOIN z_menutypetrans
				ON z_menutypetrans.menutypeid=z_menutype.id AND z_menutypetrans.languageid='.tools::int($_SESSION['langid']).'
				WHERE _items.datatypeid=1
				AND _items.siteid='.tools::int($_SESSION['Site']['id']).'
				ORDER BY z_menu.sort
				');
	if($result)
	return $result;
}

public function updateMenu($data){
	$db=db::init();
	$db->beginTransaction();
	$key=0;
	foreach($data as $row){
		$db->exec('
		update 
		z_menu 
		set 
		name="'.tools::str($row['name']).'", 
		sort='.$key.', 
		showbanner='.tools::int($row['showbanner']).',
		homewidget='.tools::int($row['homewidget']).',
		allwidget='.tools::int($row['allwidget']).',
		active='.tools::int($row['active']).' 
		where id='.tools::int($row['id']).' 
		AND userid='.tools::int($_SESSION['User']['id']).' 
		AND siteid='.tools::int($_SESSION['Site']['id']).'');
		$key++;
	}
	$db->commit();
}

public function getMenuItems(){
	$db=db::init();
	$activeStr='AND z_menu.active=1';
	if($_SESSION['User']['id']>0){
		if(is_array($_SESSION['User']['reccounts'])){
			foreach($_SESSION['User']['reccounts'] as $rec)
			$recIdArr[$rec['id']]=$rec['id'];
		}
	}
	if(is_array($recIdArr)){
		if(in_array($_SESSION['Site']['id'],$recIdArr))
		$activeStr='';
	}
	$result=$db->queryFetchAllAssoc('
				SELECT 
				z_menu.id,
				z_menu.name,
				z_menu.userid,
				z_menu.code,
				z_menu.homewidget,
				z_menu.allwidget,
				z_menu.showbanner,
				z_menu.active,
				z_menu.menutypeid,
				IF(
				    z_background2.id > 0,
				    CONCAT(
				      "/uploads/sites/",
				      z_background2.siteid,
				      "/img/",
				      z_background2.file_name
				    ),
				    CONCAT(
				      "/uploads/sites/",
				      z_background.siteid,
				      "/img/",
				      z_background.file_name
				    )
				  ) AS url 
				FROM 
				_items
				INNER JOIN z_menu
				ON z_menu.itemid=_items.id '.$activeStr.'
				LEFT JOIN z_background
				ON z_background.siteid=z_menu.siteid AND z_background.major=1
				LEFT JOIN z_menu_background
				ON z_menu_background.itemid=z_menu.itemid
				LEFT JOIN z_background z_background2
				ON z_background2.id=z_menu_background.backgroundid
				WHERE _items.datatypeid=1
				AND _items.siteid='.tools::int($_SESSION['Site']['id']).'
				GROUP BY z_menu.id
				ORDER BY z_menu.sort
				');
	//$menustr.='<div><a href="/">Главная</a></div>';	
	if($result){
		
				$cnt=0;
				foreach($result as $menu){
						if(str_replace('cinner','',$this->registry->action)==$menu['code'] 
						|| $this->registry->routername==$menu['code'] 
						|| $this->registry->controller==$menu['code']
						){
						$this->pagetitle=$menu['name'];
						if($menu['showbanner'])
						$this->registry->showteaser=$menu['showbanner'];
						}
						if($this->registry->controller=='index' && $this->registry->action=='index' && $menu['code']=='main'){
						$this->pagetitle=$menu['name'];
						if($menu['showbanner'])
						$this->registry->showteaser=$menu['showbanner'];	
						}
						
						if($menu['code']=='main')
						$menu['code']='';
						else
						$menu['code']=$menu['code'].'/';
						$menustr.='<div><a href="/'.$menu['code'].'">'.$menu['name'].'</a></div>';
				$cnt++;
				}
				/*if($this->registry->showteaser<1 && $this->registry->controller=='index' && $this->registry->action=='index')
				$this->registry->showteaser=1;*/
	
	}
	return array('data'=>$result,'html'=>$menustr);
}
public function getPageTitle(){
	$urlArr=parse_url($_SERVER['REQUEST_URI']);
	$pathArr=explode('/',trim($urlArr['path'],'/'));
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				z_menu.name
				FROM z_menu
				WHERE  z_menu.code="'.tools::str($pathArr['0']).'"
				AND z_menu.siteid='.tools::int($_SESSION['Site']['id']).'
				LIMIT 0,1
				');
	if($result['name'])
	return $result['name'];
}
}
?>