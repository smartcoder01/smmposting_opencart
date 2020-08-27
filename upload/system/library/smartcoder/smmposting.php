<?php
/**
 * @package  : SMM-Posting API
 * @version 1.0
 * @author smartcoder
 * @copyright https://smm-posting.ru
 */

class Smmposting
{
    public static $domain = 'https://smm-posting.ru/';
    private $api_version;
    private $api_token;

    /**
     * Smmposting constructor.
     * @param $api_token
     * @param int $api_version
     */
    public function __construct($api_token, $api_version = 1)
    {
        $this->api_token    = $api_token;
        $this->api_version  = $api_version;
    }

    /**
     * @param $method
     * @param array $params
     * @return bool|string
     */
    public function api($method, $params = array()) {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => self::$domain."api/v$this->api_version/smmposting/$method?api_token=$this->api_token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params)
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }

    /**
     * Get Info about me SMMposting
     * @return bool|string
     */
    public function profile()
    {
        return $this->api('profile');
    }

    /**
     * Get Profile Info Odnoklassniki
     * @param $access_token
     * @return bool|string
     */
    public function ok_info($access_token)
    {
        return $this->api('ok_user_info',['access_token'=>$access_token]);
    }

    /**
     * Get Profile Info Vkontakte
     * @param $access_token
     * @param $user_id
     * @return bool|string
     */
    public function vk_info($access_token,$user_id)
    {
        return $this->api('vk_user_info',['access_token'=>$access_token, 'user_id'=>$user_id]);
    }


    /**
     * Get Profile Info Telegram
     * @param $telegram_token
     * @return bool|string
     */
    public function tg_info($telegram_token)
    {
        return $this->api('tg_user_info', ['telegram_token' => $telegram_token]);
    }

    /**
     * Get Profile Info Instagram
     * @param $instagram_login
     * @param $instagram_password
     * @return bool|string
     */
    public function ig_info($instagram_login,$instagram_password)
    {
        return $this->api('ig_user_info',['instagram_login'=>$instagram_login, 'instagram_password'=>$instagram_password]);
    }

    /**
     * * Get Profile Info Facebook
     * @param $fb_access_token
     * @return bool|string
     */
    public function fb_info($fb_access_token)
    {
        return $this->api('fb_user_info',['fb_access_token'=>$fb_access_token]);
    }

    /**
     * Get Profile Info Tumblr
     * @param $oauth_token
     * @param $oauth_verifier
     * @param $oauth_token_secret
     * @return bool|string
     */
    public function tb_info($oauth_token, $oauth_verifier, $oauth_token_secret)
    {
        return $this->api('tb_user_info',['oauth_token'=>$oauth_token,'oauth_verifier'=>$oauth_verifier,'oauth_token_secret'=>$oauth_token_secret]);
    }

    /**
     * Get Profile Info Twitter
     * @param $oauth_token
     * @param $oauth_verifier
     * @return bool|string
     */
    public function tw_info($oauth_token, $oauth_verifier)
    {
        return $this->api('tw_user_info',['oauth_token'=>$oauth_token,'oauth_verifier'=>$oauth_verifier,]);
    }

    /**
     * Get Profile Groups Odnoklassniki
     * @return bool|string
     */
    public function ok_groups()
    {
        return $this->api('ok_groups');
    }

    /**
     * Get Profile Groups Vkontakte
     * @return bool|string
     */
    public function vk_groups()
    {
        return $this->api('vk_groups');
    }

    /**
     * Get Profile Groups Facebook
     * @return bool|string
     */
    public function fb_groups()
    {
        return $this->api('fb_groups');
    }


