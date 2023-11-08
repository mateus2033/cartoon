<?php

namespace App\Console\Commands;

use App\Jobs\SendEmail as JobsSendEmail;
use App\Models\User;
use Illuminate\Console\Command;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'envio:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esse comando envia email para um usuario cadastrados';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::find(1);
        JobsSendEmail::dispatch($user);
    }
}
