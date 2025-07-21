// resources/js/utilities/imagePreview.js

export default class ImagePreview {
    /**
     * Initialize image preview functionality
     * @param {jQuery} $input - The file input element
     * @param {string} previewSelector - Selector for the preview image element
     */
    static init($input, previewSelector) {
        $input.on('change', function() {
            const file = this.files[0];
            const $preview = $(previewSelector);
            
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $preview.attr('src', e.target.result).show();
                };
                reader.readAsDataURL(file);
            } else {
                $preview.hide().attr('src', '#');
            }
        });
    }

    /**
     * jQuery plugin style initialization
     */
    static jQueryPlugin() {
        $.fn.imagePreview = function(previewSelector) {
            return this.each(function() {
                ImagePreview.init($(this), previewSelector);
            });
        };
    }
}

// Auto-initialize if jQuery is available
if (typeof jQuery !== 'undefined') {
    ImagePreview.jQueryPlugin();
}