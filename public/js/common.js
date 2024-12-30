// number format
function number_format(number) {

    number = parseFloat(number);
    if (isNaN(number)) return '0';
    const fixedNumber = number.toFixed(0);
    
    const parts = fixedNumber.split('.');
    let integerPart = parts[0];
    let decimalPart = parts[1] || '';

    integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

    return decimalPart ? `${integerPart}${'.'}${decimalPart}` : integerPart;
}

// toggle
function toggleSubTable(key) {
    const subTable = $("#sub-table-" + key);
    subTable.stop(true, true).slideToggle(400);
}

// modal alert
function showModal(status, message, url='/') {
    
    $('#modalMessage').html(message);
    $('#alertModal').modal('show');

    $('#confirmBtn').off('click').on('click', function() { 
        if(status === 'success') {
            window.location.href = url;
        } else {
            $('#alertModal').modal('hide');
        }
    });
}

$(document).ready(function() {
    $('#ajaxForm').on('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
       
        $.ajax({
            url: $(this).attr('action'),
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
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors; 
                    var errorMessage = '';
        
                    for (var field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            errorMessage += errors[field].join('<br>');
                        }
                    }
        
                    showModal('error', errorMessage.trim());
                } else {
                    showModal('error', '예기치 못한 오류가 발생했습니다.');
                }
            }
        });
    });

    $('#copyBtn').click(function () {
        const text = $('#textToCopy').val();
        const $textarea = $('<textarea>');
        $('body').append($textarea);
        $textarea.val(text).select();
        try {
            document.execCommand('copy');
            showModal('error', '클립보드에 복사되었습니다.');
        } catch (err) {
            console.error('복사 실패:', err);
            showModal('error', '복사에 실패했습니다.');
        }
        $textarea.remove();
    });
});
