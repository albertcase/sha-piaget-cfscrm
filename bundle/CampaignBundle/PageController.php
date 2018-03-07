<?php

namespace CampaignBundle;

use Core\Controller;

class PageController extends Controller
{

    public function __construct()
    {
    }

    public function indexAction()
    {  
        $config = [];
        echo 111;exit;
        return $this->render('index', array('config' => $config));
    }
    
    public function clearCookieAction()
    {
      	$request = $this->Request();
	    setcookie('d0d38ad3', '', time(), '/', $request->getDomain());
	    $this->statusPrint('success');
    }
}
