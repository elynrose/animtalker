@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.mouthShape.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.mouth-shapes.update", [$mouthShape->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="shape">{{ trans('cruds.mouthShape.fields.shape') }}</label>
                            <input class="form-control" type="text" name="shape" id="shape" value="{{ old('shape', $mouthShape->shape) }}">
                            @if($errors->has('shape'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('shape') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.mouthShape.fields.shape_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection