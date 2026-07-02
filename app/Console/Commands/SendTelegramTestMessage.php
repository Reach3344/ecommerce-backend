<?php

namespace App\Console\Commands;

use App\Services\TelegramOrderNotifier;
use Illuminate\Console\Command;

class SendTelegramTestMessage extends Command
{
    protected $signature = 'telegram:test {message? : The message to send}';

    protected $description = 'Send a test message to Telegram';

    public function __construct(private readonly TelegramOrderNotifier $telegramOrderNotifier)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $message = $this->argument('message') ?: 'Laravel Telegram test message';

        try {
            $this->telegramOrderNotifier->sendTestMessage($message);
            $this->info('Telegram test message sent successfully.');

            return self::SUCCESS;
        } catch (\Throwable $exception) {
            $this->error('Failed to send Telegram test message: ' . $exception->getMessage());

            return self::FAILURE;
        }
    }
}
