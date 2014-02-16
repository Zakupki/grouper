<?
require_once 'modules/base/models/Basemodel.php';

Class Cards Extends Basemodel {
	
	
	public function getCardList($id){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT
					z_recard_site.id,
					z_recard_site.status,
					z_site.id AS siteid,
					z_site.name AS sitename,
					if(z_card.id>0,z_card.name,z_brand_recard.name) as name,
					if(z_domain.id,z_domain.name,concat("r",z_recard_site.siteid,".reactor.ua")) AS domain
					FROM z_recard_site
					INNER JOIN z_site
						ON z_site.id=z_recard_site.siteid
					INNER JOIN z_brand_recard
						ON z_brand_recard.id=z_recard_site.recardid
					LEFT JOIN
					  	z_domain 
					  	ON z_domain.siteid = z_recard_site.siteid 
					LEFT JOIN z_card
					ON z_card.requestid=z_recard_site.id
					WHERE z_recard_site.recardid='.tools::int($id).'
					');
		if($result)
		return $result;	
	}
	public function getCardInner($id){
		$db=db::init();
					
					$result=$db->queryFetchRowAssoc('
					SELECT 
						z_card.id AS cardid,
						z_card.name,
						z_card.price,
						z_recard_site.id,
						z_recard_site.recardid,
						z_card.yocardid,
						DATE_FORMAT(z_card.date_start,"%d.%m.%Y") AS date_start,
						DATE_FORMAT(z_card.date_end,"%d.%m.%Y") AS date_end,
						z_card.detail_text,
						z_brand_recard.brandid,
						z_brand.name AS brand,
						z_card.file_name,
						z_card.file_oldname,
						if(CHAR_LENGTH(z_card.file_name)>2,concat("/uploads/sites/",z_recard_site.siteid,"/files/",z_card.file_name), null) as url,
						z_recard_site.siteid,
						z_recard_site.status
					FROM z_card
					INNER JOIN z_recard_site
						ON z_recard_site.id=z_card.requestid
					INNER JOIN z_brand_recard
						ON z_brand_recard.id=z_recard_site.recardid
					INNER JOIN z_brand
						ON z_brand.id=z_brand_recard.brandid
					WHERE
						z_recard_site.id='.tools::int($id).'
					');
					
					if(!$result)
					$result=$db->queryFetchRowAssoc('
					SELECT
						z_recard_site.id,
						z_recard_site.recardid,
						z_brand_recard.name,
						z_brand_recard.date_start,
						DATE_FORMAT(z_brand_recard.date_start,"%d.%m.%Y") AS date_start,
						DATE_FORMAT(z_brand_recard.date_end,"%d.%m.%Y") AS date_end,
						z_brand_recard.detail_text,
						z_brand_recard.brandid,
						z_brand.name AS brand,
						z_brand_recard.file_name,
						z_brand_recard.file_oldname,
						if(CHAR_LENGTH(z_brand_recard.file_name)>2,concat("/uploads/brands/",z_brand_recard.brandid,"/",z_brand_recard.file_name), null) as url,
						z_recard_site.siteid,
						z_recard_site.status
					FROM z_recard_site
					INNER JOIN z_brand_recard
						ON z_brand_recard.id=z_recard_site.recardid
					INNER JOIN z_brand
						ON z_brand.id=z_brand_recard.brandid
					WHERE 
					z_recard_site.id='.tools::int($id).'
					');					
		if($result)
		return $result;
	}
	public function updateCardInner($data,$file){
		
		$data['date_start']=explode('.', $data['date_start']);
		$data['date_end']=explode('.', $data['date_end']);
		
		$db=db::init();
		if(!$data['cardid']){
				
			if ($file['file']['tmp_name']) {
			$tempFile = $file['file']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/sites/'.tools::int($data['siteid']).'/files/';
			$path_parts=pathinfo($file['file']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$newfilenameS=$newfilename;
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
				if(move_uploaded_file($tempFile,$targetFile)){
					$filecol=',file_name,file_oldname';
					$fileval=', "'.$newfilename.'","'.$file['file']['name'].'"';
				}
			}elseif($data['current_file']){
				$path_parts=pathinfo($data['current_file']);
				$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
				$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/sites/'.tools::int($data['siteid']).'/files/';
				if(copy($_SERVER['DOCUMENT_ROOT'].$data['current_file'],$targetPath.$newfilename)){
					$filecol=',file_name,file_oldname';
					$fileval=', "'.$newfilename.'","'.$data['file_oldname'].'"';
				}
			}
			if(tools::int($data['oldstatus'])<=1){
				$db->exec('UPDATE z_recard_site set status='.tools::int(tools::int($data['status'])).' WHERE id='.tools::int($data['id']).'');
			}	
			$db->exec('INSERT INTO z_card (name,date_start,date_end,detail_text,requestid,siteid'.$filecol.')
			VALUES (
			"'.tools::str($data['name']).'", 
			"'.tools::getSqlDate($data['date_start'][2],$data['date_start'][1],$data['date_start'][0]).'",
			"'.tools::getSqlDate($data['date_end'][2],$data['date_end'][1],$data['date_end'][0]).'",
			"'.tools::str($data['detail_text']).'",
			'.tools::int($data['id']).',
			'.tools::int($data['siteid']).'
			'.$fileval.'
			)');	
		}else{
			if ($file['file']['tmp_name']) {
				if($data['current_file']){
					tools::delImg($data['current_file']);
				}
			$tempFile = $file['file']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/sites/'.tools::int($data['siteid']).'/files/';
			$path_parts=pathinfo($file['file']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$newfilenameS=$newfilename;
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
				if(move_uploaded_file($tempFile,$targetFile)){
					$updSql='
					,file_name="'.$newfilename.'",
					file_oldname="'.$file['file']['name'].'"';
				}
			}
				
			
			if(tools::int($data['yocardid'])>0){
			$data['yocardid']=tools::int($data['yocardid']);
			$data['date_update']=', date_update=NOW()';
			}
			else
			$data['yocardid']='NULL';
			if(tools::int($data['price'])>0)
			$data['price']=tools::int($data['price']);
			else
			$data['price']='NULL';
			
			if(tools::int($data['oldstatus'])<=1){
				$db->exec('UPDATE z_recard_site set status='.tools::int(tools::int($data['status'])).' WHERE id='.tools::int($data['id']).'');
			}
			$db->exec('UPDATE z_card
			SET
			name="'.tools::str($data['name']).'", 
			date_start="'.tools::getSqlDate($data['date_start'][2],$data['date_start'][1],$data['date_start'][0]).'",
			date_end="'.tools::getSqlDate($data['date_end'][2],$data['date_end'][1],$data['date_end'][0]).'",
			detail_text="'.tools::str($data['detail_text']).'",
			yocardid='.$data['yocardid'].',
			price='.$data['price'].'
			'.$updSql.'
			'.$data['date_update'].'
			WHERE id='.tools::int($data['cardid']).' AND siteid='.tools::int($data['siteid']).'');
		}
	}
	public function getRecardList(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
						z_brand_recard.id,
						z_brand_recard.name,
						z_brand_recard.brandid,
						z_brand.name AS brandname,
						z_user.email,
						z_user.phone
					FROM
						z_brand_recard
						INNER JOIN z_brand
						ON z_brand.id=z_brand_recard.brandid
						INNER JOIN z_brand_user
						ON z_brand_user.brandid=z_brand.id
						INNER JOIN z_user
						ON z_user.id=z_brand_user.userid
					');
		if($result)
		return $result;	
	}
	public function getRecardInner($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
						z_brand_recard.id,
						z_brand_recard.name,
						z_brand_recard.date_start,
						DATE_FORMAT(z_brand_recard.date_start,"%d.%m.%Y") AS date_start,
						DATE_FORMAT(z_brand_recard.date_end,"%d.%m.%Y") AS date_end,
						z_brand_recard.detail_text,
						z_brand_recard.brandid,
						z_brand.name AS brand,
						z_brand_recard.file_name,
						if(CHAR_LENGTH(z_brand_recard.file_name)>3,concat("/uploads/brands/",z_brand_recard.brandid,"/",z_brand_recard.file_name), null) as url
					FROM
						z_brand_recard
						INNER JOIN z_brand
						ON z_brand.id=z_brand_recard.brandid
					WHERE z_brand_recard.id='.tools::int($id).'
					');
		if($result)
		return $result;
	}
	public function updateRecardInner($data,$files){
		if($data['id']>0){
			
			$Sql=', file_name=NULL';
			$Sql.=', file_oldname=NULL';
				
			if($files['file']['tmp_name']){
				if($data['current_file']){
					tools::delImg($data['current_file']);
				}
				$tempFile = $files['file']['tmp_name'];
				$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/brands/'.$data['brandid'].'/';
				$path_parts=pathinfo($files['file']['name']);
				$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
				$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
				if(move_uploaded_file($tempFile,$targetFile)){
					$Sql=', file_name="'.$newfilename.'"';
					$Sql.=', file_oldname="'.$files['file']['name'].'"';
				}
			}	

				
			$data['date_start']=explode('.', $data['date_start']);
			$data['date_end']=explode('.', $data['date_end']);
			if(tools::int($data['yocardid'])<1)
			$data['yocardid']="null";
			$db=db::init();
			$db->exec('UPDATE z_brand_recard SET 
			name="'.tools::str($data['name']).'", 
			date_start="'.tools::getSqlDate($data['date_start'][2],$data['date_start'][1],$data['date_start'][0]).'",
			date_end="'.tools::getSqlDate($data['date_end'][2],$data['date_end'][1],$data['date_end'][0]).'",
			detail_text="'.tools::str($data['detail_text']).'"
			'.$Sql.'
			WHERE z_brand_recard.id='.tools::int($data['id']).'');
		}
	}
	function updateCardList($data){
		if(count($data['send']>0)){
			$db=db::init();
			$db->exec('UPDATE z_recard_site set status=2 where id in ('.implode(',',$data['send']).') and status=1');
		}
		
	}
}
?>