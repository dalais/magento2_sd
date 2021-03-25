<?php
namespace Pulsestorm\TutorialObjectManager2\Model;

class Example
{
    protected $messageObject;
	public function __construct(Message $message)
	{
		$this->messageObject = $message;
	}

    public function sendHelloAgainMessage()
    {
        return $this->messageObject->getMessage();
    }
}
