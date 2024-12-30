$(document).ready(function() {
    $('#approvalBtn').click(function() {
        event.preventDefault();
        let formData = new FormData($('#statusForm')[0]);

        formData.append('id', $('input[name="id"]').val());
        formData.append('status', 'p');
        //formData.append('usdt', $('input[name="usdt"]').val());
       
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
        //formData.append('usdt', $('input[name="usdt"]').val());
       
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


    
    $('#addBonusBtn').click(function () {
        const newInputs = `
            <div class="d-flex align-items-center mb-3">
                <input type="hidden" name="aff_user_id[]" value="0" />              
                <div class="col-md-2 me-2">
                    <input type="number" name="daily[]" class="form-control">
                </div>
                <div class="col-md-2 me-2">
                    <input type="number" name="paid[]" class="form-control">
                </div>
                <div class="col-md-2 me-2">
                    <input type="number" name="earn[]" class="form-control">
                </div>
                <div class="col-md-2 me-2">
                    <input type="date" id="input-3" name="created_at[]" class="form-control">
                </div>
                <div class="col-md-2 me-2"></div>
            </div>`;
        $('#input_bonus').append(newInputs);
    });

    $('#bonusBtn').click(function() {
        event.preventDefault();
        let formData = new FormData($('#bonusForm')[0]);
        
        $.ajax({
            url: $('#bonusForm').attr('action'),
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

    $('#addAllowanceBtn').click(function () {
        const newInputs = `
            <div class="d-flex align-items-center mb-3">
                <div class="col-md-2 me-2">
                    <input type="number" id="input-1" name="aff_user_id[]" class="form-control">
                </div>
                <div class="col-md-2 me-2">
                    <input type="number" id="input-1" name="daily[]" class="form-control">
                </div>
                <div class="col-md-2 me-2">
                    <input type="number" id="input-2" name="paid[]" class="form-control">
                </div>
                <div class="col-md-2 me-2">
                    <input type="number" id="input-3" name="earn[]" class="form-control">
                </div>
                <div class="col-md-2 me-2">
                    <input type="date" id="input-3" name="created_at[]" class="form-control">
                </div>
                <div class="col-md-2 me-2"></div>
            </div>`;
        $('#input_allowance').append(newInputs);
    });

    $('#allowanceBtn').click(function() {
        event.preventDefault();
        let formData = new FormData($('#allowanceForm')[0]);
        
        $.ajax({
            url: $('#allowanceForm').attr('action'),
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

function deleteBonus(id) {
    event.preventDefault();
    let formData = new FormData($('#deleteForm')[0]);
    
    formData.append('id', id);
    $.ajax({
        url: $('#deleteForm').attr('action'),
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
}