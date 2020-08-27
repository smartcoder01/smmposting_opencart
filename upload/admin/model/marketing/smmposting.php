<?php

/**
 * @package SMM-Posting for Opencart 2.3-3.0
 * @version 2.0
 * @author smartcoder
 * @copyright https://smm-posting.ru
 */


class ModelMarketingSmmposting extends Model {

    function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->language('marketing/smmposting');
    }

    public function checkInstall()
    {

        /*
        |--------------------------------------------------------------------------
        | Check Tables
        |--------------------------------------------------------------------------
        |
        */
        $table = 'smmposting_accounts';
        $sql = " SHOW TABLES LIKE '".DB_PREFIX.$table."'";
        $query = $this->db->query( $sql );
        if( count($query->rows) > 0 ){
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | SMM-posting Clear Tables
        |--------------------------------------------------------------------------
        |
        */
        $table = 'smmposting_accounts';
        $sql = " SHOW TABLES LIKE '".DB_PREFIX.$table."'";
        $query = $this->db->query( $sql );
        if( count($query->rows) > 0 ) {
            $sql = "DROP TABLE " . DB_DATABASE . "." . DB_PREFIX . $table;
            $query = $this->db->query($sql);
        }


        $table = 'smmposting_image';
        $sql = " SHOW TABLES LIKE '".DB_PREFIX.$table."'";
        $query = $this->db->query( $sql );
        if( count($query->rows) > 0 ) {
            $sql = "DROP TABLE " . DB_DATABASE . "." . DB_PREFIX . $table;
            $query = $this->db->query($sql);
        }


        $table = 'smmposting_post';
        $sql = " SHOW TABLES LIKE '".DB_PREFIX.$table."'";
        $query = $this->db->query( $sql );
        if( count($query->rows) > 0 ) {
            $sql = "DROP TABLE " . DB_DATABASE . "." . DB_PREFIX . $table;
            $query = $this->db->query($sql);
        }

        $table = 'smmposting_projects';
        $sql = " SHOW TABLES LIKE '".DB_PREFIX.$table."'";
        $query = $this->db->query( $sql );
        if( count($query->rows) > 0 ) {
            $sql = "DROP TABLE " . DB_DATABASE . "." . DB_PREFIX . $table;
            $query = $this->db->query($sql);
        }



        /*
        |--------------------------------------------------------------------------
        | SMM-posting Install Tables
        |--------------------------------------------------------------------------
        |
        */

        //  Install table smmposting_accounts
        $sql = "CREATE TABLE IF NOT EXISTS `".DB_DATABASE."`.`".DB_PREFIX."smmposting_accounts` (
                                `account_id` int(11) NOT NULL AUTO_INCREMENT,
                                `user_id` varchar(64) NOT NULL,
                                `account_name` varchar(255) NOT NULL,
                                `social` varchar(255) NOT NULL,
                                `instagram_login` varchar(255) NOT NULL,
                                `instagram_password` varchar(255) NOT NULL,
                                `telegram_token` varchar(255) NOT NULL,
                                `vk_user_id` varchar(255) NOT NULL,
                                `vk_access_token` varchar(255) NOT NULL,
                                `ok_user_id` varchar(255) NOT NULL,
                                `ok_access_token` varchar(255) NOT NULL,
                                `fb_access_token` varchar(255) NOT NULL,
                                `fb_user_id` varchar(255) NOT NULL,
                                `tw_oauth_token` varchar(255) NOT NULL,
                                `tw_oauth_token_secret` varchar(255) NOT NULL,
                                `tb_oauth_token` varchar(255) NOT NULL,
                                `tb_oauth_verifier` varchar(255) NOT NULL,
                                `tb_oauth_token_secret` varchar(255) NOT NULL,
                                `status` tinyint(1) NOT NULL,
                                `date_added` datetime NOT NULL,
                                PRIMARY KEY (`account_id`)) ENGINE = MyISAM";

        $query = $this->db->query( $sql );


//  Install table smmposting_image
        $sql = "CREATE TABLE IF NOT EXISTS `".DB_DATABASE."`.`".DB_PREFIX."smmposting_image` (
                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                `post_id` int(11) NOT NULL,
                                `image` varchar(255) NOT NULL,
                                `filename` varchar(255) NOT NULL,
                                PRIMARY KEY (`id`)) ENGINE = MyISAM";

        $query = $this->db->query( $sql );


