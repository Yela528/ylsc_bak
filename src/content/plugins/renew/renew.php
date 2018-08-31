<?php
/*
Plugin Name: 更新缓存
Version: 1.0
Plugin URL: http://cz1.me/post/83
Description: 如果导入了数据，页面内容没有更新，就用一下我。
Author: chuang_no1
Author URL: http://cz1.me/
*/
!defined('EMLOG_ROOT') && exit('access deined!');

//写入插件导航
function renew_link() {
    echo '<div class="sidebarsubmenu" id="themeseditor"><a href="./plugin.php?plugin=renew">更新缓存</a></div>';
}
addAction('adm_sidebar_ext', 'renew_link');
?>