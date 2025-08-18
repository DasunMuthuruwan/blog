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
                        $social_links = siteSocialLinks();
                        $faceBookUrl = $social_links->facebook_url ?? '';
                        $twitterUrl = $social_links->twitter_url ?? '';
                        $instagramUrl = $social_links->instagram_url ?? '';
                        $linkdinUrl = $social_links->linkdin_url ?? '';
                    @endphp
                    <ul class="list-inline social-icons ml-auto mr-3 d-none d-sm-block">
                        @if ($faceBookUrl)
                            <li class="list-inline-item">
                                <a href="{{ $faceBookUrl }}" target="_blank"><i class="fa fa-facebook"></i></a>
                            </li>
                        @endif

                        @if ($twitterUrl)
                            <li class="list-inline-item">
                                <a href="{{ $twitterUrl }}" target="_blank"><i
                                        class="fa fa-twitter"></i></a>
                            </li>
                        @endif

                        @if ($linkdinUrl)
                            <li class="list-inline-item">
                                <a href="{{ $linkdinUrl }}" target="_blank"><i
                                        class="fa fa-linkedin"></i></a>
                            </li>
                        @endif
                        @if ($instagramUrl)
                            <li class="list-inline-item">
                                <a href="{{ $instagramUrl }}" target="_blank"><i
                                        class="fa fa-instagram"></i></a>
                            </li>
                        @endif
                    </ul>
                </div>

                <img src='{{ asset("images/aboutus/{$about_us->image}") }}' loading="lazy"
                    class="img-fluid w-100 mb-4 rounded-lg" alt="Dev Talk">

                <div class="content">
                    {!! $about_us->content !!}
                </div>
            </div>
        </div>
    </div>

@endsection