    /**
     * @param string       $data['api_key'] - секретный ключ, выданный в настройках на сайте smm-posting.ru/settings
     * @param array        $data['posts'] - массив с публикациями и с проектами
     * @param int          $data['posts'][0]['post_id'] - ID вашего поста
     * @param string       $data['posts'][0]['content'] - Содержание поста
     * @param array        $data['posts'][0]['images'] - Картинки поста
     * @param string       $data['posts'][0]['instagram_login'] - Логин Instagram
     * @param string       $data['posts'][0]['instagram_password'] - Пароль Instagram
     * @param string       $data['posts'][0]['telegram_token'] - Token, полученный у Bot's Father
     * @param string       $data['posts'][0]['telegram_chat'] - @yourchat
     * @param string       $data['posts'][0]['vk_access_token'] - VK Access Token
     * @param string       $data['posts'][0]['vk_user_id'] - VK user_id
     * @param string       $data['posts'][0]['vk_group_id'] - VK group_id
     * @param string       $data['posts'][0]['ok_access_token'] - OK Access Token
     * @param string       $data['posts'][0]['ok_group_id'] - OK group_id
     *
     * @return mixed response
     */
    public function send($data)
    {
        return $this->api('send',$data);

    }

    /**
     * Connect link to SMMposting
     * @return string
     */
    public static function connectLink()
    {
        return self::$domain . 'api/v1/smmposting/profile';
    }

    /**
     * Auth links to socials
     * @return array
     */
    public static function getAuthLinks()
    {
        return [
            'ok_auth_link' => self::$domain . 'api/v1/smmposting/ok_auth', // Odnoklassniki
            'vk_auth_link' => self::$domain . 'api/v1/smmposting/vk_auth', // Vkontakte
            'tg_auth_link' => self::$domain . 'api/v1/smmposting/tg_auth', // Telegram
            'fb_auth_link' => self::$domain . 'api/v1/smmposting/fb_auth', // Facebook
            'tb_auth_link' => self::$domain . 'api/v1/smmposting/tb_auth', // Tumblr
            'tw_auth_link' => self::$domain . 'api/v1/smmposting/tw_auth', // Twitter
        ];
    }

    /**
     * Groups Info links to socials
     * @return array
     */
    public static function getGroupLinks()
    {
        return [
            'ok_groups' => self::$domain . 'api/v1/smmposting/ok_groups', // Odnoklassniki
            'vk_groups' => self::$domain . 'api/v1/smmposting/vk_groups', // Vkontakte
            'fb_groups' => self::$domain . 'api/v1/smmposting/fb_groups', // Facebook
        ];
    }



}
class SmmpostingOpencart
{
    private $db;
    private $config;
    private $request;
    private $session;

    /**
     * SmmpostingOpencart constructor.
     * @param $registry
     */
    public function __construct($registry) {
        $this->config = $registry->get('config');
        $this->db = $registry->get('db');
        $this->request = $registry->get('request');
        $this->session = $registry->get('session');
        $this->url = $registry->get('url');
        $this->load = $registry->get('load');
    }


