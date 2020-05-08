<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace DtApp\ThinkLibrary\service;

use DtApp\ThinkLibrary\Service;

/**
 * 获取电脑MAC地址
 * Class MacService
 * @package DtApp\ThinkLibrary\service
 */
class MacService extends Service
{
    private $result = array();

    /**
     * 所有mac地址
     * @var array
     */
    private $macAddrs = array();

    /**
     * 第一个mac地址
     * @var
     */
    private $macAddr;


    public function get()
    {
        switch (strtolower(PHP_OS)) {
            case 'unix':
                break;
            case "solaris":
                break;
            case "aix":
                break;
            case "linux":
                $this->getLinux();
                break;
            default:
                $this->getWindows();
                break;
        }
        $tem = array();
        foreach ($this->result as $val) {
            if (preg_match("/[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f]/i", $val, $tem)) {
                $this->macAddr = $tem[0];//多个网卡时，会返回第一个网卡的mac地址，一般够用。
                break;
                //$this->macAddrs[] = $temp_array[0];//返回所有的mac地址
            }
        }
        unset($temp_array);
        return $this->macAddr;
    }

    /**
     * Linux系统
     * @return array
     */
    private function getLinux()
    {
        @exec("ifconfig -a", $this->result);
        return $this->result;
    }

    /**
     * Windows系统
     * @return array
     */
    private function getWindows()
    {
        @exec("ipconfig /all", $this->result);
        if ($this->result) {
            return $this->result;
        } else {
            $ipconfig = $_SERVER["WINDIR"] . "\system32\ipconfig.exe";
            if (is_file($ipconfig)) {
                @exec($ipconfig . " /all", $this->result);
                return $this->result;
            } else {
                @exec($_SERVER["WINDIR"] . "\system\ipconfig.exe /all", $this->result);
                return $this->result;
            }
        }
    }
}