//  Install table smmposting_post
        $sql = "CREATE TABLE IF NOT EXISTS `".DB_DATABASE."`.`".DB_PREFIX."smmposting_post` (
                                `post_id` int(11) NOT NULL AUTO_INCREMENT,
                                `project_id` int(11) NOT NULL,
                                `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `status` tinyint(1) NOT NULL,
                                `odnoklassniki` int(11) NOT NULL,
                                `vkontakte` int(11) NOT NULL,
                                `telegram` int(11) NOT NULL,
                                `instagram` int(11) NOT NULL,
                                `facebook` int(11) NOT NULL,
                                `tumblr` int(11) NOT NULL,
                                `twitter` int(11) NOT NULL,
                                `vk_download` int(11) NOT NULL,
                                `ok_download` int(11) NOT NULL,
                                `tg_download` int(11) NOT NULL,
                                `ig_download` int(11) NOT NULL,
                                `fb_download` int(11) NOT NULL,
                                `tb_download` int(11) NOT NULL,
                                `tw_download` int(11) NOT NULL,
                                `vk_success` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `ok_success` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `tg_success` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `ig_success` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `fb_success` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `tb_success` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `tw_success` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `ok_error` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `vk_error` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `tg_error` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `ig_error` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `fb_error` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `tb_error` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `tw_error` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                `ig_like` int(11) NOT NULL,
                                `ig_comment` text NOT NULL,
                                `vk_from_group` int(11) NOT NULL,
                                `vk_comment` text NOT NULL,
                                `date_public` date NOT NULL,
                                `time_public` time NOT NULL,
                                PRIMARY KEY (`post_id`))
                                ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        $query = $this->db->query( $sql );

        //  Install table smmposting_projects
        $sql = "CREATE TABLE IF NOT EXISTS `".DB_DATABASE."`.`".DB_PREFIX."smmposting_projects` (
                                `project_id` int(11) NOT NULL AUTO_INCREMENT,
                                `user_id` varchar(64) NOT NULL,
                                `project_name` varchar(255) NOT NULL,
                                `project_description` varchar(255) NOT NULL,
                                `ok_account_id` int(11) DEFAULT NULL,
                                `vk_account_id` int(11) DEFAULT NULL,
                                `tg_account_id` int(11) DEFAULT NULL,
                                `ig_account_id` int(11) DEFAULT NULL,
                                `fb_account_id` int(11) DEFAULT NULL,
                                `tb_account_id` int(11) DEFAULT NULL,
                                `tw_account_id` int(11) DEFAULT NULL,
                                `telegram_chat_id` varchar(255) NOT NULL,
                                `vk_group_id` varchar(255) NOT NULL,
                                `ok_group_id` varchar(255) NOT NULL,
                                `fb_group_id` varchar(255) NOT NULL,
                                `status` tinyint(1) NOT NULL,
                                `date_added` datetime NOT NULL,
                                PRIMARY KEY (`project_id`)) ENGINE = MyISAM";
        $query = $this->db->query( $sql );
    }
	##  BEGIN PROJECTS
	####################################################################
    public function addProject($data){
        $this->db->query("INSERT "."INTO " . DB_PREFIX . "smmposting_projects SET 
                                project_name = '" . $this->db->escape($data['project_name']) . "', 
                                status = '" . $this->db->escape($data['status']) . "', 
                                ok_account_id = '" . (int)(isset($data['ok_account_id']) ? $data['ok_account_id'] : null) . "', 
                                vk_account_id = '" . (int)(isset($data['vk_account_id']) ? $data['vk_account_id'] : null) . "', 
                                tg_account_id = '" . (int)(isset($data['tg_account_id']) ? $data['tg_account_id'] : null) . "', 
                                ig_account_id = '" . (int)(isset($data['ig_account_id']) ? $data['ig_account_id'] : null) . "', 
                                fb_account_id = '" . (int)(isset($data['fb_account_id']) ? $data['fb_account_id'] : null) . "', 
                                tb_account_id = '" . (int)(isset($data['tb_account_id']) ? $data['tb_account_id'] : null) . "',
                                tw_account_id = '" . (int)(isset($data['tw_account_id']) ? $data['tw_account_id'] : null) . "', 
                                ok_group_id = '" . $this->db->escape((isset($data['ok_group_id']) ? $data['ok_group_id'] : null)) . "', 
                                vk_group_id = '" . $this->db->escape((isset($data['vk_group_id']) ? $data['vk_group_id'] : null)) . "',  
                                fb_group_id = '" . $this->db->escape((isset($data['fb_group_id']) ? $data['fb_group_id'] : null)) . "',
                                telegram_chat_id = '" . $this->db->escape((isset($data['telegram_chat_id']) ? $data['telegram_chat_id'] : null)) . "',
                                date_added = NOW()");

        $project_id = $this->db->getLastId();

        if ($data['project_name'] == '') {
            $data['project_name'] = $this->getFromLanguage('text_project').' #'.$project_id;
            $data['project_id'] = $project_id;
            $this->editProject($data);
        }

    }
    public function editProject($data) {

        if ($data['project_name'] == '') {
            $data['project_name'] = $this->getFromLanguage('text_project').' #'.$data['project_id'];
        }

        $this->db->query("UPDATE " . DB_PREFIX . "smmposting_projects SET 
                                project_name = '" . $this->db->escape($data['project_name']) . "', 
                                status = '" . $this->db->escape($data['status']) . "', 
                                ok_account_id = '" . (int)(isset($data['ok_account_id']) ? $data['ok_account_id'] : null) . "', 
                                vk_account_id = '" . (int)(isset($data['vk_account_id']) ? $data['vk_account_id'] : null) . "', 
                                tg_account_id = '" . (int)(isset($data['tg_account_id']) ? $data['tg_account_id'] : null) . "', 
                                ig_account_id = '" . (int)(isset($data['ig_account_id']) ? $data['ig_account_id'] : null) . "', 
                                fb_account_id = '" . (int)(isset($data['fb_account_id']) ? $data['fb_account_id'] : null) . "', 
                                tb_account_id = '" . (int)(isset($data['tb_account_id']) ? $data['tb_account_id'] : null) . "',
                                tw_account_id = '" . (int)(isset($data['tw_account_id']) ? $data['tw_account_id'] : null) . "', 
                                ok_group_id = '" . $this->db->escape((isset($data['ok_group_id']) ? $data['ok_group_id'] : null)) . "', 
                                vk_group_id = '" . $this->db->escape((isset($data['vk_group_id']) ? $data['vk_group_id'] : null)) . "',  
                                fb_group_id = '" . $this->db->escape((isset($data['fb_group_id']) ? $data['fb_group_id'] : null)) . "',
                                telegram_chat_id = '" . $this->db->escape((isset($data['telegram_chat_id']) ? $data['telegram_chat_id'] : null)) . "'
                            WHERE project_id = '" . $this->db->escape($data['project_id']) . "'");
    }
	public function getProject($project_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "smmposting_projects WHERE project_id = '" . (int)$project_id . "'");

		return $query->row;
	}
	public function getProjects() {
		$sql = "SELECT * FROM `" . DB_PREFIX . "smmposting_projects` ORDER BY project_id";

		$query = $this->db->query($sql);

		return $query->rows;
	}
	public function getTotalProjects() {
		$sql = "SELECT COUNT(*) AS project_id FROM `" . DB_PREFIX . "smmposting_projects` ";

		$query = $this->db->query($sql);

		return $query->row['project_id'];
	}
    public function deleteProject($project_id) {
        return $this->db->query("DELETE FROM " . DB_PREFIX . "smmposting_projects WHERE project_id = '" . (int)$project_id . "' ");
    }
	####################################################################
	##  END PROJECTS



	##	BEGIN POSTS
	####################################################################
	public function getPosts( $data ){

		$query = 'SELECT * FROM '.DB_PREFIX.'smmposting_post';
		$query .= ' WHERE post_id > 0';

		if( isset($data['filter_status']) ){
			$query .= ' AND status='.$data['filter_status'];
		}

		if( isset($data['filter_today']) ){
			$today  = date('Y-m-d');
			$query .= " AND DATE(date_public) = DATE('". $this->db->escape($today) ."') " ;
		}

		if( isset($data['filter_tomorrow']) ){
			$tomorrow  = date('Y-m-d', strtotime("+1 day"));
			$query .= " AND DATE(date_public) = DATE('". $this->db->escape($tomorrow) ."') " ;
		}

		if( isset($data['filter_aftertomorrow']) ){
			$aftertomorrow  = date('Y-m-d', strtotime("+2 day"));
			$query .= " AND DATE(date_public) = DATE('". $this->db->escape($aftertomorrow) ."') " ;
		}

		if( isset($data['filter_project']) ){
			$query .= " AND project_id = '" . (int)$data['filter_project']."'";
		}


		$query .= " ORDER BY post_id DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$query .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}




		$query = $this->db->query( $query );
		$posts = $query->rows;
		return $posts;
	}
	public function getPost( $post_id ){
		$query = 'SELECT DISTINCT * FROM '.DB_PREFIX.'smmposting_post WHERE post_id = '.(int)$post_id;
		$query = $this->db->query( $query );
		return $query->row;
	}
	public function getImages( $post_id ) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "smmposting_image` WHERE post_id = ".(int)$post_id." ORDER BY id ASC ";

        $query = $this->db->query($sql);

        return $query->rows;
    }
    public function getFirstImage($post_id)
    {
        $this->load->model('tool/image');

        $images = self::getImages($post_id);

        if (isset($images[0]['image'])) {
            $image = '/image/'.$images[0]['image'];
        } else {
            $image = null;
        }

        return $image;
    }
    public function getProjectName($project_id)
    {
        $project = self::getProject($project_id);

        if (!empty($project)) {
            $name = $project['project_name'];
        } else {
            $name = $this->language->get('text_project').' #'.$project_id;
        }

        return $name;
    }
	public function savePost( $request ){

        $data = $request->post['smmposting_post'];
        $images = isset($request->post['images']) ? $request->post['images'] : array();

	    if (isset($request->get['id'])) {
            $data['post_id'] = $request->get['id'];

            $sql = " UPDATE  ". DB_PREFIX . "smmposting_post SET  ";
            $tmp = array();
            foreach( $data as $key => $value ){
                if( $key != "post_id" ){
                    $tmp[] = "`".$key."`='".$this->db->escape($value)."'";
                }
            }
            $sql .= implode( " , ", $tmp );
            $sql .= " WHERE post_id=".$data['post_id'];
            $this->db->query( $sql );
        } else {
            $sql = "INSERT INTO ".DB_PREFIX . "smmposting_post ( `";
            $tmp = array();
            $vals = array();
            foreach( $data as $key => $value ){
                $tmp[] = $key;
                $vals[]=$this->db->escape($value);
            }

            $sql .= implode("` , `",$tmp)."`) VALUES ('".implode("','",$vals)."') ";

            $this->db->query( $sql );
            $data['post_id'] = $this->db->getLastId();
        }

	    $this->saveImages($images, $data['post_id']);
		return $data['post_id'];
	}
    public function saveImages( $images_data, $post_id ){

        $sql = "DELETE FROM " . DB_PREFIX . "smmposting_image WHERE post_id = '" . (int)$post_id . "'  ";
        $query = $this->db->query( $sql );

        if (!empty($images_data)) {
            foreach ($images_data as $key => $image) {
                $sql = "INSERT INTO " . DB_PREFIX . "smmposting_image SET image = '" . $this->db->escape($image) . "', post_id = '" . (int)$post_id . "'  ";
                $query = $this->db->query( $sql );
            }
        }


    }
    public function getpostProducts($post_id = 0){
		$product_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "smmposting_product WHERE post_id = '" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$product_related_data[] = $result['product_id'];
		}

		return $product_related_data;
	}
	public function delete( $id ){

		if( $id ) {
			$sql = " DELETE FROM ".DB_PREFIX."smmposting_post WHERE post_id=".(int)$id;
			$res = $this->db->query( $sql );
			return $res;
		}
	}
	public function getTotalPosts($data = array()) {
		$sql = "SELECT COUNT(*) AS post_id FROM `" . DB_PREFIX . "smmposting_post` WHERE status=1";

		$query = $this->db->query($sql);

		return $query->row['post_id'];
	}
	public function getTotalPostsForPagination($data = array(), $filter=array()) {
		$query = "SELECT COUNT(*) AS post_id FROM `" . DB_PREFIX . "smmposting_post` WHERE post_id > 0 ";

		if( isset($data['filter_status']) ){
			$query .= ' AND status='.$data['filter_status'];
		}

		if( isset($data['filter_today']) ){
			$today  = date('Y-m-d');
			$query .= " AND DATE(date_public) = DATE('". $this->db->escape($today) ."') " ;
		}

		if( isset($data['filter_tomorrow']) ){
			$tomorrow  = date('Y-m-d', strtotime("+1 day"));
			$query .= " AND DATE(date_public) = DATE('". $this->db->escape($tomorrow) ."') " ;
		}

		if( isset($data['filter_aftertomorrow']) ){
			$aftertomorrow  = date('Y-m-d', strtotime("+2 day"));
			$query .= " AND DATE(date_public) = DATE('". $this->db->escape($aftertomorrow) ."') " ;
		}

		if( isset($data['filter_project']) ){
			$query .= " AND project_id = '" . (int)$data['filter_project']."'";
		}

		$query = $this->db->query($query);

		return $query->row['post_id'];
	}
	####################################################################
	##  END POSTS


    ##	BEGIN PRODUCTS
    ####################################################################
    public function getProducts($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        if (!empty($data['filter_name'])) {
            $sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (!empty($data['filter_model'])) {
            $sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
        }

        if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
            $sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
        }

        if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
            $sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
        }

        if (isset($data['filter_image']) && !is_null($data['filter_image'])) {
            if ($data['filter_image'] == 1) {
                $sql .= " AND (p.image IS NOT NULL AND p.image <> '' AND p.image <> 'no_image.png')";
            } else {
                $sql .= " AND (p.image IS NULL OR p.image = '' OR p.image = 'no_image.png')";
            }
        }

        $sql .= " GROUP BY p.product_id";

        $sort_data = array(
            'pd.name',
            'p.model',
            'p.price',
            'p.quantity',
            'p.status',
            'p.sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY pd.name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }
    ####################################################################
    ##	END PRODUCTS


    ##	BEGIN ACCOUNTS
    ####################################################################
    public function getAccount($account_id) {
        $query = $this->db->query("SELECT * FROM ". DB_PREFIX ."smmposting_accounts WHERE account_id = '".(int)$account_id."' ");
        return $query->row;
    }
    public function deleteAccount($account_id) {
        $query = $this->db->query("DELETE FROM " . DB_PREFIX . "smmposting_accounts WHERE account_id = '" . (int)$account_id . "' ");
        return $query;
    }
    public function getAccounts($social=false)
    {
        $sql = "SELECT * FROM ". DB_PREFIX ."smmposting_accounts ";

        if ($social) {
            $sql .= "WHERE social = '".$this->db->escape($social)."'";
        }

        $sql .= " ORDER BY account_id DESC";

        $query = $this->db->query($sql);

//        echo "<pre>";
//        print_r($query); die;
        return $query->rows;
    }
    public function save_ok($ok_name,$ok_user_id,$access_token)
    {
        $sql = "SELECT * FROM ". DB_PREFIX ."smmposting_accounts WHERE ok_user_id = " . $this->db->escape($ok_user_id);
        $query = $this->db->query($sql);

        if (empty($query->rows)) {
            $sql = "INSERT INTO ". DB_PREFIX ."smmposting_accounts 
								SET 
									status = '" . 1 . "', 
									account_name = '" . $this->db->escape($ok_name) . "', 
									ok_access_token = '" . $this->db->escape($access_token) . "', 
									ok_user_id = '" . $this->db->escape($ok_user_id) . "', 
									social = 'odnoklassniki',
									date_added = NOW()
								";
            $query = $this->db->query($sql);

            $this->session->data['success'] = $this->language->get('text_account') . " " .$ok_name ." " . $this->language->get('text_in_social_network') . " " . $this->language->get('text_ok') . " " . $this->language->get('text_added');
        } else {
            $sql = "UPDATE ". DB_PREFIX ."smmposting_accounts 
								SET 
									account_name = '" . $this->db->escape($ok_name) . "', 
									status = '" . (int)1 . "', 
									ok_access_token = '" . $this->db->escape($access_token) . "'
								WHERE
									ok_user_id = '" . $this->db->escape($ok_user_id) . "'
								";
            $query = $this->db->query($sql);

            $this->session->data['success'] = $this->language->get('text_account') . " " .$ok_name ." " . $this->language->get('text_in_social_network') . " " . $this->language->get('text_ok') . " " . $this->language->get('text_updated');
        }
    }
    public function save_vk($vk_name,$vk_user_id, $access_token)
    {
        $sql = "SELECT * FROM ". DB_PREFIX ."smmposting_accounts WHERE vk_user_id = '" . $this->db->escape($vk_user_id) . "'";
        $query = $this->db->query($sql);

        if (empty($query->rows)) {
            $sql = "INSERT INTO ". DB_PREFIX ."smmposting_accounts 
								SET 
									status = '" . (int)1 . "',
									account_name = '" . $this->db->escape($vk_name) . "', 
									vk_access_token = '" . $this->db->escape($access_token) . "', 
									vk_user_id = '" . $this->db->escape($vk_user_id) . "', 
									social = 'vkontakte',
									date_added = NOW()
								";
            $query = $this->db->query($sql);

            $this->session->data['success'] = $this->language->get('text_account') . " " .$vk_name ." " . $this->language->get('text_in_social_network') . " " . $this->language->get('text_vk') . " " . $this->language->get('text_added');
        } else {
            $sql = "UPDATE ". DB_PREFIX ."smmposting_accounts 
								SET 
									account_name = '" . $this->db->escape($vk_name) . "', 
									status = '" . (int)1 . "',
									vk_access_token = '" . $this->db->escape($access_token) . "'
								WHERE
									vk_user_id = '" . $this->db->escape($vk_user_id) . "'
								";
            $query = $this->db->query($sql);
            $this->session->data['success'] = $this->language->get('text_account') . " " .$vk_name ." " . $this->language->get('text_in_social_network') . " " . $this->language->get('text_vk') . " " . $this->language->get('text_updated');
        }
    }
    public function save_tg($tg_name, $access_token)
    {
        $sql = "SELECT * FROM ". DB_PREFIX ."smmposting_accounts WHERE account_name = '" . $this->db->escape($tg_name) . "' AND  social = 'telegram' ";
        $query = $this->db->query($sql);

        if (empty($query->rows)) {
            $sql = "INSERT INTO ". DB_PREFIX ."smmposting_accounts 
								SET 
									account_name = '" . $this->db->escape($tg_name) . "', 
									telegram_token = '" . $this->db->escape($access_token) . "', 
									social = 'telegram',
									status = 1,
									date_added = NOW()
								";
            $query = $this->db->query($sql);

            $this->session->data['success'] = $this->language->get('text_account') . " " .$tg_name ." " . $this->language->get('text_in_social_network') . " " .  $this->language->get('text_tg') . " " . $this->language->get('text_added');

        } else {
            $sql = "UPDATE ". DB_PREFIX ."smmposting_accounts 
								SET 
								    account_name = '" . $this->db->escape($tg_name) . "', 
									telegram_token = '" . $this->db->escape($access_token) . "', 
									status = 1 
								WHERE
									account_name = '" . $this->db->escape($tg_name) . "'
								";
            $query = $this->db->query($sql);
            $this->session->data['success'] = $this->language->get('text_account') . " " .$tg_name ." " . $this->language->get('text_in_social_network') . " " .  $this->language->get('text_tg') . " " . $this->language->get('text_updated');
        }
    }
    public function save_ig($login, $password)
    {
        if ($login == '') {
            $this->session->data['error_warning'] = 'Необходимо заполнить логин';
            return false;
        }
        if ($password == '') {
            $this->session->data['error_warning'] = 'Необходимо заполнить пароль';
            return false;
        }
        $sql = "SELECT * FROM ". DB_PREFIX ."smmposting_accounts WHERE instagram_login = '" . $this->db->escape($login) . "'";
        $query = $this->db->query($sql);

        if (empty($query->rows)) {
            $sql = "INSERT INTO ". DB_PREFIX ."smmposting_accounts 
								SET 
									account_name = '" . $this->db->escape($login) . "', 
									instagram_login = '" . $this->db->escape($login) . "', 
									instagram_password = '" . $this->db->escape($password) . "', 
									social = 'instagram',
									status = '" . (int)1 . "',
									date_added = NOW()
								";
            $this->db->query($sql);

            $this->session->data['success'] = $this->language->get('text_account') . " " .$login . " " . $this->language->get('text_in_social_network') . " " . $this->language->get('text_ig') . " " . $this->language->get('text_added');

        } else {
            $sql = "UPDATE ". DB_PREFIX ."smmposting_accounts 
								SET 
									account_name = '" . $this->db->escape($login) . "',
									instagram_login = '" . $this->db->escape($login) . "', 
									instagram_password = '" . $this->db->escape($password) . "',
									status = 1
								WHERE 
								    instagram_login = '" . $this->db->escape($login) . "'";
            $this->db->query($sql);
            $this->session->data['success'] = $this->language->get('text_account') . " " .$login . " " . $this->language->get('text_in_social_network') . " " . $this->language->get('text_ig') . " " . $this->language->get('text_updated');
        }
    }
    public function save_fb($fb_name,$fb_user_id, $access_token)
    {
        $sql = "SELECT * FROM ". DB_PREFIX ."smmposting_accounts WHERE fb_user_id = '" . $this->db->escape($fb_user_id) . "'";
        $query = $this->db->query($sql);

        if (empty($query->rows)) {
            $sql = "INSERT INTO ". DB_PREFIX ."smmposting_accounts 
								SET 
									status = '" . (int)1 . "',
									account_name = '" . $this->db->escape($fb_name) . "', 
									fb_access_token = '" . $this->db->escape($access_token) . "', 
									fb_user_id = '" . $this->db->escape($fb_user_id) . "', 
									social = 'facebook',
									date_added = NOW()
								";
            $query = $this->db->query($sql);

            $this->session->data['success'] = $this->language->get('text_account') . " " .$fb_name ." " . $this->language->get('text_in_social_network') . " " . $this->language->get('text_fb') . " " . $this->language->get('text_added');
        } else {
            $sql = "UPDATE ". DB_PREFIX ."smmposting_accounts 
								SET 
									account_name = '" . $this->db->escape($fb_name) . "', 
									status = '" . (int)1 . "',
									fb_access_token = '" . $this->db->escape($access_token) . "'
								WHERE
									fb_user_id = '" . $this->db->escape($fb_user_id) . "'
								";
            $query = $this->db->query($sql);
            $this->session->data['success'] = $this->language->get('text_account') . " " .$fb_name ." " . $this->language->get('text_in_social_network') . " " . $this->language->get('text_fb') . " " . $this->language->get('text_updated');
        }
    }
    public function save_tw($name, $oauth_token, $oauth_verifier)
    {
        $sql = "SELECT * FROM ". DB_PREFIX ."smmposting_accounts WHERE account_name = '" . $this->db->escape($name) . "' AND social='twitter'" ;
        $query = $this->db->query($sql);

        if (empty($query->rows)) {
            $sql = "INSERT INTO ". DB_PREFIX ."smmposting_accounts 
								SET 
									status = '" . (int)1 . "',
									account_name = '" . $this->db->escape($name) . "', 
									tw_oauth_token = '" . $this->db->escape($oauth_token) . "', 
									tw_oauth_token_secret = '" . $this->db->escape($oauth_verifier) . "', 
									social = 'twitter',
									date_added = NOW()
								";
            $query = $this->db->query($sql);

            $this->session->data['success'] = $this->language->get('text_account') . " " .$name ." " . $this->language->get('text_in_social_network') . " " . $this->language->get('text_tw') . " " . $this->language->get('text_added');
        } else {
            $sql = "UPDATE ". DB_PREFIX ."smmposting_accounts 
								SET 
									account_name = '" . $this->db->escape($name) . "', 
									status = '" . (int)1 . "',
                                    tw_oauth_token = '" . $this->db->escape($oauth_token) . "', 
									tw_oauth_token_secret = '" . $this->db->escape($oauth_verifier) . "'
								WHERE
									account_name = '" . $this->db->escape($name) . "' 
								AND
									social = 'twitter'
								";
            $query = $this->db->query($sql);
            $this->session->data['success'] = $this->language->get('text_account') . " " .$name ." " . $this->language->get('text_in_social_network') . " " . $this->language->get('text_tw') . " " . $this->language->get('text_updated');
        }
    }
    public function save_tb($name, $oauth_token, $oauth_verifier, $oauth_token_secret)
    {
        $sql = "SELECT * FROM ". DB_PREFIX ."smmposting_accounts WHERE account_name = '" . $this->db->escape($name) . "' AND social='tumblr'" ;
        $query = $this->db->query($sql);

        if (empty($query->rows)) {
            $sql = "INSERT INTO ". DB_PREFIX ."smmposting_accounts 
								SET 
									status = '" . (int)1 . "',
									account_name = '" . $this->db->escape($name) . "', 
									tb_oauth_token = '" . $this->db->escape($oauth_token) . "', 
									tb_oauth_verifier = '" . $this->db->escape($oauth_verifier) . "', 
									tb_oauth_token_secret = '" . $this->db->escape($oauth_token_secret) . "', 
									social = 'tumblr',
									date_added = NOW()
								";
            $query = $this->db->query($sql);

            $this->session->data['success'] = $this->language->get('text_account') . " " .$name ." " . $this->language->get('text_in_social_network') . " " . $this->language->get('text_tb') . " " . $this->language->get('text_added');
        } else {
            $sql = "UPDATE ". DB_PREFIX ."smmposting_accounts 
								SET 
									account_name = '" . $this->db->escape($name) . "', 
									status = '" . (int)1 . "',
                                    tb_oauth_token = '" . $this->db->escape($oauth_token) . "', 
									tb_oauth_verifier = '" . $this->db->escape($oauth_verifier) . "',
									tb_oauth_token_secret = '" . $this->db->escape($oauth_token_secret) . "' 
								WHERE
									account_name = '" . $this->db->escape($name) . "' 
								AND
									social = 'tumblr'
								";
            $query = $this->db->query($sql);
            $this->session->data['success'] = $this->language->get('text_account') . " " .$name ." " . $this->language->get('text_in_social_network') . " " . $this->language->get('text_tb') . " " . $this->language->get('text_updated');
        }
    }
    ####################################################################
    ##	END ACCOUNTS


} ?>