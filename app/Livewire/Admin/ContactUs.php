<?php

namespace App\Livewire\Admin;

use App\Models\ContactUs as ModelsContactUs;
use Livewire\Component;

class ContactUs extends Component
{
    public function render()
    {
        return view('livewire.admin.contact-us',[
            'contactUs' => ModelsContactUs::paginate(20)
        ]);
    }
}
