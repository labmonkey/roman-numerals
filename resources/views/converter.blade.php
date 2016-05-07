<!DOCTYPE html>
<html>
<head>
    <title>Roman numerals converter</title>

    <link href='https://fonts.googleapis.com/css?family=Lato:100,400,300,700,900' rel='stylesheet' type='text/css'>

    <link type="text/css" rel="stylesheet" href="{{ URL::asset('css/app.css') }}"/>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
</head>
<body>
<div class="container">
    <section class="header">
        <h1>Roman numerals converter</h1>
    </section>
    <section class="errors">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><span>Error:</span> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </section>
    <section class="form">
        {!! Form::open(array('url' => '/history')) !!}
        <div class="decimal">
            {!! Form::text('number', isset($number) ? $number : '', array('class' => 'decimal-text')) !!}
        </div>
        <div class="submit">
            {!! Form::button('Submit', array('class' => 'button-submit', "type" => "submit")) !!}
        </div>
        <div class="roman">
            <span class="roman-text text">@if (isset($roman)){!! $roman !!}@else&nbsp;@endif</span>
        </div>
        {!! Form::close() !!}
    </section>
    <section class='list'>
        <div class='history'>
            @if (count($history) > 0)
                <ul>
                    @foreach ($history as $item)
                        <li><span>{{ $item->number }}</span> was converted
                            to <span>{{ $converter->toRomanNumerals($item->number) }}</span>
                            <small>{{ \Carbon\Carbon::now()->diffInMinutes($item->created_at) }}
                                minutes ago
                            </small>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </section>
</div>
</body>
</html>

