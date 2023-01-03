import axios from "axios";
import $ from 'jquery';

const loadMailSetting = function () {
    axios.get('/profile/mail-settings').then(response => {
        for (const key in response.data) {
            const value = response.data[key];
            $('#' + key).prop('checked', value);
        }
    });
}

const handle_cancel_click = function() {
    $('.popup-body').hide();
}

const handle_checkbox = function(evt) {
    evt.preventDefault();
    const type = evt.target.id;
    const data = { 'type':type };
    axios.patch('/profile/mail-settings',data)
        .then( () => loadMailSetting() );
}

$(() => {
    loadMailSetting();
    $('#cancel-button').on('click', handle_cancel_click);
    $('input[type="checkbox"]').on('change', handle_checkbox);

    setTimeout(function() {
        $('.value-updated').fadeOut('slow');
    }, 2000);  
});