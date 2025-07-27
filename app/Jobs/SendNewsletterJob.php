<?php

namespace App\Jobs;

use App\Mail\SubscriberNewsLetterMail;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendNewsletterJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $subscriberEmail,private object $latestPost)
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->subscriberEmail)
                ->send(new SubscriberNewsLetterMail($this->subscriberEmail, $this->latestPost));
        } catch (Exception $exception) {
            logger()->error($exception->getMessage());
        }
    }
}
