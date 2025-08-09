@component('mail::message')
# Article Approval Request

Hello Super Admin,

A new article titled **"{{ $data->title }}"** has been submitted by **{{ $data->author->name }}** and is awaiting your approval.

@component('mail::button', ['url' => url('/admin/posts')])
Review Article
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
