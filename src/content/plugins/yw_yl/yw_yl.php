<?php
/*
Plugin Name: 网易云在线音乐播放器
Version: 1.0
Plugin URL: http://kmiwz.com
Description:给博客加入网易云在线音乐播放器！
ForEmlog:5.3.x
Author: 王少凯
Author URL: http://kmiwz.com
*/

!defined('EMLOG_ROOT') && exit('access deined!');
function yw_yl(){require_once 'yw_yl_config.php';if($config["id"]){if($config["off"] == 'yes'){?>
<script type="text/javascript" src="<?php echo BLOG_URL;?>content/plugins/yw_yl/js/jquery-1.9.1.min.js"></script><?php }?>
<link rel="stylesheet" href="<?php echo BLOG_URL;?>content/plugins/yw_yl/css/player.css"/>
<script type="text/javascript" src="<?php echo BLOG_URL;?>content/plugins/yw_yl/js/player.js"></script>
<script>$(function(){$(".sl_conct").hover(function(){$(".sl_conct").css("right", "5px");},function(){$(".sl_conct").css("right", "-127px");});});</script>
<div class="sl_conct">
<ul>
<?php if($config["id"]){?>
<div class="m_player" id="divplayer" role="application" onselectstart="return false" style="left: 0px;">
<iframe frameborder="no" border="0" marginwidth="0" marginheight="0" width=540 height=220 src="http://music.163.com/outchain/player?type=0&id=<?php echo $config["id"];?>&auto=1&height=430"></iframe>
<button type="button" class="folded_bt" title="点击收起" id="btnfold"></button>
<div class="play_list_frame" id="divplayframe" style="display: none ;filter:alpha(opacity=0);opacity:0;"></div>
</div>
<?php }?>
</ul>
</div>
<?php }}?>


<?php 
function yw_yl_menu(){
	echo '<div class="sidebarsubmenu"><a href="./plugin.php?plugin=yw_yl">网易云音乐管理</a></div>';
}?>

<?php 
addAction('index_yw_yl','yw_yl');
addAction('adm_sidebar_ext', 'yw_yl_menu');
?>
