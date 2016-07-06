<?php
$config_arr1 = include_once dirname(__FILE__)."/params.php";

$config_arr2 = array(
	//'配置项'=>'配置值'
	'DB_TYPE'		=>	'mysql',
    'DB_HOST'		=>	'localhost',
    'DB_NAME'		=>	'yjdc',
    'DB_USER'		=>	'root',
    'DB_PWD'		=>	'admin',
    'DB_PORT'		=>	'3306',
    'DB_PREFIX'		=>	'dc_',
	//'SHOW_PAGE_TRACE' => true, // 显示页面Trace信息
	'URL_CASE_INSENSITIVE' =>true, //URL大小写不敏感
	'URL_MODEL'             => 2,  //Rewrite模式
	
//	'TOKEN_ON'=>true,  // 是否开启令牌验证
//	'TOKEN_NAME'=>'__hash__',    // 令牌验证的表单隐藏字段名称
//	'TOKEN_TYPE'=>'md5',  //令牌哈希验证规则 默认为MD5
//	'TOKEN_RESET'=>true,  //令牌验证出错后是否重置令牌 默认为true
);


return array_merge($config_arr1, $config_arr2);
?>  