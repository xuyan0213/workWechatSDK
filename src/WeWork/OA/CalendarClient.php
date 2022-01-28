<?php


namespace WorkWechatSdk\WeWork\OA;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 效率工具 日程模块
 *
 */
class CalendarClient extends BaseClient
{
    /**
     * 创建日历
     * (该接口用于通过应用在企业内创建一个日历。)
     * @param array $calendar
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/93647#%E5%88%9B%E5%BB%BA%E6%97%A5%E5%8E%86
     */
    public function add(array $calendar)
    {
        return $this->httpPostJson('cgi-bin/oa/calendar/add', compact('calendar'));
    }

    /**
     * 更新日历
     * (该接口用于修改指定日历的信息。)
     * @param string $id
     * @param array  $calendar
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/93647#%E6%9B%B4%E6%96%B0%E6%97%A5%E5%8E%86
     */
    public function update(string $id, array $calendar)
    {
        $calendar += ['cal_id' => $id];

        return $this->httpPostJson('cgi-bin/oa/calendar/update', compact('calendar'));
    }

    /**
     * 获取日历详情
     * (该接口用于获取应用在企业内创建的日历信息。)
     * @param string|array $ids 日历ID列表，调用创建日历接口后获得。一次最多可获取1000条
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/93647#%E8%8E%B7%E5%8F%96%E6%97%A5%E5%8E%86%E8%AF%A6%E6%83%85
     */
    public function get($ids)
    {
        return $this->httpPostJson('cgi-bin/oa/calendar/get', ['cal_id_list' => (array) $ids]);
    }

    /**
     * 删除日历
     * (该接口用于删除指定日历。)
     * @param string $id 日历ID
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/93647#%E5%88%A0%E9%99%A4%E6%97%A5%E5%8E%86
     */
    public function delete(string $id)
    {
        return $this->httpPostJson('cgi-bin/oa/calendar/del', ['cal_id' => $id]);
    }
}
