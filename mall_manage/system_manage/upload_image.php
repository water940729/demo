<?php
	ob_start();
	set_time_limit(0);//时间限制解除	
	require_once '../inc_function.php';
	require_once '../../conn/config.php';
	
	$home_path = HOME_PATH;
	$url="/waimai/android/download/";//app上传路径
	$type = sqlReplace(trim($_GET['type']));
	$info = '';
	$fileElementName = 'file';
	//检查上传文件是否有问题
	if(!empty($_FILES[$fileElementName]['error'])){
		switch($_FILES[$fileElementName]['error']){
		case '1':
			$info = 'E|Upload file size is more than the system limit';
			break;
		case '3':
			$info = 'E|Upload process error';
			break;
		case '4':
			$info = 'E|No file has been chosen';
			break;
		case '6':
			$info = 'E|System error:temp directory not found';
			break;
		case '7':
			$info = 'E|System error:Error occurs while writing file';
			break;
		default:
			$info = 'E|Unkown error';
		}
	}elseif(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none'){
		$info = 'E|No file has been chosen';
	}else{
		$f_name=$_FILES[$fileElementName]['name'];
		$f_size=$_FILES[$fileElementName]['size'];
		$f_tmpName=$_FILES[$fileElementName]['tmp_name'];

		$f_ext=strtolower(preg_replace('/.*\.(.*[^\.].*)*/iU','\\1',$f_name));
		
		$f_extAllowList="mp3|f4v|flv";

		$f_exts=explode("|",$f_extAllowList);
		$checkExt=true;
		foreach ($f_exts as $v){
			if ($f_ext==$v){
				$checkExt=false;
				break;
			}
		}
		if ($type == "image")
		{
		$checkExt = false;
		}
		if($checkExt){
			$info = 'E|File format is wrong,format must be MP3';
		}else{
			if($f_size>800*1024*1024){
				$info = 'E|File size cannot more than 800M';					
			}else{
				$random= rand(100,999); 
				$pub_name = time().$random;
				$year = date('Y');
				$month = date('m');
				$directory = "system/logo/".$year.'/'.$month.'/';
				$f_fullname= $directory.'upload_'.$pub_name.".".$f_ext;
				$mode = 0777;
				if(!is_dir($home_path.URL.$directory)){
					mkdir($home_path.URL.$directory,$mode,true);
				}
				$f_path=$home_path.URL.$f_fullname;
				$sys_fullpath = SYSTEM_IP.URL.$f_fullname;
				
				if(copy($f_tmpName,$f_path))
				{
					$info = "S|".$sys_fullpath;
									
				}else{
					$info = 'E|Destination directory not found or permission denied'.$f_path;
				}
			}
		}
		@unlink($_FILES[$fileElementName]);
	}
	echo $info;

	//echo("E|文件保存的目标文件夹不存在或无写权限。");
?>
