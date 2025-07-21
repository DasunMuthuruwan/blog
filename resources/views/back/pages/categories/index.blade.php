@extends('back.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Page Title')
@section('content')
    @livewire('admin.category.categories')
@endsection
@push('scripts')
<script src="{{ asset('back/src/custom/FormOptions.js') }}"></script>
    <script>
        window.addEventListener('showParentCategoryModalForm', function() {
            $('#parent_category_modal').modal('show');
        });

        window.addEventListener('hideParentCategoryModalForm', function() {
            $('#parent_category_modal').modal('hide');
        })

        window.addEventListener('showCategoryModalForm', function() {
            $('#category_modal').modal('show');
        });

        window.addEventListener('hideCategoryModalForm', function() {
            $('#category_modal').modal('hide');
        })

        $('table tbody#sortable_parent_categories').sortable({
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
                Livewire.dispatch('updateParentCategoryOrdering', [positions]);

            }
        })

        $('table tbody#sortable_categories').sortable({
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
                Livewire.dispatch('updateCategoryOrdering', [positions]);

            }
        })

        window.addEventListener('deleteParentCategory', function(event) {
            let id = event.detail[0].id;
            FormOptions.deleteRecord(id, 'deleteParentCategoryAction');
        })

        window.addEventListener('deleteCategory', function(event) {
            let id = event.detail[0].id;
            FormOptions.deleteRecord(id, 'deleteCategoryAction');
        })
    </script>
@endpush
