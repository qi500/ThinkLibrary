<?php

// +----------------------------------------------------------------------
// | ThinkLibrary 5.1 for ThinkPhP 5.1
// +----------------------------------------------------------------------
// | 版权所有 2017~2020 [ https://www.dtapp.net ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/liguangchun/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/liguangchun/ThinkLibrary
// | github 仓库地址 ：https://github.com/GC0202/ThinkLibrary
// | Packagist 地址 ：https://packagist.org/packages/liguangchun/think-library
// +----------------------------------------------------------------------

namespace DtApp\ThinkLibrary\facade;

use think\Facade;

/**
 * 数字门面
 * Class Ints
 * @see \DtApp\ThinkLibrary\Ints
 * @package think\facade
 * @mixin \DtApp\ThinkLibrary\Ints
 *
 * @method \DtApp\ThinkLibrary\Ints isEvenNumbers(int $num) bool 判断一个数是不是偶数
 * @method \DtApp\ThinkLibrary\Ints isOddNumbers(int $num) bool 判断一个数是不是奇数
 */
class Ints extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'DtApp\ThinkLibrary\Ints';
    }
}
