<?php

namespace App\Livewire;

use App\Models\NewsLetterSubscriber;
use Exception;
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
        try {
            $this->validate();

            // Save
            NewsLetterSubscriber::create(['email' => $this->email]);

            //Clear input and notify user
            $this->email = '';
            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'You have successfully subscribed.'
            ]);
        } catch (Exception $exception) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    public function render()
    {
        return view('livewire.news-letter-form');
    }
}
