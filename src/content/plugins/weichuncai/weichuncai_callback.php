<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once(EMLOG_ROOT.'/content/plugins/weichuncai/weichuncai.php');
function callback_init()//初始化春菜时间
{
	$data = chuncai_read();
	$data['lifetime']['rakutori'] = time();
	$data['lifetime']['neko'] = time();
	$data['lifetime']['chinese_moe'] = time();
	weichuncai_save($data);
}