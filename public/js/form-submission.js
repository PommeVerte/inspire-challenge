/**
 *  @todo place in a widget to be more flexible and reusable. Felt like it was outside the scope of this challenge since it also requires importing jquery.ui.widget.js
 */


/**
 *  Disable Ajax submissions (button)
 *
 *  We do not want to use the [disabled] attribute as it shifts the focus from the button to the document.
 *  This can lead to odd behavior for some accessibility features (like keyboards navigation, visually impaired features, etc)
 *  Instead we will:
 *  - Use a .disabled class instead of the [disabled] attribute.
 *  - Update the button text to indicate that the form is submitting and should not be clicked again.
 *  - Ignore any additional submits until the previous submission is finished.
 *
 * @param btn jQuery for button element
 * @return bool true if successful, false if the form is already disabled
 */
function disableSubmissions(btn) {
    // check if the button is already disabled
    if (typeof btn.attr('data-original') != 'undefined')
        return false;

    // disable the button
    btn.addClass('disabled');

    // Store the original text to a data attribute
    btn.attr('data-original', btn.text());
    // Change the button text
    btn.html('Sending...');

    return true;
}

/**
 * Enable Ajax submissions
 *
 * @see disableSubmissions
 * @param btn jQuery for button element
 */
function enableSubmissions(btn) {
    // Restore the button text
    btn.html(btn.attr('data-original'));

    // Remove the data attribute
    btn.removeAttr('data-original');

    // enable the button
    btn.removeClass('disabled');
}

/**
 * Will display the error in the form.
 * We only display one error message per field (the first one)
 *
 * @param form Jquery element for the form
 * @param name name of the field
 * @param errors array list of errors for this field
 */
function displayError(form, name, errors) {
    if (Array.isArray(errors) && errors.length) {
        form.find('[name=' + name + ']').addClass('is-invalid') // set invalid class on input
            .siblings('.text-danger').html(errors[0]); // add error message
    }
}

/**
 *  Reset all errors currently displayed in the form
 *
 * @param form Jquery element for the form
 */
function resetErrors(form) {
    form.find('.is-invalid').removeClass('is-invalid');
    form.find('.text-danger').html('');
}


/**
 *  Handles the success display and animation
 *
 * @param form Jquery element for the form
 */
function displaySuccess(form) {
    // Create the success message
    let successMessage = $('<div>').addClass('alert alert-success text-center');
    successMessage.attr('role', 'alert');
    successMessage.html("We have received your message!");

    //animate the form. Scroll the user up and slideUp the form simultaneously
    $([document.documentElement, document.body]).animate({
        scrollTop: form.offset().top - (form.height() / 2)
    }, 300);
    form.slideUp(300, function () {
        form.hide();
        successMessage.hide().insertAfter(form).fadeIn(300);
    });
}


/**
 *  Set Ajax submission and handling of the contact form
 */
$(function () {
    $('.contact-form').on('submit', function (e) {
        // Prevent default behavior
        e.preventDefault();

        let form = $(this);
        let submitButton = form.find('button[type="submit"]');

        // Stop here if we can't disable the form (already disabled)
        if (!disableSubmissions(submitButton)) return;

        // lets reset error messages
        resetErrors(form);

        // run ajax call
        $.post(form.attr('action'), form.serialize(), function (data) {
            //success
            displaySuccess(form);
        }, 'json')
            .fail(function (data) {
                //parse data
                let json = $.parseJSON(data.responseText);

                //loop on all errors
                $.each(json['errors'], function (key, value) {
                    displayError(form, key, value);
                });
            })
            .always(function () {
                enableSubmissions(submitButton);
            });
    });
});
