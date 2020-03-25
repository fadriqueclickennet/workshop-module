{!! Form::open(['route' => 'admin.workshop.workbench.migrate.index', 'method' => 'post']) !!}
    <div class="card-body">
        <div class='form-group{{ $errors->has('module') ? ' has-error' : '' }}'>
            {!! Form::label('module', trans('workshop::workbench.form.module name')) !!}
            {!! Form::select('module', $modules, null, ['class' => 'form-control']) !!}
            {!! $errors->first('module', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary btn-flat">{{ trans('workshop::workbench.button.migrate') }}</button>
    </div>
{!! Form::close() !!}
