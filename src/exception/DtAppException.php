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

namespace DtApp\ThinkLibrary\exception;

use Exception;

/**
 * 错误管理
 * Class DtAppException
 * @package DtApp\ThinkLibrary\exception
 */
class DtAppException extends Exception
{
    public function errorMessage()
    {
        return $this->getMessage();
    }
}