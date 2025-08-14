@extends('front.layout.pages-layout')

@section('pageTitle', $pageTitle ?? 'Contact Us')
@section('meta_tags')
    {!! SEO::generate(true) !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="mb-5 d-flex align-items-center">
                <h3 class="title-color">Get in Touch</h3>
                @php
                    $siteSocialLinks = siteSocialLinks();
                @endphp
                <ul class="list-inline social-icons ml-auto mr-3 d-none d-sm-block">
                    @if ($siteSocialLinks->facebook_url)
                        <li class="list-inline-item">
                            <a target="_blank" href="{{ $siteSocialLinks->facebook_url }}"><i class="ti-facebook"></i></a>
                        </li>
                    @endif
                    @if ($siteSocialLinks->twitter_url)
                        <li class="list-inline-item">
                            <a target="_blank" href="{{ $siteSocialLinks->twitter_url }}"><i class="ti-twitter-alt"></i></a>
                        </li>
                    @endif
                    @if ($siteSocialLinks->linkdin_url)
                        <li class="list-inline-item">
                            <a target="_blank" href="{{ $siteSocialLinks->linkdin_url }}"><i class="ti-linkedin"></i></a>
                        </li>
                    @endif
                    @if ($siteSocialLinks->instagram_url)
                        <li class="list-inline-item">
                            <a target="_blank" href="{{ $siteSocialLinks->instagram_url }}"><i class="ti-instagram"></i></a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="col-md-6">
            <div class="content mb-5">
                <h4 class="mb-3">We'd Love to Hear From You</h4>
                <p>If you have any questions, suggestions, or just want to say hello — don’t hesitate to reach out. We're
                    always here to help and listen.</p>

                <h5 class="mt-5">Prefer Email?</h5>
                <p>
                    <i class="ti-email mr-2 text-primary"></i>
                    <a href="mailto:{{ config('app.contact_email') }}">{{ config('app.contact_email') }}</a>
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <form method="POST" action="{{ route('send_email') }}">
                @csrf
                <x-form-alerts />

                <div class="form-group">
                    <label for="name"><strong>Your Name</strong> <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Jane Doe"
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email"><strong>Your Email Address</strong> <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="e.g. jane@example.com" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subject"><strong>Subject</strong></label>
                    <input type="text" name="subject" id="subject" class="form-control"
                        placeholder="e.g. Business Inquiry" value="{{ old('subject') }}">
                    @error('subject')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="message"><strong>Your Message</strong></label>
                    <textarea name="message" id="message" rows="5" class="form-control" placeholder="Write your message here...">{{ old('message') }}</textarea>
                    @error('message')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mt-3">Send Message</button>
            </form>
        </div>
    </div>
@endsection
