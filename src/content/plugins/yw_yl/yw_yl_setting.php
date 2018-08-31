<?php
!defined('EMLOG_ROOT') && exit('出错了！！！!');

function plugin_setting_view(){
require_once 'yw_yl_config.php';
?>
<div class="yw_yl">
<span style=" font-size:18px; font-weight:bold;">网易云在线音乐播放器</span><?php if(isset($_GET['setting'])){echo "<span class='actived'>设置保存成功!</span>";}?><br />
<br />
<style type="text/css">
<!--
.iteam{font-size:18px;font-weight:bold;color:#666666;border-bottom: #CCCCCC 1px solid;padding:10px;}
-->
</style>
<form action="plugin.php?plugin=yw_yl&action=setting" method="post">
<ul>
<p class="iteam">是否加载jQuery</p>
<li><p>如果模板或其他插件已经加载过jQuery，必须选择不加载，否则出错</p>
<input type="radio" name="off" value="yes"<?php if($config["off"] == 'yes'){echo ' checked="checked"';}?> /><label>加载</label>
<input type="radio" name="off" value="no"<?php if($config["off"]=='no'){echo ' checked="checked"';}?> /><label>不加载</label>
</li>
<p class="iteam">网易云在线音乐id</p>
<li><p>模板必须含有挂载点(请自行加上)：&lt;?php doAction('index_yw_yl');?&gt;</p>
<input type="text" class="txt" name="id" value="<?php echo $config["id"];?>" size="33"/>
</li>
</ul>
<input type="submit" class="button" name="submit" value="保存设置" />
</form></div>
<?php }?>
<?php 
function plugin_setting(){
	require_once 'yw_yl_config.php';
	$id = $_POST["id"]==""?"":$_POST["id"];
	$off = $_POST["off"]==""?"no":$_POST["off"];
	$newConfig = '<?php
$config = array(
	"id" => "'.$id.'",
	"off" => "'.$off.'",
);';
	echo $newConfig;
	@file_put_contents(EMLOG_ROOT.'/content/plugins/yw_yl/yw_yl_config.php', $newConfig);
}
?>