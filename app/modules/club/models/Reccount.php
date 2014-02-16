<?
require_once 'modules/base/models/Basemodel.php';
require_once 'modules/club/models/Brand.php';

Class Reccount Extends Basemodel {

private $registry;
public function __construct($registry){
	$this->registry=$registry;
}

public function getAdminName(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_site.name,
				  z_site.metatitle,
				  z_site.metakeywords,
				  z_site.metadescription
				FROM
				  z_site 
				WHERE z_site.id ='.tools::int($_SESSION['Site']['id']).'
				AND z_site.userid='.tools::int($_SESSION['User']['id']).'
				LIMIT 0,1
				');
	if($result)
	return $result;
}
public function updateName($data){
	$db=db::init();
	$result=$db->exec('
				UPDATE z_site
				SET name="'.tools::str($data['name']).'",
				metatitle="'.tools::str($data['metatitle']).'",
				metakeywords="'.tools::str($data['metakeywords']).'",
				metadescription="'.tools::str($data['metadescription']).'"
				WHERE z_site.id ='.tools::int($_SESSION['Site']['id']).'
				AND z_site.userid='.tools::int($_SESSION['User']['id']).'
				');
	$_SESSION['Site']['name']=$data['name'];
	$_SESSION['Site']['metatitle']=$data['metatitle'];
	$_SESSION['Site']['metakeywords']=$data['metakeywords'];
	$_SESSION['Site']['metadescription']=$data['metadescription'];
	if($result)
	return $result;
}
public function getDomains(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_domain.name as url,
					  z_domain.id
					FROM
					  z_domain 
					WHERE z_domain.siteid = '.tools::int($_SESSION['Site']['id']).' 
					LIMIT 0,1
					');
		if($result)
		return $result;
}
public function updateDomain($domains){
		$db=db::init();
		if($domains)
		
		foreach($domains as $d){
			$d['url']=str_replace('http://','',$d['url']);
			$dom=parse_url('http://'.$d['url']);
			$d['url']=str_replace('www.','',($dom['host']));
			
			if($d['id']>0 && strlen(trim($d['url']))>3){
				$db->exec("UPDATE z_domain SET name='".tools::str($d['url'])."' WHERE z_domain.id=".tools::int($d['id'])." AND siteid=".$_SESSION['Site']['id']."");
			}
			elseif($d['id']>0 && strlen(trim($d['url']))<4){
				$db->exec("DELETE FROM z_domain WHERE z_domain.id=".tools::int($d['id'])." AND siteid=".$_SESSION['Site']['id']."");
			}
			elseif(!$d['id'] && strlen(trim($d['url']))>3){
				$db->exec("DELETE FROM z_domain WHERE siteid=".$_SESSION['Site']['id']."");
				$db->exec("INSERT INTO z_domain (name,siteid,active) VALUES ('".tools::str($d['url'])."',".$_SESSION['Site']['id'].",1)");
				//$db->exec("INSERT INTO z_site_domain (domainid,siteid) VALUES (".$db->lastInsertId().",".$_SESSION['Site']['id'].")");
			}
			elseif(!$d['id'] && strlen(trim($d['url']))<4){
				
			}
			
			
		}
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_domain.name as url
					FROM
					  z_domain 
					WHERE z_domain.siteid = '.tools::int($_SESSION['Site']['id']).' 
					LIMIT 0,1
					');
		if($result)
		return $result;
	}

public function getAdminPlace(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_site.id,
				  z_site.slogan,
				  z_site.address,
				  z_site.maplink,
				  z_site.about,
				  z_site.gallerytypeid,
				  z_site.videoid 
				FROM
				  z_site 
				WHERE z_site.id ='.tools::int($_SESSION['Site']['id']).'
				AND z_site.userid='.tools::int($_SESSION['User']['id']).'
				LIMIT 0,1
				');
	if($result)
	return $result;
}
public function updatePlace($data){
	if($_SESSION['Site']['id']!=$data['id'])
	return;
	$db=db::init();
	$result=$db->exec('
				UPDATE z_site
				SET slogan="'.tools::str($data['slogan']).'",
				  address="'.tools::str($data['address']).'",
				  maplink="'.tools::str($data['maplink']).'",
				  about="'.tools::str($data['about']).'",
				  gallerytypeid='.tools::int($data['gallery']).',
				  videoid='.tools::int($data['video']).'
				WHERE z_site.id ='.tools::int($_SESSION['Site']['id']).'
				AND z_site.userid='.tools::int($_SESSION['User']['id']).'
				');
	if($result)
	return $result;
}
public function getPlace(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_site.id,
				  z_site.slogan,
				  z_site.address,
				  z_site.maplink,
				  z_site.about,
				  z_site.gallerytypeid,
				  z_gallerytype.date_start,
				  z_gallerytype.NAME AS gallerytypename,
				  z_video.url AS videourl,
				  z_video.NAME AS videoname,
				  z_video.date_start AS videodate,
				  z_video.socialid AS videosocialid,
				  IF(
				    z_videopreview.id > 0,
				    CONCAT(
				      "/uploads/sites/",
				      z_video.siteid,
				      "/img/1_",
				      z_videopreview.url
				    ),
				    CONCAT(
				      "/uploads/sites/",
				      z_video.siteid,
				      "/img/1_",
				      z_videopreview_default.url
				    )
				  ) AS videopreview,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallerytype.siteid,
				    "/img/1_",
				    z_gallery.file_name
				  ) AS preview 
				FROM
				  z_site 
				  LEFT JOIN
				  z_gallerytype 
				  ON z_gallerytype.id = z_site.gallerytypeid 
				  LEFT JOIN
				  z_gallery 
				  ON z_gallery.gallerytypeid = z_gallerytype.id 
				  AND z_gallery.sort = 0 
				  LEFT JOIN
				  z_video 
				  ON z_video.id = z_site.videoid 
				  LEFT JOIN
				  z_videopreview 
				  ON z_videopreview.id = z_video.previewid 
				  LEFT JOIN
				  z_videopreview z_videopreview_default 
					ON z_videopreview_default.siteid = '.tools::int($_SESSION['Site']['id']).'
  					AND z_videopreview_default.major = 1 
				WHERE z_site.id ='.tools::int($_SESSION['Site']['id']).'
				LIMIT 0,1
				');
	if($result)
	return $result;
}
public function getСontacts(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_contacts.id,
				  z_contacts.name,
				  z_contacts.email,
				  z_contacts.phone
				FROM
				  z_contacts 
				WHERE z_contacts.siteid = '.tools::int($_SESSION['Site']['id']).'
				ORDER BY z_contacts.sort ASC
				');
	if($result)
	return $result;
}
public function getAdminContact(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_contacts.id,
				  z_contacts.name,
				  z_contacts.email,
				  z_contacts.phone 
				FROM
				  z_contacts 
				WHERE z_contacts.siteid = '.tools::int($_SESSION['Site']['id']).'
				AND z_contacts.userid='.tools::int($_SESSION['User']['id']).' 
				ORDER BY z_contacts.sort ASC
				');
	if($result)
	return $result;
}
public function updateContacts($contacts){
	$db=db::init();
	$cnt=0;
	foreach($contacts as $data){
	if($data['id']>0){
				$db->exec('
				UPDATE z_contacts
				SET name="'.tools::str($data['name']).'",
				  phone="'.tools::str($data['phone']).'",
				  email="'.tools::str($data['email']).'",
				  sort='.$cnt.'
				WHERE z_contacts.id='.tools::int($data['id']).' AND z_contacts.siteid ='.tools::int($_SESSION['Site']['id']).'
				AND z_contacts.userid='.tools::int($_SESSION['User']['id']).'
				');
	}else{
				$db->exec('INSERT INTO z_contacts
				(name,phone,email,active,userid,siteid,sort) VALUES 
				("'.tools::str($data['name']).'",
				"'.tools::str($data['phone']).'",
				"'.tools::str($data['email']).'",
				1,
				'.tools::int($_SESSION['User']['id']).',
				'.tools::int($_SESSION['Site']['id']).',
				'.$cnt.')
				');
				$data['id']=$db->lastInsertId();
	}
	if($data['id']>0)
	$idArr[$data['id']]=$data['id'];
	$cnt++;
	}
	if(count($idArr)>0)
	$idWhere= 'z_contacts.id NOT IN('.implode(',',$idArr).') AND';
	$db->exec('DELETE FROM z_contacts WHERE '.$idWhere.' z_contacts.siteid ='.tools::int($_SESSION['Site']['id']).'
				AND z_contacts.userid='.tools::int($_SESSION['User']['id']).'');

}
public function getSiteTeasers(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_teaser.id,
				  z_teaser.link,
				  CONCAT(
				    "/uploads/sites/",
				    z_teaser.siteid,
				    "/img/",
				    z_teaser.file_name
				  ) AS url  
				FROM
				  z_teaser 
				WHERE  z_teaser.active=1 AND z_teaser.siteid = '.tools::int($_SESSION['Site']['id']).'
				ORDER BY z_teaser.sort ASC
				');
	$result2=$db->queryFetchAllAssoc('
				SELECT
				  z_banner_site.id, 
				  z_brand_banner.link,
				  CONCAT("/uploads/brands/",z_brand_banner.brandid,"/",z_brand_banner.file_name) AS url,
				  1 AS brand,
				  DATE_FORMAT(z_brand_banner.date_start,"%d.%m.%Y") AS date_start,
				  DATE_FORMAT(z_brand_banner.date_end,"%d.%m.%Y") AS date_end
				FROM
				  z_banner_site 
				INNER JOIN z_brand_banner
				ON z_brand_banner.`id`=z_banner_site.`bannerid`
				WHERE z_banner_site.`siteid` = '.tools::int($_SESSION['Site']['id']).' AND z_banner_site.`status`=3
				AND NOW() BETWEEN z_brand_banner.`date_start` AND z_brand_banner.`date_end`
				');
	
	if($result)
	return array_merge($result2,$result);
}
public function getSiteAdminTeasers(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_teaser.id,
				  z_teaser.link,
				  z_teaser.active,
				  CONCAT(
				    "/uploads/sites/",
				    z_teaser.siteid,
				    "/img/",
				    z_teaser.file_name
				  ) AS url 
				FROM
				  z_teaser 
				WHERE z_teaser.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_teaser.userid = '.tools::int($_SESSION['User']['id']).'
				ORDER BY z_teaser.sort ASC');
	$result2=$db->queryFetchAllAssoc('
				SELECT 
				  z_brand_banner.link,
				  CONCAT("/uploads/brands/",z_brand_banner.brandid,"/",z_brand_banner.file_name) AS url,
				  1 AS brand,
				  DATE_FORMAT(z_brand_banner.date_start,"%d.%m.%Y") AS date_start,
				  DATE_FORMAT(z_brand_banner.date_end,"%d.%m.%Y") AS date_end
				FROM
				  z_banner_site 
				INNER JOIN z_brand_banner
				ON z_brand_banner.`id`=z_banner_site.`bannerid`
				WHERE z_banner_site.`siteid` = '.tools::int($_SESSION['Site']['id']).' AND z_banner_site.`status`=3
				AND NOW() BETWEEN z_brand_banner.`date_start` AND z_brand_banner.`date_end`
				');

    if($result)
	return array_merge($result2,$result);
}
public function updateTeasers($data,$deleted){
	$db=db::init();
	if(is_array($data)){
	$cnt=0;
	foreach($data as $bg){
				if($bg['url'] && !$bg['id']){
							//$bg['url']=str_replace('11_', '', $bg['url']);
							
							$bg['url']=tools::GetImageFromUrl("http://".$_SERVER['HTTP_HOST'].$bg['url']);
                            
							$tempfile="".$_SERVER['DOCUMENT_ROOT'].$bg['url']."";
							if(file_exists($tempfile)){
								$bg['url']=pathinfo($bg['url']);
								$newfile=md5(uniqid().microtime()).'.'.$bg['url']['extension'];
								rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
							}
				}
				
				if(!$bg['id']){
						$db->exec('
						INSERT INTO z_teaser 
						(link, active, file_name, siteid, userid, sort)
						VALUES
						("'.tools::str($bg['link']).'", '.tools::int($bg['active']).',"'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', '.tools::int($_SESSION['User']['id']).', '.$cnt.')
						');
				} else {
					$db->exec('UPDATE z_teaser SET 
					link="'.tools::str($bg['link']).'",
					active='.tools::int($bg['active']).',
					sort='.$cnt.'
					WHERE z_teaser.id='.tools::int($bg['id']).' AND z_teaser.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_teaser.userid = '.tools::int($_SESSION['User']['id']).'
					');
				}
			$cnt++;
			}
	}
	if(is_array($deleted)){
		foreach($deleted as $del)
		{
			if($del['id']>0){
				 $db->exec('DELETE FROM z_teaser WHERE id='.tools::int($del['id']).' AND z_teaser.siteid = '.tools::int($_SESSION['Site']['id']).' AND z_teaser.userid = '.tools::int($_SESSION['User']['id']).'');
				 tools::delImg($del['url']);
			}
		}
	}
}
	public function getSiteData(){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_site.name,
				  z_site.address,
				  z_site.maplink,
				  z_site.color,
				  z_site.margin,
				  z_contacts.phone,
				  CONCAT(
				    "/uploads/sites/",
				    z_background.siteid,
				    "/img/",
				    z_background.file_name
				  ) AS pagebg,
				  CONCAT(
				    "/uploads/sites/",
				    z_pattern.siteid,
				    "/img/",
				    z_pattern.url
				  ) AS pagepattern,
				  CONCAT("/uploads/sites/",z_favicon.siteid,"/img/",z_favicon.url) AS favicon 
				FROM
				  z_site 
				  LEFT JOIN
				  z_contacts 
				  ON z_contacts.siteid = z_site.id 
				  AND z_contacts.sort = 0 
				  LEFT JOIN
				  z_background 
				  ON z_background.siteid = z_site.id 
				  LEFT JOIN
				  z_pattern 
				  ON z_pattern.siteid = z_site.id
				  LEFT JOIN
				  z_favicon 
				  ON z_favicon.siteid = z_site.id
				WHERE z_site.id ='.tools::int($_SESSION['Site']['id']).'
				LIMIT 0,1
				');
		if($result){
		$this->registry->sitedata=$result;
		return $result;
		}
	}
	public function getForm(){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
			SELECT * FROM z_clubform
			WHERE siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'
		');
		$this->Brand=new Brand;
		$result['brandlist']=$this->Brand->getSiteBrandList();
		
		if($result)
		return $result;
	}
	public function updateForm($data){
		$db=db::init();
		if($data['id']>0){
			$db->exec('UPDATE z_clubform
			SET name="'.tools::str($data['name']).'", date_update=NOW(),
			email="'.tools::str($data['email']).'",
			phone="'.tools::str($data['phone']).'",
			espresso="'.tools::str($data['espresso']).'",
			mohito="'.tools::str($data['mohito']).'",
			longisland="'.tools::str($data['longisland']).'",
			bonaqua="'.tools::str($data['bonaqua']).'",
			age="'.tools::str($data['age']).'",
			music="'.tools::str($data['music']).'",
			bar="'.tools::str($data['bar']).'",
			plazma="'.tools::str($data['plazma']).'",
			visits="'.tools::str($data['visits']).'",
			visitorscounter="'.tools::str($data['visitorscounter']).'",
			extradescription="'.tools::str($data['extradescription']).'"
			WHERE id='.tools::int($data['id']).' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'
			');
		$subject = "Обновленная анкета клуба r".$_SESSION['Site']['id'].".reactor.ua";
		}else{
			$db->exec('INSERT INTO z_clubform 
			(name,
			siteid,
			userid,
			date_update,
			email,
			phone,
			espresso,
			mohito,
			longisland,
			bonaqua,
			age,
			music,
			bar,
			visits,
			visitorscounter,
			extradescription,
			plazma
			) 
			VALUES(
			"'.tools::str($data['name']).'",
			'.tools::int($_SESSION['Site']['id']).',
			'.tools::int($_SESSION['User']['id']).',
			NOW(),
			"'.tools::str($data['email']).'",
			"'.tools::str($data['phone']).'",
			"'.tools::str($data['espresso']).'",
			"'.tools::str($data['mohito']).'",
			"'.tools::str($data['longisland']).'",
			"'.tools::str($data['bonaqua']).'",
			"'.tools::str($data['age']).'",
			"'.tools::str($data['music']).'",
			"'.tools::str($data['bar']).'",
			"'.tools::str($data['visits']).'",
			"'.tools::str($data['visitorscounter']).'",
			"'.tools::str($data['extradescription']).'",
			"'.tools::str($data['plazma']).'"
			)
			');
		$subject = "Новая анкета клуба r".$_SESSION['Site']['id'].".reactor.ua";
		}
		#Update Brands
		$this->Brand=new Brand;
		foreach($data['brandname'] as $key=>$brandname){
			if(strlen(trim($brandname))>0){
				if(tools::int($data['brandid'][$key])<1){
					$branddata[$key]=$this->Brand->findBrand($brandname);
					if($branddata[$key][0]['id']<1){
						$data['brandid'][$key]=$this->Brand->createBrand($brandname);
					}else
						$data['brandid'][$key]=$branddata[$key][0]['id'];
				}
				$brandidArr[$data['brandid'][$key]]=$data['brandid'][$key];
			}
		}
		
		
				$sitebrands=$this->Brand->getSiteBrands();
				if(count($sitebrands)>0){
					if(count($brandidArr)>0)
					$whereSql=' AND brandid not in('.implode(',',$brandidArr).')';
					$db->exec('DELETE FROM z_brand_site WHERE siteid='.tools::int($_SESSION['Site']['id']).$whereSql);
				}
				if(count($brandidArr)>0){
					foreach($brandidArr AS $bid)
						if(!in_array($bid,$sitebrands)){
							$db->exec('INSERT INTO z_brand_site (brandid,siteid) VALUES ('.tools::int($bid).','.tools::int($_SESSION['Site']['id']).')');
						}
				}
		


		$message="
1. Контактная информация\n\nИмя, Фамилия контактного лица: ".tools::str($data["name"])."\n\nE-mail: ".tools::str($data["email"])."\n\nНомер мобильного телефона: ".tools::str($data["phone"])."\n\n2. Укажите торговые марки, с которыми Вы работаете в эксклюзиве\n\nТорговые марки, компани (через запятую): ".tools::str($data["trademarks"])."\n\n3. Укажите стоимость в меню следующих позиций:\n\nЭспрессо (грн. за 1 чашку): ".tools::str($data["espresso"])."\n\nКоктейль Мохито (грн. за 1 штуку): ".tools::str($data["mohito"])."\n\nКоктейль ЛонгАйленд (грн. за 1 штуку): ".tools::str($data["longisland"])."\n\nВода Бонаква (грн. за бут. 0,5л.): ".tools::str($data["bonaqua"])."\n\n4. Укажите средний возраст посетителей: ".tools::str($data["age"])."\n\n5.Укажите направление музыки, которая играет в Вашем заведении: ".tools::str($data["music"])."\n\n6. Количество барных стоек: ".tools::str($data["bar"])."\n\n7. Количество посещений за неделю: ".tools::str($data["visits"])."\n\n8. Есть ли счетчик посетителей?\n\nесли да - укажите марку счетчика: ".tools::str($data["visitorscounter"])."\n\n9. количество плазм: ".tools::str($data["plazma"])."\n\n10. Описать возможности in-door: ".tools::str($data["extradescription"])."\n\n
		";
		/*
		$smtp=new smtp;
				$smtp->Connect(SMTP_HOST);
				$smtp->Hello(SMTP_HOST);
				$smtp->Authenticate('reactor@reactor-pro.ru', '123qwe123');
				$smtp->Mail('reactor@reactor-pro.ru');
				$smtp->Recipient('ula@reparty.com.ua');
				$smtp->Recipient('zazhigina@mads.com.ua');
				$smtp->Recipient('dmitriy.bozhok@gmail.com');
				$smtp->Data($message, $subject,"Reactor Pro");*/
		
	}
}
?>