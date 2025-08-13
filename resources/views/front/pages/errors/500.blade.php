@extends('front.layout.error-pages-layout')
@section('pageTitle', 'Server Error')
@section('content')
    <div class="error-page d-flex align-items-center flex-wrap justify-content-center pd-20">
        <div class="pd-10">
            <div class="error-page-wrap text-center">
                <h1>500</h1>
                <h3>Server Error</h3>
                <p>
                    This error indicates that the server encountered an unexpected condition that prevented it from fulfilling the request
                </p>
                <div class="pt-20 mx-auto max-width-200">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-block rounded">Back To Home</a>
                </div>
            </div>
        </div>
    </div>
@endsection
