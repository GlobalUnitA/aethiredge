$(document).ready(function() {
    
    $('#approvalBtn').click(function() {
        event.preventDefault();
        let formData = new FormData($('#statusForm')[0]);

        formData.append('id', $('input[name="id"]').val());
        formData.append('status', 'p');
        formData.append('usdt', $('input[name="usdt"]').val());
        formData.append('created_at', $('input[name="created_at"]').val());
       
        $.ajax({
            url: $('#statusForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                showModal(response.status, response.message, response.url);
            },
            error: function( xhr, status, error) {
                console.log(error);
                showModal('error', '예기치 못한 오류가 발생했습니다.');
            }
        });
    
    });

    $('#cancelBtn').click(function() {
        event.preventDefault();
        let formData = new FormData($('#statusForm')[0]);

        formData.append('id', $('input[name="id"]').val());
        formData.append('status', 'c');
        formData.append('usdt', $('input[name="usdt"]').val());
        
        $.ajax({
            url: $('#statusForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                showModal(response.status, response.message, response.url);
            },
            error: function( xhr, status, error) {
                console.log(error);
                showModal('error', '예기치 못한 오류가 발생했습니다.');
            }
        });
    
    });
});