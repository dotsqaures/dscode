@extends('layouts.admin.master')
@section('title', 'Website Logo and fav icon')
@section('content')
@include('layouts.admin.flash.alert')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage Website Logo & Fav Icon
                <small>Here you can manage the logo and fav icons Option</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{url('admin/settings/general')}}">Settings</a></li>
                <li><a href="javascript:void(0)" class="active">Website logos</a></li>
            </ol>
        </section>
        <section class="content">
            <div class="row">

                <div class="col-md-8">
                    <div class="box box-default settings">
                        <div class="box-header with-border">
                            <h3 class="box-title">Theme Options</h3>
                        </div><!-- /.box-header -->
                        <form method="post" enctype="multipart/form-data" accept-charset="utf-8" role="form" action="{{route('setting.logo.update')}}">
                            @csrf
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-bordered" id="tab-theme-files">
                                            <thead>
                                            <tr>
                                                <th>Constant/Slug</th>
                                                <th width="17%">Config Value</th>
                                                <th width="22%">#</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($settings->count() > 0 || old('setting'))

                                                @php
                                                    $settings = old('setting') ? (object) old('setting') : $settings;
                                                    $inc = 0;
                                                @endphp

                                                @foreach($settings as $k => $setting)
                                                    <tr id="file-row{{ $k }}" class="row-{{ old('setting.'.$k.'.id') ? old('setting.'.$k.'.id') : (isset($setting->id) ? $setting->id : 0) }}">
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="input text required">
                                                                {{Form::text('setting['.$k.'][slug]', old('setting.'.$k.'.slug') ? old('setting.'.$k.'.slug') : $setting->slug,['class' => 'form-control','readonly' => old('setting.'.$k.'.slug') ? false : true])}}</div>
                                                                {{Form::hidden('setting['.$k.'][title]',old('setting.'.$k.'.title') ? old('setting.'.$k.'.title') : $setting->title)}}
                                                                {{Form::hidden('setting['.$k.'][field_type]',old('setting.'.$k.'.field_type') ? old('setting.'.$k.'.field_type') : $setting->field_type)}}
                                                                {{Form::hidden('setting['.$k.'][manager]', old('setting.'.$k.'.manager') ? old('setting.'.$k.'.manager') : $setting->manager)}}
                                                                @php if(old('setting.'.$k.'.id')){
                                                                    echo Form::hidden('setting['.$k.'][id]',old('setting.'.$k.'.id'));
                                                                      }else if(isset($setting->id)){
                                                                    echo Form::hidden('setting['.$k.'][id]', $setting->id);
                                                                   } @endphp
                                                                @if($errors->has('setting.'.$k.'.slug'))
                                                                <span class="help-block" style="color:red">{{ $errors->first('setting.'.$k.'.slug') }}</span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="thumbimage">
                                                                @if (old('setting.'.$k.'.config_value'))
                                                                    @php
                                                                        $filename = old('setting.'.$k.'.config_value');
                                                                        if(old('setting.'.$k.'.id'))
                                                                            $filepath = '/storage/settings/';
                                                                        else
                                                                            $filepath =  "/storage/temp/";
                                                                    @endphp
                                                                @else
                                                                    @php
                                                                        $filename = isset($setting->config_value) ? $setting->config_value : "";
                                                                        $filepath = '/storage/settings/';
                                                                    @endphp
                                                                @endif
                                                            @if(!empty($filename) && file_exists( public_path() . $filepath . $filename))
                                                            <img src="{{ asset($filepath. $filename )}}" alt="" style="max-height:100px;">
                                                              @else
                                                              <img src="{{asset('img/no_image.gif')}}" alt="" height="100" style="max-height:100px;">
                                                              @endif
                                                            </div>
                                                            <button class="btn bg-olive btn-flat margin button-upload" data-toggle="tooltip" title="Upload File" data-loading-text="Loading..." type="button">
                                                                    <i class="fa fa-upload"></i>
                                                                    Upload
                                                                </button>
                                                                <input type="hidden" name="setting[{{ $k }}][config_value]" class="img_hidden" value="{{ old('setting.'.$k.'.config_value') ? old('setting.'.$k.'.config_value') : @$setting->config_value }}" />

                                                                @if($errors->has('setting.'.$k.'.config_value'))
                                                                <span class="help-block" style="color:red">{{ $errors->first('setting.'.$k.'.config_value') }}</span>
                                                                @endif

                                                        </td>
                                                        <td class="form-inline">
                                                            @if($k > 1)
                                                            @if(old('setting'))
                                                                <a href='javascript:void(0);' class="btn btn-danger pull-right" onclick="$('#file-row{{ $k }}').remove()" ><i class="fa fa-minus-circle"></i></a>
                                                            @else
                                                                <a href='javascript:void(0);' class="confirmDeleteBtn btn btn-danger pull-right" data-id="{{  $setting->id }}" data-url="{{ route('setting.deletelogo', $setting->id) }}" ><i class="fa fa-minus-circle"></i></a>
                                                            @endif

                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @php $inc++ @endphp
                                                @endforeach
                                            @else
                                            @php
                                                $inc = 2;
                                            @endphp
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="input text required">
                                                                {{Form::text('setting[0][slug]','MAIN_FAVICON',['class' => 'form-control','readonly' =>'readonly'])}}</div>
                                                                {{Form::hidden('setting[0][title]','Main Favicon')}}
                                                                {{Form::hidden('setting[0][field_type]','text')}}
                                                                {{Form::hidden('setting[0][manager]','theme_images')}}
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <div class="thumbimage">
                                                            <img src="{{asset('img/no_image.gif')}}" style="max-height:100px;">
                                                            <button class="btn bg-olive btn-flat margin button-upload" data-toggle="tooltip" title="Upload File" data-loading-text="Loading..." type="button">
                                                                <i class="fa fa-upload"></i>
                                                                Upload
                                                            </button>
                                                            <input type="hidden" name="setting[0][config_value]" class="img_hidden" value="" />
                                                        </div>
                                                    </td>
                                                    <td class="form-inline">

                                                    </td>
                                                </tr>
                                                <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="input text required">
                                                                    {{Form::text('setting[1][slug]','MAIN_LOGO',['class' => 'form-control','readonly' =>'readonly'])}}</div>
                                                                    {{Form::hidden('setting[1][title]','MAIN LOGO')}}
                                                                    {{Form::hidden('setting[1][field_type]','text')}}
                                                                    {{Form::hidden('setting[1][manager]','theme_images')}}
                                                            </div>

                                                        </td>
                                                        <td>
                                                            <div class="thumbimage">
                                                                <img src="{{asset('img/no_image.gif')}}" style="max-height:100px;">
                                                                <button class="btn bg-olive btn-flat margin button-upload" data-toggle="tooltip" title="Upload File" data-loading-text="Loading..." type="button">
                                                                    <i class="fa fa-upload"></i>
                                                                    Upload
                                                                </button>
                                                                <input type="hidden" name="setting[1][config_value]" class="img_hidden" value="" />
                                                            </div>
                                                        </td>
                                                        <td class="form-inline">

                                                        </td>
                                                    </tr>
                                            @endif
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary pull-right"
                                                            data-toggle="tooltip" title="" onclick="addMoreRow()"
                                                            data-original-title="Add New"><i class="fa fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i
                                            class="fa fa-fw fa-save"></i> Submit
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-exclamation"></i> Important Rules
                            </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <p>
                                For each config settings that would be added to the system, make sure it has these
                                constant/slug:
                            </p>
                            <ul>
                                <li>
                                    <small class="label bg-yellow">
                                        MAIN_LOGO
                                    </small>
                                    - Will be replaced by logo from the admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        MAIN_FAVICON
                                    </small>
                                    - Will be replaced by favicon icon image from the admin settings.
                                </li>

                            </ul>
                        </div><!-- ./box-body -->
                    </div>
                </div>
            </div>
        </section>

