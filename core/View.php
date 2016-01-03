<?php
class View{
	public $use_tpl = true;
	public $_errors = false;
	public $_success = false;
	public $_args	 = array();
	protected $_meta = array();
	protected $_js_file = array();
	protected $_css_file = array();
	
	public function __construct()
	{

	}
	
	public static function run()
	{
		if (isset($_GET['route']) && !empty(Tools::G('route'))) {
			$routes = explode('-', Tools::G('route'));
			$viewName = '';
			foreach ($routes as $route) {
				$viewName .= ucwords($route);
			}
		} else {
			$viewName = 'IndexView';
		}

		if (class_exists($viewName)) {
			$view = new $viewName();
		} else {
			$view = new NotFundView();
		}

		return $view;
	}
	
	public function displayHeader()
	{
		global $smarty;
		$this->requestAction();
		if($this->use_tpl){
			$this->setHead();
			$this->sendSectionHead();
			$smarty->display('header.tpl');
		}
	}
	
	public function requestAction()
	{
		global $smarty,$cart;

		$cart_info = array('cart_total'=>0,'cart_quantity'=>0,'cart_products'=>0);
		if(isset($cart)&& Validate::isLoadedObject($cart)){
			$cart_info = $cart->getCartInfo();
		}
		$wishs  = Wish::getWishSumByUser();
		$alerts = Alert::getAlertSumByUser();
		$smarty->assign(array(
			'wish_total'   => $wishs['count'],
			'wish_array'   => $wishs['array'],
			'alert_total'  => $alerts['count'],
			'cart_products'=> $cart_info['cart_products'],
			'cart_total'   => $cart_info['cart_total'],
			'cart_quantity'=> $cart_info['cart_quantity']
		));
	}
	
	public function sendSectionHead()
	{
		global $smarty;
		$smarty->assign("SECATION_HEAD","");
	}
	
	public function displayMain()
	{
		global $smarty;
		if(isset($this->entity->rewrite))
			$smarty->assign(array(
				'this_url' => Tools::getLink($this->entity->rewrite),
			));
		return;
	}
	
	public function displayFooter()
	{
		global $smarty,$cookie;

		if($this->use_tpl){
			$smarty->display('footer.tpl');
		}
	}
	
	public function display()
	{	
		$this->displayHeader();
		$this->displayMain();
		$this->displayFooter();
	}
	
	public function setHead()
	{
		global $smarty,$view;
		
		$this->_meta['title'] 			= isset($this->entity->meta_title)?$this->entity->meta_title.' '.Configuration::get('TM_SHOP_NAME'):Configuration::get('TM_SHOP_NAME');
		$this->_meta['keywords'] 		= isset($this->entity->meta_keywords)?$this->entity->meta_keywords.' '.Configuration::get('TM_SHOP_NAME'):Configuration::get('TM_SHOP_NAME');
		$this->_meta['description']		= isset($this->entity->meta_description)?$this->entity->meta_description.' '.Configuration::get('TM_SHOP_NAME'):Configuration::get('TM_SHOP_NAME');
		$is_google_ip = true;
		if(Configuration::get('GOOGLEBOT_SHOW')=='YES'){
			$is_google_ip = Tools::isGoogleBot();
		}

		$smarty->assign(array(
			'view_name'=>str_replace("view","",strtolower(get_class($view))),
			'is_google_ip'=>$is_google_ip,
			'allow_cn'=>AllowCN::getInstance()->AA(),
			'meta' => $this->_meta,
			'js_file' => $this->_js_file,
			'css_file' => $this->_css_file
		)); 
	}
	
	public function pagination($nbProducts = 10)
	{
		global $smarty, $link;

		$current_url = Tools::htmlentitiesUTF8($_SERVER['REQUEST_URI']);
		//delete parameter page
		$current_url = preg_replace('/(\?)?(&amp;)?page=\d+/', '$1', $current_url);

		if ($this->p < 0)
			$this->p = 0;

		if ($this->p > ($nbProducts / $this->n))
			$this->p = ceil($nbProducts / $this->n);
		$pages_nb = ceil($nbProducts / (int)($this->n));
		
		$n_list   =  array_map('intval',explode(',',Configuration::get('TM_PRODUCTS_PER_PAGE_LIST')));
		$arg	  = $_GET;
		$arg	  = array_unique($arg);
		unset($arg['rule']);
		unset($arg['p']);
		unset($arg['entity']);
		unset($arg['id_entity']);
		if($arg_string = http_build_query($arg))
			$this_link = $link->getPage(get_class($this)) .'&' . $arg_string;
		else
			$this_link = $link->getPage(get_class($this)) ;

		$pagination_infos = array(
			'this_url' => $this_link,
			'pages_nb' => $pages_nb,
			'n_list'   => $n_list,
			'p' => $this->p,
			'n' => $this->n,
			'currenN'=>($this->p*$this->n),
			'total'=>$nbProducts,
			'current_url' => $current_url
		);
		$smarty->assign($pagination_infos);
	}
	
	public function loadFilter()
	{
		global $cookie,$smarty;

		$this->n = abs((int)(Tools::getRequest('resultSize', (isset($cookie->resultSize)?$cookie->resultSize:(int)(Configuration::get('TM_PRODUCTS_PER_PAGE'))))));
		$this->p = abs((int)(Tools::getRequest('p', 1)));
		
		/*filter init*/
		$this->filter = array();
		if(isset($_GET['id_color']))
			$this->filter['id_color'] = Tools::arrayToggle(array_map("intval",explode("_",$_GET['id_color'])));

		if (!isset($cookie->resultSize) || (isset($cookie->resultSize) && $this->n != $cookie->resultSize))
			$cookie->resultSize = $this->n;

		$order_by = array(
			'newest'=>'is_new',
			'orders'=>'orders',
			'availability'=>'in_stock',
			'rental_price_desc'=>'price',
			'rental_price_asc'=>'price'
		);
		$order_way = array(
			'newest'=>'desc',
			'orders'=>'desc',
			'availability'=>'asc',
			'rental_price_desc'=>'desc',
			'rental_price_asc'=>'asc'
		);
		
		$orderSort = Tools::getRequest('sort',isset($cookie->orderSort)?$cookie->orderSort:'newest');
		
		if (!isset($cookie->orderSort) || (isset($cookie->orderSort) && $orderSort != $cookie->orderSort))
			$cookie->orderSort = $orderSort;
			
		$this->by = $order_by[$orderSort];
		$this->way = $order_way[$orderSort];
		$smarty->assign('sort',$orderSort);
	}
}
?>