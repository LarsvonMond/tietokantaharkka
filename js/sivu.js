$(document).ready(function(){
    $('table').find('input[type="checkbox"]').on('click', function(){
        $(this).parent('form').submit();
        console.log('klikattu');
    });
});
