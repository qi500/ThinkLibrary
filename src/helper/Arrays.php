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

/**
 * 数组管理类
 * @mixin Arrays
 * @package DtApp\ThinkLibrary\helper
 */
class Arrays
{
    /**
     * 数组随机返回一个下标
     * @param $array
     * @return mixed
     */
    public function rand(array $array)
    {
        return array_rand($array);
    }

    /**
     * 数组随机返回一个值
     * @param $array
     * @return mixed
     */
    public function randValue(array $array)
    {
        return $array[array_rand($array)];
    }

    /**
     * 分隔数组
     * @param array $array 数组
     * @param int $num 数量
     * @return array
     */
    public function split(array $array, $num = 5): array
    {
        $arrRet = array();
        if (!isset($array) || empty($array)) {
            return $arrRet;
        }
        $iCount = count($array) / $num;
        if (!is_int($iCount)) {
            $iCount = ceil($iCount);
        } else {
            ++$iCount;
        }
        for ($i = 0; $i < $iCount; ++$i) {
            $arrInfos = array_slice($array, $i * $num, $num);
            if (empty($arrInfos)) {
                continue;
            }
            $arrRet[] = $arrInfos;
            unset($arrInfos);
        }
        return $arrRet;
    }

    /**
     * 多维数组去重
     * @param array $array
     * @return array
     */
    public function unique(array $array): array
    {
        $out = array();
        foreach ($array as $key => $value) {
            if (!in_array($value, $out)) {
                $out[$key] = $value;
            }
        }
        $out = array_values($out);
        return $out;
    }

    /**
     * 二维数组根据某个键排序
     * @param array $arrays
     * @param string $sort_key
     * @param int $sort_order
     * @param int $sort_type
     * @return array
     */
    public function sort(array $arrays, string $sort_key, $sort_order = SORT_ASC, $sort_type = SORT_NUMERIC): array
    {
        $key_arrays = array();
        if (is_array($arrays)) {
            foreach ($arrays as $array) {
                if (is_array($array)) {
                    $key_arrays[] = $array[$sort_key];
                } else {
                    return [];
                }
            }
        } else {
            return [];
        }
        array_multisort($key_arrays, $sort_order, $sort_type, $arrays);
        return $arrays;
    }

    /**
     * 数组删除空格
     * @param array $arr
     * @return array
     */
    public function trimArray(array $arr)
    {
        if (!is_array($arr)) {
            return $arr;
        }
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $arr[$key] = $this->TrimArray($value);
            } else {
                $arr[$key] = $this->trimAll($value);
            }
        }
        return $arr;
    }

    /**
     * 字符串删除空格
     * @param $str
     * @return string|string[]
     */
    private function trimAll($str)
    {
        $oldchar = array(" ", "　", "\t", "\n", "\r");
        $newchar = array("", "", "", "", "");
        return str_replace($oldchar, $newchar, $str);
    }

    /**
     * 把json字符串或json对象转json数组
     * @param $output
     * @return array
     */
    public function toArray($output): array
    {
        if (is_array($output)) {
            return $output;
        }
        if (is_object($output)) {
            $output = json_encode($output, JSON_UNESCAPED_UNICODE);
        }
        return json_decode($output, true);
    }
}
