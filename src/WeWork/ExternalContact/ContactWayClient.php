<?php


namespace WorkWechatSdk\WeWork\ExternalContact;;

use WorkWechatSdk\Kernel\BaseClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 企业服务人员管理
 *
 */
class ContactWayClient extends BaseClient
{
    /**
     * 获取配置了客户联系功能的成员列表.
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/92571
     */
    public function getFollowUsers()
    {
        return $this->httpGet('cgi-bin/externalcontact/get_follow_user_list');
    }
    /**
     * 配置客户联系「联系我」方式.
     *
     * @param int   $type   联系方式类型,1-单人, 2-多人
     * @param int   $scene  场景，1-在小程序中联系，2-通过二维码联系
     * @param array $config 其他参数 参考下面链接文档
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/92572#%E9%85%8D%E7%BD%AE%E5%AE%A2%E6%88%B7%E8%81%94%E7%B3%BB%E3%80%8C%E8%81%94%E7%B3%BB%E6%88%91%E3%80%8D%E6%96%B9%E5%BC%8F
     */
    public function create(int $type, int $scene, array $config = [])
    {
        $params = array_merge([
            'type' => $type,
            'scene' => $scene,
        ], $config);

        return $this->httpPostJson('cgi-bin/externalcontact/add_contact_way', $params);
    }

    /**
     * 获取企业已配置的「联系我」方式.
     *
     * @param string $configId 	联系方式的配置id
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/92572#%E8%8E%B7%E5%8F%96%E4%BC%81%E4%B8%9A%E5%B7%B2%E9%85%8D%E7%BD%AE%E7%9A%84%E3%80%8C%E8%81%94%E7%B3%BB%E6%88%91%E3%80%8D%E5%88%97%E8%A1%A8
     */
    public function get(string $configId)
    {
        return $this->httpPostJson('cgi-bin/externalcontact/get_contact_way', [
            'config_id' => $configId,
        ]);
    }

    /**
     * 更新企业已配置的「联系我」方式.
     *
     * @param string $configId 企业联系方式的配置id
     * @param array  $config 其他参数
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/92572#%E6%9B%B4%E6%96%B0%E4%BC%81%E4%B8%9A%E5%B7%B2%E9%85%8D%E7%BD%AE%E7%9A%84%E3%80%8C%E8%81%94%E7%B3%BB%E6%88%91%E3%80%8D%E6%96%B9%E5%BC%8F
     */
    public function update(string $configId, array $config = [])
    {
        $params = array_merge([
            'config_id' => $configId,
        ], $config);

        return $this->httpPostJson('cgi-bin/externalcontact/update_contact_way', $params);
    }

    /**
     * 删除企业已配置的「联系我」方式.
     *
     * @param string $configId 企业联系方式的配置id
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/92572#%E5%88%A0%E9%99%A4%E4%BC%81%E4%B8%9A%E5%B7%B2%E9%85%8D%E7%BD%AE%E7%9A%84%E3%80%8C%E8%81%94%E7%B3%BB%E6%88%91%E3%80%8D%E6%96%B9%E5%BC%8F
     */
    public function delete(string $configId)
    {
        return $this->httpPostJson('cgi-bin/externalcontact/del_contact_way', [
            'config_id' => $configId,
        ]);
    }

    /**
     * 获取企业已配置的「联系我」列表，注意，该接口仅可获取2021年7月10日以后创建的「联系我」
     *
     * @param string $cursor 分页查询使用的游标，为上次请求返回的 next_cursor
     * @param int $limit 每次查询的分页大小，默认为100条，最多支持1000条
     * @param int|null $startTime 「联系我」创建起始时间戳, 不传默认为90天前
     * @param int|null $endTime 「联系我」创建结束时间戳, 不传默认为当前时间
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/92572#%E8%8E%B7%E5%8F%96%E4%BC%81%E4%B8%9A%E5%B7%B2%E9%85%8D%E7%BD%AE%E7%9A%84%E3%80%8C%E8%81%94%E7%B3%BB%E6%88%91%E3%80%8D%E5%88%97%E8%A1%A8
     */
    public function list(string $cursor = '', int $limit = 100, int $startTime = null, int $endTime = null)
    {
        $data = [
            'cursor' => $cursor,
            'limit' => $limit,
        ];
        if ($startTime) {
            $data['start_time'] = $startTime;
        }
        if ($endTime) {
            $data['end_time'] = $endTime;
        }
        return $this->httpPostJson('cgi-bin/externalcontact/list_contact_way', $data);
    }
}
