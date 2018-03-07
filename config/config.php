<?php

define("BASE_URL", 'http://127.0.0.1:9445/');
define("TEMPLATE_ROOT", dirname(__FILE__) . '/../template');
define("VENDOR_ROOT", dirname(__FILE__) . '/../vendor');

//ENV
define("ENV", 'prod');

//User
define("USER_STORAGE", 'COOKIE');

//
define("WECHAT_CAMPAIGN", false);

//Wechat Vendor
define("WECHAT_VENDOR", 'default'); // default | coach | same

//Wechat config info
define("TOKEN", '');
define("APPID", '');
define("APPSECRET", '');
define("NOWTIME", date('Y-m-d H:i:s'));
define("AHEADTIME", '1000');

define("NONCESTR", '?????');
define("COACH_AUTH_URL", '');
define("COACH_TOKEN", '');

define("SAME_OAUTH_URL", '');

//Redis config info
define("REDIS_HOST", '127.0.0.1');
define("REDIS_DBNAME", 1);
define("REDIS_PORT", '6379');

//Database config info
define("DBHOST", '127.0.0.1');
define("DBUSER", 'root');
define("DBPASS", '');
define("DBNAME", 'hk-panerai-qregister');

//Wechat Authorize
define("CALLBACK", 'wechat/callback');
define("SCOPE", 'snsapi_base');

//Wechat Authorize Page
define("AUTHORIZE_URL", '[
	""
]');

define("ENCRYPT_KEY", '29FB77CB8E94B358');
define("ENCRYPT_IV", '6E4CAB2EAAF32E90');

define("WECHAT_TOKEN_PREFIX", 'wechat:token:');
