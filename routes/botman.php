<?php
use App\Http\Controllers\BotManController;
//use BotMan\BotMan\Middleware\ApiAi;
use App\Http\Middleware\DialogflowV2;

$botman = resolve('botman');
//$dialogflow = ApiAi::create(env('DIALOG_FLOW_TOKEN'))->listenForAction();
$dialogflow = DialogflowV2::create()->listenForAction();
$botman->middleware->received($dialogflow);

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');

/* $botman->hears('Hello', function ($bot) {
    $bot->reply('Hi! 👋');
}); */

/* $botman->hears('(Hey|Hello|Salute)', function ($bot, $greeting) {
    $bot->reply($greeting.' for you too! 👋');
}); */

$botman->hears(trans('chatbot.in-salute'), function ($bot, $greeting) {
    $bot->reply($greeting.trans('chatbot.out-salute')); 
});

$botman->hears('conversation', BotManController::class.'@startConversation');

//$botman->hears('choose color', BotManController::class.'@firstConversation');
$botman->hears('.*color$', BotManController::class.'@firstConversation');

/* $botman->hears('My name is {name}', function ($bot, $name) {
    $bot->reply('Hello '.$name. '. How are you?');
});
 */
$botman->hears('My name is {name} and I have {age} years old', function ($bot, $name, $age) {
    $bot->reply('Hello '.$name.', so you have born in '.(Date('Y')-$age));
});

$botman->hears('R(e|oy?)al', function ($bot) {
    $bot->reply('This is real');
});

$botman->hears('(^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$)', function ($bot, $email) {
    $bot->reply('Got it, I will send the message to your e-mail address : ' . $email);
});

/* $botman->hears('botman.agent.menu', function ($bot) {
    $extras = $bot->getMessage()->getExtras();
    $apiReply = $extras['apiReply'];
    $apiAction = $extras['apiAction'];
    $apiIntent = $extras['apiIntent'];
    
    $bot->reply($apiReply);
})->middleware($dialogflow); */

$botman->fallback(function($bot) {
    return $bot->reply($bot->getMessage()->getExtras('apiReply'));
    //return $bot->reply($bot->getMessage()->getExtras('apiIntent'));
});
