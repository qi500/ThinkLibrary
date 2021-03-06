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

declare (strict_types=1);

namespace DtApp\ThinkLibrary\helper;

use DtApp\ThinkLibrary\exception\DtaException;

/**
 * XML管理类
 * @mixin Xmls
 * @package DtApp\ThinkLibrary\helper
 */
class Xmls
{
    /**
     * 数组转换为xml
     * @param array $values 数组
     * @return string
     * @throws DtaException
     */
    public function toXml(array $values): string
    {
        if (!is_array($values) || count($values) <= 0) {
            throw new DtaException('数组数据异常！');
        }
        $xml = "<xml>";
        foreach ($values as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . $this->toXml($val) . "</" . $key . ">";
            } else if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * 将XML转为array
     * @param string $xml
     * @return mixed
     * @throws DtaException
     */
    public function toArray(string $xml)
    {
        if (!$xml) {
            throw new DtaException('xml数据异常！');
        }
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }
}
