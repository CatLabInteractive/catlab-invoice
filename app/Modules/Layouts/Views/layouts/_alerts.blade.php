@foreach ($errors->all('<div class="alert alert-danger">:message</div>') as $error)
    {!! $error !!}
@endforeach

@if (session()->has('error'))
    <div class="alert alert-danger">{!! session('error') !!}</div>
@endif

@if (session()->has('alert'))
    <div class="alert alert-warning">{!! session('alert') !!}</div>
@endif

@if (session()->has('alertSuccess'))
    <div class="alert alert-success">{!! session('alertSuccess') !!}</div>
@endif

@if (session()->has('alertInfo'))
    <div class="alert alert-info">{!! session('alertInfo') !!}</div>
@endif