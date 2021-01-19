@extends('layouts.admin.master')
@section('title','CMS Page')
@section('content')
@include('layouts.admin.flash.alert')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage CMS Pages
            <small>Here you can manage cms pages</small>
        </h1>
        {{ Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> \Request::route()->getName()]]]) }}
    </section>

    <section class="content" data-table="pages">
            <div class="row pages">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><span class="caption-subject font-green bold uppercase">{{ __('List Pages') }}</span></h3>
                            <div class="box-tools">
                              <!--<a href="{{route('admin.pages.create')}}" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> Add New Page</a>-->
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col" width="30%">Short Description</th>
                                        <th scope="col" width="18%">Created</th>
                                        <th scope="col" class="actions" width="12%">Action</th>
                                    </tr>
                                </thead>
                                        @if($pages->count() > 0)
                                        <tbody>
                                    @php
                                    $i = (($pages->currentPage() - 1) * ($pages->perPage()) + 1)
                                    @endphp
                                    @foreach($pages as $page)
                                        <tr>
                                            <td> {{$i}}. </td>
                                            <td>{{$page->title}}</td>
                                            <td>{{$page->slug}}</td>
                                            <td>{{$page->short_description}}</td>
                                            <td>{{ $page->created_at->format(config('get.ADMIN_DATE_TIME_FORMAT')) }}</td>
                                            <td class="actions">
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.pages.show',['id' => $page->id]) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" alt="View setting" title="" data-original-title="View"><i class="fa fa-fw fa-eye"></i></a>
                                                    <a href="{{ route('admin.pages.edit',['id' => $page->id]) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" alt="Edit" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @php
                                        $i++;
                                    @endphp
                                    @endforeach
                                    </tbody>
                                    @else
                                    <tfoot>
                                        <tr>
                                            <td colspan='7' align='center'> <strong>Record Not Available</strong> </td>
                                        </tr>
                                    </tfoot>
                                    @endif
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                            {{ $pages->appends(Request::query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
@stop
