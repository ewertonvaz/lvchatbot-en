<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->hears('Hello', function ($bot) {
    $bot->reply('Hi! 👋');
});
$botman->hears('Menu', BotManController::class.'@startConversation');

$botman->hears('choose color', BotManController::class.'@firstConversation');