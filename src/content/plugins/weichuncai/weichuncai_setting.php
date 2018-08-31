<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
function plugin_setting_view()
{
	$data = chuncai_read();
#删除自言自语
if($_POST['del_tku_sub']) {
	if(!$_POST['del_tku']) {
		echo '<span class="error">请先选择一个要删除的项目</span>';
	}else {
		foreach($data['says'] as $k=>$v) {
			if(in_array($k, $_POST['del_tku'])) {
				unset($data['says'][$k]);
				unset($data['face'][$k]);				
			}
		}
		weichuncai_save($data);
		echo '<span class="actived">删除成功</span>';
	}
}

#新增自言自语
if($_POST['talkself_user_sub']) {
	if( count($data['says']) < 50 ) {
		$data['says'][] = $_POST['talkself_user']['says'];
		$data['face'][] = $_POST['talkself_user']['face'];
		weichuncai_save($data);
		echo '<span class="actived">设置成功</span>';
	}else{
		echo '<span class="error">设置未保存! 你的自言自语设置有点多了哦，删除一些吧.</span>';
	}
}
#春菜模板选择
if($_POST['editchuncai']){
	$data['defaultccs'] = $_POST['defaultccs'];
	weichuncai_save($data);
	echo '<span class="actived">春菜更新成功.</span>';
}

#默认选项设置
if($_POST['subnotice']){
	$data['notice'] = 	$_POST['notice'];
	$data['adminname'] = 	$_POST['adminname'];
	$data['isnotice'] = 	$_POST['isnotice'];
	$data['ques'] =		$_POST['ques'];
	$data['ans'] =		$_POST['ans'];
	weichuncai_save($data);
	echo '<span class="actived">设置已保存.</span>';
}

#删除春菜皮肤
if($_GET['del']){
	$id = $_GET['ccsid'];
	$preg = '/userdefccs_/i';
	if(preg_match($preg, $id) ) {
		$id = str_replace( 'userdefccs_', '', $id );
		unset($data['userdefccs'][$id]);
		unset($data['lifetime'][$id]);
		weichuncai_save($data);
	}else{
		$pic = get_pic_path($data['ccs'][$id]);
		foreach($pic as $k=>$v){
			if(file_exists($v)){@unlink($v);}
		}
		$dir = dirname(__FILE__).'/skin/'.$data['ccs'][$id].'/';
		@rmdir($dir);
		unset($data['lifetime'][$data['ccs'][$id]]);
		unset($data['ccs'][$id]);
		weichuncai_save($data);
		echo '<script>window.location.href="?plugin=weichuncai";</script>';
	}
}
#喂食设置
if($_POST['additional']){
	$data['foods'] = $_POST['foods'];
	$data['eatsay'] = $_POST['eatsay'];
	weichuncai_save($data);
	echo '<span class="actived">喂食设置已保存.</span>';
}

#添加春菜页面
if( $_GET['cp'] == 1 && $_POST['new_userdef_ccs_sub']) {
	$data['userdefccs'][$_POST['userdefccs']] = array('name'=>$_POST['userdefccs'], 
	'face'=>$_POST['face'],
	);
	$data['lifetime'][$_POST['userdefccs']] = time();;
	weichuncai_save($data);
	echo '<span class="actived">添加伪春菜成功.</span>';
}

?>
<style>
.chuncaidiv {
float:left;padding:3px;text-align:center; width:168px;position:relative;
overflow:hidden;
}
.chuncaidiv img {
	height:50px;
}
</style>
<div class=containertitle><b>伪春菜控制面板</b></div>
<p><a href="./plugin.php?plugin=weichuncai">通用设置</a> | <a href="./plugin.php?plugin=weichuncai&cp=1">创建伪春菜</a></p>
<div class=line></div>
<?php if($_GET['cp'] != '1') 
{
?>
<form action="" method="post">
<h5>设置默认春菜</h5>
<?php
foreach($data['ccs'] as $k=>$v)
	if($v == $data['defaultccs'])
	{
	echo '<div style="" class="chuncaidiv"><img src="'.BLOG_URL.'content/plugins/weichuncai/skin/'.$v.'/face1.gif"><p>'.$v.'<input type="radio" name="defaultccs" value="" checked></p></div>';
	}else{
	echo '<div class="chuncaidiv" style=""><img src="'.BLOG_URL.'content/plugins/weichuncai/skin/'.$v.'/face1.gif"><p><input type="radio" name="defaultccs" value="'.$v.'"> '.$v.'(<a href="?plugin=weichuncai&del=del&ccsid='.$k.'">删除?</a>)</p></div>';
	}
	
if( !empty($data['userdefccs']) ) {
		foreach( $data['userdefccs'] as $k=>$v ) {
			if( 'userdefccs_'.$k == $data['defaultccs'] ) {
				echo '<div class="chuncaidiv"><img src="'.$v['face'][0].'"><p><input type="radio" name="defaultccs" value="userdefccs_'.$k.'" checked="checked"> '.$k.'</p></div>';
			}else{
				echo '<div class="chuncaidiv" style=""><img src="'.$v['face'][0].'"><p><input type="radio" name="defaultccs" value="userdefccs_'.$k.'"> '.$k.'(<a href="?plugin=weichuncai&del=del&ccsid=userdefccs_'.$k.'">删除?</a>)</p></div>';
			}
		}
	}
?>
<p>
<div style="float:left;width:100%;*width:672px;">
<p style="clear:left;" class="submit"><input type="submit" name="editchuncai" value="更新春菜"></p>
</form>

<div class=line></div>
<form action="" method="post">
<h5>设置默认春菜</h5>
	<label>1. 你希望伪春菜如何称呼你呢？</label>
	<p><input type="text" name="adminname" value="<?php echo $data['adminname']?>"></p>
	<label>2. 公告：</label>
	<p><textarea name="notice" cols="40" rows="7"><?php echo $data['notice']?></textarea></p>
	<label>3. 对话回应<p style="color:red">在这里设置了问题与回答后，在前台的聊天功能中输入相关问题伪春菜就会回答，如输入：早上好，伪春菜会回答：“早上好～”,暂时最多只支持5个问答</p></label>
<?php
	$i = 1;
	foreach($data['ques'] as $k=>$v){
		echo '<p>问'.$i.'：<input type="text" name="ques['.$k.']" value="'.$v.'"> 答'.$i.'：<input type="text" name="ans['.$k.']" value="'.$data['ans'][$k].'"></p>';
		$i++;
	}
?>	
<p>
<div style="float:left;width:100%;*width:672px;">
<p style="clear:left;" class="submit"><input type="submit" name="subnotice" value="更新设置"></p>
</form>
<div class=line></div>
<h5>设置默认春菜</h5>
<p>设置伪春菜自言自语时说的话，<font color="red">最多允许自定义50项。</font></p>
<form action="" method="post">
<?php
	if(!empty($data['says']) && is_array($data['says']) ) {
		$tmpk = 1;
		foreach($data['says'] as $k=>$v) {
			echo '<p><input type="checkbox" name="del_tku[]" value="'.$k.'">设定言语'.$tmpk.': '.stripslashes($v).'</p>';
			$tmpk++;
		}
		echo '<input class="button-primary" type="submit" name="del_tku_sub" value="删除选中项" />';
	}
?>
</form>
<form action="" method="post">
<?php
	echo '<p>新增：<input type="text" name="talkself_user[says]" style="width:300px;" value=""> 对应表情：';
	echo '<select type="text" name="talkself_user[face]">';
	echo '<option value="1">表情1</option>';
	echo '<option value="2">表情2</option>';
	echo '<option value="3">表情3</option>';
	echo '</select>';
	echo ' <input  class="button-primary" type="submit" name="talkself_user_sub" value="添加" /></p>';
?>
</form>

<div class=line></div>
<h5>附加设置</h5>
<form action="" method="post">
	<p>零食：</p>
<?php
	$fom = 1;
	for($fo=0; $fo < 5; $fo++){
		echo '零食'.$fom.'：<input type="text" name="foods['.$fo.']" value="'.$data['foods'][$fo].'"> 回答'.$fom.'：<input type="text" name="eatsay['.$fo.']" value="'.$data['eatsay'][$fo].'"></p>';
		++$fom;
	}
?>
<p class="submit"><input class="button-primary" type="submit" name="additional" value="保存附加设置" /></p>
</form>
<hr>
<h4>基本状态</h4>
<?php
	foreach($data['lifetime'] as $key=>$val){
		$lifetime = get_lifetime($val);
		echo '<p>春菜<font color="red">'.$key.'</font> 已经与主人一起生存了 '.$lifetime["day"].'天'.$lifetime["hours"].'小时'.$lifetime["minutes"].'分钟'.$lifetime["seconds"].'秒的快乐时光。</p>';
	}
	
}	
elseif($_GET['cp'] == 1)
	{
	?>
	<form action="" method="post">
	<p>春菜名字：<input type="text" name="userdefccs" value="" /></p>
	<p>提示：复制图片地址到下面文本框。或者你可以到上传图片先进行上传。图片应小于160像素。</p>
	<p><font color="red">*</font>表&nbsp;&nbsp;&nbsp;&nbsp;情1(普通)：<input style="width:350px;" type="text" name="face[]" value="" />
	<p>&nbsp;&nbsp;表&nbsp;&nbsp;&nbsp;&nbsp;情2(开心)：<input style="width:350px;" type="text" name="face[]" value="" />
	<p>&nbsp;&nbsp;表&nbsp;&nbsp;&nbsp;&nbsp;情3(悲伤)：<input style="width:350px;" type="text" name="face[]" value="" />

	<p>注：图片可以只上传第一张，发挥想象创造吧～</p>
	<p><input class="button-primary" type="submit" name="new_userdef_ccs_sub" value="新增春菜" />
	</form>
	<?php
	}
}
?>