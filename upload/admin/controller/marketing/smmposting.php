<?php

/**
 * @package  : SMM-Posting for Opencart 2.3-3.0
 * @version 2.0
 * @author smartcoder
 * @copyright https://smm-posting.ru
 */

header('Content-type: text/html');
header('Access-Control-Allow-Origin: *');

require_once DIR_SYSTEM.'library/smartcoder/smmposting.php';

class ControllerMarketingSmmposting extends Controller {

	private $version = '2.0';
	private $auth = false;
	private $smmposting;
	private $smmposting_opencart;

	## GLOBAL CONFIG MODULE
	####################################################################

	function __construct($registry) {
		parent::__construct($registry);

		#	Languages
		$this->load->language('marketing/smmposting');
		$this->document->setTitle($this->language->get('heading_title'));

		#	Models
		$this->load->model('marketing/smmposting');
		$this->load->model('setting/setting');
		# CheckInstall Models
		$this->model_marketing_smmposting->checkInstall();

		#	CheckInstall API SMM-posting
		$this->checkInstallApi();

		#	Smmposting Opencart
		$this->smmposting_opencart = new SmmpostingOpencart($registry);

		#	Styles
		$this->document->addStyle('view/stylesheet/smmposting/css/smmposting.css');
		$this->document->addStyle('view/stylesheet/smmposting/plugins/sweetalert2/sweetalert2.css');
		$this->document->addStyle('view/stylesheet/smmposting/plugins/dropzone/dist/dropzone.css');

		#	Scripts
		$this->document->addScript('view/stylesheet/smmposting/plugins/sweetalert2/sweetalert2.min.js');
		$this->document->addScript('view/stylesheet/smmposting/plugins/dropzone/dist/dropzone.js');
	}


	public function checkInstallApi()
	{
		if ($this->request->get['route'] != 'marketing/smmposting/welcome') {
			$this->checkApiToken();
		}
	}
	private function checkApiToken($api_token = false)
	{
		if (!$api_token) $api_token = $this->getApiToken();

		$this->smmposting = new Smmposting($api_token);
		$profile = $this->smmposting->profile();

		$setData = array(
			'SMMposting' => [
				'config' => ['api_token' => $api_token]
			]
		);
		$this->model_setting_setting->editSetting('SMMposting', $setData);

		if (isset($profile->error)) {
			$this->session->data['error_warning'] = isset($profile->error) ? $profile->error : $this->language->get('smmposting_error_1');
			$this->response->redirect($this->url->link('marketing/smmposting/welcome', '&'.$this->token_to_link(), true));
		} else {
			if (isset($profile->result->date_off)) {
				$now = time();
				$your_date = strtotime($profile->result->date_off);
				$date_diff = $your_date - $now;
				$date_diff =  floor($date_diff / (60 * 60 * 24));

				if ($date_diff <= 3) {
					if (isset($this->session->data['remain_to_pay'])) {
						if ($this->session->data['remain_to_pay'] == $date_diff) {
							unset($this->session->data['remain_to_pay']);
						} else {
							$this->session->data['remain_to_pay'] = $date_diff;
						}
					}
				}
			}
			$this->auth = true;
		}

		return true;
	}

