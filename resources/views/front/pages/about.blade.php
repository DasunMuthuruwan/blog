@extends('front.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Document title')
@section('meta_tags')
    {!! SEO::generate(true) !!}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="mb-2 d-flex align-items-center">
                    <h3 class="title-color">About Us</h3>
                    @php
                        $siteSocialLinks = siteSocialLinks();
                    @endphp
                    <ul class="list-inline social-icons ml-auto mr-3 d-none d-sm-block">
                        @if ($siteSocialLinks->facebook_url)
                            <li class="list-inline-item">
                                <a href="{{ $siteSocialLinks->facebook_url }}" target="_blank"><i class="ti-facebook"></i></a>
                            </li>
                        @endif

                        @if ($siteSocialLinks->twitter_url)
                            <li class="list-inline-item">
                                <a href="{{ $siteSocialLinks->twitter_url }}" target="_blank"><i
                                        class="ti-twitter-alt"></i></a>
                            </li>
                        @endif

                        @if ($siteSocialLinks->linkdin_url)
                            <li class="list-inline-item">
                                <a href="{{ $siteSocialLinks->linkdin_url }}" target="_blank"><i
                                        class="ti-linkedin"></i></a>
                            </li>
                        @endif
                        @if ($siteSocialLinks->instagram_url)
                            <li class="list-inline-item">
                                <a href="{{ $siteSocialLinks->instagram_url }}" target="_blank"><i
                                        class="ti-instagram"></i></a>
                            </li>
                        @endif
                    </ul>
                </div>

                <img src='{{ asset("images/aboutus/{$about_us->image}") }}' loading="lazy" class="img-fluid w-100 mb-4 rounded-lg"
                    alt="Dev Talk">

                <div class="content">
                    {!! $about_us->content !!}
                </div>
            </div>
        </div>
    </div>

@endsection
