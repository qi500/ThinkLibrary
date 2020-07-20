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

namespace DtApp\ThinkLibrary\cache;

use DtApp\ThinkLibrary\exception\DtaException;
use DtApp\ThinkLibrary\facade\Times;
use think\db\exception\DbException;
use think\facade\Db;
use think\Model;

/**
 * 缓存数据库驱动
 * Class Mysql
 * @package DtApp\ThinkLibrary\cache
 */
class Mysql
{
    private $table = "think_cache";
    private $cache_name, $cache_expire = 0;

    /**
     * 名称
     * @param string $cache_name
     * @return $this
     */
    public function name(string $cache_name)
    {
        $this->cache_name = $cache_name;
        return $this;
    }

    /**
     * 过期时间
     * @param int $cache_expire
     * @return $this
     */
    public function expire(int $cache_expire)
    {
        $this->cache_expire = $cache_expire;
        return $this;
    }

    /**
     * 设置
     * @param $cache_value
     * @return int|string
     * @throws DtaException
     */
    public function set($cache_value)
    {
        $this->judge();
        $result = Db::table($this->table)
            ->insert([
                'cache_name' => $this->cache_name,
                'cache_value' => $cache_value,
                'cache_expire' => Times::dateRear("Y-m-d H:i:s", $this->cache_expire)
            ]);
        return $result ? true : false;
    }

    /**
     * 获取
     * @return array|Model|null
     * @throws DtaException
     */
    public function get()
    {
        $this->judge();
        return Db::table($this->table)
            ->where('cache_name', $this->cache_name)
            ->whereTime('cache_expire', '>=', time())
            ->order('cache_expire desc')
            ->value('access_token', '');
    }

    /**
     * 删除
     * @return int
     * @throws DbException|DtaException
     */
    public function delete()
    {
        $this->judge();
        $result = Db::table($this->table)
            ->where('cache_name', $this->cache_name)
            ->delete();
        return $result ? true : false;
    }

    /**
     * 更新
     * @param $cache_value
     * @return int
     * @throws DbException|DtaException
     */
    public function update($cache_value)
    {
        $this->judge();
        $result = Db::table($this->table)
            ->where('cache_name', $this->cache_name)
            ->update([
                'cache_value' => $cache_value,
                'cache_expire' => Times::dateRear("Y-m-d H:i:s", $this->cache_expire)
            ]);
        return $result ? true : false;
    }

    /**
     * 自增
     * @param int $int
     * @return int
     * @throws DbException
     * @throws DtaException
     */
    public function inc(int $int = 1)
    {
        $cache_value = (int)$this->get();
        $result = Db::table($this->table)
            ->where('cache_name', $this->cache_name)
            ->update([
                'cache_value' => $cache_value + $int
            ]);
        return $result ? true : false;
    }

    /**
     * 自减
     * @param int $int
     * @return int
     * @throws DbException
     * @throws DtaException
     */
    public function dec(int $int = 1)
    {
        $cache_value = (int)$this->get();
        $result = Db::table($this->table)
            ->where('cache_name', $this->cache_name)
            ->update([
                'cache_value' => $cache_value - $int
            ]);
        return $result ? true : false;
    }

    /**
     * @throws DtaException
     */
    private function judge()
    {
        if (empty($this->cache_name)) {
            throw new DtaException("名称未配置");
        }
    }
}
