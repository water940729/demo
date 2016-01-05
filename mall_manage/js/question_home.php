<?php
/*
作者：雷秀英
日期：2014-10-16
 */
include_once("../conn/conn.php");
include_once("../header.php");
include_once("../menu.php");
?>
<div class="mid-content">
	<div class="follow-title clearfix">
		<ul>
			<li class="active"><a href="#"></a></li>
			<li><a href="#"></a></li>
			<li><a href="#"></a></li>
			<li><a href="#"></a></li>
		</ul>
	</div>
	<div class="follow-list clearfix">
		<ul>
			<?php			
				$pagesize=5;
				$select="select count(*) as page_count from question";
				$rest=mysql_query($select);
				$rs=mysql_fetch_array($rest);
				$count=$rs['page_count'];
				if($count%$pagesize){
				$pagecount = intval($count/$pagesize)+1;
				}else{
					$pagecount = intval($count/$pagesize);
				}
				if(isset($_GET['page'])){
					$page=intval($_GET['page']);
				}else{
					$page=1;
				}
				$pagestart = ($page-1)*$pagesize;
				$query="select * from question  order by create_time desc limit ".$pagestart.",".$pagesize;
				$res=mysql_query($query);
				while($row=mysql_fetch_array($res)){
					 
					 $question_id = $row["question_id"];
					 $community_user_id = $row["community_user_id"];
					 $question_title = $row["question_title"];
					 $question_content = $row["question_content"];
					 $question_type =  $row["question_type"];
					 $create_time = date("Y-m-d,H:i:s",$row["create_time"]);
					 $comment_num=  $row["comment_num"];
					 $type = $row['type'];
					 $sql = "select * from community_user where community_user_id =".$community_user_id;
					 $res1 = mysql_query($sql);
					 $row1 = mysql_fetch_array($res1);
			?>
			<li class="item">
				<header class="clearfix">
					<a href="javascript:window.open('../other_message/home_page.php?community_user_id=<?php echo $community_user_id ?>')"><img class="avatar" src="<?php echo $row1['head_img_url']  ?>" alt="Username">
					<div>
						<span class="name"><a href="javascript:window.open('../other_message/home_page.php?community_user_id=<?php echo $community_user_id ?>')"><?php echo $row1['community_account'] ?></a></span>
						<span class="action"><?php if($type==1) echo 'Issued';else echo "Transfered";?>a question</span>
					</div>
					<div class="time"><?php echo $create_time?></div>
				</header>
				<section>
					<p class="title"><?php echo $question_title ?></p>
					<p><?php echo $question_content?></p>
				</section>
				<footer>
					<a href='../paper_manage/mypaper_content.php?paper_id=<?php echo $content_id?>&community_user_id = <?php echo $passive_user_id?>' class="search"> Details<i class="icon-search"></i></a>
					<ul class="tools">
						<li>
							<span id = "s_<?php echo $content_id?>" onclick = "comment_opnion(<?php echo $content_id?>)">Praise(<span id="s_num_<?php echo $content_id?>"><?php echo $support_num?></span>)</span><i id="z_<?php echo $content_id?>" class="icon-up"></i>
						</li>
						<li>
							<span>Issue(<?php echo $comment_num?>)</span><i class="icon-comment"></i>
						</li>
						<li>
							<span id="store" onclick="store(<?php echo $community_user_id;?>,<?php echo $content_id; ?>,<?php echo $passive_user_id;?>,2)">Store(<span id="num_store_<?php echo $content_id?>"><?php echo $store_num;?></span>)</span><i class="icon-favourite"></i>
						</li>
						<li>
							<span id = "reprint_<?php echo $content_id?>" onclick = "reprint_paper(<?php echo $content_id;?>)">Transfer(<span id="reprint_num_<?php echo $content_id?>"><?php echo $reprint_num?></span>)</span><i class="icon-send"></i>
						</li>
						<li>
							<span>Shared</span><i class="icon-share"></i>
						</li>
					</ul>
				</footer>
			</li>
		</ul>
	</div>
</div>