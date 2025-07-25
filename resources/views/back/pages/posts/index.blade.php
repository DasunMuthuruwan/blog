@extends('back.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Page Title')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Posts</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            List
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <a href="{{ route('admin.add_post') }}" class="btn btn-sm btn-primary">
                    <i class="icon-copy bi bi-plus-circle mr-1"></i>Add post
                </a>
            </div>
        </div>
    </div>
    @livewire('admin.posts')
@endsection
@push('scripts')
    <script src="{{ asset('back/src/custom/FormOptions.js') }}"></script>
    <script>
        window.addEventListener('deletePost', function(event) {
            console.log(event.detail[0].id);
            
            const id = event.detail[0].id;
            FormOptions.deleteRecord(id, 'deletePostAction');
        })
    </script>
@endpush
