<?php 
!defined('EMLOG_ROOT') && exit('access deined!');

if(file_exists(dirname(__FILE__).'/qiniu_config.php')){
	include ('qiniu_config.php');
}

function plugin_setting_view(){

?>
<div class="com-hd">
	<?php
	if( isset($_GET['setting']) ){
		echo "<span class='actived'>设置保存成功!</span>";
	}
	?>
</div>
<form action="plugin.php?plugin=qiniu&action=setting" method="post">
	<table class="tb-set">
		<tr>
			<td align="right" width="25%"><b>七牛的CDN域名：</b></td>
			<td width="75%"><input type="text" name="cdn_host" size="50" value="<?php echo isset($config['cdn_host']) ? $config['cdn_host'] : null;?>"  /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" value="保存" /></td>
		</tr>
	</table>
</form>
<?php 
}

function plugin_setting() {
	$cdn_host = trim($_POST['cdn_host'], '/ ');
	$cdn_host = str_replace('http://', '', $cdn_host);
	$newConfig = '<?php
	$config = array(
		"cdn_host" => "'.$cdn_host.'" //七牛提供的二级域名或你绑定在七牛的域名
	);';
	if(! file_put_contents ( EMLOG_ROOT . '/content/plugins/qiniu/qiniu_config.php', $newConfig )){
		die('生成配置文件失败，请检查目录是否有相应权限');
	};
}
?>