@extends('layouts.master')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">  {{ trans('workshop::themes.title') }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a
                        href="{{ route('dashboard.index') }}"><i
                        class="fas fa-tachometer-alt"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
                <li class="breadcrumb-item active">  {{ trans('workshop::themes.title') }}</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
@stop

@push('css-stack')
    <style>
        .jsUpdateModule {
            transition: all .5s ease-in-out;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>{{ trans('workshop::modules.table.name') }}</th>
                            <th width="15%">{{ trans('workshop::themes.type') }}</th>
                            <th width="15%">{{ trans('workshop::modules.table.version') }}</th>
                            <th width="15%">{{ trans('workshop::modules.table.enabled') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($themes)): ?>
                            <?php foreach ($themes as $theme): ?>
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.workshop.themes.show', [$theme->getName()]) }}">
                                            {{ $theme->getName() }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.workshop.themes.show', [$theme->getName()]) }}">
                                            {{ $theme->type }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.workshop.themes.show', [$theme->getName()]) }}">
                                            {{ theme_version($theme) }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.workshop.themes.show', [$theme->getName()]) }}">
                                            <span class="btn p-1 label label-{{$theme->active ? 'success' : 'danger'}}">
                                                {{ $theme->active ? trans('workshop::modules.enabled') : trans('workshop::modules.disabled') }}
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ trans('workshop::modules.table.name') }}</th>
                            <th>{{ trans('workshop::themes.type') }}</th>
                            <th>{{ trans('workshop::modules.table.version') }}</th>
                            <th>{{ trans('workshop::modules.table.enabled') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</div>
@stop

@push('js-stack')
    <?php $locale = locale(); ?>
    <script>
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "asc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                },
                "columns": [
                    null,
                    null,
                    null,
                    null,
                ]
            });
        });
    </script>
<script>
$( document ).ready(function() {
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
    $('.jsUpdateModule').on('click', function(e) {
        $(this).data('loading-text', '<i class="fa fa-spinner fa-spin"></i> Loading ...');
        var $btn = $(this).button('loading');
        var token = '<?= csrf_token() ?>';
        $.ajax({
            type: 'POST',
            url: '<?= route('admin.workshop.modules.update') ?>',
            data: {module: $btn.data('module'), _token: token},
            success: function(data) {
                console.log(data);
                if (data.updated) {
                    $btn.button('reset');
                    $btn.removeClass('btn-primary');
                    $btn.addClass('btn-success');
                    $btn.html('<i class="fa fa-check"></i> Module updated!')
                    setTimeout(function() {
                        $btn.removeClass('btn-success');
                        $btn.addClass('btn-primary');
                        $btn.html('Update')
                    }, 2000);
                }
            }
        });
    });
});
</script>
@endpush
