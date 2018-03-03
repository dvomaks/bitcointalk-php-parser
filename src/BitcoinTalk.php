<?php
/**
 * Created by PhpStorm.
 * User: dvomaks
 * Date: 24.02.18
 * Time: 15:57
 */

namespace Dvomaks\BitcoinTalkAccount;

use Dvomaks\BitcoinTalkAccount\BitcoinTalkAccount;

class BitcoinTalk {
    public static function accountUrl($url)
    {
        return new BitcoinTalkAccount($url);
    }

    public static function accountId($id)
    {
        return new BitcoinTalkAccount('https://bitcointalk.org/index.php?action=profile;u='.$id);
    }
}