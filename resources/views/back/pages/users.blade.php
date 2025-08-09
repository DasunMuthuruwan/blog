@extends('back.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Page Title')
@section('content')
    @livewire('admin.users')
@endsection
@push('scripts')
    <script src="{{ asset('back/src/custom/FormOptions.js') }}"></script>
    <script>
        var modal = $('#user_modal');
        window.addEventListener('showUserModalForm', function(e) {
            modal.modal('show');
        })
        window.addEventListener('hideUserModalForm', function(e) {
            modal.modal('hide');
        })
        window.addEventListener('deleteUser', function(event) {
            FormOptions.deleteRecord(event.detail.id, 'deleteUserAction');
        })
    </script>
@endpush
