function hasPresence($obj){
    return $obj.val() !== '' && $obj.val() !== null;
}

function isValidEmail($obj){
    return $obj.val().includes('@');
}

function minimumPasswordLength($obj){
    return $obj.val().length >= 8;
}

function comparePasswords(){
    return $('#password').val() === $('#password_confirmation').val();
}

function success($obj){
    $obj.removeClass('error');
    $obj.addClass('success');
}

function error($obj){
    $obj.removeClass('success');
    $obj.addClass('error');
}
$(document).ready(function(){
    $('#first_name').keyup(function(){
        hasPresence($(this)) ? success($(this)) : error($(this));
    });
    $('#last_name').keyup(function(){
        hasPresence($(this)) ? success($(this)) : error($(this));
    });
    $('#email').keyup(function(){
        isValidEmail($(this)) ? success($(this)) : error($(this));
    })
    $('#password').keyup(function(){
        minimumPasswordLength($(this)) ? success($(this)) : error($(this));
    })
    $('#password_confirmation').keyup(function(){
        comparePasswords() ? success($(this)) : error($(this));
    })
});