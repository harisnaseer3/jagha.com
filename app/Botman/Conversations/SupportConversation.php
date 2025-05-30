<?php

namespace App\Botman\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class SupportConversation extends Conversation
{
    protected $name;
    protected $email;

    public function run()
    {
        $this->askName();
    }

    public function askName()
    {
        $this->ask('Hi! What is your name?', [$this, 'handleName']);
    }

    public function handleName(Answer $answer)
    {
        $this->name = $answer->getText();
        $this->askEmail();
    }

    public function askEmail()
    {
        $this->ask('Thanks! Now please enter your email:', [$this, 'handleEmail']);
    }

    public function handleEmail(Answer $answer)
    {
        $this->email = $answer->getText();

        // Optionally save to database
        // UserInfo::create(['name' => $this->name, 'email' => $this->email]);

        $this->showFAQ();
    }

    public function showFAQ()
    {
        $question = Question::create('Please choose one of the following:')
            ->addButtons([
                Button::create('What services do you offer?')->value('services'),
                Button::create('How to contact support?')->value('contact'),
                Button::create('Working hours?')->value('hours'),
            ]);

        $this->ask($question, [$this, 'handleFAQ']);
    }

    public function handleFAQ(Answer $answer)
    {
        switch ($answer->getValue()) {
            case 'services':
                $this->say('We offer Web Development, SEO, and Digital Marketing.');
                break;
            case 'contact':
                $this->say('Contact us at support@example.com.');
                break;
            case 'hours':
                $this->say('Our working hours are 9AM - 6PM, Mon to Fri.');
                break;
            default:
                $this->say('Please choose a valid option.');
                $this->showFAQ(); // Ask again
        }
    }
}
