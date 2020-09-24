<!DOCTYPE html>
<html>
    <head>
        <title>InnStatusChecker</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <input type="text" name="inn" id="inn">
            <button id="check">Проверить</button>
        </div>
        <div id="result" style="display: none">
            <span id="error" style="display: none">

            </span>
            <span id="message">

            </span>
        </div>
    </body>

    <script type="text/javascript">
        $(document).ready(function() {
            $('button').on('click', function() {
                $('#result').hide();
                $('#error').hide();
                $.get('/check/' + $('#inn').val(), function(data) {
                    $('#result').show();
                    if (data.error) {
                        $('#error').show();
                        $('#error').html(data.code);
                    }
                    $('#message').html(data.message);
                });
            });
        });
    </script>
</html>
