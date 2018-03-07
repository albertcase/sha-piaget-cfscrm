<?php

namespace CampaignBundle;

use Core\Controller;
use Lib\PDO;

class ApiController extends Controller
{
    //REST API FAILD STATUS
    const FAILD_STATUS = [
        'API_JSON_FAILD'            => ['code' => 101, 'msg' => 'post data is not json!'],
        'API_ACCOUNT_FAILD'         => ['code' => 102, 'msg' => 'account failed!'],
        'API_PASSWORD_FAILD'        => ['code' => 103, 'msg' => 'password failed!'],
        'API_CURRENT_PAGE_FAILD'    => ['code' => 104, 'msg' => 'current page not exist!'],
        'API_DATA_NULL_FAILD'       => ['code' => 105, 'msg' => 'data is null!'],
        'API_PARAM_FAILD'           => ['code' => 106, 'msg' => 'api param is failed!']
    ];
      
	private $_pdo;
    private $_param;
    private $_methodVars;
    public function __construct() 
    {
        parent::__construct();
        $this->_pdo = PDO::getInstance();
        $this->_param = json_decode(file_get_contents("php://input"));
        if(is_null($this->_param))
            $this->dataPrint(self::FAILD_STATUS['API_JSON_FAILD']);
    }

    //Admin Login
    public function loginAction()
    {
        if(!isset($this->_param->account) || !isset($this->_param->password))
            $this->dataPrint(self::FAILD_STATUS['API_PARAM_FAILD']);
		$adminList = json_decode(ADMIN_LIST);
		if(!array_key_exists($this->_param->account, $adminList))
			$this->dataPrint(self::FAILD_STATUS['API_ACCOUNT_FAILD']);
	    $name = $this->_param->account;
		if($this->_param->password != $adminList->$name)
			$this->dataPrint(self::FAILD_STATUS['API_PASSWORD_FAILD']);
        //设置登录状态
        $request = $this->Request();
        setcookie('6a9bb49ce9b1', 'b8f9', time() + 3600 * 24, '/', $request->getDomain());
        setcookie('35419145', $this->_param->account, time() + 3600 * 24, '/', $request->getDomain());
		$this->successPrint('login success!');
    }

    //GET Data
    public function dataAction()
    {
        if(!isset($this->_param->page))
            $this->dataPrint(self::FAILD_STATUS['API_CURRENT_PAGE_FAILD']);
        $selectFeilds = json_decode(FEILD_CONF);
    	$dataSum = $this->getSum($selectFeilds);
    	if(!$dataSum) 
            $this->dataPrint(self::FAILD_STATUS['API_DATA_NULL_FAILD']);
    	$totalPages = ceil($dataSum / PAGE_SIZE);
        $selectFeilds->start = ((int) $this->_param->page - 1) * PAGE_SIZE;
        $selectFeilds->end = PAGE_SIZE;
   		$dataList = $this->getData($selectFeilds);
    	$data = [
    		'code' => 200,
    		'msg' => 'get success!',
    		'data' => [
				'total_pages' => $totalPages,
				'current_page' => (int) $this->_param->page,
				'lable_list' => json_decode(LABLE_LIST),
 				'data_list' => $dataList
			],
		];
		$this->dataPrint($data);
    }

    public function getData($feild)
    {
    	$sql = "SELECT {$feild->feilds} FROM {$feild->table} WHERE {$feild->where} ORDER BY {$feild->order} LIMIT {$feild->start}, {$feild->end}";
  	    $query = $this->_pdo->prepare($sql);    
	    $query->execute();
	    $row = $query->fetchAll(\PDO::FETCH_ASSOC);
	    if($row) {
	    	return $row;
	    } else {
	    	return [];
	    }
    }

    public function getSum($filed)
    {
    	$sql = "SELECT count(*) AS sum FROM {$filed->table} WHERE {$filed->where}";
  	    $query = $this->_pdo->prepare($sql);    
	    $query->execute();
	    $row = $query->fetch(\PDO::FETCH_ASSOC);
	    if($row) {
	    	return $row['sum'];
	    } else {
	    	return 0;
	    }
    }

    public function __destruct()
    {
        unset($this->_pdo, $this->_param);
    }

}