    /**
     * @param $post_id
     * @param bool $social
     * @return bool
     */
    public function getPost($post_id, $social = false)
    {
        switch ($social){
            case 'vkontakte':
                $sql = "SELECT p1.post_id, p1.content, p1.vkontakte, p2.vk_group_id,";
                $sql .= "(SELECT vk_access_token FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.vk_account_id) as vk_access_token,
                         (SELECT vk_user_id FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.vk_account_id) as vk_user_id";
                break;
            case 'odnoklassniki':
                $sql = "SELECT p1.post_id, p1.content, p1.odnoklassniki, p2.ok_group_id,";
                $sql .= "(SELECT ok_access_token FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.ok_account_id) as ok_access_token";
                break;
            case 'telegram':
                $sql = "SELECT p1.post_id, p1.content, p1.telegram, p2.telegram_chat_id,";
                $sql .= "(SELECT telegram_token FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.tg_account_id) as telegram_bot_id,
                         (SELECT telegram_chat_id FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.tg_account_id) as telegram_chat_id";
                break;
            case 'instagram':
                $sql = "SELECT p1.post_id, p1.content, p1.instagram,";
                $sql .= "(SELECT instagram_login FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.ig_account_id) as instagram_login,
                         (SELECT instagram_password FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.ig_account_id) as instagram_password";
                break;
            case 'facebook':
                $sql = "SELECT p1.post_id, p1.content, p1.facebook, p2.fb_group_id,";
                $sql .= "(SELECT fb_access_token FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.fb_account_id) as fb_access_token,
                         (SELECT fb_user_id FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.fb_account_id) as fb_user_id";
                break;
            case 'twitter':
                $sql = "SELECT p1.post_id, p1.content, p1.twitter,";
                $sql .= "(SELECT tw_oauth_token FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.tw_account_id) as tw_oauth_token,
                         (SELECT tw_oauth_token_secret FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.tw_account_id) as tw_oauth_token_secret,
                         (SELECT account_name FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.tb_account_id) as account_name";
                break;
            case 'tumblr':
                $sql = "SELECT p1.post_id, p1.content, p1.tumblr,";
                $sql .= "(SELECT tb_oauth_token FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.tb_account_id) as tb_oauth_token,
                         (SELECT tb_oauth_token_secret FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.tb_account_id) as tb_oauth_token_secret,
                         (SELECT account_name FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.tb_account_id) as account_name";
                break;
            default:
                return false;
                break;
        }


        $sql .= ", (SELECT GROUP_CONCAT('".HTTP_SERVER."image', image) FROM ".DB_PREFIX."smmposting_image WHERE post_id = p1.post_id) as cloud_links";

        $sql .= " FROM ".DB_PREFIX."smmposting_post p1 
                  LEFT JOIN ".DB_PREFIX."smmposting_projects p2 ON(p1.project_id=p2.project_id) 
                  WHERE p1.post_id = '".(int)$post_id ."'
                  ORDER BY p1.date_public DESC LIMIT 1";

        $query = $this->db->query($sql);
        return $query->rows;
    }

    /**
     * @return mixed
     */
    public function getPosts()
    {

        $sql = "SELECT p1.post_id, p1.project_id, p1.content, p1.vkontakte, p1.date_public,p1.time_public, 

					p2.telegram_chat_id, p2.vk_group_id, p2.ok_group_id,

					(SELECT instagram_login FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.ig_account_id) as instagram_login,
                    (SELECT instagram_password FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.ig_account_id) as instagram_password,
                    (SELECT telegram_token FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.tg_account_id) as telegram_bot_id,
                    (SELECT telegram_chat_id FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.tg_account_id) as telegram_chat_id,
					(SELECT vk_access_token FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.vk_account_id) as vk_access_token,
                    (SELECT vk_user_id FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.vk_account_id) as vk_user_id,
					(SELECT ok_access_token FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.ok_account_id) as ok_access_token,
					
					(SELECT GROUP_CONCAT('".HTTP_SERVER."image', image) FROM ".DB_PREFIX."smmposting_image WHERE post_id = p1.post_id) as cloud_links

					FROM ". DB_PREFIX ."smmposting_post p1 
					LEFT JOIN ". DB_PREFIX ."smmposting_projects p2 ON(p1.project_id=p2.project_id) 
					WHERE p1.status = 0
					AND p2.status = 1
					AND DATE(p1.date_public) = CURRENT_DATE
					AND TIME(p1.time_public) < CURRENT_TIME 
					ORDER BY p1.date_public DESC";


        $query = $this->db->query($sql);
        return $query->rows;
    }

