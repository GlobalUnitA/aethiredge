$(document).ready(function() {
    $('#loginForm').on('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                showModal(response.status, response.message, response.url);
            },
            error: function() {
                showModal('error', '예기치 못한 오류가 발생했습니다.');
            }
        });
    });
});