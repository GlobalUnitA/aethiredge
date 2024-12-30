$(document).ready(function() {
    $('#inputEmail').focusout(function() {
        var self = this;
        var email = $(self).val();
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

        if (!emailRegex.test(email)) {
            showModal('error', '잘못된 이메일 향식입니다.');
            $(self).val('');
        } else {

            $('#inputEmailCheck').val(email);

            const emailCheckForm = $('#emailCheckForm')[0];
            const emailCheckFormData = new FormData(emailCheckForm);

            $.ajax({
                url: $(emailCheckForm).attr('action'),
                type: 'POST',
                data: emailCheckFormData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.status !== 'success') {
                        showModal(response.status, response.message, response.url);
                        $(self).val('');
                    }
                },
                error: function() {
                    showModal('error', '예기치 못한 오류가 발생했습니다.');
                }
            });
        }
    });
});