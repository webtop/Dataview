$(document).ready(function() {
    $('button#test', 'form#db_connect').click(function() {
        $.ajax({
            url: '/test_database',
            type: 'POST',
            data: {
                connection: $('form#db_connect').serialize()
            },
            success: function(data) {
                console.log(data);
            }
        });
    });
});