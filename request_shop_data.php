<?php
global $dotenv;
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();  // 環境変数の読み込み

class KintoneShop
{
    protected $APP_NO = 1;
    protected $ID = 1;
    private $api_key;
    private $sub_domain;

    function __construct()	{
        $this->api_key = getenv('API_TOKEN');
        $this->sub_domain = getenv('SUB_DOMAIN');

        $this->_settingRequest();
        $this->_request($this->query, $this->options);
    }

    /**
     * リクエストに関する設定
     */
    private function _settingRequest() {
        $this->options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'X-Cybozu-API-Token:' . $this->api_key ."\r\n"
            )
        );

        $this->query = array(
            'app' => $this->APP_NO,
            'id' => $this->ID
        );
    }

    /**
     * Kintone にリクエストを送信する処理
     *
     * @param array $query
     * @param array $options
     */
    private function _request($query, $options) {
        if (!isset($query) && !isset($options)) {
            return false;
        }

        $builded_query = http_build_query($query);
        $context = stream_context_create($options);
        $request_data = file_get_contents(
                        'https://' . $this->sub_domain . '.cybozu.com/k/v1/record.json' . '?' . $builded_query,
                        FALSE,
                        $context
                        );

        $this->shop_data = json_decode($request_data, true);
    }

    /**
     * リクエストデータの出力処理
     *      これをテンプレートに渡す処理やModelへデータを渡す処理に変える
     */
    public function deliverShopData() {
        // var_dump($this->shop_data);
        // return $this->shop_data;
    }
}