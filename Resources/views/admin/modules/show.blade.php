@extends('layouts.master')

@section('content-header')
    <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <small>
                            <a href="{{ route('admin.workshop.modules.index') }}" data-toggle="tooltip"
                                       title="" data-original-title="{{ trans('core::core.back') }}">
                                <i class="fas fa-reply"></i>
                             </a>
                        </small>
                        {{ $module->name }} <small>{{ trans('workshop::modules.module') }}</small>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('user::users.breadcrumb.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.workshop.modules.index') }}">{{ trans('workshop::modules.breadcrumb.modules') }}</a></li>
                        <li class="breadcrumb-item active">{{ trans('workshop::modules.viewing module') }} {{ $module->name }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
@stop

@push('css-stack')
    <style>
        .module-type {
            text-align: center;
        }
        .module-type span {
            display: block;
        }
        .module-type i {
            font-size: 124px;
        }
        form {
            display: inline;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="box-tools float-right">
                        <?php $status = $module->enabled() ? 'disable' : 'enable'; ?>
                        <button class="btn btn-box-tool jsPublishAssets" data-toggle="tooltip"
                                title="" data-original-title="{{ trans("workshop::modules.publish assets") }}">
                                <i class="fas fa-cloud-upload-alt"></i>
                            {{ trans("workshop::modules.publish assets") }}
                        </button>
                            <?php $routeName = $module->enabled() ? 'disable' : 'enable' ?>
                        {!! Form::open(['route' => ["admin.workshop.modules.$routeName", $module->getName()], 'method' => 'post']) !!}
                            <button class="btn btn-box-tool" data-toggle="tooltip" type="submit"
                                    title="" data-original-title="{{ trans("workshop::modules.{$status}") }}">
                                <i class="fas fa-toggle-{{ $module->enabled() ? 'on' : 'off' }}"></i>
                                {{ trans("workshop::modules.{$status}") }}
                            </button>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 module-details">
                            <div class="module-type float-left mr-2">
                                <i class="fas fa-cube"></i>
                                <span>{{ module_version($module) }}</span>
                            </div>
                            <h2>{{ ucfirst($module->getName()) }}</h2>
                            <p>{{ $module->getDescription() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($changelog) && count($changelog['versions'])): ?>
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="box-title"><i class="fa fa-bars"></i> {{ trans('workshop::modules.changelog')}}</h3>
                    <div class="box-tools float-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    @include('workshop::admin.modules.partials.changelog')
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
@stop

@push('js-stack')
    <script>
        $( document ).ready(function() {
            $('.jsPublishAssets').on('click',function (event) {
                event.preventDefault();
                var $self = $(this);
                $self.find('i').toggleClass('fa-cloud-upload fa-refresh fa-spin');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('api.workshop.module.publish', [$module->getName()]) }}',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function() {
                        $self.find('i').toggleClass('fa-cloud-upload fa-refresh fa-spin');
                    }
                });
            });
        });
    </script>
@endpush
