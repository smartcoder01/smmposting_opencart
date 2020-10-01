<?php
/**
 * @package  : SMM-Posting API
 * @version 2.0
 * @author vladgaus & smartcoder
 * @copyright https://smm-posting.ru
 */

class Smmposting
{
    public static $domain = 'https://smm-posting.ru/';
    public static $api_version = 2;
    private $api_token;

    /**
     * Smmposting constructor.
     * @param $api_token
     * @param int $api_version
     */
    public function __construct($api_token, $api_version = 2)
    {
        $this->api_token    = $api_token;
        self::$api_version  = $api_version;
    }

    /**
     * @param $api_method
     * @param array $params
     * @param string $http_method
     * @return bool|string
     */
    public function api($api_method, $params = array(), $http_method = "GET") {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::$domain."api/v".self::$api_version."/smmposting/$api_method?api_token=$this->api_token&".http_build_query($params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $http_method,
            CURLOPT_HTTPHEADER => array(
                "cms: opencart"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode((string)$response);
    }

    /**
     * Auth links to socials
     * @return array
     */
    public static function getAuthLinks()
    {
        return [
            'ok_auth_link' => self::$domain . 'api/v'.self::$api_version.'/smmposting/ok_auth', // Odnoklassniki
            'vk_auth_link' => self::$domain . 'api/v'.self::$api_version.'/smmposting/vk_auth', // Vkontakte
            'tg_auth_link' => self::$domain . 'api/v'.self::$api_version.'/smmposting/tg_auth', // Telegram
            'fb_auth_link' => self::$domain . 'api/v'.self::$api_version.'/smmposting/fb_auth', // Facebook
            'tb_auth_link' => self::$domain . 'api/v'.self::$api_version.'/smmposting/tb_auth', // Tumblr
            'tw_auth_link' => self::$domain . 'api/v'.self::$api_version.'/smmposting/tw_auth', // Twitter
            'ig_auth_link' => self::$domain . 'api/v'.self::$api_version.'/smmposting/ig_auth', // Instagram
        ];
    }

    public static function dd($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die;
    }

    public static function dump($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }


}