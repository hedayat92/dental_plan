/*
 *  Document   : readyPatients.js
 *  Author     : webtech
 *  Description: Custom javascript code used in Register page
 */

var ReadyPatients = function() {

    return {
        init: function() { 
            /*
             *  Jquery Validation, Check out more examples and documentation at https://github.com/jzaefferer/jquery-validation
             */

            /* Register form - Initialize Validation */
            $('#form-patients').validate({
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
                    'patient_email': {
                        required: true,
						email: true
                    },
                    'patient_password': {
                        required: true,
						minlength: 5
                    },
                    'patient_name': {
                        required: true
                    },
                    'patient_dob': {
                        required: true
                    },
                    'patient_sex': {
                        required: true
                    },
                    'patient_address': {
                        required: true
                    },
                    'patient_zip': {
                        required: true,
                        minlength: 5
                    }
                },
                messages: {
                    'patient_email': 'Please enter Valid Email ID',
                    'patient_password': {
                        required: 'Please provide a password',
                        minlength: 'Your password must be at least 5 characters long'
                    },
                    'patient_name': 'Please enter Name',
                    'patient_dob': 'Please enter DOB',
                    'patient_sex': 'Please choose Sex',
                    'patient_address': 'Please your address',
                    'patient_zip': {
                        required: 'Please enter Zipcode',
                        minlength: 'Zipcode must be at least 5 characters long'
                    }/*,
                    'register-terms': {
                        required: 'Please accept the terms!'
                    }*/
                }
            });
        }
    };
}();