    /**
     * @param $project_id
     * @param array $products
     * @param $social
     * @return array|bool|string
     */
    public function getProductsAsPosts($project_id, $products = [], $social) {
        $products = implode(',', $products);
        $sql = "SELECT p1.*,p3.*,";

        switch ($social){
            case 'vkontakte':
                $sql .= "p2.vk_group_id,";
                $sql .= "(SELECT vk_access_token FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.vk_account_id) as vk_access_token,
                         (SELECT vk_user_id FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.vk_account_id) as vk_user_id,";
                break;
            case 'odnoklassniki':
                $sql .= "p2.ok_group_id,";
                $sql .= "(SELECT ok_access_token FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.ok_account_id) as ok_access_token,";
                break;
            case 'telegram':
                $sql .= "p2.telegram_chat_id,";
                $sql .= "(SELECT telegram_token FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.tg_account_id) as telegram_bot_id,
                         (SELECT telegram_chat_id FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.tg_account_id) as telegram_chat_id,";
                break;
            case 'instagram':
                $sql .= "(SELECT instagram_login FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.ig_account_id) as instagram_login,
                         (SELECT instagram_password FROM ".DB_PREFIX."smmposting_accounts WHERE account_id = p2.ig_account_id) as instagram_password,";
                break;
            default:
                return false;
                break;
        }

        $sql .= "(SELECT GROUP_CONCAT('".HTTP_SERVER."image/', image) FROM ".DB_PREFIX."product_image WHERE product_id = p1.product_id) as cloud_links";

        $sql .= " FROM ".DB_PREFIX."product p1 
                  LEFT JOIN ".DB_PREFIX."smmposting_projects p2 ON(p2.project_id ='".$project_id."')
                  LEFT JOIN ".DB_PREFIX."product_description p3 ON(p1.product_id = p3.product_id)
                  WHERE p1.product_id IN(". $products. ")";
        /*$sql .= " AND p3.language_id = 1 ";*/

        $query = $this->db->query($sql);
        $products_data = $query->rows;


        $products = array();
        foreach ($products_data as $key => $product) {

            $product['price'] = round($product['price'],0);
            $product_link = '<a href="'.$this->url->link('product/product', '&product_id=' . $product['product_id']).'">'.$this->url->link('product/product', '&product_id=' . $product['product_id'])."</a>";

            $product['content'] = isset($this->config->get('SMMposting')['config']['product_template']) ? $this->config->get('SMMposting')['config']['product_template'] : '';
            $product['content'] = str_replace(['{price}','{name}','{model}','{sku}','{description}','{link}'], [$product['price'],$product['name'],$product['model'],$product['sku'],$product['description'],$product_link], $product['content']);

            //  Для товаров
            $products[$key]['name'] = $product['name'];
            $products[$key]['price'] = $product['price'];

            //   Контент
            $products[$key]['content'] = $product['content'];
            $products[$key]['cloud_links'] = $product['cloud_links'];
            $products[$key]['post_id'] = $product['product_id'];

            //  Пароли и токены
            if ($social == 'instagram') {
                $products[$key]['instagram'] = 1;
                $products[$key]['instagram_login'] = $product['instagram_login'];
                $products[$key]['instagram_password'] = $product['instagram_password'];
            }

            if ($social == 'telegram') {
                $products[$key]['telegram'] = 1;
                $products[$key]['telegram_bot_id'] = $product['telegram_bot_id'];
                $products[$key]['telegram_chat_id'] = $product['telegram_chat_id'];
            }

            if ($social == 'vkontakte') {
                $products[$key]['vkontakte'] = 1;
                $products[$key]['vk_access_token'] = $product['vk_access_token'];
                $products[$key]['vk_user_id'] = $product['vk_user_id'];
                $products[$key]['vk_group_id'] = $product['vk_group_id'];
            }

            if ($social == 'odnoklassniki') {
                $products[$key]['odnoklassniki'] = 1;
                $products[$key]['ok_group_id'] = $product['ok_group_id'];
                $products[$key]['ok_access_token'] = $product['ok_access_token'];
            }

        }

        return $products;
    }

