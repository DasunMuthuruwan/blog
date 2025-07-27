@extends('front.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Document title')
@section('meta_tags')
    {!! SEO::generate(true) !!}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="mb-5 d-flex align-items-center">
                    <h3 class="title-color">About Us</h3>
                    <ul class="list-inline social-icons ml-auto mr-3 d-none d-sm-block">
                        @if (siteSocialLinks()->facebook_url)
                            <li class="list-inline-item">
                                <a href="{{ siteSocialLinks()->facebook_url }}" target="_blank"><i class="ti-facebook"></i></a>
                            </li>
                        @endif

                        @if (siteSocialLinks()->twitter_url)
                            <li class="list-inline-item">
                                <a href="{{ siteSocialLinks()->twitter_url }}" target="_blank"><i
                                        class="ti-twitter-alt"></i></a>
                            </li>
                        @endif

                        @if (siteSocialLinks()->linkdin_url)
                            <li class="list-inline-item">
                                <a href="{{ siteSocialLinks()->linkdin_url }}" target="_blank"><i
                                        class="ti-linkedin"></i></a>
                            </li>
                        @endif
                        @if (siteSocialLinks()->instagram_url)
                            <li class="list-inline-item">
                                <a href="{{ siteSocialLinks()->instagram_url }}" target="_blank"><i
                                        class="ti-instagram"></i></a>
                            </li>
                        @endif
                    </ul>
                </div>

                <img src="{{ asset('front/images/posts/10.png') }}" class="img-fluid w-100 mb-4 rounded-lg"
                    alt="TechSolve Central">

                <div class="content">
                    <p>Welcome to <strong>{{ config('app.name') }}</strong> – your go-to hub for practical programming tips, code
                        examples, and solutions to everyday development challenges.</p>

                    <p>Our blog is dedicated to helping developers by providing clear and concise code snippets, tutorials,
                        and problem-solving guides across a wide range of technologies. Whether you're a beginner or a
                        seasoned developer, you'll find valuable content here.</p>

                    <h4>🚀 What We Cover:</h4>
                    <p>We share real-world examples and snippets in technologies such as:</p>
                    <ul>
                        <li>PHP & Laravel Framework</li>
                        <li>CSS3, HTML5, and Bootstrap</li>
                        <li>MySQL & Database Optimization</li>
                        <li>jQuery & JavaScript</li>
                        <li>React, Vue</li>
                        <li>Server Configuration & Hosting Tips</li>
                    </ul>

                    <h4>💡 Our Goal:</h4>
                    <p>Our mission is to make coding easier and more accessible by sharing simple, effective solutions to
                        complex problems. Every snippet we post is tested and optimized to save you time and frustration.
                    </p>

                    <h4>📣 Get Involved:</h4>
                    <p>We love hearing from our readers! If you find a bug, have a suggestion, or want to share your
                        approach to a problem, leave a comment under the post. Your feedback helps us grow and keeps the
                        content fresh and relevant.</p>

                    <h4>📱 Connect With Us:</h4>
                    <p>You can also follow us on social media for quick updates, new post alerts, and tech discussions:</p>
                    <ul>
                        <li><a href="https://medium.com/@techsolver" target="_blank">Medium</a></li>
                    </ul>

                    <p>Thank you for being a part of the <strong>{{ config('app.name') }}</strong> community. Let’s solve problems,
                        learn new things, and build awesome projects together!</p>
                </div>
            </div>
        </div>
    </div>

@endsection
