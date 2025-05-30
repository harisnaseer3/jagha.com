<?php

namespace App\Http\Controllers\HitRecord;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use App\BotMan\Conversations\SupportConversation;

class ChatBotController extends Controller
{
//    public function handle()
//    {
//        \Log::info('ChatBotController@handle was called');
//        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
//        $botman = app('botman');
//
//        $botman->hears('start', function ($bot) {
//            \Log::info('BotMan hears start');
//            $bot->startConversation(new SupportConversation());
//        });
//
//        $botman->fallback(function ($bot) {
//            \Log::info('BotMan fallback');
////            $bot->startConversation(new SupportConversation());
//            $bot->reply("Sorry, I didn't understand that. Try typing 'start'.");
//        });
//
//        $botman->listen();
//    }

    public function handle(Request $request)
    {
        \Log::info('ChatBotController@handle was called');
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        $config = [];

        // THIS IS REQUIRED
        $botman = BotManFactory::create($config);

        $botman->hears('(?i)start', function ($bot) {
            \Log::info('BotMan hears start');
            $bot->startConversation(new SupportConversation());
        });

        $botman->fallback(function ($bot) {
            \Log::info('BotMan fallback');
            $bot->reply("Sorry, I didn't understand that. Try typing 'start'.");
        });

        $botman->listen();
    }

}
