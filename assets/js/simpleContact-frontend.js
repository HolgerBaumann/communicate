
    $(window).on('ajaxBeforeSend', function() {
        $('#CommunicateSubmitButton').prop('disabled',true);
    });
    $(window).on('ajaxUpdateComplete', function() {
        $('#CommunicateSubmitButton').prop('disabled',false);
    });
    $('#CommunicateForm').on('ajaxSuccess', function() {
        document.getElementById('CommunicateForm').reset();
        
        if(typeof grecaptcha != "undefined")
            grecaptcha.reset();
    });
    
