<?php

namespace App\Livewire;

use App\Models\NewsLetterSubscriber;
use Livewire\Component;

class NewsLetterForm extends Component
{
    public $news_letter_email = '';
    protected string $serverError;

    public function __construct()
    {
        $this->serverError = config('exception-errors.errors.server-error');
    }

    protected $rules =
     [
        'news_letter_email' => 'required|email|unique:news_letter_subscribers,email'
    ];

    protected function message()
    {
        return [
            'news_letter_email.required' => 'Please enter your email address.',
            'news_letter_email.email' => 'Please provide a valid email address.',
            'news_letter_email.unique' => 'This email is already subscribed. Please use another one.'
        ];
    }

    // REal time validation
    public function updatedEmail()
    {
        $this->validateOnly('news_letter_email');
    }

    public function subscribe()
    {
        $this->validate();

        // Save
        $created = NewsLetterSubscriber::create(['email' => $this->news_letter_email]);

        //Clear input and notify user
        $this->news_letter_email = '';

        if (!$created) {
            $this->dispatch('showToastr', [
                'type' => 'newsletter_fail',
                'message' => $this->serverError
            ]);
        }

        $this->dispatch('showToastr', [
            'type' => 'newsletter_success',
            'message' => 'You have successfully subscribed.'
        ]);
    }

    public function render()
    {
        return view('livewire.news-letter-form');
    }
}
