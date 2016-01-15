<?php
return array (
      'DB_TYPE' => 'mysql',
      'DB_HOST' => '127.0.0.1',
      'DB_PORT' => '3306',
      'DB_NAME' => 'cleanMine',
      'DB_USER' => 'root',
      'DB_PWD' => 'root',
      'DB_PREFIX' => '',
      'agent_version' => 1,

      'SHOW_PAGE_TRACE' => true,

      'TMPL_PARSE_STRING'  =>array(
     '__PUBLIC__' =>__ROOT__.'/Public', //公共资源目录
     '__JS__'     => __ROOT__.'/Public/js', // js目录
     '__CSS__'     => __ROOT__.'/Public/css', //css目录
     '__IMG__'     => __ROOT__.'/Public/img', //css目录
     ),
);



