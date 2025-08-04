@extends('back.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Page Title')
@section('content')
    @livewire('admin.advertisements')
@endsection
@push('scripts')
    <script src="{{ asset('back/src/custom/FormOptions.js') }}"></script>
    <script>
        function initializeDatePickers() {
            // Initialize new datepickers
            $('.date-picker').datepicker({
                dateFormat: 'yyyy-mm-dd',
                autoClose: true,
                minDate: new Date(),
                onSelect: function(formattedDate, date, inst) {
                    // This is the correct callback for date selection
                    const fieldId = inst.el.id;

                    // Use Livewire.dispatch to communicate with component
                    if (fieldId == 'start_at_picker') {
                        Livewire.dispatch('updateStartAt', {
                            value: formattedDate
                        });
                    } else if (fieldId == 'end_at_picker') {
                        Livewire.dispatch('updateEndAt', {
                            value: formattedDate
                        });
                    }
                }
            })

        }

        var modal = $('#advertisement_modal');
        window.addEventListener('showAdvertisementModalForm', function(e) {
            modal.modal('show');
            setTimeout(initializeDatePickers, 100);
            Livewire.on('setEditDates', function(dates) {
                
                if (dates[0].start_at) {
                    $('#start_at_picker').datepicker('setDate', new Date(dates[0].start_at));
                }
                if (dates[0].end_at) {
                    
                    console.log(dates[0].end_at);
                    $('#end_at_picker').datepicker('setDate', new Date(dates[0].end_at));
                }
            });
        })

        window.addEventListener('hideAdvertisementModalForm', function(e) {
            modal.modal('hide');
            $('.date-picker').val('');
        })

        window.addEventListener('deleteAd', function(event) {
            FormOptions.deleteRecord(event.detail.id, 'deleteAdvertisementAction');
        })

        // initializeDatePickers();
    </script>
@endpush
