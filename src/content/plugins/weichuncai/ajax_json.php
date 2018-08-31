<?php
//获得春菜的详细数据与js交互
function chuncai_read() {
	$file = 'data';
	$data = unserialize(file_get_contents($file));
	return $data;
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
$data = chuncai_read();
	global $data;
		if( preg_match('/userdefccs_/i', $data['defaultccs']) )
			$key = str_replace( 'userdefccs_', '', $data['defaultccs']);
		else
			$key = $data['defaultccs'];		
		$lifetime = get_lifetime($data['lifetime'][$key]);
		$data['showlifetime'] = '我已经与主人 '.$data["adminname"].' 一起生存了 <font color="red">'.$lifetime["day"].'</font> 天 <font color="red">'.$lifetime["hours"].'</font> 小时 <font color="red">'.$lifetime["minutes"].'</font> 分钟 <font color="red">'.$lifetime["seconds"].'</font> 秒的快乐时光啦～*^_^*';
		$data['notice'] = stripslashes($data['notice']);
		$data = json_encode($data);
		echo $data;
?>