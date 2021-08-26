<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>
        
        <script src="http://{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>

    </head>
    <body>
    
        <div id="app">
            <chat-component></chat-component>
        </div>
        
    <script src="{{ mix('/js/app.js') }}"></script>
    
    </body>
</html>