    /**
     * @param $response
     */
    public function saveResponse($response)
    {

        foreach ($response as $key => $post) {

            /*
            |--------------------------------------------------------------------------
            | Writing down errors
            |--------------------------------------------------------------------------
            |
            */
            if (isset($post->odnoklassniki->error)) {
                $this->errorSocial($key, 'odnoklassniki', $post->odnoklassniki->error);
            }
            if (isset($post->vkontakte->error)) {
                $this->errorSocial($key, 'vkontakte', $post->vkontakte->error);
            }
            if (isset($post->telegram->error)) {
                $this->errorSocial($key, 'telegram', $post->telegram->error);
            }
            if (isset($post->instagram->error)) {
                $this->errorSocial($key, 'instagram', $post->instagram->error);
            }
            if (isset($post->facebook->error)) {
                $this->errorSocial($key, 'facebook', $post->facebook->error);
            }
            if (isset($post->tumblr->error)) {
                $this->errorSocial($key, 'tumblr', $post->tumblr->error);
            }
            if (isset($post->twitter->error)) {
                $this->errorSocial($key, 'twitter', $post->twitter->error);
            }

            /*
            |--------------------------------------------------------------------------
            | We save successful results
            |--------------------------------------------------------------------------
            |
            */
            if (isset($post->odnoklassniki->success)) {
                $this->successSocial($key, 'odnoklassniki', $post->odnoklassniki->success);
            }
            if (isset($post->vkontakte->success)) {
                $this->successSocial($key, 'vkontakte', $post->vkontakte->success);
            }
            if (isset($post->telegram->success)) {
                $this->successSocial($key, 'telegram', $post->telegram->success);
            }
            if (isset($post->instagram->success)) {
                $this->successSocial($key, 'instagram', $post->instagram->success);
            }
            if (isset($post->facebook->success)) {
                $this->successSocial($key, 'facebook', $post->facebook->success);
            }
            if (isset($post->tumblr->success)) {
                $this->successSocial($key, 'tumblr', $post->tumblr->success);
            }
            if (isset($post->twitter->success)) {
                $this->successSocial($key, 'twitter', $post->twitter->success);
            }

            /*
            |--------------------------------------------------------------------------
            | We update the publication status if it is published on all socials
            |--------------------------------------------------------------------------
            |
            */

            $this->updateStatus($key);
        }

    }

    /**
     * @param $post_id
     */
    public function updateStatus($post_id)
    {

        $errors = 0;
        $need_to_download_post = 0;
        $downloaded_post = 0;

        /*
        |----------------------------------------------------------------------------------
        | We count the number of publications specified by the user and the number of published
        |----------------------------------------------------------------------------------
        |
        */

        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "smmposting_post WHERE post_id = '".(int)$post_id."' ");
        $post_info = $query->row;


        if (!empty($post_info)) {
            $downloaded_post = 0;
            $downloaded_post += (int)$post_info['ok_download'];
            $downloaded_post += (int)$post_info['vk_download'];
            $downloaded_post += (int)$post_info['tg_download'];
            $downloaded_post += (int)$post_info['ig_download'];
            $downloaded_post += (int)$post_info['fb_download'];
            $downloaded_post += (int)$post_info['tb_download'];
            $downloaded_post += (int)$post_info['tw_download'];

            $need_to_download_post = 0;
            $need_to_download_post += (int)$post_info['odnoklassniki'];
            $need_to_download_post += (int)$post_info['vkontakte'];
            $need_to_download_post += (int)$post_info['telegram'];
            $need_to_download_post += (int)$post_info['instagram'];
            $need_to_download_post += (int)$post_info['facebook'];
            $need_to_download_post += (int)$post_info['tumblr'];
            $need_to_download_post += (int)$post_info['twitter'];

            if ($post_info['ok_error']) $errors++;
            if ($post_info['vk_error']) $errors++;
            if ($post_info['tg_error']) $errors++;
            if ($post_info['ig_error']) $errors++;
            if ($post_info['fb_error']) $errors++;
            if ($post_info['tb_error']) $errors++;
            if ($post_info['tw_error']) $errors++;
        }

        /*
        |----------------------------------------------------------------------------------
        | Updating status 1 - completed, status 2 - publication error
        |----------------------------------------------------------------------------------
        |
        */

