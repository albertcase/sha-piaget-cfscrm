<?php
define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Redis;
use Lib\Helper;

$initData = new initData();
$initData->init();
echo 'init data success';
exit;

class initData
{
	private $helper;

	public function __construct()
	{
        $this->helper = new Helper();
	}

	public function init()
	{
		for($i=1; $i<=100; $i++) {
            $info = new \stdClass();
            $info->name = "张三{$i}";
            $info->age = 18 + $i;
            $info->address = "地址{$i}";
            $info->created = date('Y-m-d H:i:s');
            $uid = $this->helper->insertTable('data', (array)$info);
            $payinfo = new \stdClass();
            $payinfo->uid = $uid;
            $payinfo->payment = $i.'元';
            $this->helper->insertTable('pays', (array)$payinfo);
            unset($info, $payinfo);
        }
	}
}
?>