@foreach ($merchantDrivers as $driver)
    <h4>{{ $driver->getName() }}</h4>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label>{{ trans('fi.enabled') }}</label>
                {!! Form::select('setting[' . $driver->getSettingKey('enabled') . ']', [0=>trans('fi.no'),1=>trans('fi.yes')], $driver->getSetting('enabled'), ['class' => 'form-control']) !!}
            </div>
        </div>
        @foreach ($driver->getSettings() as $key => $setting)
            <div class="col-md-2">
                <div class="form-group">
                    @if (!is_array($setting))
                        <label>{{ trans('fi.' . snake_case($setting)) }}</label>
                        {!! Form::text('setting[' . $driver->getSettingKey($setting) . ']', config('fi.' . $driver->getSettingKey($setting)), ['class' => 'form-control']) !!}
                    @else
                        <label>{{ trans('fi.' . snake_case($key)) }}</label>
                        {!! Form::select('setting[' . $driver->getSettingKey($key) . ']', $setting, config('fi.' . $driver->getSettingKey($key)), ['class' => 'form-control']) !!}
                    @endif
                </div>
            </div>
        @endforeach
        <div class="col-md-2">
            <div class="form-group">
                <label>{{ trans('fi.payment_button_text') }}</label>
                {!! Form::text('setting[' . $driver->getSettingKey('paymentButtonText') . ']', $driver->getSetting('paymentButtonText'), ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
@endforeach