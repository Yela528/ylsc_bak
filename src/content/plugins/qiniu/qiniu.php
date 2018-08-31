<?php
/*
Plugin Name: 七牛镜像储存
Version: 1.0
Plugin URL: http://cuelog.com/?p=202
Description: 七牛镜像储存，让你体验闪电般的速度 <a href="?plugin=qiniu">点击设置</a> &nbsp;&nbsp;
ForEmlog:5.1.2
Author: cuelog
Author URL: http://cuelog.com
*/
! defined ( 'EMLOG_ROOT' ) && exit ( 'access deined!' );
if(file_exists(dirname(__FILE__).'/qiniu_config.php')){
	include ('qiniu_config.php');
}

ob_start ();


function qiniu_init() {
	global $config;
	$html = ob_get_contents ();
	$home_url = $_SERVER ['HTTP_HOST'];
	ob_end_clean();
	$urls = array ();
	$config['cdn_host'] = isset($config['cdn_host']) ? $config['cdn_host'] : $home_url;
	// preg_match_all("/<[img|link|script|a].*[src|href]=[\"\'](http:\/\/({$home_url})\/[^>\'\"]*\.(?:jpg|jpeg|gif|png|ico|css|js))/U", $html, $urls);
	echo preg_replace ( "/(<[img|link|script|a].*[src|href]=[\"\'])(http:\/\/)({$home_url})(\/[^>\'\"]*\.(?:jpg|jpeg|gif|png|ico|css|js))/U", "\${1}\${2}{$config['cdn_host']}\${4}", $html );
}
addAction ( 'index_footer', 'qiniu_init' );