        if ($need_to_download_post == $downloaded_post && $need_to_download_post != 0) {
            if ($errors > 0) {
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET status = 2 WHERE post_id = '".(int)$post_id."' ");
            } else {
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET status = 1 WHERE post_id = '".(int)$post_id."' ");
            }
        }
    }

    /*
     * Function puts a successful post to social network
     * Saves the link to the successful publication in the success field
     * At the next attempt to publish this post in the social network will not be loaded
     *
     * @param $post_id
     * @param $social_type
     * @param $success
     */
    public function successSocial($post_id, $social_type, $success)
    {
        switch($social_type){
            case 'odnoklassniki':
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET ok_download = 1 WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET ok_error = '".$this->db->escape(false)."' WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET ok_success = '".$this->db->escape($success)."' WHERE post_id = '".(int)$post_id."' ");
                break;
            case 'vkontakte':
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET vk_download = 1 WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET vk_error = '".$this->db->escape(false)."' WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET vk_success = '".$this->db->escape($success)."' WHERE post_id = '".(int)$post_id."' ");
                break;
            case 'telegram':
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tg_download = 1 WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tg_error = '".$this->db->escape(false)."' WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tg_success = '".$this->db->escape($success)."' WHERE post_id = '".(int)$post_id."' ");
                break;
            case 'instagram':
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET ig_download = 1 WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET ig_error = '".$this->db->escape(false)."' WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET ig_success = '".$this->db->escape($success)."' WHERE post_id = '".(int)$post_id."' ");
                break;
            case 'facebook':
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET fb_download = 1 WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET fb_error = '".$this->db->escape(false)."' WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET fb_success = '".$this->db->escape($success)."' WHERE post_id = '".(int)$post_id."' ");
                break;
            case 'tumblr':
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tb_download = 1 WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tb_error = '".$this->db->escape(false)."' WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tb_success = '".$this->db->escape($success)."' WHERE post_id = '".(int)$post_id."' ");
                break;
            case 'twitter':
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tw_download = 1 WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tw_error = '".$this->db->escape(false)."' WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tw_success = '".$this->db->escape($success)."' WHERE post_id = '".(int)$post_id."' ");
                break;
            default:
                break;
        }


    }

    /*
     * Function puts post error for social network
     * Stores the cause of the error in the error field
	 */
    public function errorSocial($post_id, $social_type, $error)
    {
        switch($social_type){
            case 'odnoklassniki':
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET ok_download = 2 WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET ok_success = '".$this->db->escape(false)."' WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET ok_error = '".$this->db->escape($error)."' WHERE post_id = '".(int)$post_id."' ");
                break;
            case 'vkontakte':
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET vk_download = 2 WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET vk_success = '".$this->db->escape(false)."' WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET vk_error = '".$this->db->escape($error)."' WHERE post_id = '".(int)$post_id."' ");
                break;
            case 'telegram':
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tg_download = 2 WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tg_success = '".$this->db->escape(false)."' WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tg_error = '".$this->db->escape($error)."' WHERE post_id = '".(int)$post_id."' ");
                break;
            case 'instagram':
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET ig_download = 2 WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET ig_success = '".$this->db->escape(false)."' WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET ig_error = '".$this->db->escape($error)."' WHERE post_id = '".(int)$post_id."' ");
                break;
            case 'facebook':
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET fb_download = 2 WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET fb_success = '".$this->db->escape(false)."' WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET fb_error = '".$this->db->escape($error)."' WHERE post_id = '".(int)$post_id."' ");
                break;
            case 'tumblr':
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tb_download = 2 WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tb_success = '".$this->db->escape(false)."' WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tb_error = '".$this->db->escape($error)."' WHERE post_id = '".(int)$post_id."' ");
                break;
            case 'twitter':
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tw_download = 2 WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tw_success = '".$this->db->escape(false)."' WHERE post_id = '".(int)$post_id."' ");
                $this->db->query("UPDATE " . DB_PREFIX . "smmposting_post SET tw_error = '".$this->db->escape($error)."' WHERE post_id = '".(int)$post_id."' ");
                break;
            default:
                break;
        }
    }
}