<?php

include __DIR__.'/vendor/autoload.php';

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;

$discord = new Discord([
    'token' => getenv('BOT-TOKEN'),
]);

$discord->on('ready', function (Discord $discord) {
    echo "Bot is ready!", PHP_EOL;

    // Listen for messages.
    $discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) {
        // se for uma mensagem de bot não faz nada
        if ($message->author->bot) {
            return;
        }

        $message->reply('Bot Moscão respondendo sua mensagem, tenha um bom dia meu jovem gafanhoto!');

        echo "{$message->author->username}: {$message->content}", PHP_EOL;
    });
});

$discord->run();