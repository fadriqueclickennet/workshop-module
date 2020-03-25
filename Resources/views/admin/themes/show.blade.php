@extends('layouts.master')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-6">
                <h1 class="m-0 text-dark">  
                    <small>
                        <a href="{{ route('admin.workshop.themes.index') }}" data-toggle="tooltip"
                        title="" data-original-title="{{ trans('core::core.back') }}">
                            <i class="fas fa-reply"></i>
                        </a>
                    </small>
                    {{ $theme->getName() }} <small>{{ trans('workshop::themes.theme') }}</small>
                </h1>
            </div><!-- /.col -->
            <div class="col-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i class="fas fa-tachometer-alt"></i> {{ trans('user::users.breadcrumb.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.workshop.themes.index') }}">{{ trans('workshop::themes.breadcrumb.themes') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('workshop::themes.viewing theme', ['theme' => $theme->getName()]) }}</li>
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
            margin-right: 20px;
        }
        .module-type span {
            margin-left: -20px;
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
            <div class="card card-primary">
                <div class="card-header">
                    <div class="box-tools float-right">
                        <button class="btn btn-box-tool jsPublishAssets" data-toggle="tooltip"
                                title="" data-original-title="{{ trans("workshop::modules.publish assets") }}">
                                <i class="fas fa-cloud-upload-alt"></i>
                            {{ trans("workshop::modules.publish assets") }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 module-details">
                            <div class="module-type float-left">
                                <i class="fas fa-images"></i>
                            </div>
                            <h2>{{ ucfirst($theme->getName()) }}</h2>
                            <p>{{ $theme->getDescription() }}</p>
                        </div>
                        <div class="col-6">
                            <dl class="dl-horizontal">
                                <dt>{{ trans('workshop::themes.type') }}:</dt>
                                <dd>{{ $theme->type }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($theme->changelog) && count($theme->changelog['versions'])): ?>
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bars"></i> {{ trans('workshop::modules.changelog')}}</h3>
                    <div class="box-tools float-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    @include('workshop::admin.modules.partials.changelog', [
                        'changelog' => $theme->changelog
                    ])
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
                    url: '{{ route('api.workshop.theme.publish', [$theme->getName()]) }}',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function() {
                        $self.find('i').toggleClass('fa-cloud-upload fa-refresh fa-spin');
                    }
                });
            });
        });
    </script>
@endpush
