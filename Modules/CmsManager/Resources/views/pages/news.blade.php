@extends('layouts.cms')
@section('title','Buyer Dashboard')
@section('content')
<h1>{{ $page->title }}</h1>
<div id="accordion2" class="faq-block">
    @php $i=1 @endphp
    @foreach($newses as $news)
    <div class="card">
        <div class="card-header">
            <a class="card-link {{ ($i!=1)?'collapsed':'' }}" data-toggle="collapse" href="#faq{{ $i }}" aria-expanded="{{ ($i==1)?'true':'false' }}">{{ $news->title }}</a>
        </div>
        <div id="faq{{ $i }}" class="collapse {{ ($i==1)?'show':'' }}" data-parent="#accordion2">
            <div class="card-body">
                <p>{{ $news->description }}</p>
            </div>
        </div>
    </div>
    @php $i++ @endphp
    @endforeach




</div>
@stop
