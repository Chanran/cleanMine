<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>排行榜</title>
	<style type="text/css" >
	.span{
		margin-left:160px;
		width:100px;
		height:10px;
		display: inline-block;
	}
	</style>	
</head>
<body>
	<div style="border:1px solid black;border-radius:5px;padding:0px 40px;">
		<h1 style="text-align:center">排行榜</h1>
		<div style="border:1px solid black;border-radius:5px;padding:20px 20px;">
			<span class="span" >昵称</span><span class="span" >完成时间</span><span class="span" >地雷总数</span><span class="span" >记录创建时间</span><hr>
			<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="span"><?php echo ($vo["name"]); ?></span><span class="span"><?php echo ($vo["cost_time"]); ?></span><span class="span"><?php echo ($vo["mine_num"]); ?></span><span class="span" style="width:100px"><?php echo ($vo["create_time"]); ?></span><hr><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div>
</body>
</html>