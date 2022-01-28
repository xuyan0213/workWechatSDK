<?php


namespace WorkWechatSdk\WeWork\Media;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Http\Response;
use WorkWechatSdk\Kernel\Http\StreamResponse;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 素材管理
 *
 */
class Client extends BaseClient
{
    /**
     * 获取临时素材
     *
     * @param string $mediaId 素材ID
     *
     * @return array|Response|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/90254
     */
    public function get(string $mediaId)
    {
        return $this->getResources($mediaId, 'cgi-bin/media/get');
    }

    /**
     * 上传临时图片
     *
     * @param string $path
     * @param array $form
     *
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function uploadImage(string $path, array $form = [])
    {
        return $this->upload('image', $path, $form);
    }

    /**
     * 上传临时语音
     *
     * @param string $path
     * @param array $form
     *
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function uploadVoice(string $path, array $form = [])
    {
        return $this->upload('voice', $path, $form);
    }

    /**
     * 上传视频
     *
     * @param string $path
     * @param array $form
     *
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function uploadVideo(string $path, array $form = [])
    {
        return $this->upload('video', $path, $form);
    }

    /**
     * 上传文件
     *
     * @param string $path
     * @param array $form
     *
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function uploadFile(string $path, array $form = [])
    {
        return $this->upload('file', $path, $form);
    }

    /**
     * 上传临时素材
     *
     * @param string $type
     * @param string $path
     * @param array $form
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/90253
     */
    public function upload(string $type, string $path, array $form = [])
    {
        $files = [
            'media' => $path,
        ];

        return $this->httpUpload('cgi-bin/media/upload', $files, $form, compact('type'));
    }

    /**
     * 上传图片
     *
     * @see https://developer.work.weixin.qq.com/document/path/90256
     * @param string $path
     * @param array $form
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function uploadImg(string $path, array $form = [])
    {
        $files = [
            'media' => $path,
        ];

        return $this->httpUpload('cgi-bin/media/uploadimg', $files, $form);
    }


    /**
     * 获取高清语音素材
     *
     * @see https://developer.work.weixin.qq.com/document/path/90255
     * @param string $mediaId
     *
     * @return array|Response|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getHdVoice(string $mediaId)
    {
        return $this->getResources($mediaId, 'cgi-bin/media/get/jssdk');
    }

    /**
     * @param string $mediaId
     * @param string $uri
     *
     * @return array|Response|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    protected function getResources(string $mediaId, string $uri)
    {
        $response = $this->requestRaw($uri, 'GET', [
            'query' => [
                'media_id' => $mediaId,
            ],
        ]);

        if (false !== stripos($response->getHeaderLine('Content-Type'), 'text/plain')) {
            return $this->castResponseToType($response, $this->app['config']->get('response_type'));
        }

        return StreamResponse::buildFromPsrResponse($response);
    }
}
