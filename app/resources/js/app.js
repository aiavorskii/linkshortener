require('@popperjs/core')
import notification from 'notification-js'
import axios from 'axios';
import { Modal } from 'bootstrap';
import jQuery from 'jquery';

(($) => {

    $(document).on('click', '#clipboard-copy-button', function(e) {
        $("#copy-field").removeAttr('disabled');
        navigator.clipboard.writeText($("#copy-field").val())
        $("#copy-field").attr('disabled', true);
        notification.notify( 'success', 'Copied' );
    });


    $('#link-form').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(document.querySelector('#link-form'))

        axios.post('/link-create', Object.fromEntries(formData)).then((response) => {
            // open modal
            $('#copy-field').val(response.data.link)

            let linkModal = new Modal(document.getElementById('link-modal'))
            linkModal.show()
        }).catch((error) => {
            if (error.response.data.errors !== undefined) {
                for (const [field, message] of Object.entries(error.response.data.errors)) {
                    notification.notify( 'error', message );
                }
            } else {
                notification.notify( 'error', 'Error occured' );
            }
        });
    })
})(jQuery)

