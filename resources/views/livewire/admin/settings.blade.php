<div>
    <div class="pd-20 card-box mb-4">
        <h5 class="h4 text-blue mb-20">General Settings</h5>
        <div class="tab">
            <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item">
                    <a wire:click="selectTab('general_settings')"
                        class="nav-link {{ $tab == 'general_settings' ? 'active' : '' }}" href="#general_settings"
                        role="tab">
                        General Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a wire:click="selectTab('logo_favicon')"
                        class="nav-link {{ $tab == 'logo_favicon' ? 'active' : '' }}" href="#logo_favicon"
                        role="tab">
                        Logo & Favicon
                    </a>
                </li>
                <li class="nav-item">
                    <a wire:click="selectTab('social_links')"
                        class="nav-link {{ $tab == 'social_links' ? 'active' : '' }}" href="#social_links"
                        role="tab">
                        Social Links
                    </a>
                </li>
                <li class="nav-item">
                    <a wire:click="selectTab('about_us')" class="nav-link {{ $tab == 'about_us' ? 'active' : '' }}"
                        href="#about_us" role="tab">
                        About Us
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade {{ $tab == 'general_settings' ? 'show active' : '' }}" id="general_settings"
                    role="tabpanel">
                    <div class="pd-20">
                        <form wire:submit="updateSiteInfo()">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="site_title">Site title</label>
                                        <input type="text" name="site_title" id="site_title" wire:model="site_title"
                                            placeholder="Enter site title" class="form-control form-control-sm">
                                        @error('site_title')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="site_title">Site email</label>
                                        <input type="text" name="site_email" id="site_email" wire:model="site_email"
                                            placeholder="Enter site email" class="form-control form-control-sm">
                                        @error('site_email')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="site_phone">Site phone number</label>
                                        <input type="text" name="site_phone" id="site_phone" wire:model="site_phone"
                                            placeholder="Enter site contact number"
                                            class="form-control form-control-sm">
                                        @error('site_phone')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="site_meta_keywords"><b>Site Meta Keywords</b><small>
                                                (Optional)</small></label>
                                        <input type="text" name="site_meta_keywords" id="site_meta_keywords"
                                            wire:model="site_meta_keywords" placeholder="Eg: free api, laravel, mysql"
                                            class="form-control form-control-sm">
                                        @error('site_meta_keywords')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="site_meta_description"><b>Site Meta Description</b><small>
                                        (Optional)</small></label>
                                <textarea wire:model="site_meta_description" name="site_meta_description" id="site_meta_description"
                                    class="form-control" placeholder="Site meta description..."></textarea>
                                @error('site_meta_description')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save
                                Changes</button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade {{ $tab == 'logo_favicon' ? 'show active' : '' }}" id="logo_favicon"
                    role="tabpanel">
                    <div class="pd-20">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Site Logo</h6>
                                <div class="mb-2 mt-1" style="max-width: 200px">
                                    @php
                                    $siteLogo = settings()->site_logo;
                                    @endphp
                                    <img src='{{ $siteLogo ? asset("storage/images/site/{$siteLogo}") : asset(path: "default-logo.png") }}'
                                        wire:ignore alt="" class="img-thumbnail preview_site_logo"
                                        id="preview_site_logo">
                                </div>
                                <form id="updateLogoForm" enctype="multipart/form-data" method="POST"
                                    class='needs-validation' novalidate='novalidate'>
                                    @csrf
                                    <div class="mb-2">
                                        <input type="file" class="form-control form-control-sm" name="site_logo"
                                            id="site_logo" required>
                                    </div>
                                    <button onclick="updateLogo('#updateLogoForm', event)"
                                        class="btn btn-sm btn-primary"><i class="fa fa-save"></i>
                                        Change Logo</button>
                                </form>
                            </div>

                            <div class="col-md-6">
                                <h6>Site Favicon</h6>
                                <div class="mb-2 mt-1" style="max-width: 100px">
                                    <img src="{{ settings()->site_favicon ? asset('storage/images/site/' . settings()->site_favicon) : asset('default-favicon.png') }}"
                                        wire:ignore alt="" class="img-thumbnail preview_site_favicon"
                                        id="preview_site_favicon">
                                </div>
                                <form enctype="multipart/form-data" id="updateFaviconForm" method="POST"
                                    class= 'needs-validation' novalidate='novalidate'>
                                    @csrf
                                    <div class="mb-2">
                                        <input type="file" class="form-control form-control-sm"
                                            name="site_favicon" id="site_favicon" required>
                                    </div>
                                    <button onclick="updateFavicon('#updateFaviconForm', event)"
                                        class="btn btn-sm btn-primary"><i class="fa fa-save"></i>
                                        Change Favicon</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade {{ $tab == 'social_links' ? 'show active' : '' }}" id="social_links"
                    role="tabpanel">
                    <div class="pd-20">
                        <form wire:submit="updateSiteSocialLinks()">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="facebook"><b>Facebook</b>:</label>
                                        <input type="text" wire:model="facebook_url"
                                            class="form-control form-control-sm" placeholder="Facebook URL">
                                        @error('facebook_url')
                                            <span class="text-danger small ml-1">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="instagram"><b>Instagram</b>:</label>
                                        <input type="text" wire:model="instagram_url"
                                            class="form-control form-control-sm" placeholder="Instagram URL">
                                        @error('instagram_url')
                                            <span class="text-danger small ml-1">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="linkdin"><b>Linkdin</b>:</label>
                                        <input type="text" wire:model="linkdin_url"
                                            class="form-control form-control-sm" placeholder="Linkdin URL">
                                        @error('linkdin_url')
                                            <span class="text-danger small ml-1">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="twitter"><b>Twitter (X)</b>:</label>
                                        <input type="text" wire:model="twitter_url"
                                            class="form-control form-control-sm" placeholder="Twitter URL">
                                        @error('twitter_url')
                                            <span class="text-danger small ml-1">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="fa fa-save"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade {{ $tab == 'about_us' ? 'show active' : '' }}" id="about_us"
                    role="tabpanel">
                    <div class="pd-20">
                        <form wire:submit="updateSiteAboutUs()">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="content"><b>Content</b>:</label>
                                        <div wire:ignore>
                                            <textarea id="content" class="ckeditor form-control" placeholder="Enter about us content here...">
        {!! $content !!}
    </textarea>
                                        </div>
                                        @error('content')
                                            <span class="text-danger small ml-1">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        @if ($selected_image)
                                            <div class="d-block" style="max-width: 200px">
                                                <img src="{{ $selected_image }}" alt="image"
                                                    class="img-thumbnail" style="max-width: 100%; height:auto">
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="slide_image"><b>Image</b>:</label>
                                            <input type="file" wire:model="image"
                                                class="form-control form-control-sm" wire:ignore>
                                            @error('image')
                                                <span class="text-danger small ml-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="twitter"><b>Meta Keywords</b>(Comma seperated):</label>
                                        <input type="text" wire:model="meta_keywords"
                                            class="form-control form-control-sm" placeholder="Meta Keywords">
                                        @error('meta_keywords')
                                            <span class="text-danger small ml-1">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="twitter"><b>Meta Descriptions</b>:</label>
                                        <textarea type="text" wire:model="meta_descriptions" class="form-control form-control-sm"
                                            placeholder="Meta Descriptions"></textarea>
                                        @error('meta_descriptions')
                                            <span class="text-danger small ml-1">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="fa fa-save"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('back/src/custom/FormOptions.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('ckeditor/plugins/codesnippet/plugin.js') }}"></script>
    <script src="{{ asset('ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js') }}"></script>
    {{-- <script src="{{ asset('back/src/custom/imagePreview.js') }}"></script> --}}
    <script>
        function initCkeditor() {
            if (CKEDITOR.instances.content) {
                CKEDITOR.instances.content.destroy(true); // remove old instance if exists
            }

            CKEDITOR.replace('content', {
                height: 400,
                extraPlugins: 'codesnippet,uploadimage,image,clipboard,dialog,dialogui,widget,lineutils,justify,colorbutton,font',
                codeSnippet_theme: 'default',
                toolbar: [{
                        name: 'document',
                        items: ['Source', '-', 'Preview', 'Print']
                    },
                    {
                        name: 'clipboard',
                        items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
                    },
                    {
                        name: 'editing',
                        items: ['Find', 'Replace', '-', 'SelectAll', 'Scayt']
                    },
                    {
                        name: 'insert',
                        items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar', 'Embed', 'CodeSnippet']
                    },
                    {
                        name: 'styles',
                        items: ['Styles', 'Format', 'Font', 'FontSize']
                    },
                    {
                        name: 'basicstyles',
                        items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat']
                    },
                    {
                        name: 'paragraph',
                        items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink', 'Anchor']
                    },
                    {
                        name: 'tools',
                        items: ['Maximize', 'ShowBlocks']
                    },
                    {
                        name: 'colors',
                        items: ['TextColor', 'BGColor']
                    },
                    {
                        name: 'align',
                        items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                    }
                ],
                autoGrow_minHeight: 300,
                autoGrow_maxHeight: 600,
                autoGrow_bottomSpace: 50,
                removePlugins: 'resize'
            });

            CKEDITOR.instances.content.on('change', function() {
                @this.set('content', CKEDITOR.instances.content.getData());
            });
        }

        document.addEventListener('livewire:load', () => {
            initCkeditor();
        });

        document.addEventListener('livewire:navigated', () => {
            initCkeditor();
        });

        Livewire.on('refreshCkeditor', () => {
            initCkeditor();
        });
    </script>
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

            $('#site_logo').imagePreview('#preview_site_logo');
            $('#site_favicon').imagePreview('#preview_site_favicon');

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

            let logoRules = {
                rules: {
                    site_logo: {
                        required: true,
                        extension: "jpg|jpeg|png|gif|svg|webp",
                        filesize: 2 // 2MB
                    }
                },
                messages: {
                    site_logo: {
                        required: "Please select a logo image",
                        extension: "Please upload an image file (jpg, jpeg, png, gif, svg, webp)",
                        filesize: "File size must be less than 2MB"
                    }
                }
            }
            let favionRules = {
                rules: {
                    site_favicon: {
                        required: true,
                        extension: "ico|png|jpg|jpeg|gif|svg",
                        filesize: 1 // 1MB
                    }
                },
                messages: {
                    site_favicon: {
                        required: "Please select a favicon image",
                        extension: "Please upload an ico, png, jpg, jpeg, gif or svg file",
                        filesize: "File size must be less than 1MB"
                    }
                }
            }

            FormOptions.initValidation('updateLogoForm', logoRules);
            FormOptions.initValidation('updateFaviconForm', favionRules);
        });

        function updateLogo(formId, event) {
            const form = $(formId);
            if (form.valid()) {
                event.preventDefault();
                const formData = new FormData(form[0]);

                $.ajax({
                    url: "{{ route('admin.update_logo') }}",
                    method: $(formId).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.success) {
                            $(form)[0].reset();
                            Notifications.showSuccessMsg(data.message);

                            $('img.brand_logo').each(function() {
                                $(this).attr('src', `/${data.data.image_path}`);
                            });
                            $('img.site_logo').each(function() {
                                $(this).attr('src', `/${data.data.image_path}`);
                            });
                        } else {
                            Notifications.showErrorMsg(data.message);
                        }
                    },
                    error: function(xhr) {
                        Notifications.showErrorMsg(xhr.responseJSON?.message || 'Upload failed');
                    },
                });
            }
        }

        function updateFavicon(formId, event) {
            const form = $(formId);
            if (form.valid()) {
                event.preventDefault();
                const formData = new FormData(form[0]);

                $.ajax({
                    url: "{{ route('admin.update_favicon') }}",
                    method: $(formId).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.success) {
                            $(form)[0].reset();
                            Notifications.showSuccessMsg(data.message);
                            $('img.site_favicon').each(function() {
                                $(this).attr('src', `/${data.data.image_path}`);
                            });
                            var linkElement = document.querySelector("link[rel*='icon']");
                            if (linkElement) {
                                linkElement.href = `/${data.data.image_path}`;
                            }
                        } else {
                            Notifications.showErrorMsg(data.message);
                        }
                    },
                    error: function(xhr) {
                        Notifications.showErrorMsg(xhr.responseJSON?.message || 'Upload failed');
                    },
                });
            }
        }
    </script>
@endpush
