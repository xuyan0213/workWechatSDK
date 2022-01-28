<?php


namespace WorkWechatSdk\Kernel\Messages;

/**
 * Class Card.
 */
class Card extends Message
{
    /**
     * Message type.
     *
     * @var string
     */
    protected $type = 'wxcard';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = ['card_id'];

    /**
     * Media constructor.
     *
     * @param string $cardId
     */
    public function __construct(string $cardId)
    {
        parent::__construct(['card_id' => $cardId]);
    }
}
