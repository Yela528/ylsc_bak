<?php 
/*
Plugin Name: 伪春菜(移植自WP)
Version: 0.1
Plugin URL:http://mysteryfuko.com/emlog/weichuncai.html
Description: 为了emlog的萌化，移植伪春菜插件一枚!原插件地址:http://www.lmyoaoa.com/inn/archives/3134/
Author: MysteryFuko
Author Email: admin@mysteryfuko.com
Author URL: http://mysteryfuko.com
Author QQ:43431200
 */
if(function_exists('emLoadJQuery')) {
	emLoadJQuery();
}
//获得春菜
function get_chuncai(){
	$data = chuncai_read();
	
	echo '<link rel="stylesheet" type="text/css" href="'.BLOG_URL.'/content/plugins/weichuncai/css/style.css">';
	if( preg_match('/userdefccs_/i', $data['defaultccs']) ) {
		$key = str_replace( 'userdefccs_', '', $data['defaultccs']);
		$fpath = $data['userdefccs'][$key]['face'];
		$fpath1 = $fpath[0];
		$fpath2 = $fpath[1] ? $fpath[1] : $fpath1;
		$fpath3 = $fpath[2] ? $fpath[2] : $fpath1;
	}else {
		$path = 'content/plugins/weichuncai/skin/'.$data[defaultccs].'/';
		$fpath1 = BLOG_URL.'content/plugins/weichuncai/skin/'.$data[defaultccs].'/face1.gif';
		$fpath2 = BLOG_URL.'content/plugins/weichuncai/skin/'.$data['defaultccs'].'/face2.gif';
		$fpath3 = BLOG_URL.'content/plugins/weichuncai/skin/'.$data['defaultccs'].'/face3.gif';
		$fpath2 = file_exists($path.'face2.gif') ? $fpath2 : $fpath1;
		$fpath3 = file_exists($path.'face3.gif') ? $fpath3 : $fpath1;
	}

	$size = getimagesize($fpath1);
	$notice_str = '&nbsp;&nbsp;'.$data['notice'].'<br />';
	echo '<script>var path = "'.BLOG_URL.'";';
	echo "var imagewidth = '{$size[0]}';";
	echo "var imageheight = '{$size[1]}';";	
	echo '</script>';
	echo '<script src="'.BLOG_URL.'/content/plugins/weichuncai/js/common.js"></script>';
	echo '<script>createFace("'.$fpath1.'", "'.$fpath2.'", "'.$fpath3.'");</script>';
	echo '<script>';
	//自定义自言自语
	if(!empty($data['says']) && is_array($data['says']) ) {
		$talkself_user_str = 'var talkself_user = [ ';
		$dot = '';
		foreach($data['says'] as $k=>$v) {
			$tmpf = $data['face'][$k] ? $data['face'][$k] : 1;
			$talkself_user_str .= $dot.'["'.$v.'", "'.$tmpf.'"]';
			$dot = ',';
		}
		$talkself_user_str .= ' ];';
	}
	echo $talkself_user_str;
	echo 'var talkself_arr = talkself_arr.concat(talkself_user);';
	echo '</script>';
}

addAction('index_footer', 'get_chuncai');
 
function chuncai_read() {
	$file = EMLOG_ROOT.'/content/plugins/weichuncai/data';
	$data = unserialize(file_get_contents($file));
	return $data;
}

function get_pic_path($name){
	$fpath1 = dirname(__FILE__).'/skin/'.$name.'/face1.gif';
	$fpath2 = dirname(__FILE__).'/skin/'.$name.'/face2.gif';
	$fpath3 = dirname(__FILE__).'/skin/'.$name.'/face3.gif';
	return array($fpath1, $fpath2, $fpath3);
}

function get_lifetime($starttime){
	$endtime = time();
	$lifetime = $endtime-$starttime;
	$day = intval($lifetime / 86400);
	$lifetime = $lifetime % 86400;
	$hours = intval($lifetime / 3600);
	$lifetime = $lifetime % 3600;
	$minutes = intval($lifetime / 60);
	$lifetime = $lifetime % 60;
	return array('day'=>$day, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$lifetime);
}
function weichuncai_save($data)
{
	$Ndata=serialize($data);
	$file = EMLOG_ROOT.'/content/plugins/weichuncai/data';
	@ $fp = fopen($file, 'wb+') OR emMsg('读取文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/weichuncai/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	@ $fw =	fwrite($fp,$Ndata) OR emMsg('写入文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/weichuncai/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	fclose($fp);
}
function weichuncai_menu()
{
	echo '<div class="sidebarsubmenu" id="weichuncai"><a href="./plugin.php?plugin=weichuncai">伪春菜设置</a></div>';
}
addAction('adm_sidebar_ext', 'weichuncai_menu');