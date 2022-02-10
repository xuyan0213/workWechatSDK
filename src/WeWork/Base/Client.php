<?php


namespace WorkWechatSdk\WeWork\Base;

use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 通用
 *
 */
class Client extends BaseClient
{
    /**
     * 获取企业微信服务器的ip段
     *
     * @return array|object|ResponseInterface|string
     * @throws InvalidConfigException
     * @see https://developer.work.weixin.qq.com/document/path/90238#%E8%8E%B7%E5%8F%96%E4%BC%81%E4%B8%9A%E5%BE%AE%E4%BF%A1%E6%9C%8D%E5%8A%A1%E5%99%A8%E7%9A%84ip%E6%AE%B5
     */
    public function getCallbackIp()
    {
        return $this->httpGet('cgi-bin/getcallbackip');
    }

    /**
     * 将明文corpid转换为第三方应用获取的corpid
     * （仅限第三方服务商，转换已获授权企业的corpid）
     *
     * @see https://open.work.weixin.qq.com/api/doc/90001/90143/95327#1.4%20corpid%E8%BD%AC%E6%8D%A2
     *
     * @param string $corpId 获取到的企业ID
     *
     * @return array|Collection|object|ResponseInterface|string
     * @throws InvalidConfigException

     */
    public function getOpenCorpid(string $corpId)
    {
        return $this->httpPostJson('cgi-bin/corp/to_open_corpid', ['corpid' => $corpId]);
    }

    /**
     * 将自建应用获取的userid转换为第三方应用获取的userid
     * （仅代开发自建应用或第三方应用可调用）
     *
     * @see https://developer.work.weixin.qq.com/document/path/95327#24-userid%E7%9A%84%E8%BD%AC%E6%8D%A2
     *
     * @param array $useridList 获取到的成员ID
     *
     * @return array|Collection|object|ResponseInterface|string
     * @throws InvalidConfigException

     */
    public function batchUseridToOpenUserid(array $useridList)
    {
        return $this->httpPostJson('cgi-bin/batch/userid_to_openuserid', ['userid_list' => $useridList]);
    }

    /**
     * 获取访问用户身份
     * @see https://developer.work.weixin.qq.com/document/path/91437
     * @param string $code
     * @return array|object|ResponseInterface|string|Collection

     * @throws InvalidConfigException
     */
    public function getUser(string $code)
    {
        $params = [
            'code' => $code,
        ];

        return $this->httpGet('cgi-bin/user/getuserinfo', $params);
    }
}
