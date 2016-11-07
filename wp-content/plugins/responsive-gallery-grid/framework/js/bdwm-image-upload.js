/* global ajaxurl */
(function($) {
    $(document).ready(function() {
        var frame;

        $('.choose-from-library-link').click( function( event ) {
            var $el = $(this);
            var $inputfield = $('#'+$el.data('field'));
            var $imgcontainer = $('#'+$el.data('image_container'));

            event.preventDefault();

            // Create the media frame.
            frame = wp.media.frames.customBackground = wp.media({
                // Set the title of the modal.
                title: $el.data('choose'),

                // Tell the modal to show only images.
                library: {
                    type: 'image'
                },

                // Customize the submit button.
                button: {
                    // Set the text of the button.
                    text: $el.data('update'),
                    close: true
                }
            });

            // When an image is selected, run a callback.
            frame.on( 'select', function() {
                // Grab the selected attachment.
                var attachment = frame.state().get('selection').first();
                
                $inputfield.val(attachment.id);
                $imgcontainer.html('<img src="'+attachment.attributes.url+'" height="100">');;
                
            });

            // Finally, open the modal.
            frame.open();
        });
    });
})(jQuery);
    