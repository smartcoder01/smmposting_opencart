<?php

/*
 * @module SMM-posting for Opencart 2.3 - 3.0
 * @author smart-coder.ru
 * @copyright Copyright (c) 2020 SMM-posting.ru
 * @version 2.0
 */

header('Content-type: text/html');
header('Access-Control-Allow-Origin: *');

require_once DIR_SYSTEM.'library/smartcoder/smmposting.php';

Class ControllerMarketingSmmposting extends Controller {
	
	protected $config = [];
    private $smmposting;
    private $smmposting_opencart;

    /**
     * ControllerMarketingSmmposting constructor.
     * @param $registry
     */
    public function __construct($registry) {
        parent::__construct($registry);

        #	Smmposting Opencart
        $this->smmposting_opencart = new SmmpostingOpencart($registry);

        ## Module Settings
        $this->load->model('setting/setting');
        $config = $this->model_setting_setting->getSetting('SMMposting');
        $this->config = isset($config['SMMposting']['config']) ? $config['SMMposting']['config'] : [];
    }


	public function index() {

        //  Validate
        if(isset($this->request->get['api_token']) && isset($this->config['api_token'])) {
            if($this->request->get['api_token'] != $this->config['api_token']){
                $json['error'] = 'Not found or no valid API Token';
                $this->response->addHeader('Content-Type: application/json');
                $this->response->setOutput(json_encode($json));
            }
        } else {
            $json['error'] = 'Not found or no valid API Token';
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }

        $json = [];

		if (isset($this->request->get['post_id']) && isset($this->request->get['social'])) {
		    //  One Post
            $data['posts'] = $this->smmposting_opencart->getPost($this->request->get['post_id'],$this->request->get['social']);
        } else if (isset($this->request->get['products']) && $this->request->get['project'] && $this->request->get['social']) {
            //  Products
		    $data['posts'] = $this->smmposting_opencart->getProductsAsPosts($this->request->get['project'], $this->request->get['products'], $this->request->get['social']);
        } else {
		    //  Posts
            $data['posts'] = $this->smmposting_opencart->getPosts();
		}

        $data['api_token'] = $this->config['api_token']; //  Api Token from https://smm-posting.ru/settings

        ##  Sending posts
        if (count($data['posts']) > 0) {
            $response = $this->send($data);
            if (isset($response->result)) {
                $this->smmposting_opencart->saveResponse($response->result);
            }
            $this->response->setOutput(json_encode($response,JSON_UNESCAPED_UNICODE));
        } else {
            $json['error'] = 'No posts data or products data to send';
            $this->response->setOutput(json_encode($json, JSON_UNESCAPED_UNICODE));
        }
	}


    /**
     * @param string       $data['api_token'] - api token from smm-posting.ru/settings
     *
     * @param array        $data['posts'] - array with your publications (posts)
     *
     * @param int          $data['posts'][$key]['odnoklassniki'] - Public in odnoklassniki = 1
     * @param int          $data['posts'][$key]['vkontakte'] - Public in Vkontakte = 1
     * @param int          $data['posts'][$key]['telegram'] - Public in Telegram = 1
     * @param int          $data['posts'][$key]['instagram'] - Public in Instagram = 1
     * @param int          $data['posts'][$key]['facebook'] - Public in Facebook = 1
     * @param int          $data['posts'][$key]['tumblr'] - Public in Tumblr = 1
     * @param int          $data['posts'][$key]['twitter'] - Public in Twitter = 1
     * @param int          $data['posts'][$key]['post_id'] - Post ID
     * @param string       $data['posts'][$key]['content'] - Post Content
     * @param array        $data['posts'][$key]['images'] - Post Images Links
     * @param string       $data['posts'][$key]['instagram_login'] - Login Instagram
     * @param string       $data['posts'][$key]['instagram_password'] - Password Instagram
     * @param string       $data['posts'][$key]['telegram_token'] - Telegram token from Bot's Father
     * @param string       $data['posts'][$key]['telegram_chat'] - @yourchat
     * @param string       $data['posts'][$key]['vk_access_token'] - Vkontakte Access Token
     * @param string       $data['posts'][$key]['vk_user_id'] - Vkontakte user_id
     * @param string       $data['posts'][$key]['vk_group_id'] - Vkontakte group_id
     * @param string       $data['posts'][$key]['ok_access_token'] - Odnoklassniki Access Token
     * @param string       $data['posts'][$key]['ok_group_id'] - Odnoklassniki group_id
     * @param string       $data['posts'][$key]['fb_access_token'] - Facebook access_token
     * @param string       $data['posts'][$key]['fb_user_id'] - Facebook user_id
     * @param string       $data['posts'][$key]['tw_oauth_token'] - Twitter oauth_token
     * @param string       $data['posts'][$key]['tw_oauth_token_secret'] - Twitter oauth_verifier
     * @param string       $data['posts'][$key]['tb_oauth_verifier'] - Tumblr oauth_verifier
     * @param string       $data['posts'][$key]['tb_oauth_token_secret'] - Tumblr oauth_token_secret

     *
     * @return mixed response
     */
    private function send($data) {
        #   Response from smm-posting.ru
        $this->smmposting = new Smmposting($this->getApiToken());
        return $this->smmposting->send($data);
    }

    private function getApiToken()
    {
        $this->load->model('setting/setting');
        $config = $this->model_setting_setting->getSetting('SMMposting');
        return isset($config['SMMposting']['config']['api_token']) ? $config['SMMposting']['config']['api_token'] : false;
    }

}