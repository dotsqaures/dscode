@extends('layouts.admin.master')
@section('title','Category Detail')
@section('content')
@include('layouts.admin.flash.alert')
<section class="content-header">
    <h1>
        Manage CMS Pages
        <small>Here you can view cms page detail</small>
    </h1>
    {{ Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.pages.index'],['label' => 'View CMS Page Detail']]]) }}
</section>

<section class="content" data-table="emailHooks">
    <div class="box">
        <div class="box-header"><h3 class="box-title">{{ $page->title }}</h3>
            {{-- <a href="{{route('admin.pages.index')}}" class="btn btn-default pull-right" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a> --}}
        </div>
        <div class="box-body">
            <table class="table table-hover table-striped">
                <tr>
                    <th scope="row">{{ __('Title') }}</th>
                    <td>{{ $page->title }}</td>
                </tr>


                <tr>
                    <th scope="row">{{ __('Sub  Title') }}</th>
                    <td>{{ $page->sub_title }}</td>
                </tr>

                <tr>
                    <th scope="row">{{ __('Slug') }}</th>
                    <td>{{ $page->slug }}</td>
                </tr>

                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td>{{ $page->created_at->toFormattedDateString() }}</td>
                </tr>
                <tr>
                    <th scope="row">{{ __('Modified') }}</th>
                    <td>{{ $page->updated_at->toFormattedDateString() }}</td>
                </tr>
                <tr>
                    <th scope="row">{{ __('Status') }}</th>
                    <td>{{ $page->status ? __('Active') : __('Inactive')  }}</td>
                </tr>
            </table>
            <div class="row">
                <div class="col-md-12">
                    <h4>{{ __('Description') }}</h4>
                    {!! $page->description !!}
                </div>
            </div>
        </div>
        <div class="box-footer">
                <a href="{{route('admin.pages.index')}}" class="btn btn-default pull-left" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
        </div>
    </div>
</section>

@endsection
