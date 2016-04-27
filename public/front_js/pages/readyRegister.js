/*
 *  Document   : readyRegister.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Register page
 */

var ReadyRegister = function() {

    return {
        init: function() {
            /*
             *  Jquery Validation, Check out more examples and documentation at https://github.com/jzaefferer/jquery-validation
             */

            /* Register form - Initialize Validation */
            $('#form-register').validate({
                errorClass: 'help-block animation-slideUp', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    if (e.closest('.form-group').find('.help-block').length === 2) {
                        e.closest('.help-block').remove();
                    } else {
                        e.closest('.form-group').removeClass('has-success has-error');
                        e.closest('.help-block').remove();
                    }
                },
                rules: {
                    'doc_firstname': {
                        required: true
                    },
                    'doc_lastname': {
                        required: true
                    },
                    'doc_email': {
                        required: true,
                        email: true
                    },
                    'doc_phone': {
                        required: true,
                        minlength: 10
                    },
                    'doc_address': {
                        required: true
                    },
                    'doc_zip': {
                        required: true,
                        minlength: 5
                    },
                    'doc_sex': {
                        required: true
                    },
                    'doc_speciality': {
                        required: true
                    },
                    'doc_username': {
                        required: true,
                    },
                    'doc_pass': {
                        required: true,
                        minlength: 5
                    },
                    'password-verify': {
                        required: true,
                        equalTo: '#doc_pass'
                    },
                    'doc_license_no': {
                        required: true
                    },
                    'doc_contact_person': {
                        required: true
                    }
                },
                messages: {
                    'doc_firstname': 'Please enter First Name',
                    'doc_lastname': 'Please enter Last Name',
                    'email': 'Please enter a valid email address',
                    'doc_phone': {
                        required: 'Please enter Phone Number',
                        minlength: 'Phone Number must be at least 10 characters long'
                    },
                    'doc_address': 'Please enter Address',
                    'doc_zip': {
                        required: 'Please enter Zipcode',
                        minlength: 'Zipcode must be at least 5 characters long'
                    },
                    'doc_sex': 'Please choose Sex',
                    'doc_speciality': 'Please enter Speciality',
                    'doc_username': 'Please enter Username',
                    'password': {
                        required: 'Please provide a password',
                        minlength: 'Your password must be at least 5 characters long'
                    },
                    'password-verify': {
                        required: 'Please provide a password',
                        minlength: 'Your password must be at least 5 characters long',
                        equalTo: 'Please enter the same password as above'
                    },
                    'doc_license_no': 'Please enter License No.',
                    'doc_contact_person': {
                        required: 'Please enter Contact Person'
                    }
                }
            });
        }
    };
}();