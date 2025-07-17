@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="title">
                    <h4>Profile</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Profile
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @livewire('admin.profile')
@endsection
@push('scripts')
    <script>
        const cropper = new Kropify('#profilePictureFile', {
            aspectRatio: 1,
            preview: '#profilePicturePreview',
            processURL: '{{ route('admin.update_profile_picture') }}', // or processURL:'/crop'
            maxSize: 2 * 1024 * 1024, // 2MB
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            showLoader: true,
            animationClass: 'pulse',
            // fileName: 'avatar', // leave this commented if you want it to default to the input name
            cancelButtonText: 'Cancel',
            maxWoH: 500,
            onError: function(msg) {
                Notifications.showErrorMsg(msg);
            },
            onDone: function(response) {
                Livewire.dispatch('updateTopUserInfo', []);
                Livewire.dispatch('updateProfile', []);
                Notifications.showSuccessMsg(response.message);
            }
        });
    </script>
@endpush
