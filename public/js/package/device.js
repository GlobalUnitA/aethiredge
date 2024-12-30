$(document).ready(function() {
    // device quantitly modal
    if($('#quantityModal')[0]) {
        const modal = new bootstrap.Modal($('#quantityModal')[0]);

        $('#confirmQuantity').click( function() {
        const $selectedQuantity = $('input[name="quantity"]:checked');
        if ($selectedQuantity.length) {
            $('input[name="ea"]').val($selectedQuantity.attr('id'));
            $('input[name="usdt"]').val($selectedQuantity.val());
            $("#usdt").val(number_format($selectedQuantity.val()));
            modal.hide();
        }
    });
    }

    // upload
    import('../upload.js').then(module => {
        module.upload($('#fileInput'), $('#defaultContent'), $('#imagePreview'), $('#uploadBox'));
    }).catch(err => {
        showModal('error', '예기치 못한 오류가 발생했습니다.');
    });
    
});