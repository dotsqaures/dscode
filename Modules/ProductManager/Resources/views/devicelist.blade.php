

<div class="search-col required {{ $errors->has('device_type') ? 'has-error' : '' }}">
            <label class="" for="category_id">Device Type</label>
                {{ Form::select('device_type', $Devices, old("device_type"), ['class' => 'form-control selectdevice',]) }}
                @if($errors->has('device_type'))
                <span class="help-block">{{ $errors->first('device_type') }}</span>
                @endif
    </div>





