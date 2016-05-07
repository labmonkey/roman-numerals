<?php

/**
 * Author: Paweł Derehajło
 * Contact: derehajlo@gmail.com
 * Date: 06/05/16
 */

?>
        <!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <link type="text/css" href="{{ URL::asset('css/app.css') }}"/>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
</head>
<body>
<div class="container">
    <div class="content">
        {!! Form::open(array('url' => '/history')) !!}
        {!! Form::text('number') !!}
        {!! Form::submit('Click Me!') !!}
        {!! Form::close() !!}
        @if (count($history) > 0)
            <ul>
                @foreach ($history as $item)
                    <li>{{ $item->number }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
</body>
</html>

