<?php
/**
 * Created by PhpStorm.
 * User: dvomaks
 * Date: 24.02.18
 * Time: 10:43
 */

namespace Dvomaks\BitcoinTalk;

use Sunra\PhpSimple\HtmlDomParser;

class BitcoinTalkAccount {

    public $account_url;
    public $account = [];
    protected $html = null;

    public function __construct($account_url)
    {
        $this->account_url = $account_url;
        $this->load();
    }

    public function __get($name)
    {
        return $this->account[$name];
    }

    /**
     * Load account page html
     */
    public function load(){
        if(is_null($this->html)){
            $this->html = HtmlDomParser::file_get_html($this->account_url);

            $row = $this->html->find('td[class=windowbg]', 0);

            if(is_null($row)){
                return;
            }

            foreach ($row->find('tr') as $tr){
                $td = $tr->find('td');
                $key = $this->toSnakeCase($td[0]->plaintext);

                if($key !== ""){
                    $this->account[$key] = $this->strFormatter($td[1]->plaintext);
                }

                if($key == "local_time"){
                    break;
                }
            }

            $signature = $row->find('div[class=signature]', 0);
            $this->account['signature_code'] = $signature->innertext;
            $this->account['signature_hash'] = md5($signature->innertext);

            $avatar = $this->html->find('img[class=avatar]',0);
            if(is_null($avatar)){
                $this->account['avatar_url'] = null;
            } else {
                $this->account['avatar_url'] = 'https://bitcointalk.org' . $avatar->src;
            }
        }
    }

    /**
     * Clear string
     *
     * @param $str
     * @return mixed|string
     */
    private function strFormatter($str){
        $str = trim($str);
        $str = str_replace("\t", "", $str);
        return $str;
    }

    /**
     * Convert string to snake case format
     *
     * @param $str
     * @return mixed|string
     */
    private function toSnakeCase($str)
    {
        $str = trim($str);
        $str = strtolower($str);
        $str = preg_replace ("/[^a-zA-Z0-9\s]/","",$str);
        $str = str_replace(" ", "_", $str);
        return $str;
    }

    /**
     * Return avatar image base64 string
     *
     * @return null|string
     */
    public function avatar()
    {
        if(is_null($this->account['avatar_url'])){
            return null;
        }

        return 'data:image/png;base64,' . base64_encode(file_get_contents($this->account['avatar_url']));
    }

}