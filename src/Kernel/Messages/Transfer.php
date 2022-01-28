<?php


namespace WorkWechatSdk\Kernel\Messages;

/**
 * Class Transfer.
 *
 * @property string $to
 * @property string $account
 */
class Transfer extends Message
{
    /**
     * Messages type.
     *
     * @var string
     */
    protected $type = 'transfer_customer_service';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = [
        'account',
    ];

    /**
     * Transfer constructor.
     *
     * @param string|null $account
     */
    public function __construct(string $account = null)
    {
        parent::__construct(compact('account'));
    }

    public function toXmlArray()
    {
        return empty($this->get('account')) ? [] : [
            'TransInfo' => [
                'KfAccount' => $this->get('account'),
            ],
        ];
    }
}
