<?php

include __DIR__.'/vendor/autoload.php';

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$discord = new Discord([
    'token' => $_ENV['BOT_TOKEN'],
]);

$discord->on('ready', function (Discord $discord) {
    echo "Bot is ready!", PHP_EOL;

    // Listen for messages.
    $discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) {
        // SE A MENSAGEM FOR DO BOT MOSCÃO NÃO FAZ NADA
        if ($message->author->bot && $message->author->id === $_ENV['MOSCAO_BOT_ID']) {
            return;
        }

        // SE A MENSAGEM FOR DO BOT ARAYNA (MÚSICA) VAI REMOVER A MENSAGEM
        if ($message->author->id === $_ENV['MOSCAO_BOT_ID']) {
            $message->delete($message->content);
        }

        // EXPLODE EM ARRAY A MENSAGEM POR ESPAÇO
        $contentMusic = explode(' ',$message->content);

        // SE NA MENSAGEM CONTER =M E FOR NO CANAL DO GERSON VAI ENVIAR UMA MENSAGEM E APAGAR A DO AUTHOR
        if (in_array("=m", $contentMusic) && $message->channel_id === $_ENV['GERSON_TEXT_CHANNEL']) {
            $message->reply("O Corno do `{$message->author->username}` tá colocando música no lugar errado.");
            $message->delete($message->content);
        }
    });
});

$discord->run();