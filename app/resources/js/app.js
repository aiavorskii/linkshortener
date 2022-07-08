const { default: axios } = require('axios');
require('./bootstrap');
require('axios');
import jQuery from 'jquery';

(($) => {
    $('#link-form').on('submit', function(e) {
        e.preventDefault();
        
        axios.post('/link-create', {
            data: $(this).serializeArray(),
            success: () => {

            },
            error: () => {

            }
        });
    })
})(jQuery)

