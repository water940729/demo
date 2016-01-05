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
			$info = 'E|上传的文件大小超过了系统限制。';
			break;
		case '3':
			$info = 'E|上传文件过程出错。';
			break;
		case '4':
			$info = 'E|没有选择文件。';
			break;
		case '6':
			$info = 'E|系统错误：不存在临时文件夹。';
			break;
		case '7':
			$info = 'E|系统错误：写入文件出错。';
			break;
		default:
			$info = 'E|未知错误。';
		}
	}elseif(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none'){
		$info = 'E|没有选择文件。';
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
			$info = 'E|文件格式不正确，格式必须为MP3。';
		}else{
			if($f_size>800*1024*1024){
				$info = 'E|文件大小不能超过800M。';					
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
					$info = 'E|文件保存的目标文件夹不存在或无写权限。'.$f_path;
				}
			}
		}
		@unlink($_FILES[$fileElementName]);
	}
	echo $info;

	//echo("E|文件保存的目标文件夹不存在或无写权限。");
?>