	## LOAD
	####################################################################
	private function links() {
		return array(
			//Menu links
			'add_post_link' => $this->url->link('marketing/smmposting/post', $this->token_to_link(), 'SSL'),
			'edit_post_link' => $this->url->link('marketing/smmposting/post', $this->token_to_link(), 'SSL'),
			'copy_post_link' => $this->url->link('marketing/smmposting/copyPost', $this->token_to_link(), 'SSL'),
			'delete_post_link' => $this->url->link('marketing/smmposting/deletePost', $this->token_to_link(), 'SSL'),
			'posts_link' => $this->url->link('marketing/smmposting/posts', $this->token_to_link(), 'SSL'),
			'products_link' => $this->url->link('marketing/smmposting/products', $this->token_to_link(), 'SSL'),
			'accounts_link' => $this->url->link('marketing/smmposting/accounts', $this->token_to_link(), 'SSL'),
			'welcome_link' => $this->url->link('marketing/smmposting/welcome', $this->token_to_link(), 'SSL'),

			//Projects
			'edit_project_link' => $this->url->link('marketing/smmposting/project', $this->token_to_link(), 'SSL'),
			'deleteproject_link' => $this->url->link('marketing/smmposting/deleteProject', $this->token_to_link(), 'SSL'),
			'project_list' => $this->url->link('marketing/smmposting/projects', $this->token_to_link(), 'SSL'),
			'add_project_link' => $this->url->link('marketing/smmposting/project', $this->token_to_link(), 'SSL'),

			//Settings
			'settings' => $this->url->link('marketing/smmposting/settings', $this->token_to_link(), 'SSL'),
			'cancel' => $this->url->link('marketing/smmposting/posts', $this->token_to_link(), 'SSL'),

			//	Actions
			'deleteImage'	=> $this->url->link('marketing/smmposting/deleteImage', $this->token_to_link(), 'SSL'),

	);
	}
	private function languages() {
		return $this->language->all();
	}
	private function token_to_link() {
		if (version_compare(VERSION, '3.0.0') >= 0) {
			$token_to_link = 'user_token=' . $this->session->data['user_token'];
		} else {
			$token_to_link = 'token=' . $this->session->data['token'];
		}

		return $token_to_link;
	}
	private function config() {
		switch ($this->request->get['route']) {
			case 'marketing/smmposting/post':
			case 'marketing/smmposting/posts':
				$heading_title = $this->language->get('text_posts');
				break;
			case 'marketing/smmposting/product':
			case 'marketing/smmposting/products':
				$heading_title = $this->language->get('text_products');
				break;
			case 'marketing/smmposting/accounts':
				$heading_title = $this->language->get('text_accounts');
				break;
			case 'marketing/smmposting/project':
			case 'marketing/smmposting/projects':
				$heading_title = $this->language->get('text_projects');
				break;
			case 'marketing/smmposting/settings':
				$heading_title = $this->language->get('text_settings');
				break;
			default:
				$heading_title = $this->language->get('text_smmposting');
				break;
		}

		$this->document->setTitle($heading_title .' | '. $this->language->get('text_smmposting'));
		$data['heading_title'] = $heading_title;
		$data['route'] = $this->request->get['route'];
		$data['token_to_link'] = $this->token_to_link();
		$data['version'] = $this->version;
		$data['domain'] = $_SERVER['HTTP_HOST'];

		//	For Send Post
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$data['send_link'] = HTTPS_CATALOG . 'index.php?api_token='.$this->getApiToken().'&route=marketing/smmposting';
		} else {
			$data['send_link'] = HTTP_CATALOG . 'index.php?api_token='.$this->getApiToken().'&route=marketing/smmposting';
		}

		$data['group_links'] = Smmposting::getGroupLinks();
		$data['connect_link'] = Smmposting::connectLink();

		#	OPENCART TOKEN
		$data['token'] = version_compare(VERSION, '3.0.0') >= 0 ? $this->session->data['user_token'] : $this->session->data['token'];

		#	USER CONFIG
		$this->load->model('setting/setting');
		$config = $this->model_setting_setting->getSetting('SMMposting');
		$data['config'] = isset($config['SMMposting']['config']) ? $config['SMMposting']['config'] : [];
		$data['api_token'] = isset($config['SMMposting']['config']['api_token']) ? $config['SMMposting']['config']['api_token'] : null;

		if (isset($this->request->get['error'])) {
			$this->session->data['error_warning'] = $this->request->get['error'];
		}

		unset($this->session->data['smmposting_profile']);
		if (isset($this->session->data['smmposting_profile'])) {
			$data['smmposting_profile'] = $this->session->data['smmposting_profile'];
		} else {
			if ($data['api_token']) {
				$this->smmposting = new Smmposting($data['api_token']);
				$profile = $this->smmposting->profile();
				if (isset($profile->result)) {
					$data['smmposting_profile'] = $profile->result;
					$this->session->data['smmposting_profile'] = $profile->result;
				}

				if (isset($profile->error)) {
					$data['error_connect'] = $profile->error;
				}
			}
		}

		if (isset($this->session->data['remain_to_pay'])) {
			$data['remain_to_pay'] = $this->session->data['remain_to_pay'];
		}


		$data['error_warning'] = isset($this->session->data['error_warning']) ? $this->session->data['error_warning'] : false;
		unset($this->session->data['error_warning']);
		$data['success'] = isset($this->session->data['success']) ? $this->session->data['success'] : null;
		unset($this->session->data['success']);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		return $data;
	}
	private function load_module_data() {
		$this->load->model('marketing/smmposting');
		$data = array_merge($this->links(),$this->languages(),$this->config());

		if (version_compare(VERSION, '3.0.0') >= 0) {
			$data['smm_menu'] = $this->load->view('marketing/smmposting/menu', $data);
		} else {
			$data['smm_menu'] = $this->load->view('marketing/smmposting/menu.tpl', $data);
		}

		return $data;
	}
	private function getApiToken()
	{
		$this->load->model('setting/setting');
		$config = $this->model_setting_setting->getSetting('SMMposting');
		return isset($config['SMMposting']['config']['api_token']) ? $config['SMMposting']['config']['api_token'] : false;
	}
	####################################################################

	##	Pages
	####################################################################
	public function index()
	{
		$this->response->redirect($this->url->link('marketing/smmposting/welcome', '&'.$this->token_to_link(), true));
	}
	public function welcome()
	{


		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (isset($this->request->post['config']['api_token'])) {
				$this->checkApiToken($this->request->post['config']['api_token']);
			}
		}

		$data = $this->load_module_data();

		if ($this->auth) {
			$this->response->redirect($this->url->link('marketing/smmposting/posts', '&'.$this->token_to_link(), true));
		}

		if (version_compare(VERSION, '3.0.0') >= 0) {
			$this->response->setOutput($this->load->view('marketing/smmposting/welcome', $data));
		} else {
			$this->response->setOutput($this->load->view('marketing/smmposting/welcome.tpl', $data));
		}
	}

	## Accounts
	####################################################################
	public function accounts()
	{
		/*
        |--------------------------------------------------------------------------
        | Connecting Odnoklassniki
        |--------------------------------------------------------------------------
        |
        */

		if (isset($_GET['access_token'])  && !isset($_GET['user_id']) )  {
			#Response from SMM-posting
			$this->smmposting = new Smmposting($this->getApiToken());
			$response = $this->smmposting->ok_info($_GET['access_token']);

			if (isset($response->error)) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_3') . $response->error;
			} else {
				if (isset($response->user->name) && isset($response->user->id)) {
					$this->load->model('marketing/smmposting');
					$this->model_marketing_smmposting->save_ok($response->user->name, $response->user->id, $_GET['access_token']);
				} else {
					$this->session->data['error_warning'] = $this->language->get('smmposting_error_4');
				}
			}
		}

		/*
        |--------------------------------------------------------------------------
        | Connecting Vkontakte
        |--------------------------------------------------------------------------
        |
        */
		if (isset($_GET['access_token'])  && isset($_GET['user_id']) )  {
			#Response from SMM-posting
			$this->smmposting = new Smmposting($this->getApiToken());
			$response =  $this->smmposting->vk_info($_GET['access_token'],$_GET['user_id']);
			if (isset($response->error)) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_5'). $response->error;
			} else {
				if (isset($response->name) && isset($_GET['user_id'])) {
					$this->load->model('marketing/smmposting');
					$this->model_marketing_smmposting->save_vk($response->name, $_GET['user_id'], $_GET['access_token']);
				} else {
					$this->session->data['error_warning'] = $this->language->get('smmposting_error_6');
				}
			}
		}

		/*
        |--------------------------------------------------------------------------
        | Connecting Facebook
        |--------------------------------------------------------------------------
        |
        */
		if (isset($_GET['fb_access_token']))  {
			#Response from SMM-posting
			$this->smmposting = new Smmposting($this->getApiToken());
			$response =  $this->smmposting->fb_info($_GET['fb_access_token']);
			if (isset($response->error)) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_7'). $response->error;
			} else {
				if (isset($response->first_name) && isset($response->last_name) && isset($response->id)) {
					$name = $response->first_name . ' ' . $response->last_name;
					$fb_user_id = $response->id;
					$access_token = $_GET['fb_access_token'];
					$this->load->model('marketing/smmposting');
					$this->model_marketing_smmposting->save_fb($name, $fb_user_id, $access_token);
				} else {
					$this->session->data['error_warning'] = $this->language->get('smmposting_error_8');
				}
			}
		}
		/*
        |--------------------------------------------------------------------------
        | Connecting Twitter
        |--------------------------------------------------------------------------
        |
        */
		/*
        |--------------------------------------------------------------------------
        | Connecting Twitter
        |--------------------------------------------------------------------------
        |
        */
		if (isset($_GET['tw_auth'])) {
			$oauth_token = $_GET['oauth_token'];
			$oauth_verifier = $_GET['oauth_verifier'];
			$oauth_token_secret = $_GET['oauth_token_secret'];
			//#Ответ сервера SMM-posting
			$this->smmposting = new Smmposting($this->getApiToken());
			$response = $this->smmposting->tw_info($oauth_token,$oauth_verifier);
			if (isset($response->error)) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_9'). $response->error;
			} else {
				if (isset($response->screen_name)) {
					$name = $response->screen_name;
					$this->load->model('marketing/smmposting');
					$this->model_marketing_smmposting->save_tw($name, $oauth_token, $oauth_token_secret);
				} else {
					$this->session->data['error_warning'] = $this->language->get('smmposting_error_10');
				}
			}
		}


		/*
        |--------------------------------------------------------------------------
        | Connecting Tumblr
        |--------------------------------------------------------------------------
        |
        */
		if (isset($_GET['tb_auth'])) {
			$oauth_token = $_GET['oauth_token'];
			$oauth_verifier = $_GET['oauth_verifier'];
			$oauth_token_secret = $_GET['oauth_token_secret'];
			#Response from SMM-posting
			$this->smmposting = new Smmposting($this->getApiToken());
			$response = $this->smmposting->tb_info($oauth_token,$oauth_verifier, $oauth_token_secret);

			if (isset($response->error)) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_11'). $response->error;
			} else {
				if (isset($response->user->name)) {
					$name = $response->user->name;
					$this->load->model('marketing/smmposting');
					$this->model_marketing_smmposting->save_tb($name, $oauth_token, $oauth_verifier,$oauth_token_secret);
				} else {
					$this->session->data['error_warning'] = $this->language->get('smmposting_error_11');
				}
			}

		}

		/*
		 * End Tumblr
		 */

		$data = $this->load_module_data();
		$this->load->model('setting/setting');

		$data['action_add_telegram'] = $this->url->link('marketing/smmposting/addTelegram', $this->token_to_link());
		$data['action_add_instagram'] = $this->url->link('marketing/smmposting/addInstagram', $this->token_to_link());
		$data['accounts'] = $this->model_marketing_smmposting->getAccounts();
		$data['auth_links'] = Smmposting::getAuthLinks();

		//	for account redirect uri
		if ($this->request->server['HTTPS']) {
			$data['server_link'] = HTTPS_SERVER.'index.php?route=marketing/smmposting/accounts&'.$this->token_to_link();
		} else {
			$data['server_link'] = HTTP_SERVER.'index.php?route=marketing/smmposting/accounts&'.$this->token_to_link();
		}

		if (version_compare(VERSION, '3.0.0') >= 0) {
			$this->response->setOutput($this->load->view('marketing/smmposting/accounts', $data));
		} else {
			$this->response->setOutput($this->load->view('marketing/smmposting/accounts.tpl', $data));
		}
	}
	public function deleteAccount() {

		$json = array();

		if( isset($this->request->post['account_id']) ) {
			$res = $this->model_marketing_smmposting->deleteAccount($this->request->post['account_id']);
			if ($res) {
				$json['success'] = $this->language->get('account_deleted');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));

	}
	public function addTelegram() {

		if( isset($this->request->post['telegram_token'])) {
			#Response from SMM-posting
			$this->smmposting = new Smmposting($this->getApiToken());
			$response = $this->smmposting->tg_info($this->request->post['telegram_token']);

			if (isset($response->error)) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_13'). $response->error;
			} else {
				if (isset($response->name)) {
					$this->load->model('marketing/smmposting');
					$this->model_marketing_smmposting->save_tg($response->name,$this->request->post['telegram_token']);
				} else {
					$this->session->data['error_warning'] = $this->language->get('smmposting_error_14');
				}
			}
		}

		$this->response->redirect($this->url->link('marketing/smmposting/accounts', $this->token_to_link()));

	}
	public function addInstagram() {
		if( isset($this->request->post['instagram_login']) && isset($this->request->post['instagram_password'])) {
			#Response from SMM-posting
			$this->smmposting = new Smmposting($this->getApiToken());
			$response =  $this->smmposting->ig_info($this->request->post['instagram_login'],$this->request->post['instagram_password']);
			if (isset($response->success)) {
				$this->load->model('marketing/smmposting');
				$this->model_marketing_smmposting->save_ig($this->request->post['instagram_login'], $this->request->post['instagram_password']);
			} else {
				$this->session->data['error_warning'] = isset($response->error) ? $response->error : $this->language->get('smmposting_error_15');
			}
		}
		$this->response->redirect($this->url->link('marketing/smmposting/accounts', $this->token_to_link()));
	}


	## Posts
	####################################################################

	public function post() {

		$data = $this->load_module_data();

		$this->load->model('setting/setting');
		$this->load->model('tool/image');
		$this->load->model('user/user');

		$data['post'] = isset($this->request->get['id']) ? $this->model_marketing_smmposting->getPost( (int)$this->request->get['id'] ) : null;
		$data['images'] = isset($this->request->get['id']) ? $this->model_marketing_smmposting->getImages($this->request->get['id']) : [];
		$data['project_info'] = isset($data['post']['project_id']) ? $this->model_marketing_smmposting->getProject($data['post']['project_id']) : null;
		$data['show_ok'] = isset($data['project_info']['ok_account_id']) ? $data['project_info']['ok_account_id'] : false;
		$data['show_vk'] = isset($data['project_info']['vk_account_id']) ? $data['project_info']['vk_account_id'] : false;
		$data['show_tg'] = isset($data['project_info']['tg_account_id']) ? $data['project_info']['tg_account_id'] : false;
		$data['show_ig'] = isset($data['project_info']['ig_account_id']) ? $data['project_info']['ig_account_id'] : false;
		$data['show_fb'] = isset($data['project_info']['fb_account_id']) ? $data['project_info']['fb_account_id'] : false;
		$data['show_tb'] = isset($data['project_info']['tb_account_id']) ? $data['project_info']['tb_account_id'] : false;
		$data['show_tw'] = isset($data['project_info']['tw_account_id']) ? $data['project_info']['tw_account_id'] : false;

		$data['projects'] = $this->model_marketing_smmposting->getProjects();

		if (!isset($this->request->get['id'])) {
			$this->document->setTitle( $this->language->get('text_add_post') );
			$data['action'] = $this->url->link('marketing/smmposting/savePost', $this->token_to_link() , true);
		} else {
			$this->document->setTitle( $this->language->get('text_edit_post') );
			$data['action'] = $this->url->link('marketing/smmposting/savePost', $this->token_to_link() . '&id=' . $this->request->get['id'], true);
		}
		$data['cancel'] = $this->url->link('marketing/smmposting/posts', $this->token_to_link(), true);

		## OC3
		$data['date_today'] = date("Y-m-d");
		$data['date_tomorrow'] = date('Y-m-d', strtotime("+1 day"));
		$data['date_after_tommorrow'] = date('Y-m-d', strtotime("+2 day"));
		$data['status']  = isset($data['post']['status']) ? $data['post']['status'] : 1;

		if (version_compare(VERSION, '3.0.0') >= 0) {
			$this->response->setOutput($this->load->view('marketing/smmposting/post', $data));
		} else {
			$this->response->setOutput($this->load->view('marketing/smmposting/post.tpl', $data));
		}
	}
	public function posts(){

		$data = $this->load_module_data();
		$this->load->model('setting/setting');

		$data['action'] = $this->url->link('marketing/smmposting/posts', $this->token_to_link(), 'SSL');
		$data['action_reset'] = $this->url->link('marketing/smmposting/posts', 'reset=true&'.$this->token_to_link(), 'SSL');
		$data['post_setting'] = $this->url->link('marketing/smmposting', $this->token_to_link(), 'SSL');
		$data['delete_link'] = $this->url->link('marketing/smmposting/deletePost', 'id=%s&'.$this->token_to_link(), 'SSL');
		$data['projects'] = $this->model_marketing_smmposting->getProjects();
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$data_posts = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit'),
		);

		$this->load->model('marketing/smmposting');
		$results = $this->model_marketing_smmposting->getPosts(array($data_posts,false));
		$this->load->model('tool/image');

		foreach ($results as $result) {
			$data['posts'][] = array(
				'post_id' => $result['post_id'],
				'project_id' => $result['project_id'],
				'project_name' => $this->model_marketing_smmposting->getProjectName($result['project_id']),
				'image' => $this->model_marketing_smmposting->getFirstImage($result['post_id']),
				'content' => nl2br(utf8_substr(html_entity_decode($result['content']), 0, 250)),
				'status' => $result['status'],
				'vkontakte' => $result['vkontakte'],
				'telegram' => $result['telegram'],
				'instagram' => $result['instagram'],
				'odnoklassniki' => $result['odnoklassniki'],
				'facebook' 	  => $result['facebook'],
				'tg_download' => $result['tg_download'],
				'vk_download' => $result['vk_download'],
				'ok_download' => $result['ok_download'],
				'ig_download' => $result['ig_download'],
				'fb_download' => $result['fb_download'],
				'date_public' => date('d.m.y', strtotime($result['date_public'])),
				'time_public' => date('H:i', strtotime($result['time_public'])),
			);
		}

		$url = '';
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$project_posts = $this->model_marketing_smmposting->getTotalPostsForPagination($data_posts);

		$pagination = new Pagination();
		$pagination->total = $project_posts;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('marketing/smmposting/posts', $this->token_to_link() . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($project_posts) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($project_posts - $this->config->get('config_limit_admin'))) ? $project_posts : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $project_posts, ceil($project_posts / $this->config->get('config_limit_admin')));



		if (version_compare(VERSION, '3.0.0') >= 0) {
			$this->response->setOutput($this->load->view('marketing/smmposting/posts', $data));
		} else {
			$this->response->setOutput($this->load->view('marketing/smmposting/posts.tpl', $data));
		}
	}
	public function savePost(){

		$this->load->language('marketing/smmposting');
		$this->load->model('marketing/smmposting');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$id = $this->model_marketing_smmposting->savePost( $this->request );
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('marketing/smmposting/posts', $this->token_to_link(), true));
		}

		$this->posts();
	}
	public function deletePost(){
		if (!$this->user->hasPermission('modify', 'marketing/smmposting')) {
			$this->session->data['error_warning'] = $this->language->get('error_permission');
		} else {
			if( isset($this->request->get['id']) && $id=$this->request->get['id'] ){
				$this->load->model('marketing/smmposting');

				$this->model_marketing_smmposting->delete( $id );
			}
		}
		$this->response->redirect($this->url->link('marketing/smmposting/posts', $this->token_to_link(), 'SSL'));
	}
	public function changeProject(){
		$json = [
			'odnoklassniki' =>	0,
			'vkontakte'		=>	0,
			'telegram'		=>	0,
			'instagram'		=>	0,
			'facebook'		=>	0,
			'tumblr'		=>	0,
			'twitter'		=>	0,
		];

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if( isset($this->request->post['smmposting_post']['project_id']) && $this->request->post['smmposting_post']['project_id'] != '*' ){
				$this->load->model('marketing/smmposting');
				$project = $this->model_marketing_smmposting->getProject($this->request->post['smmposting_post']['project_id']);
				$json['odnoklassniki'] = !empty($project['ok_account_id']) ? 1 : 0;
				$json['vkontakte'] = !empty($project['vk_account_id']) ? 1 : 0;
				$json['telegram'] = !empty($project['tg_account_id']) ? 1 : 0;
				$json['instagram'] = !empty($project['ig_account_id']) ? 1 : 0;
				$json['facebook'] = !empty($project['fb_account_id']) ? 1 : 0;
				$json['tumblr'] = !empty($project['tb_account_id']) ? 1 : 0;
				$json['twitter'] = !empty($project['tw_account_id']) ? 1 : 0;
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	## Projects
	####################################################################

	public function project(){

		$data = $this->load_module_data();
		$this->language->load('marketing/smmposting');
		$this->load->model('setting/setting');
		$this->load->model('marketing/smmposting');

		if (isset($this->request->get['project_id'])) {
			$data['action'] = $this->url->link('marketing/smmposting/editProject', $this->token_to_link() . '&project_id=' . $this->request->get['project_id'] , true);
			$data['heading_title'] = 'Редактировать проект';
			$data['project'] = $this->model_marketing_smmposting->getProject($this->request->get['project_id']);
		} else {
			$data['action'] = $this->url->link('marketing/smmposting/addProject', $this->token_to_link() , true);
			$data['heading_title'] = 'Добавить проект';
			$data['project'] = false;
		}

		$data['accounts'] = [
			'odnoklassniki'	=> $this->model_marketing_smmposting->getAccounts('odnoklassniki'),
			'vkontakte'		=> $this->model_marketing_smmposting->getAccounts('vkontakte'),
			'telegram'		=> $this->model_marketing_smmposting->getAccounts('telegram'),
			'instagram'		=> $this->model_marketing_smmposting->getAccounts('instagram'),
			'facebook'		=> $this->model_marketing_smmposting->getAccounts('facebook'),
			'tumblr'		=> $this->model_marketing_smmposting->getAccounts('tumblr'),
			'twitter'		=> $this->model_marketing_smmposting->getAccounts('twitter'),
		];
//echo "<pre>";
//print_r($data['accounts']);die;
		if (version_compare(VERSION, '3.0.0') >= 0) {
			$this->response->setOutput($this->load->view('marketing/smmposting/project', $data));
		} else {
			$this->response->setOutput($this->load->view('marketing/smmposting/project.tpl', $data));
		}
	}
	public function projects(){

		$data = $this->load_module_data();
		$this->language->load('marketing/smmposting');
		$this->load->model('setting/setting');
		$this->load->model('marketing/smmposting');
		$this->document->setTitle($this->language->get('heading_title'));

		$data['smm_projects'] = $this->model_marketing_smmposting->getProjects();

		$url = '';

		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$pagination = new Pagination();
		$pagination->total = $this->model_marketing_smmposting->getTotalProjects();
		$pagination->page = $page;
		$pagination->limit = isset($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('marketing/smmposting', $this->token_to_link() . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		if (version_compare(VERSION, '3.0.0') >= 0) {
			$this->response->setOutput($this->load->view('marketing/smmposting/projects', $data));
		} else {
			$this->response->setOutput($this->load->view('marketing/smmposting/projects.tpl', $data));
		}
	}
	public function addProject() {
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$project_id = $this->model_marketing_smmposting->addProject( $this->request->post );
			$this->session->data['success'] = $this->language->get('text_success_project');
			$this->response->redirect($this->url->link('marketing/smmposting/projects', 'project_id='.$project_id.'&'.$this->token_to_link(), true));
		}

		$this->project();
	}
	public function editProject() {

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->request->post['project_id'] = $this->request->get['project_id'];
			$this->model_marketing_smmposting->editProject( $this->request->post );
			$this->response->redirect($this->url->link('marketing/smmposting/projects', 'project_id='.$this->request->get['project_id'] .'&'.$this->token_to_link(), true));
		}

		$this->project();
	}
	public function getProject()
	{
		$json = array();

		if (isset($this->request->post['project_id'])) {
			$project = $this->model_marketing_smmposting->getProject($this->request->post['project_id']);

			$json['socials'] = array();

			if (isset($this->request->post['method'])) {
				$method = $this->request->post['method'];
			} else {
				$method = false;
			}

			if ($project['ok_account_id'] && $method == 'wall') {
				$json['socials']['odnoklassniki'] = $this->language->get('text_ok');
			}
			if ($project['vk_account_id'] && $method == 'wall') {
				$json['socials']['vkontakte'] = $this->language->get('text_vk');
			}
			if ($project['tg_account_id'] && $method == 'wall') {
				$json['socials']['telegram'] = $this->language->get('text_tg');
			}
			if ($project['ig_account_id'] && $method == 'wall') {
				$json['socials']['instagram'] = $this->language->get('text_ig');
			}
			if ($project['fb_account_id'] && $method == 'wall') {
				$json['socials']['facebook'] = $this->language->get('text_fb');
			}
			if ($project['tb_account_id'] && $method == 'wall') {
				$json['socials']['tumblr'] = $this->language->get('text_tb');
			}
			if ($project['tw_account_id'] && $method == 'wall') {
				$json['socials']['twitter'] = $this->language->get('text_tw');
			}

			if (!$json['socials']) {
				$json['socials']['0'] = $this->language->get('no_socials');
				$json['error'] = $this->language->get('select_another_project');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function deleteProject() {
		if (isset($this->request->get['project_id'])) {
			$this->model_marketing_smmposting->deleteProject($this->request->get['project_id']);
		}
		$this->response->redirect($this->url->link('marketing/smmposting/projects', $this->token_to_link() , 'SSL'));
	}

	## ТОВАРЫ
	####################################################################

	public function products(){

		$data = $this->load_module_data();
		$data['projects'] = $this->model_marketing_smmposting->getProjects();

		$this->load->language('catalog/product');
		$data = array_merge($this->language->all(),$data);
		$data['heading_title'] = $this->language->get('text_products');


		$this->load->model('catalog/product');

		$filter_name = isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : null;
		$filter_model = isset($this->request->get['filter_model']) ? $this->request->get['filter_model'] : null;
		$filter_price = isset($this->request->get['filter_price']) ? $this->request->get['filter_price'] : null;
		$filter_quantity = isset($this->request->get['filter_quantity']) ? $this->request->get['filter_quantity'] : null;
		$filter_status = isset($this->request->get['filter_status']) ? $this->request->get['filter_status'] : null;
		$filter_image = isset($this->request->get['filter_image']) ? $this->request->get['filter_image'] : null;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'pd.name';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;

		$url = '';
		if (isset($this->request->get['filter_name'])) $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		if (isset($this->request->get['filter_model'])) $url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		if (isset($this->request->get['filter_price'])) $url .= '&filter_price=' . $this->request->get['filter_price'];
		if (isset($this->request->get['filter_quantity'])) $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		if (isset($this->request->get['filter_status'])) $url .= '&filter_status=' . $this->request->get['filter_status'];
		if (isset($this->request->get['filter_image'])) $url .= '&filter_image=' . $this->request->get['filter_image'];
		if (isset($this->request->get['sort'])) $url .= '&sort=' . $this->request->get['sort'];
		if (isset($this->request->get['order'])) $url .= '&order=' . $this->request->get['order'];
		if (isset($this->request->get['page'])) $url .= '&page=' . $this->request->get['page'];

		$data['products'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
			'filter_image'    => $filter_image,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');
		$product_total = $this->model_catalog_product->getTotalProducts($filter_data);
		$results = $this->model_catalog_product->getProducts($filter_data);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$special = false;

			$product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);

			foreach ($product_specials  as $product_special) {
				if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) > time())) {
					$special = $product_special['price'];
					break;
				}
			}

			$data['products'][] = array(
				'product_id' => $result['product_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'description'=> $result['description'],
				'model'      => $result['model'],
				'price'      => $result['price'],
				'special'    => $special,
				'quantity'   => $result['quantity'],
				'status'     => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('catalog/product/edit', $this->token_to_link() . '&product_id=' . $result['product_id'] . $url, true)
			);
		}

		$data['selected'] = isset($this->request->post['selected']) ? (array)$this->request->post['selected'] : [];

		$url = '';

		if (isset($this->request->get['filter_name'])) $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		if (isset($this->request->get['filter_model'])) $url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		if (isset($this->request->get['filter_price'])) $url .= '&filter_price=' . $this->request->get['filter_price'];
		if (isset($this->request->get['filter_quantity'])) $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		if (isset($this->request->get['filter_status'])) $url .= '&filter_status=' . $this->request->get['filter_status'];
		if (isset($this->request->get['filter_image'])) $url .= '&filter_image=' . $this->request->get['filter_image'];
		if (isset($this->request->get['page'])) $url .= '&page=' . $this->request->get['page'];

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		$data['sort_name'] = $this->url->link('catalog/product', $this->token_to_link(). '&sort=pd.name' . $url, true);
		$data['sort_model'] = $this->url->link('catalog/product', $this->token_to_link(). '&sort=p.model' . $url, true);
		$data['sort_price'] = $this->url->link('catalog/product', $this->token_to_link(). '&sort=p.price' . $url, true);
		$data['sort_quantity'] = $this->url->link('catalog/product', $this->token_to_link(). '&sort=p.quantity' . $url, true);
		$data['sort_status'] = $this->url->link('catalog/product', $this->token_to_link(). '&sort=p.status' . $url, true);
		$data['sort_order'] = $this->url->link('catalog/product', $this->token_to_link(). '&sort=p.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		if (isset($this->request->get['filter_model'])) $url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		if (isset($this->request->get['filter_price'])) $url .= '&filter_price=' . $this->request->get['filter_price'];
		if (isset($this->request->get['filter_quantity'])) $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		if (isset($this->request->get['filter_status'])) $url .= '&filter_status=' . $this->request->get['filter_status'];
		if (isset($this->request->get['filter_image'])) $url .= '&filter_image=' . $this->request->get['filter_image'];
		if (isset($this->request->get['sort'])) $url .= '&sort=' . $this->request->get['sort'];
		if (isset($this->request->get['order'])) $url .= '&order=' . $this->request->get['order'];

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('marketing/smmposting/products', $this->token_to_link(). $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));
		$data['filter_name'] = $filter_name;
		$data['filter_model'] = $filter_model;
		$data['filter_price'] = $filter_price;
		$data['filter_quantity'] = $filter_quantity;
		$data['filter_status'] = $filter_status;
		$data['filter_image'] = $filter_image;

		$data['sort'] = $sort;
		$data['order'] = $order;

		if (version_compare(VERSION, '3.0.0') >= 0) {
			$this->response->setOutput($this->load->view('marketing/smmposting/products', $data));
		} else {
			$this->response->setOutput($this->load->view('marketing/smmposting/products.tpl', $data));
		}
	}


	## SETTINGS
	####################################################################

	public function settings(){

		$data = $this->load_module_data();

		$this->document->setTitle($this->language->get('text_smmposting'));
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$setData = array(
				'SMMposting' => $this->request->post
			);
			$this->model_setting_setting->editSetting('SMMposting', $setData);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('marketing/smmposting/posts', $this->token_to_link(), 'SSL'));
		}

		$data['action'] = $this->url->link('marketing/smmposting/settings', $this->token_to_link(), 'SSL');

		## FOR CRON
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$data['cron_link'] = HTTPS_CATALOG . 'index.php?route=marketing/smmposting&api_token='.$this->getApiToken();
		} else {
			$data['cron_link'] = HTTP_CATALOG . 'index.php?route=marketing/smmposting&api_token='.$this->getApiToken();
		}

		if (version_compare(VERSION, '3.0.0') >= 0) {
			$this->response->setOutput($this->load->view('marketing/smmposting/settings', $data));
		} else {
			$this->response->setOutput($this->load->view('marketing/smmposting/settings.tpl', $data));
		}
	}

	## VALIDATE
	####################################################################
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'marketing/smmposting')) {
			$this->session->data['error_warning'] = $this->language->get('error_permission');
		}
		return !isset($this->session->data['error_warning']) ? true : false;
	}


	## IMAGES
	####################################################################
	public function uploadImage() {
		if (!$this->validate()) return false;
		$json = array();
		if(isset($_FILES) && isset($_FILES['file'])) {
			$image = $_FILES['file'];
			$json['filename'] = $image['name'];
			$user_folder = DIR_IMAGE.'/smmposting/';
			if (!file_exists($user_folder)) {
				mkdir($user_folder);
			}
			$filesdir = scandir($user_folder, 1);
			$filename=count($filesdir)+1;
			if ($image['size'] > 10485760) {
				$json['error'] = $this->language->get('error_file_size');
			} else {
				$imageType = $image['type'];
				$imageFormat = $this->getFormat($imageType);
				if ($imageFormat) {
					$imageFullName = $user_folder. $filename . '_' . hash('crc32',time()) . '.' . $imageFormat;
					$imageShortName = '/smmposting/'. $filename . '_' . hash('crc32',time()) . '.' . $imageFormat;
					$imagePreview = '/image/smmposting/'. $filename . '_' . hash('crc32',time()) . '.' . $imageFormat;
					if ($imageType == 'image/jpeg' || $imageType == 'image/png' || $imageType == 'image/jpg' || $imageType == 'image/gif') {
						if (move_uploaded_file($image['tmp_name'],$imageFullName)) {
							$json['success']=$this->language->get('uploaded');
							$json['path_file']=$imageShortName;
							$json['preview_image']=$imagePreview;
							$json['delete_file_id']='image_id_'.$filename;
						} else {
							$json['error']=$this->language->get('error_error');
						}
					} else {
						$json['error'] = $this->language->get('error_file_format');
					}
				}
			}
		} else {
			$json['error'] = $this->language->get('error_error');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json, true));
	}
	public function deleteImage() {

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$path = DIR_IMAGE. '/smmposting/' . isset($this->request->post['filename']) ? $this->request->post['filename'] : 0;
			return file_exists($path) ? unlink($path) : false;
		} else {
			return false;
		}

	}
	private function getFormat($imageType, $format = false)
	{
		switch ($imageType) {
			case 'image/gif': $format = 'gif';
				break;
			case 'image/png':
				$format = 'png';
				break;
			case 'image/jpeg':
				$format = 'jpeg';
				break;
			default:
				$format = 'jpg';
				break;
		}
		return $format;
	}
}
?>
