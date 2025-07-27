<?php

namespace App\Livewire;

use App\Models\NewsLetterSubscriber;
use Livewire\Component;

class NewsLetterForm extends Component
{
    public $email = '';
    protected string $serverError;

    public function __construct()
    {
        $this->serverError = config('exception-errors.errors.server-error');
    }

    protected $rules = [
        'email' => 'required|email|unique:news_letter_subscribers,email'
    ];

    protected function message()
    {
        return [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already subscribed. Please use another one.'
        ];
    }

    // REal time validation
    public function updatedEmail()
    {
        $this->validateOnly('email');
    }

    public function subscribe()
    {
        $this->validate();

        // Save
        $created = NewsLetterSubscriber::create(['email' => $this->email]);

        //Clear input and notify user
        $this->email = '';

        if (!$created) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }

        $this->dispatch('showToastr', [
            'type' => 'info',
            'message' => 'You have successfully subscribed.'
        ]);
    }

    public function render()
    {
        return view('livewire.news-letter-form');
    }
}
