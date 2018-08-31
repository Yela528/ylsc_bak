<?php
!defined('EMLOG_ROOT') && exit('access deined!');

//删除缓存文件
function renew_do(){
    $path = EMLOG_ROOT.'/content/cache/';
    $dh = opendir($path);
    while($file = readdir($dh)){
        if($file != "." && $file != ".."){
        $fpath = "$path/$file";
        unlink($fpath);
        }
    }
}

//显示插件配置界面，此处用作更新缓存回显结果
function plugin_setting_view(){
    renew_do();
    echo '已更新缓存。';
}
?>