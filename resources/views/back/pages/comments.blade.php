@extends('back.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Page Title')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="title">
                    <h4>Comments</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Comments
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    @livewire('admin.comments')
@endsection
@push('scripts')
    <script src="{{ asset('back/src/custom/FormOptions.js') }}"></script>
    <script>
        window.addEventListener('deleteComments', function(event) {
            FormOptions.deleteRecord(event.detail.id, 'deleteCommentAction');
        })
    </script>
@endpush
