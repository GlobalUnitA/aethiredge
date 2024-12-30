$(document).ready(function() {
    // staking quantitly modal
    if($('#quantityModal')[0]) {
        const modal = new bootstrap.Modal($('#quantityModal')[0]);

        $('#confirmQuantity').click( function() {
        const $selectedQuantity = $('input[name="quantity"]:checked');
            if ($selectedQuantity.length) {
                const ea = $selectedQuantity.attr('id');
                const ath = $selectedQuantity.val();
                const bundle = $('#bundle').val();
                const totalAth = parseInt(ath) * parseInt(bundle);

                console.log('ea : ', ea);
                console.log('ath : ', ath);
                console.log('bundle : ', bundle);
                console.log('totalATh : ', totalAth);

                $('input[name="ea"]').val(ath);
                $('input[name="ath"]').val(totalAth);
                $('input[name="bundle"]').val(bundle);
                $("#totalAth").val(totalAth);
                modal.hide();
            }
        });
    }

    if($('#decreaseBtn')) {
        $('#decreaseBtn').click(function() {
            const quantity = $('#bundle');
            let value = parseInt(quantity.val());
      
            if (value > 1) {
                quantity.val(value - 1);
            }
        });   
    }

    if($('#increaseBtn')) {
        $('#increaseBtn').click(function() {
            const quantity = $('#bundle');
            let value = parseInt(quantity.val());
    
            quantity.val(value + 1);
        });
    }

    // upload
    import('../upload.js').then(module => {
        module.upload($('#fileInput'), $('#defaultContent'), $('#imagePreview'), $('#uploadBox'));
    }).catch(err => {
        showModal('error', '예기치 못한 오류가 발생했습니다.');
    });
    
});