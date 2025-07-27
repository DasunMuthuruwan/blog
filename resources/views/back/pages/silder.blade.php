@extends('back.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Page Title')
@section('content')
    @livewire('admin.slides')
@endsection
@push('scripts')
<script src="{{ asset('back/src/custom/FormOptions.js') }}"></script>
    <script>
        var modal = $('#slide_modal');
        window.addEventListener('showSlideModalForm', function(e) {
            modal.modal('show');
        })
        window.addEventListener('hideSlideModalForm', function(e) {
            modal.modal('hide');
        })

        $('table tbody#sortable_slides').sortable({
            cursor: "move",
            update: function(event, ui) {
                $(this).children().each(function(index) {
                    if ($(this).attr('data-ordering') != (index + 1)) {
                        $(this).attr('data-ordering', (index + 1)).addClass('updated');
                    }
                });
                var positions = [];
                $('.updated').each(function() {
                    positions.push([$(this).attr('data-index'), $(this).attr('data-ordering')]);
                    $(this).removeClass('updated');
                });
                Livewire.dispatch('updateSlidesOrdering', [positions]);
            }
        })

        window.addEventListener('deleteSlide', function(event) {
            FormOptions.deleteRecord(event.detail.id, 'deleteSlideAction');
        })
    </script>
@endpush
