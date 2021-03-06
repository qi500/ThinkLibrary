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

namespace DtApp\ThinkLibrary\service\wechat;

use DtApp\ThinkLibrary\exception\DtaException;
use DtApp\ThinkLibrary\Service;
use DtApp\ThinkLibrary\service\curl\HttpService;

/**
 * 企业微信
 * Class QyService
 * @package DtApp\ThinkLibrary\service\wechat
 */
class QyService extends Service
{
    /**
     * 消息类型
     * @var string
     */
    private $msgType = 'text';

    /**
     * @var
     */
    private $key;

    /**
     * 配置Key
     * @param string $str
     * @return $this
     */
    public function key(string $str): self
    {
        $this->key = $str;
        return $this;
    }

    /**
     * 发送文本消息
     * @param string $content 消息内容
     * @return bool
     * @throws DtaException
     */
    public function text(string $content = ''): bool
    {
        $this->msgType = 'text';
        return $this->sendMsg([
            'text' => [
                'content' => $content,
            ],
        ]);
    }

    /**
     * 发送markdown消息
     * @param string $content 消息内容
     * @return bool
     * @throws DtaException
     */
    public function markdown(string $content = '')
    {
        $this->msgType = 'markdown';
        return $this->sendMsg([
            'markdown' => [
                'content' => $content,
            ],
        ]);
    }

    /**
     * 组装发送消息
     * @param array $data 消息内容数组
     * @return bool
     * @throws DtaException
     */
    private function sendMsg(array $data): bool
    {
        if (empty($this->key)) {
            throw new DtaException("请检查KEY");
        }
        if (empty($data['msgtype'])) {
            $data['msgtype'] = $this->msgType;
        }
        $result = HttpService::instance()
            ->url("https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=" . $this->key)
            ->data($data)
            ->toArray();
        return $result['errcode'] === 0;
    }
}
