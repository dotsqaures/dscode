
@extends('layouts.admin.master')
@section('title','Category')
@section('content')
@include('layouts.admin.flash.alert')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Category Manager
            <small>Here you can manage category</small>
        </h1>
        {{ Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> \Request::route()->getName()]]]) }}
    </section>

    <section class="content" data-table="categories">

            {{ Form::open(['url' => route('admin.categories.index'),'method' => 'get']) }}
            <div class="col-md-12">
            <div class="row">

                <div class="col-md-2 form-group">
                        {{ Form::select('status', ['' => 'All',1 => 'Active', 0 => 'In-Active'], app('request')->query('status'), ['class' => 'form-control']) }}
                    </div>
                <div class="col-md-5 form-group">
                    {{ Form::text('keyword', app('request')->query('keyword'), ['class' => 'form-control','placeholder' => 'Keyword e.g: Category name, Description']) }}
                </div>
                <div class="col-md-3 form-group">
                    <button class="btn btn-success" title="Search" type="submit"><i class="fa fa-filter"></i> Filter</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-warning" title="Cancel"><i class="fa fa-fw fa-refresh"></i> Reset</a>
                </div>
            </div>
        </div>
    {{ Form::close() }}

            <div class="row categories">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><span class="caption-subject font-green bold uppercase">{{ __('List Category') }}</span></h3>
                            <div class="box-tools">
                                <a href="{{route('admin.categories.create')}}" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> Add New Category
                                </a>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>

                                        <th scope="col">Parent Category</th>
                                        <th scope="col">Sub Category</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col" width="18%">created</th>
                                        <th scope="col" class="actions" width="12%">Action</th>
                                    </tr>
                                </thead>
                                        @if($categories)
                                        <tbody>
                                    @php
                                    $i = (($categories->currentPage() - 1) * ($categories->perPage()) + 1)
                                    @endphp
                                    @foreach($categories as $category)

                                        <tr class="row-{{ $category->id }}">
                                            <td> {{$i}}. </td>

                                            <td>
                                                @if(!empty($category->parent_id))
                                                {{ \app\Helpers\BasicHelpers::GetparentCategory($category->parent_id)  }}
                                                @else
                                                {{$category->title}}
                                                @endif


                                            </td>



                                            <td>

                                                 @if(!empty($category->parent_id))
                                                 {{$category->title}}
                                                @else
                                                {{ '--' }}
                                                @endif

                                            </td>
                                            <td> {{ $category->slug }}</td>
                                            <td>{{ $category->created_at->format(config('get.ADMIN_DATE_TIME_FORMAT')) }}</td>
                                            <td class="actions">
                                                <div class="form-group">
                                                    {{-- <a href="{{ route('admin.categories.show',['id' => $category->id]) }}" class="btn btn-warning btn-sm btn-flat" data-toggle="tooltip" alt="View setting" title="" data-original-title="View"><i class="fa fa-fw fa-eye"></i></a> --}}
                                                    <a href="{{ route('admin.categories.edit',['id' => $category->id]) }}" class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" alt="Edit" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                    <a href="javascript:void(0);" class="confirmDeleteBtn btn btn-danger btn-sm btn-flat" data-toggle="tooltip" alt="Delete {{ $category->title }}" data-url="{{ route('admin.categories.destroy', $category->id) }}" data-title="{{ $category->title }}"><i class="fa fa-trash"></i></a>

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
                            {{ $categories->appends(Request::query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
@stop
