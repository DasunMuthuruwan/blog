<?php

namespace App\Livewire\Admin;

use App\Models\ContactUs as ModelsContactUs;
use Livewire\Component;
use Livewire\WithPagination;

class ContactUs extends Component
{
    use WithPagination;
    
    public function render()
    {
        return view('livewire.admin.contact-us',[
            'contactUs' => ModelsContactUs::paginate(5)
        ]);
    }
}
