<?
require_once 'modules/base/models/Basemodel.php';

Class Menu Extends Basemodel {

public function getAdminMenuItems(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				z_menu.id,
				z_menu.name,
				z_menutype.code,
				z_menu.active,
				_items.id as itemid
				FROM 
				_items
				INNER JOIN z_menu
				ON z_menu.itemid=_items.id
				INNER JOIN z_menutype 
				ON z_menutype.id = z_menu.menutypeid
				WHERE _items.datatypeid=1
				AND _items.siteid='.tools::int($_SESSION['Site']['id']).'
				ORDER BY z_menu.sort
				');
	if($result)
	return $result;
}
public function getMenuBgIds($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  itemid AS id 
				FROM
				  z_menu_background 
				WHERE backgroundid='.tools::int($id).'
				');
	if($result)
	{
	foreach($result as $row)
	$ids[]=$row['id'];
	return $ids;
	}
	else 
	return array();
}
public function getAdminMenuAll(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_menu.id,
				  z_menu.name,
				  z_menu.original,
				  z_menu.CODE AS url,
				  _items.id AS itemid,
				  z_menu.active,
				  z_menutype.id AS menutypeid,
				  z_menutypetrans.NAME AS menutypename 
				FROM
				  _items 
				  INNER JOIN
				  z_menu 
				  ON z_menu.itemid = _items.id 
				  INNER JOIN
				  z_menutype 
				  ON z_menutype.id = z_menu.menutypeid
				  LEFT JOIN z_menutypetrans
				  ON z_menutypetrans.menutypeid=z_menutype.id
				  AND z_menutypetrans.languageid= '.tools::int($_SESSION['Site']['languageid']).'
				WHERE _items.siteid = '.tools::int($_SESSION['Site']['id']).' 
				  AND _items.datatypeid = 1
				ORDER BY z_menu.sort ASC
				');
	if($result)
	return $result;
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
				z_menu.active,
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
		
	if($result){
				$cnt=0;
				foreach($result as $menu){
						$lastmenuli=''; 
						if(str_replace('inner','',$this->registry->action)==$menu['code'] || $this->registry->controller==$menu['code']){
                        $curmodule=$menu['code'];
						$this->pagetitle=$menu['name'];
						echo $menu['name'];
						echo 123;
						}
						
						$menucss='';
						if($menu['active']==0)
						$menucss=' class="unactive"';
						
						if(count($result)-1==$cnt){
						$lastmenuli=' class="last"';
						}
						$menustr.='<li'.$lastmenuli.'><a rel="'.$menu['url'].'" href="/'.$menu['code'].'/"'.$menucss.'>'.$menu['name'].'</a></li>';
				$cnt++;
				}
	
	}
	return $menustr;
}
public function updateMenu($data){
	$db=db::init();
	$db->beginTransaction();
	foreach($data as $key=>$row){
		$db->exec('update z_menu set name="'.$row['name'].'", active='.$row['active'].', sort='.$key.' where id='.tools::int($row['id']).' AND userid='.tools::int($_SESSION['User']['id']).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
	}
	$db->commit();
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