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

namespace DtApp\ThinkLibrary;

use stdClass;
use think\App;
use think\exception\HttpResponseException;
use think\Request;

/**
 * 标准控制器基类
 * Class Controller
 * @package DtApp\ThinkLibrary
 */
class Controller extends stdClass
{
    /**
     * 应用容器
     * @var App
     */
    public $app;

    /**
     * 请求对象
     * @var Request
     */
    public $request;

    /**
     * Controller constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->request = $app->request;
        $this->app->bind('DtApp\ThinkLibrary\Controller', $this);
        if (in_array($this->request->action(), get_class_methods(__CLASS__))) {
            $this->error('Access without permission.');
        }
        $this->initialize();
    }

    /**
     * 控制器初始化
     */
    protected function initialize()
    {
    }

    /**
     * 返回失败的操作
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param integer $code 返回代码
     */
    public function error($info, $data = '{-null-}', $code = 0): void
    {
        if ($data === '{-null-}') {
            $data = new stdClass();
        }
        throw new HttpResponseException(json([
            'code' => $code, 'info' => $info, 'data' => $data,
        ]));
    }

    /**
     * 返回成功的操作
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param integer $code 返回代码
     */
    public function success($info, $data = '{-null-}', $code = 1): void
    {
        if ($data === '{-null-}') {
            $data = new stdClass();
        }
        throw new HttpResponseException(json([
            'code' => $code, 'info' => $info, 'data' => $data,
        ]));
    }

    /**
     * URL重定向
     * @param string $url 跳转链接
     * @param integer $code 跳转代码
     */
    public function redirect($url, $code = 301): void
    {
        throw new HttpResponseException(redirect($url, $code));
    }

    /**
     * 返回视图内容
     * @param string $tpl 模板名称
     * @param array $vars 模板变量
     */
    public function fetch($tpl = '', $vars = []): void
    {
        foreach ($this as $name => $value) {
            $vars[$name] = $value;
        }
        throw new HttpResponseException(view($tpl, $vars));
    }

    /**
     * 模板变量赋值
     * @param mixed $name 要显示的模板变量
     * @param mixed $value 变量的值
     * @return $this
     */
    public function assign($name, $value = ''): self
    {
        if (is_string($name)) {
            $this->$name = $value;
        } elseif (is_array($name)) {
            foreach ($name as $k => $v) {
                if (is_string($k)) {
                    $this->$k = $v;
                }
            }
        }
        return $this;
    }

    /**
     * 数据回调处理机制
     * @param string $name 回调方法名称
     * @param mixed $one 回调引用参数1
     * @param mixed $two 回调引用参数2
     * @return boolean
     */
    public function callback($name, &$one = [], &$two = []): bool
    {
        if (is_callable($name)) {
            return $name($this, $one, $two);
        }
        foreach ([$name, "_{$this->app->request->action()}{$name}"] as $method) {
            if (method_exists($this, $method) && false === $this->$method($one, $two)) {
                return false;
            }
        }
        return true;
    }
}
