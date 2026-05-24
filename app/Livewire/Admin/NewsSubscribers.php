<?php

namespace App\Livewire\Admin;

use App\Models\NewsLetterSubscriber;
use Livewire\Component;
use Livewire\WithPagination;

class NewsSubscribers extends Component
{
    use WithPagination;
    
    public function render()
    {
        return view('livewire.admin.news-subscribers', [
            'subscribers' => NewsLetterSubscriber::paginate(20)
        ]);
    }
}
