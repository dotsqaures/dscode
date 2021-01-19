@extends('layouts.admin.master')
@section('title','Stamp Card list')
@section('content')
@include('layouts.admin.flash.alert')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Stamp Cards
            <small>Here you can manage stamp cards </small>
        </h1>
            {{ Breadcrumbs::render('common',['append' => [['label' => 'Stamp Manager']]]) }}

    </section>

    <section class="content" data-table="users">
            <div class="row users">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><span class="caption-subject font-green bold uppercase">{{ __('Stamps List') }}</span></h3>
                            <div class="box-tools">
                                <a href="{{ route('admin.stamps.create') }}" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> Add New stamp</a
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                                <div class="">
                                        <ul class="nav nav-tabs">

                                        </ul>
                                        <div class="tab-content" style="margin-top:10px;">

                                                <div class="tab-pane active">
                                                    <table class="table table-hover table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th scope="col"> Title</th>
                                                                <th scope="col">Stamps</th>
                                                                <th scope="col">Valid Till</th>
                                                                <th scope="col">Normal Price</th>
                                                                <th scope="col">Discount</th>

                                                                <th scope="col" width="8%"> Status</th>


                                                                <th scope="col" width="18%">Created</th>
                                                                <th scope="col" class="actions" width="12%">Actions</th>
                                                            </tr>
                                                        </thead>
                                                                @if($resto->count() > 0)
                                                                <tbody>
                                                            @php
                                                            $i = (($resto->currentPage() - 1) * ($resto->perPage()) + 1)
                                                            @endphp
                                                            @foreach($resto as $val)
                                                                <tr class="row-{{ $val->id }}">
                                                                    <td> {{$i}}. </td>

                                                                    <td>{{ $val->title }}</td>

                                                                    <td>{{$val->stemp_no}}</td>
                                                                    <td>{{$val->stemp_valid}}</td>
                                                                    <td>{{$val->normal_price}}</td>
                                                                    <td>{{$val->descoun_price}}</td>

                                                                    <td>{{  $val->status == 1 ? "Active" : "In-Active" }}</td>

                                                                    <td>{{ $val->created_at->format(config('get.ADMIN_DATE_TIME_FORMAT')) }}</td>
                                                                    <td class="actions">
                                                                        @php
                                                                            $queryStr['id'] = $val->id;
                                                                            //$queryStr = array_merge( $queryStr , $qparams);
                                                                        @endphp
                                                                        <div class="form-group">
                                                                            <a href="{{ route('admin.stamps.show', $queryStr) }}" class="btn btn-warning btn-sm btn-flat" data-toggle="tooltip" alt="View setting" title="" data-original-title="View"><i class="fa fa-fw fa-eye"></i></a>
                                                                            <a href="{{ route('admin.stamps.edit', $queryStr) }}" class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" alt="Edit" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>

                                                                            <a href="javascript:void(0);" class="confirmDeleteBtn btn btn-danger btn-sm btn-flat" data-toggle="tooltip" alt="Delete {{ $val->title }}" data-url="{{ route('admin.stamps.destroy', $val->id) }}" data-title="Delete {{ $val->name }}"><i class="fa fa-trash"></i></a>
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
                                        </div>
                                </div>
                        </div>
                        <div class="box-footer clearfix">
                            {{ $resto->appends(Request::query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
@stop