@stop


@section('per_page_style')
    <style>
        .btn-file {
            position: relative;
            overflow: hidden;
        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        #img-upload{
            width: 100%;
        }
    </style>
@stop
@section('per_page_script')
    <script>

        $(document).on('click','.button-upload', function () {
            var _this = $(this);
            var inputValue = _this.closest("tr").find(".img_hidden");
            var iconBox = _this.closest("tr").find("img");
            $('#form-upload').remove();
            var fields = '<input type="file" name="file" />';
            $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;">' + fields + '</form>');
            $('#form-upload input[name=\'file\']').trigger('click');
            if (typeof timer != 'undefined') {
                clearInterval(timer);
            }
            timer = setInterval(function () {
                if ($('#form-upload input[name=\'file\']').val() !== '') {
                    clearInterval(timer);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{url('admin/settings/store-image-temp')}}',
                        type: 'post',
                        dataType: 'json',
                        data: new FormData($('#form-upload')[0]),
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function (xhr) {
                            _this.closest("tr").find(".button-upload").button('loading');
                        },
                        complete: function () {
                            _this.closest("tr").find(".button-upload").button('reset');
                        },
                        success: function (json) {
                            if (json.success === true) {
                                console.log(json.fake_path);
                                inputValue.val(json.fake_path);
                                inputValue.val(json.filename);
                                iconBox.attr('src', json.image_path);
                            } else {
                                inputValue.val('');
                                iconBox.attr('src', "{{asset('img/no_image.gif')}}");
                                // wowMsg(json.message);
                            }

                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            }, 500);
        });

        var file_row = {{  $inc + 1 }}
        function addMoreRow() {
            html = '<tr id="file-row' + file_row + '">';
            html += '  <td>';
            html += '    <input name="setting[' + file_row + '][slug]" class="form-control" required="required" maxlength="255" id="' + file_row + '-slug" value="MAIN_LOGO_' + file_row + '" type="text">';
            html += '  <input name="setting[' + file_row + '][title]" id="' + file_row + '-title" value="Logo ' + file_row + '" type="hidden"><input name="setting[' + file_row + '][field_type]" id="' + file_row + '-field-type" value="text" type="hidden"><input name="setting[' + file_row + '][manager]" id="' + file_row + '-manager" value="theme_images" type="hidden">';
            html += '  </td>';
            html += '  <td>';
            html += '<div class="thumbimage" id="imageBox-' + file_row + '">';
            html += ' <img src="{{asset('img/no_image.gif')}}" class="img-thumbnail"  style="max-height:100px;" alt="">';
            html += '</div>';
            html += '<button class="btn bg-olive btn-flat margin button-upload" data-toggle="tooltip" title="" data-loading-text="Loading..." type="button" data-original-title="Upload File"><i class="fa fa-upload"></i>Upload</button>';
            html += '<input name="setting[' + file_row + '][config_value]" class="img_hidden" id="' + file_row + '-config-value" value="" type="hidden">';

            html += '  </td>';
            html += '  <td>';
            html += '<a onclick="$(\'#file-row' + file_row + '\').remove()" data-toggle="tooltip" title="Remove" class="btn btn-danger pull-right"><i class="fa fa-minus-circle"></i></a>';
            html += '  </td>';
            html += '</tr>';

            $('table#tab-theme-files tbody').append(html);

            file_row++;
        }
    </script>
@stop
