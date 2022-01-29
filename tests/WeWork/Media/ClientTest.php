<?php

namespace WorkWechatSdk\Tests\WeWork\Media;


use WorkWechatSdk\Kernel\Http\Response;
use WorkWechatSdk\Kernel\Http\StreamResponse;
use WorkWechatSdk\Kernel\ServiceContainer;
use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\Media\Client;


/**
 * 素材管理
 */
class ClientTest extends TestCase
{

    /**
     * 获取临时素材
     * @return void
     */
    public function testGet()
    {
        $app = new ServiceContainer();
        $client = $this->mockApiClient(Client::class, [], $app);
        $imageResponse = new Response(200, ['content-type' => 'text/plain'], '{"error": "invalid media id hits."}');
        $client->expects()->requestRaw('cgi-bin/media/get', 'GET', [
            'query' => [
                'media_id' => 'qwe',
            ],
        ])->andReturn($imageResponse);

        $this->assertSame(['error' => 'invalid media id hits.'], $client->get('qwe'));

        $imageResponse = new Response(200, [], 'valid data');
        $client->expects()->requestRaw('cgi-bin/media/get', 'GET', [
            'query' => [
                'media_id' => 'qwe',
            ],
        ])->andReturn($imageResponse);

        $this->assertInstanceOf(StreamResponse::class, $client->get('qwe'));
    }

    /**
     * 上传临时图片
     * @return void
     */
    public function testUploadImage()
    {
        //无参
        $client = $this->mockApiClient(Client::class);
        $files = [
            'media' => '/foo/bar/image.jpg',
        ];
        $form = [];
        $type = 'image';

        $client->expects()->httpUpload('cgi-bin/media/upload', $files, $form, compact('type'))->andReturn('mock-result');

        $this->assertSame('mock-result', $client->uploadImage('/foo/bar/image.jpg'));

        //有参
        $client = $this->mockApiClient(Client::class, ['upload']);
        $client->expects()->upload('image', '/foo/bar/image.jpg', ['filename' => 'image.jpg'])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->uploadImage('/foo/bar/image.jpg', ['filename' => 'image.jpg']));
    }

    /**
     * 上传临时图片
     * @return void
     */
    public function testUploadVoice()
    {
        //无参
        $client = $this->mockApiClient(Client::class);
        $files = [
            'media' => '/foo/bar/voice.mp3',
        ];
        $form = [];
        $type = 'voice';

        $client->expects()->httpUpload('cgi-bin/media/upload', $files, $form, compact('type'))->andReturn('mock-result');

        $this->assertSame('mock-result', $client->uploadVoice('/foo/bar/voice.mp3'));

        //有参
        $client = $this->mockApiClient(Client::class, ['upload']);
        $client->expects()->upload('voice', '/foo/bar/voice.mp3', ['filename' => 'voice.mp3'])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->uploadVoice('/foo/bar/voice.mp3', ['filename' => 'voice.mp3']));
    }

    /**
     * 上传视频
     * @return void
     */
    public function testUploadVideo()
    {
        //无参
        $client = $this->mockApiClient(Client::class);

        $files = [
            'media' => '/foo/bar/video.mp4',
        ];
        $form = [];
        $type = 'video';

        $client->expects()->httpUpload('cgi-bin/media/upload', $files, $form, compact('type'))->andReturn('mock-result');

        $this->assertSame('mock-result', $client->uploadVideo('/foo/bar/video.mp4'));

        //有参
        $client = $this->mockApiClient(Client::class, ['upload']);
        $client->expects()->upload('video', '/foo/bar/video.mp4', ['filename' => 'video.mp4'])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->uploadVideo('/foo/bar/video.mp4', ['filename' => 'video.mp4']));
    }

    /**
     * 上传文件
     * @return void
     */
    public function testUploadFile()
    {
        //无参
        $client = $this->mockApiClient(Client::class);

        $files = [
            'media' => '/foo/bar/file.txt',
        ];
        $form = [];
        $type = 'file';

        $client->expects()->httpUpload('cgi-bin/media/upload', $files, $form, compact('type'))->andReturn('mock-result');

        $this->assertSame('mock-result', $client->uploadFile('/foo/bar/file.txt'));

        //有参
        $client = $this->mockApiClient(Client::class, ['upload']);
        $client->expects()->upload('file', '/foo/bar/file.txt', ['filename' => 'file.txt'])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->uploadFile('/foo/bar/file.txt', ['filename' => 'file.txt']));
    }

    /**
     * 上传临时素材
     * @return void
     */
    public function testUpload()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpUpload('cgi-bin/media/upload', [
            'media' => '/foo/bar/voice.mp3',
        ], [], ['type' => 'voice'])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->upload('voice', '/foo/bar/voice.mp3'));

        //有参
        $client->expects()->httpUpload('cgi-bin/media/upload', [
            'media' => '/foo/bar/voice.mp3',
        ], ['filename' => 'voice.mp3'], ['type' => 'voice'])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->upload('voice', '/foo/bar/voice.mp3', ['filename' => 'voice.mp3']));
    }

    /**
     * 上传图片
     * @return void
     */
    public function testUploadImg()
    {
        //无参
        $client = $this->mockApiClient(Client::class);
        $files = [
            'media' => '/foo/bar/image.jpg',
        ];
        $form = [];

        $client->expects()->httpUpload('cgi-bin/media/uploadimg', $files, $form)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->uploadImg('/foo/bar/image.jpg'));

        //有参
        $client = $this->mockApiClient(Client::class, ['uploadImg']);
        $client->expects()->uploadImg('/foo/bar/image.jpg', ['filename' => 'image.jpg'])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->uploadImg('/foo/bar/image.jpg', ['filename' => 'image.jpg']));
    }

    /**
     * 获取高清语音素材
     * @return void
     */
    public function testGetHdVoice()
    {
        $app = new ServiceContainer();
        $client = $this->mockApiClient(Client::class, [], $app);

        $mediaId = 'invalid-media-id';
        $imageResponse = new Response(200, ['content-type' => 'text/plain'], '{"error": "invalid media id hits."}');
        $client->expects()->requestRaw('cgi-bin/media/get/jssdk', 'GET', [
            'query' => [
                'media_id' => $mediaId,
            ],
        ])->andReturn($imageResponse);

        $this->assertSame(['error' => 'invalid media id hits.'], $client->getHdVoice($mediaId));

        $mediaId = 'valid-media-id';
        $imageResponse = new Response(200, [], 'valid data');
        $client->expects()->requestRaw('cgi-bin/media/get/jssdk', 'GET', [
            'query' => [
                'media_id' => $mediaId,
            ],
        ])->andReturn($imageResponse);

        $this->assertInstanceOf(StreamResponse::class, $client->getHdVoice($mediaId));
    }
}