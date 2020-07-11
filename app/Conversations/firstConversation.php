<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class firstConversation extends Conversation
{
    /**
     * First question
     */
    public function askMeWhy()
    {
        $question = Question::create("What color do you prefer?")
            ->addButtons([
                Button::create('RED')->value('red'),
                Button::create('BLUE')->value('blue'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->say("Color psychology says that :");
                $this->getBot()->typesAndWaits(3);
                if ($answer->getValue() === 'red') {
                    $attachment = new Image('/img/red-flower.jpg');
                    $this->say("You are dynamic and strong!");
                } else {
                    $attachment = new Image('/img/blue-flower.jpg');
                    $this->say("You are reliable and friendly!");
                }
                $message = OutgoingMessage::create('Be welcome and accept this flower as proof of friendship')
                    ->withAttachment($attachment);
                $this->getBot()->reply($message);
            }
        });
    }

    /**
     * Begin conversation
     */
    public function run()
    {
        $this->askMeWhy();
    }
}
