@php
    $settings = settings();
@endphp
@if($settings->admin_logo)
    <img height='50' src="{{route('frontend.index')}}/settings/admin_logo/{{$settings->admin_logo}}">
@else
    {{ app_name() }}
@endif