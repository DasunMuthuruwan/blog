@component('mail::message')
# 🎉 Your Article Has Been Approved!

Hello {{ $data->author->name }},

We're excited to let you know that your article titled:

### "**{{ $data->title }}**"

has been **approved** and is now live on **{{ config('app.name') }}**.

@component('mail::button', ['url' => url("/post/{$data['slug']}")])
View Your Article
@endcomponent

Thank you for contributing to our platform. We look forward to more great content from you!

Best regards,  
**The {{ config('app.name') }} Team**

@endcomponent
