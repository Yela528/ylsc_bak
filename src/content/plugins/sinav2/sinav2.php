<?php
/*
Plugin Name: 新浪微博插件(OAuth2.0授权认证)
Version: 1.0
Plugin URL:http://www.emlog.net/plugins/plugin-sinav2
Description: 基于新浪微博API(OAuth2.0授权认证)，可以将在emlog内发布的碎语、日志同步到指定的新浪微博账号。
Author:gemingcao@qq.com
Author Email: gemingcao@qq.com
Author URL: http://www.6jiji.com/suiyu/
*/

!defined('EMLOG_ROOT') && exit('access deined!');

require_once 'sinav2_profile.php';
require_once 'sinav2_config.php';
include_once( 'saetv2.ex.class.php' );

if (file_exists(EMLOG_ROOT.'/content/plugins/sinav2/sinav2_token_conf.php') &&
	isset($_GET['do']) && $_GET['do'] == 'chg') {
	if (!unlink(EMLOG_ROOT.'/content/plugins/sinav2/sinav2_token_conf.php')) {
		emMsg('操作失败，请确保插件目录(/content/plugins/sinav2/)可写');
	}
}

if (file_exists(EMLOG_ROOT.'/content/plugins/sinav2/sinav2_token_conf.php')) {
	include_once( 'sinav2_token_conf.php' );
}

function sinav2_postBlog2Sinat($blogid) {

	if (!defined('SINAV2_ACCESS_TOKEN')) {
		return false;
	}
	
    global $title, $ishide, $action;
    
    if('y' == $ishide) {//忽略写日志时自动保存
        return false;
    }
    if('edit' == $action) {//忽略编辑日志
        return false;
    }
    if('autosave' == $action && 'n' == $ishide) {//忽略编辑日志时移步保存
        return false;
    }

    $t = stripcslashes(trim($title)) . ' ' . Url::log($blogid);

    $c = new SaeTClientV2( SINAV2_AKEY , SINAV2_SKEY , SINAV2_ACCESS_TOKEN );
	$c->update($t);
}

if (SINAV2_SYNC == '3' || SINAV2_SYNC == '1') {
    addAction('save_log', 'sinav2_postBlog2Sinat');
}

function sinav2_postTwitter2Sinat($t) {
	if (!defined('SINAV2_ACCESS_TOKEN')) {
		return false;
	}
    $postData = stripcslashes($t);
    if (SINAV2_TFROM == '4') {
        $postData = stripcslashes(subString($t, 0, 300)) . ' - 来自博客：' . BLOG_URL;
    }

	$c = new SaeTClientV2( SINAV2_AKEY , SINAV2_SKEY , SINAV2_ACCESS_TOKEN );
	$c->update($postData);
}

if (SINAV2_SYNC == '2' || SINAV2_SYNC == '1') {
    addAction('post_twitter', 'sinav2_postTwitter2Sinat');
}


function sinav2_menu() {
    echo '<div class="sidebarsubmenu" id="sinav2"><a href="./plugin.php?plugin=sinav2">新浪微博设置</a></div>';
}

addAction('adm_sidebar_ext', 'sinav2_menu');
