<?php
	class Tags{
		public function getTag($type,$name,$value=""){
			if($type=="text"||$type=='password'){
				echo "<input type='$type' name='$name' id='$name' value='$value' />";
			}else if($type=="textarea"){
				echo "<textarea name='$name' id='$name' >$value</textarea>";
			}else if($type=="radio"){
				
			}else if($type=="checkbox"){
				
			}else if($type=="select"){
				
			}
		}
	}
	$tags=new Tags();
	$tags->getTag("textarea","name","chy");

?>