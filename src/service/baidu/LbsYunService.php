<?php

// +----------------------------------------------------------------------
// | ThinkLibrary 6.0 for ThinkPhP 6.0
// +----------------------------------------------------------------------
// | 版权所有 2017~2020 [ https://www.dtapp.net ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/liguangchun/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/liguangchun/ThinkLibrary
// | github 仓库地址 ：https://github.com/GC0202/ThinkLibrary
// | gitlab 仓库地址 ：https://gitlab.com/liguangchun/thinklibrary
// | weixin 仓库地址 ：https://git.weixin.qq.com/liguangchun/ThinkLibrary
// | huaweicloud 仓库地址 ：https://codehub-cn-south-1.devcloud.huaweicloud.com/composer00001/ThinkLibrary.git
// | Packagist 地址 ：https://packagist.org/packages/liguangchun/think-library
// +----------------------------------------------------------------------

namespace DtApp\ThinkLibrary\service\baidu;

use DtApp\ThinkLibrary\exception\DtaException;
use DtApp\ThinkLibrary\Service;
use DtApp\ThinkLibrary\service\curl\HttpService;

/**
 * 百度地图
 * http://lbsyun.baidu.com/index.php?title=webapi
 * Class LbsYunService
 * @package DtApp\ThinkLibrary\service\baidu
 */
class LbsYunService extends Service
{
    /**
     * @var string
     */
    private $ak = "";

    /**
     * @var string
     */
    private $output = "json";

    /**
     * @param string $ak
     * @return $this
     */
    public function ak(string $ak): self
    {
        $this->ak = $ak;
        return $this;
    }

    /**
     * 国内天气查询
     * http://lbsyun.baidu.com/index.php?title=webapi/weather
     * @param int $district_id
     * @param string $coordtype
     * @param string $location
     * @return array|bool|mixed|string
     * @throws DtaException
     */
    public function weather($district_id = 110100, string $coordtype = "bd09ll", string $location = "")
    {
        if (empty($this->ak)) {
            throw new DtaException('请检查ak参数');
        }
        $data = http_build_query([
            "district_id" => $district_id,
            "coordtype" => $coordtype,
            "ak" => $this->ak,
            "location" => $location,
            "data_type" => 'all',
            "output" => $this->output,
        ]);
        return HttpService::instance()
            ->url("http://api.map.baidu.com/weather/v1/?{$data}")
            ->toArray();
    }

    /**
     * 国外天气查询
     * http://lbsyun.baidu.com/index.php?title=webapi/weather-abroad
     * @param int $district_id
     * @param string $coordtype
     * @param string $location
     * @param string $language
     * @return array|bool|mixed|string
     * @throws DtaException
     */
    public function weatherAbroad($district_id = 110100, string $coordtype = "bd09ll", string $location = "", string $language = "cn")
    {
        if (empty($this->ak)) {
            throw new DtaException('请检查ak参数');
        }
        $data = http_build_query([
            "district_id" => $district_id,
            "coordtype" => $coordtype,
            "ak" => $this->ak,
            "location" => $location,
            "data_type" => 'all',
            "language" => $language,
            "output" => $this->output,
        ]);
        return HttpService::instance()
            ->url("http://api.map.baidu.com/weather_abroad/v1/?{$data}")
            ->toArray();
    }
}
