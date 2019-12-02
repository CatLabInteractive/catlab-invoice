@include('quotes._js_edit_to')

<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">{{ trans('fi.to') }}</h3>

        <div class="box-tools pull-right">
            <button class="btn btn-default btn-sm" id="btn-change-client"><i
                        class="fa fa-exchange"></i> {{ trans('fi.change') }}</button>
            <button class="btn btn-default btn-sm" id="btn-edit-client" data-client-id="{{ $quote->client->id }}"><i
                        class="fa fa-pencil"></i> {{ trans('fi.edit') }}</button>
        </div>
    </div>
    <div class="box-body">
        <strong>{{ $quote->client->name }}</strong><br>
        {!! $quote->client->formatted_address !!}<br>
        {{ trans('fi.phone') }}: {{ $quote->client->phone }}<br>
        {{ trans('fi.email') }}: {{ $quote->client->email }}
    </div>
</div>