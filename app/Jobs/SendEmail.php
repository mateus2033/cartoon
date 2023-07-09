<?php

namespace App\Jobs;

use App\Models\User;
use App\Utils\SendEmail\Email;
use App\Utils\SendEmail\MessageEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $enviaEmail = new Email(); 
        $enviaEmail->add(MessageEmail::$subject, MessageEmail::$body, $this->user->name, $this->user->email)->send();
    }

    public function failed(Throwable $e)
    {
        
    }
}
