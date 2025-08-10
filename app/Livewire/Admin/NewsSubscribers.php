<?php

namespace App\Livewire\Admin;

use App\Models\NewsLetterSubscriber;
use Livewire\Component;

class NewsSubscribers extends Component
{
    public function render()
    {
        return view('livewire.admin.news-subscribers', [
            'subscribers' => NewsLetterSubscriber::paginate(20)
        ]);
    }
}
