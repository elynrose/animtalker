@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.headShape.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.head-shapes.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="shape">{{ trans('cruds.headShape.fields.shape') }}</label>
                <input class="form-control {{ $errors->has('shape') ? 'is-invalid' : '' }}" type="text" name="shape" id="shape" value="{{ old('shape', '') }}">
                @if($errors->has('shape'))
                    <div class="invalid-feedback">
                        {{ $errors->first('shape') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.headShape.fields.shape_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection