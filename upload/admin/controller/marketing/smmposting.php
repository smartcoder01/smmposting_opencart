<?php

/**
 * @package SMM-Posting for Opencart 2.3-3.0
 * @version 2.0
 * @author smartcoder & vladgaus
 * @copyright https://smm-posting.ru
 */

header('Content-type: text/html');
header('Access-Control-Allow-Origin: *');

require_once DIR_SYSTEM.'library/smartcoder/smmposting.php';

class ControllerMarketingSmmposting extends Controller {

	private $version = '2.1';
	private $auth = false;
	private $smmposting;

	## GLOBAL CONFIG MODULE
	####################################################################

	function __construct($registry) {
		parent::__construct($registry);

		#	Languages
		$this->load->language('marketing/smmposting');

		#	Models
		$this->load->model('setting/setting');

		#	CheckInstall API SMM-posting
		$this->checkInstallApi();

		#	Styles
		$this->document->addStyle('view/stylesheet/smmposting/css/smmposting.css');
		$this->document->addStyle('view/stylesheet/smmposting/plugins/sweetalert2/sweetalert2.css');
		$this->document->addStyle('view/stylesheet/smmposting/plugins/dropzone/dist/dropzone.css');

		#	Scripts
		$this->document->addScript('view/javascript/smmposting/instagram.js');
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
		$profile = $this->smmposting->api('profile');

		$setData = array(
			'SMMposting' => [
				'config' => ['api_token' => $api_token]
			]
		);
		$this->model_setting_setting->editSetting('SMMposting', $setData);

		if (isset($profile->error) && $profile->error == "Y") {
			$this->session->data['error_warning'] = isset($profile->text) ? $profile->text : $this->language->get('smmposting_error_1');
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
			'contact_link' => $this->url->link('marketing/smmposting/contact', $this->token_to_link(), 'SSL'),
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
			return 'user_token=' . $this->session->data['user_token'];
		} else {
			return 'token=' . $this->session->data['token'];
		}
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
				$profile = $this->smmposting->api('profile');
				if (isset($profile->result)) {
					$data['smmposting_profile'] = $profile->result;
					$this->session->data['smmposting_profile'] = $profile->result;
				}

				if (isset($profile->error) && $profile->error == "Y" && isset($profile->text)) {
					$data['error_connect'] = $profile->text;
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
		$data = $this->load_module_data();


		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (isset($this->request->post['config']['api_token'])) {
				$this->checkApiToken($this->request->post['config']['api_token']);
			}
		}

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
		if (isset($this->request->get['s'])) {
			$this->session->data['success'] = $this->language->get('account_added');
		}

		$data = $this->load_module_data();

		$connected_accounts = $this->smmposting->api('connected_accounts');
		$connected_accounts = isset($connected_accounts->result) ? $connected_accounts->result : [];
		$data['accounts'] = json_decode(json_encode($connected_accounts), true);

		//	Redirect Link
		if ($this->request->server['HTTPS']) {
			$data['server_link'] = HTTPS_SERVER.'?route=marketing/smmposting/accounts&'.$this->token_to_link();
		} else {
			$data['server_link'] = HTTP_SERVER.'?route=marketing/smmposting/accounts&'.$this->token_to_link();
		}
		$result_auth_links = $this->smmposting->api('socials', ['redirect_url' => $data['server_link']]);

		$data['allowed_socials'] = isset($result_auth_links->result) ? $result_auth_links->result : [];
		$data['auth_links'] = $this->smmposting->getAuthLinks();

		if (version_compare(VERSION, '3.0.0') >= 0) {
			$this->response->setOutput($this->load->view('marketing/smmposting/accounts', $data));
		} else {
			$this->response->setOutput($this->load->view('marketing/smmposting/accounts.tpl', $data));
		}
	}
	public function deleteAccount() {

		$json = array();

		if( isset($this->request->post['account_id']) ) {
			//	Send to SMMposting
			$res = $this->smmposting->api('account_delete/'.$this->request->post['account_id'],[],'DELETE');
			//	Response
			if (isset($res->result->success) && $res->error == "N") {
				$json['success'] = $this->language->get('account_deleted');
			} else {
				$json['error'] = $this->language->get('account_not_deleted');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));

	}

	## Posts
	####################################################################

	public function post() {

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatePermission()) {

			$request = $this->request->request;
			$this->session->data['old'] = array('post'=>$request);
			/*
			|--------------------------------------------------------------------------
			| Validate
			|--------------------------------------------------------------------------
			|
			*/
			if (empty($request['content'])) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_3');
			}
			if (isset($request['media']) && count($request['media']) > 5) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_4');
			}
			if (!is_numeric($request['project_id'])) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_5');
			}
			if (empty($request['time_public'])) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_6');
			}
			if (empty($request['date_public'])) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_7');
			}

			if (isset($this->session->data['error_warning'])) {
				if (isset($request['id'])) {
					$this->response->redirect($this->url->link('marketing/smmposting/post&id=' . (int)$request['id'], $this->token_to_link(), true));
				} else {
					$this->response->redirect($this->url->link('marketing/smmposting/post', $this->token_to_link(), true));
				}
			}

			/////////////////////////////////////////

			if (isset($request['media'])) {
				$request['media'] = json_encode($request['media']);
			}
			if (isset($request['socials'])) {
				$request['socials'] = json_encode($request['socials']);
			}
			if (isset($request['id'])) {
				//	Send to SMMposting
				$results = $this->smmposting->api('update_post/'.(int)$request['id'], $request, 'PATCH');
			} else {
				//	Send to SMMposting
				$results = $this->smmposting->api('add_post', $request, 'POST');
			}

			//	Response
			if (isset($results->result->success) && $results->result->success == "Y") {
				$this->deleteImages();
				unset($this->session->data['old']);
				$this->session->data['success'] = $this->language->get('text_success');
				$this->response->redirect($this->url->link('marketing/smmposting/posts', $this->token_to_link(), true));
			} else {
				$this->session->data['error_warning'] = isset($results->result) ? $results->result : $this->language->get('smmposting_error_14');
				if (isset($request['id'])) {
					$this->response->redirect($this->url->link('marketing/smmposting/post&id=' . (int)$request['id'], $this->token_to_link(), true));
				} else {
					$this->response->redirect($this->url->link('marketing/smmposting/post', $this->token_to_link(), true));
				}
			}
			$this->posts();
		}

		$data = $this->load_module_data();

		$data['post'] = [];
		if (isset($this->request->get['id'])) {

			$data['action'] = $this->url->link('marketing/smmposting/post', $this->token_to_link() . '&id=' . $this->request->get['id'], true);

			//	Send to SMMposting Get Post
			$results = $this->smmposting->api("get_post/".$this->request->get['id']);
			//	Response
			$results = isset($results->result) ? $results->result : [];
			$results = json_decode(json_encode($results), true);
			$data['post'] = $results;

			//	Send to SMMposting Get Project
			$project_info = $this->smmposting->api("get_project/".$results['project_id']);
			//	Response
			$project_info = isset($project_info->result) ? $project_info->result : [];
			$project_info = json_decode(json_encode($project_info), true);


		} else {
			$data['action'] = $this->url->link('marketing/smmposting/post', $this->token_to_link() , true);
			$data['post'] = [];
		}

		$data['allowed_socials'] = isset($project_info['allowed']) ? $project_info['allowed'] : [];

		//	Send to SMMposting
		$results = $this->smmposting->api('list_projects', ['limit'=>100]);
		//	Response
		$smm_projects = isset($results->result) ? $results->result : [];
		$data['projects'] = json_decode(json_encode($smm_projects), true);

		$data['cancel'] = $this->url->link('marketing/smmposting/posts', $this->token_to_link(), true);
		## Time
		$data['date_today'] = date("Y-m-d");
		$data['date_tomorrow'] = date('Y-m-d', strtotime("+1 day"));
		$data['date_after_tommorrow'] = date('Y-m-d', strtotime("+2 day"));

		//	OLD DATA
		if (isset($this->session->data['old'])) {
			$data = array_replace($data, $this->session->data['old']);
			unset($this->session->data['old']);
		}



		if (version_compare(VERSION, '3.0.0') >= 0) {
			$this->response->setOutput($this->load->view('marketing/smmposting/post', $data));
		} else {
			$this->response->setOutput($this->load->view('marketing/smmposting/post.tpl', $data));
		}
	}
	public function posts(){

		$data = $this->load_module_data();

		$data['delete_link'] = $this->url->link('marketing/smmposting/deletePost', 'id=%s&'.$this->token_to_link(), 'SSL');

		//	Send to SMMposting
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$limit = isset($this->request->get['limit']) ? $this->request->get['limit'] : 10;
		$results = $this->smmposting->api('list_posts',  ['page'=>$page, 'limit'=>$limit]);

		//	Response
		$count = isset($results->count) ? $results->count : 0;
		$results = isset($results->result) ? $results->result : [];
		$results = json_decode(json_encode($results), true);

		foreach ($results as $result) {
			$data['posts'][] = array(
				'post_id' 		=> $result['id'],
				'project_id' 	=> $result['project_id'],
				'project_name' 	=> $result['project_name'],
				'image' 		=> isset($result['media'][0]) ? $result['media'][0] : null,
				'content' 		=> nl2br(utf8_substr(html_entity_decode($result['content']), 0, 250)),
				'status' 		=> $result['status'],
				'vk'			=> isset($result['socials']) && in_array("vk",$result['socials']),
				'ok'			=> isset($result['socials']) && in_array("ok",$result['socials']),
				'tg'			=> isset($result['socials']) && in_array("tg",$result['socials']),
				'ig'			=> isset($result['socials']) && in_array("ig",$result['socials']),
				'fb'			=> isset($result['socials']) && in_array("fb",$result['socials']),
				'tb'			=> isset($result['socials']) && in_array("tb",$result['socials']),
				'tw'			=> isset($result['socials']) && in_array("tw",$result['socials']),
				'date_public' 	=> date('d.m.y', strtotime($result['date_public'])),
				'time_public' 	=> date('H:i', strtotime($result['time_public'])),
			);
		}

		$pagination 		= new Pagination();
		$pagination->total 	= $count;
		$pagination->page 	= isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$pagination->limit 	= $limit;
		$pagination->url 	= $this->url->link('marketing/smmposting/posts', $this->token_to_link() . '&page={page}', true);
		$data['pagination']	= $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($pagination->total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($pagination->total - $this->config->get('config_limit_admin'))) ? $pagination->total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $pagination->total, ceil($pagination->total / $this->config->get('config_limit_admin')));



		if (version_compare(VERSION, '3.0.0') >= 0) {
			$this->response->setOutput($this->load->view('marketing/smmposting/posts', $data));
		} else {
			$this->response->setOutput($this->load->view('marketing/smmposting/posts.tpl', $data));
		}
	}
	public function deletePost(){
		if (!$this->user->hasPermission('modify', 'marketing/smmposting')) {
			$this->session->data['error_warning'] = $this->language->get('error_permission');
		} else {
			if( isset($this->request->get['id']) && $id=$this->request->get['id'] ){
				//	Send to SMMposting
				$res = $this->smmposting->api('delete_post/'.$this->request->get['id'],[],'DELETE');
				//	Response
				if ((isset($res->result->was_deleted) && $res->result->was_deleted == "Y") || (isset($res->result->success) && $res->result->success == "Y")) {
					$this->session->data['success'] = $this->language->get('text_success');
				} else {
					$this->session->data['error_warning'] = $this->language->get('error_warning');
				}
			}
		}
		$this->response->redirect($this->url->link('marketing/smmposting/posts', $this->token_to_link(), 'SSL'));
	}

	## Projects
	####################################################################

	public function project(){

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatePermission()) {

			$request = $this->request->request;
			$this->session->data['old'] = array('project'=>$request);

			/*
			|--------------------------------------------------------------------------
			| Validate
			|--------------------------------------------------------------------------
			|
			*/
			if (empty($request['name'])) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_8');
			}

			if ($request['ok_account_id'] && !isset($request['ok_group_id'])) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_9');
			}

			if ($request['vk_account_id'] && !isset($request['vk_group_id'])) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_10');
			}

			if ($request['tg_account_id'] && empty($request['tg_chat_id'])) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_11');
			}

			if ($request['fb_account_id'] && !isset($request['fb_group_id'])) {
				$this->session->data['error_warning'] = $this->language->get('smmposting_error_12');
			}

			if (isset($this->session->data['error_warning'])) {
				if (isset($request['id'])) {
					$this->response->redirect($this->url->link('marketing/smmposting/project&id=' . (int)$request['id'], $this->token_to_link(), true));
				} else {
					$this->response->redirect($this->url->link('marketing/smmposting/project', $this->token_to_link(), true));
				}
			}

			/////////////////////////////////////////

			if (!$request['ok_account_id'] && !isset($request['ok_group_id'])) {
				unset($request['ok_account_id']);
			}

			if (!$request['vk_account_id'] && !isset($request['vk_group_id'])) {
				unset($request['vk_account_id']);
			}

			if (!$request['tg_account_id'] && empty($request['tg_chat_id'])) {
				unset($request['tg_account_id']);
				unset($request['tg_chat_id']);
			}

			if (!$request['fb_account_id'] && !isset($request['fb_group_id'])) {
				unset($request['fb_account_id']);
			}

			if (!$request['ig_account_id']) {
				unset($request['ig_account_id']);
			}

			if (!$request['tb_account_id']) {
				unset($request['tb_account_id']);
			}

			if (!$request['tw_account_id']) {
				unset($request['tw_account_id']);
			}

			if (isset($request['id'])) {
				//	Send to SMMposting
				$results = $this->smmposting->api('update_project/'.(int)$request['id'], $request, 'PATCH');
			} else {
				//	Send to SMMposting
				$results = $this->smmposting->api('add_project', $request, 'POST');
			}

			//	Response
			if (isset($results->result->success) && $results->result->success == "Y") {
				unset($this->session->data['old']);
				$this->session->data['success'] = $this->language->get('text_success');
				$this->response->redirect($this->url->link('marketing/smmposting/projects', $this->token_to_link(), true));
			} else {

				$this->session->data['error_warning'] = isset($results->result) ? $results->result : $this->language->get('smmposting_error_13');
				if (isset($request['id'])) {
					$this->response->redirect($this->url->link('marketing/smmposting/project&id=' . (int)$request['id'], $this->token_to_link(), true));
				} else {
					$this->response->redirect($this->url->link('marketing/smmposting/project', $this->token_to_link(), true));
				}


			}

			$this->projects();
		}

		$data = $this->load_module_data();

		if (isset($this->request->get['id'])) {
			$data['action'] = $this->url->link('marketing/smmposting/project', $this->token_to_link() . '&id=' . $this->request->get['id'], true);

			//	Send to SMMposting Get Post
			$results = $this->smmposting->api("get_project/".$this->request->get['id']);
			//	Response
			$results = isset($results->result) ? $results->result : [];
			$results = json_decode(json_encode($results), true);
			$data['project'] = $results;
		} else {
			$data['action'] = $this->url->link('marketing/smmposting/project', $this->token_to_link() , true);
			$data['project'] = [];
		}

		//	Send to SMMposting Get Connected Accounts
		$connected_accounts = $this->smmposting->api('connected_accounts');
		$connected_accounts = isset($connected_accounts->result) ? $connected_accounts->result : [];
		$connected_accounts = json_decode(json_encode($connected_accounts), true);

		$data['accounts'] = [
			"ok" => [], "vk" => [], "tg" => [], "ig" => [], "fb" => [], "tw" => [], "tb" => []
		];
		foreach ($connected_accounts as $account)
		{
			switch ($account['social']) {
				case "ok":
					$data['accounts']["ok"][] = $account;
					break;
				case "vk":
					$data['accounts']["vk"][] = $account;
					break;
				case "tg":
					$data['accounts']["tg"][] = $account;
					break;
				case "ig":
					$data['accounts']["ig"][] = $account;
					break;
				case "fb":
					$data['accounts']["fb"][] = $account;
					break;
				case "tw":
					$data['accounts']["tw"][] = $account;
					break;
				case "tb":
					$data['accounts']["tb"][] = $account;
					break;
			}
		}

		//	OLD DATA
		if (isset($data['project']['socials']['ok']['id'])) {
			$data['project']['ok_account_id'] = $data['project']['socials']['ok']['id'];
		}
		if (isset($data['project']['socials']['vk']['id'])) {
			$data['project']['vk_account_id'] = $data['project']['socials']['vk']['id'];
		}
		if (isset($data['project']['socials']['tg']['id'])) {
			$data['project']['tg_account_id'] = $data['project']['socials']['tg']['id'];
		}
		if (isset($data['project']['socials']['fb']['id'])) {
			$data['project']['fb_account_id'] = $data['project']['socials']['fb']['id'];
		}

		if (isset($this->session->data['old'])) {
			$data = array_replace($data, $this->session->data['old']);
			unset($this->session->data['old']);
		}

		if (version_compare(VERSION, '3.0.0') >= 0) {
			$this->response->setOutput($this->load->view('marketing/smmposting/project', $data));
		} else {
			$this->response->setOutput($this->load->view('marketing/smmposting/project.tpl', $data));
		}
	}
	public function projects(){

		$data = $this->load_module_data();

		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$limit = isset($this->request->get['limit']) ? $this->request->get['limit'] : 10;
		$results = $this->smmposting->api('list_projects', ['page'=>$page, 'limit'=>$limit]);
		$count = isset($results->count) ? $results->count : 0;
		$smm_projects = isset($results->result) ? $results->result : [];
		$data['smm_projects'] = json_decode(json_encode($smm_projects), true);

		$pagination 		= new Pagination();
		$pagination->total 	= $count;
		$pagination->page 	= isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$pagination->limit 	= $limit;
		$pagination->url 	= $this->url->link('marketing/smmposting/projects', $this->token_to_link() . '&page={page}', true);
		$data['pagination']	= $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($pagination->total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($pagination->total - $this->config->get('config_limit_admin'))) ? $pagination->total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $pagination->total, ceil($pagination->total / $this->config->get('config_limit_admin')));

		if (version_compare(VERSION, '3.0.0') >= 0) {
			$this->response->setOutput($this->load->view('marketing/smmposting/projects', $data));
		} else {
			$this->response->setOutput($this->load->view('marketing/smmposting/projects.tpl', $data));
		}
	}
	public function getProject()
	{
		$json = array();

		if (isset($this->request->post['project_id'])) {
			$project = $this->model_marketing_smmposting->getProject($this->request->post['project_id']);

			//$this->smmposting->api('connected_accounts');
			//$project = $this->smmposting->api('account_delete/'.$this->request->post['account_id'],[],'DELETE');

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
		if (isset($this->request->get['id'])) {
			//	Send to SMMposting
			$res = $this->smmposting->api('delete_project/'.$this->request->get['id'],[],'DELETE');
			//	Response
			if (isset($res->result->success) && $res->result->success == "Y") {
				$this->session->data['success'] = $this->language->get('text_success');
			} else {
				$this->session->data['error_warning'] = $this->language->get('error_warning');
			}
		}
		$this->response->redirect($this->url->link('marketing/smmposting/projects', $this->token_to_link() , 'SSL'));
	}

	## CONTACT
	####################################################################

	public function contact(){

		$data = $this->load_module_data();

		if (version_compare(VERSION, '3.0.0') >= 0) {
			$this->response->setOutput($this->load->view('marketing/smmposting/contact', $data));
		} else {
			$this->response->setOutput($this->load->view('marketing/smmposting/contact.tpl', $data));
		}
	}

	## VALIDATION
	####################################################################
	protected function validatePermission() {
		if (!$this->user->hasPermission('modify', 'marketing/smmposting')) {
			$this->session->data['error_warning'] = $this->language->get('error_permission');
		}
		return !isset($this->session->data['error_warning']) ? true : false;
	}


	## IMAGES
	####################################################################
	public function uploadImage() {
		if (!$this->validatePermission()) return false;
		$json = array();
		if(isset($_FILES) && isset($_FILES['file'])) {
			$image = $_FILES['file'];
			$json['filename'] = $image['name'];
			$user_folder = DIR_IMAGE.'/smmposting/';
			if (!file_exists($user_folder)) mkdir($user_folder);
			$filesdir = scandir($user_folder, 1);
			$filename=count($filesdir)+1;
			if ($image['size'] > 10485760) {
				$json['error'] = $this->language->get('error_file_size');
			} else {
				$imageType = $image['type'];
				$imageFormat = $this->getFormat($imageType);
				if ($imageFormat) {
					$image_path = $user_folder. $filename . '_' . hash('crc32',time()) . '.' . $imageFormat;

					if ($this->request->server['HTTPS']) {
						$preview_image = HTTPS_CATALOG.'image/smmposting/'. $filename . '_' . hash('crc32',time()) . '.' . $imageFormat;
					} else {
						$preview_image = HTTP_CATALOG.'image/smmposting/'. $filename . '_' . hash('crc32',time()) . '.' . $imageFormat;
					}

					if ($imageType == 'image/jpeg' || $imageType == 'image/png' || $imageType == 'image/jpg' || $imageType == 'image/gif') {
						if (move_uploaded_file($image['tmp_name'],$image_path)) {
							$json['success']=$this->language->get('uploaded');
							$json['preview_image']=$preview_image;
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
	public function deleteImages() {
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatePermission()) {
			$path = DIR_IMAGE. '/smmposting/';
			return is_dir($path) ? rmdir($path) : true;
		} else {
			return false;
		}
	}
	private function getFormat($imageType, $format = false)
	{
		switch ($imageType) {
			case 'image/gif': $format = 'gif'; break;
			case 'image/png': $format = 'png'; break;
			case 'image/jpeg': $format = 'jpeg'; break;
			default: $format = 'jpg'; break;
		}
		return $format;
	}
}
?>
