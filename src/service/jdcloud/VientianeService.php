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

namespace DtApp\ThinkLibrary\service\jdcloud;

use DtApp\ThinkLibrary\Service;
use DtApp\ThinkLibrary\service\curl\HttpService;

/**
 * 京东万象
 * https://wx.jdcloud.com/
 * Class VientianeService
 * @package DtApp\ThinkLibrary\service\jdcloud
 */
class VientianeService extends Service
{
    /**
     * @var
     */
    private $url, $param, $app_key;

    /**
     * 您申请的appkey
     * @param string $appKey
     * @return $this
     */
    public function appKey(string $appKey): self
    {
        $this->app_key = $appKey;
        return $this;
    }

    /**
     * 组参
     * @param array $param
     * @return $this
     */
    public function param(array $param): self
    {
        $this->param = $param;
        return $this;
    }

    /**
     * 空气质量实时数据
     * https://wx.jdcloud.com/market/datas/26/1656
     * @return array|bool|mixed|string
     */
    public function pm25Cities()
    {
        $this->url = "https://way.jd.com/pm25/cities";
        return $this->http();
    }

    /**
     * 中国和世界天气预报
     * https://wx.jdcloud.com/market/datas/26/10610
     */
    public function heFreeWeather()
    {
        $this->url = "https://way.jd.com/he/freeweather";
        return $this->http();
    }

    /**
     * 全国天气预报
     * https://wx.jdcloud.com/market/datas/26/11065
     */
    public function jiSuApiWeather()
    {
        $this->url = "https://way.jd.com/jisuapi/weather";
        return $this->http();
    }

    /**
     * 菜谱大全
     * https://wx.jdcloud.com/market/datas/26/11072
     */
    public function jiSuApiSearch()
    {
        $this->url = "https://way.jd.com/jisuapi/search";
        return $this->http();
    }

    /**
     * IP商圈字典
     * https://wx.jdcloud.com/market/datas/26/13432
     */
    public function rtBaSiaIpAreaDict()
    {
        $this->url = "https://way.jd.com/RTBAsia/ip_area_dict";
        return $this->http();
    }

    /**
     * 请求
     * @return array|bool|mixed|string
     */
    private function http()
    {
        $this->param['appkey'] = $this->app_key;
        $this->param = http_build_query($this->param);
        return HttpService::instance()
            ->url("{$this->url}?{$this->param}")
            ->toArray();
    }
}
