@extends('back.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Page Title')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Add post</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Add post
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <a href="{{ route('admin.posts') }}" class="btn btn-sm btn-primary">View all posts</a>
            </div>
        </div>
    </div>
    <form id="addPostForm" action="{{ route('admin.create_post') }}" method="POST" class='needs-validation' novalidate='novalidate'
        autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="card card-box mb-2">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title"><b>Title</b>:</label>
                            <input type="text" name="title" class="form-control form-control-sm" id="title"
                                placeholder="Enter post title" required>
                        </div>
                        <div class="form-group">
                            <label for="title"><b>Content</b>:</label>
                            <textarea name="content" id="content" cols="30" rows="10" class="form-control"
                                placeholder="Enter post content here..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="card card-box mb-2">
                    <div class="card-header weight-500">SEO</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="meta_keywords"><b>Post meta keywords</b><small>(Seperated by comma)</small>:</label>
                            <input type="text" class="form-control form-control-sm" name="meta_keywords"
                                id="meta_keywords" placeholder="Enter post meta keywords">
                        </div>
                        <div class="form-group">
                            <label for="meta_description"><b>Post meta description</b>:</label>
                            <textarea name="meta_description" id="meta_description" cols="30" rows="10" class="form-control"
                                placeholder="Enter post meta description here..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-box mb-2">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="category"><b>Post category</b>:</label>
                            <select name="category" id="category" class="custom-select form-control form-control-sm"
                                required>
                                <option value="">Choose...</option>
                                {!! $categories_html !!}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="feature_image"><b>Post Featured image</b>:</label>
                            <input type="file" class="form-control-file form-control form-control-sm"
                                name="feature_image" id="feature_image" height="auto" required>
                        </div>
                        <div class="d-block mb-3" style="max-width: 250px;">
                            <img src="" alt="" class="img-thumbnail" id="featured_image_preview">
                        </div>
                        <div class="form-group">
                            <label for="tags"><b>Tags</b></label>
                            <input type="text" class="form-control form-control-sm" name="tags" data-role="tagsinput">
                        </div>
                        <div class="form-group">
                            <label for="visibility"><b>Visibility</b>:</label>
                            <div class="custom-control custom-radio mb-5">
                                <input type="radio" name="visibility" id="customRadio1" class="custom-control-input"
                                    value="1" checked>
                                <label for="customRadio1" class="custom-control-label">Public</label>
                            </div>
                            <div class="custom-control custom-radio mb-5">
                                <input type="radio" name="visibility" id="customRadio2" class="custom-control-input">
                                <label for="customRadio2" class="custom-control-label">Private</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <button type="button" onclick="FormOptions.submitForm('addPostForm', true, {'imagePreviewId':'featured_image_preview', 'tagsinput': 'tags'})" class="btn btn-sm btn-primary"><i
                    class="fa fa-save"></i> Create post</button>
        </div>
    </form>
@endsection
@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('back/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('back/src/custom/FormOptions.js') }}"></script>
    <script src="{{ asset('back/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    {{-- <script src="{{ asset('back/src/custom/imagePreview.js') }}"></script> --}}

    <script>
        $(document).ready(function() {
            (function($) {
                $.fn.imagePreview = function(previewSelector) {
                    this.on('change', function() {
                        const file = this.files[0];
                        if (file && file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                $(previewSelector).attr('src', e.target.result).show();
                            };
                            reader.readAsDataURL(file);
                        } else {
                            $(previewSelector).hide().attr('src', '#');
                        }
                    });
                    return this;
                };
            })(jQuery);
            $('#feature_image').imagePreview('#featured_image_preview');

            // Custom method for file extension validation
            $.validator.addMethod("extension", function(value, element, param) {
                param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
                return this.optional(element) || value.match(new RegExp("\\.(" + param + ")$",
                    "i"));
            });

            // Custom method for file size validation (in MB)
            $.validator.addMethod("filesize", function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param * 1024 * 1024);
            });

            FormOptions.initValidation('addPostForm', {
                rules: {
                    feature_image: {
                        required: true,
                        extension: "png|jpg|jpeg|svg|webp",
                        filesize: 1 // 2MB
                    }
                },
                messages: {
                    feature_image: {
                        required: "Please select a feature image",
                        extension: "Please upload an image file (jpg, jpeg, png, svg, webp)",
                        filesize: "File size must be less than 2MB"
                    }
                }
            });
        });
    </script>
@endpush
