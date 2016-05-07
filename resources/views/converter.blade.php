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
        {!! Form::text('number', isset($number) ? $number : '') !!}
        {!! Form::submit('Submit') !!}
        {!! Form::close() !!}
        <span>@if (isset($roman)){!! $roman !!}@endif</span>
        @if (count($history) > 0)
            <ul>
                @foreach ($history as $item)
                    <li>{{ $item->number }} was converted to {{ $converter->toRomanNumerals($item->number) }}
                        {{ \Carbon\Carbon::now()->diffInMinutes($item->created_at) }}
                        minutes ago
                    </li>
                @endforeach
            </ul>
            @endif
            @if (count($errors) > 0)
                    <!-- Form Error List -->
            <div class="alert alert-danger">
                <strong>Whoops! Something went wrong!</strong>

                <br><br>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
</body>
</html>

