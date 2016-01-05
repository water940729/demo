<?php
	class FileUpload{
		private $path="./uploads";						//上传文件保存路径
		private $allowtype=array("jpg","gif","png");	//设置限制上传文件的类型
		private $maxsize=1000000;						//限制文件上传大小（字节）
		private $israndname=true;						//设置是否随机重命名文件，false不随机
		
		private $originName;							//源文件名
		private $tmpFileName;							//临时文件名
		private $fileType;								//文件类型
		private $fileSize;								//文件大小
		private $newFileName;							//新文件名
		private $errorNum=0;							//错误号
		private $errorMess="";							//错误报告信息
		
		/**
		*用于设置成员属性($path,$allowtype,$maxsize,$israndname)
		*可以通过连贯操作一次设置多个属性值
		*@param string $key 成员属性名(不区分大小写)
		*@param mixed $val 为成员属性设置的值
		*@return object	返回自己对象$this，可以用于连贯操作
		*
		*/
		public function set($key,$value){
			$key=strtolower($key);
			if(array_key_exists($key,get_class_vars(get_class($this)))){
				$this->setOption($key,$val);
			}
			return $this;
		}
		/**
		*调用该方法上传文件
		*@param string $fileField 上传文件的表单名称
		*@return bool 如果上传成功返回true
		*
		*/
		public function upload($fileField){
			$return=true;
			if(!$this->checkFilePath()){
				$this->errorMess=$this->getError();
				return false;
			}
			$i=0;
			foreach($_FILES[$fileField]["name"] as $filename){
				//判断file是否已选择文件
				if(!empty($filename)){
					$index[]=$i;//保存上传文件的索引
					$name[$i]=$filename;
				}
				$i++;
			}
			//$name=$_FILES[$fileField]["name"];
			$tmp_name=$_FILES[$fileField]["tmp_name"];
			$size=$_FILES[$fileField]["size"];
			$error=$_FILES[$fileField]["error"];
			if(is_Array($name)){
				//多个文件上传
				$errors=array();
				for($i=0;$i<count($index);$i++){
					//检查上传的文件，将所有的文件都进行检查
					$j=$index[$i];//获取文件的索引
					if($this->setFiles($name[$j],$tmp_name[$j],$size[$j],$error[$j])){
						if(!$this->checkFileSize()||!$this->checkFileType()){
							$errors[$j]=$this->getError();
							$return=false;
						}
					}else{
						$errors[$j]=$this->getError();
						$return=false;
					}
				}
				if($return){
					$fileNames=array();
					for($i=0;$i<count($index);$i++){
						$j=$index[$i];
						//如果上传的多个文件都是合法的，则通过循环向服务器上传文件
						if($this->setFiles($name[$j],$tmp_name[$j],$size[$j],$error[$j])){
							$this->setNewFileName();
							//可能会出现一些文件上传成功，有些文件上传失败，如果错误发生在copyFile
							if(!$this->copyFile()){
								$errors[$j]=$this->getError();
								$return=false;
							}
							$fileNames[$j]=$this->newFileName;
						}
					}
					$this->newFileName=$fileNames;
				}
				$this->errorMess=$errors;
				return $return;
			}else{
				//单个文件上传
				if($this->setFiles($name,$tmp_name,$size,$error)){
					if($this->checkFileSize()&&$this->checkFileType()){
						$this->setNewFileName();
						if($this->copyFile()){
							return true;
						}else{
							$return=false;
						}
					}else{
						$return=false;
					}
				}else{
					$return=false;
				}
				if(!$return){
					$this->errorMess=$this->getError();
				}
				return $return;
			}
		}
		/**
		*获取上传后的文件名称
		*@param void 没有参数
		*@return string 上传后，新文件的名称，如果是多文件上传返回数组
		*/
		public function getFileName(){
			return $this->newFileName;
		}
		
		/**
		*上传失败后，调用该方法则返回上传出错信息
		*@param void 没有参数
		*@return string 返回上传文件出错的信息报告，如果是多文件上传返回数组
		*/
		public function getErrorMsg(){
			return $this->errorMess;
		}
		/*设置上传出错信息*/
		private function getError(){
			$str="上传文件<font color='red'>{$this->originName}</font>时出错:";
			switch($this->errorNum){
				case 4:$str.="没有文件被上传";break;
				case 3:$str.="文件只有部分被上传";break;
				case 2:$str.="上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值";break;
				case 1:$str.="上传的文件超过了php.ini中upload_max_filesize选项限制的值";break;
				case -1:$str.="未允许类型";break;
				case -2:$str.="文件过大，不能超过{$this->maxsize}个字节";break;
				case -3:$str.="上传失败";break;
				case -4:$str.="建立存放上传文件目录失败,请重新指定上传目录";break;
				case -5:$str.="必须指定上传文件的路径";break;
				default:$str.="未知错误";
			}
			return $str."<br/>";
		}
		
		/*设置和$_FILES有关的内容*/
		private function setFiles($name="",$tmp_name="",$size=0,$error=0){
			$this->setOption("errorNum",$error);
			if($error){
				return false;
			}
			$this->setOption("originName",$name);
			$this->setOption("tmpFileName",$tmp_name);
			$aryStr=explode(".",$name);
			$this->setOption("fileType",strtolower($aryStr[count($aryStr)-1]));
			$this->setOption("fileSize",$size);
			return true;
		}
		
		/*为单个成员属性设置值*/
		private function setOption($key,$val){
			$this->$key=$val;
		}
		/*设置上传后的文件名称*/
		private function setNewFileName(){
			if($this->israndname){
				$this->setOption("newFileName",$this->proRandName());
			}else{
				$this->setOption("newFileName",$this->originName);
			}
		}
		/*检查上传的文件是否是合法的类型*/
		private function checkFileType(){
			if(in_array(strtolower($this->fileType),$this->allowtype)){
				return true;
			}else{
				$this->setOption("errorNum",-1);
				return false;
			}
		}
		/*检查上传的文件是否是允许的大小*/
		private function checkFileSize(){
			if($this->fileSize>$this->maxsize){
				$this->setOption("errorNum",-2);
				return false;
			}else{
				return true;
			}
		}
		/*检查是否有存放上传文件的目录*/
		private function checkFilePath(){
			if(empty($this->path)){
				$this->setOption("errorNum",-5);
				return false;
			}
			if(!file_exists($this->path)||!is_writable($this->path)){
				if(!@mkdir($this->path,0755)){
					$this->setOption("errorNum",-4);
					return false;
				}
			}
			return true;
		}
		/*设置随机文件名*/
		private function proRandName(){
			$fileName=date("YmdHis")."_".rand(100,999);
			return $fileName.".".$this->fileType;
		}
		/*复制上传文件到指定位置*/
		private function copyFile(){
			if(!$this->errorNum){
				$path=rtrim($this->path,"/")."/";
				$path.=$this->newFileName;
				if(@move_uploaded_file($this->tmpFileName,$path)){
					return true;
				}else{
					$this->setOption("errorNum",-3);
					return false;
				}
			}else{
				return false;
			}
		}
	}