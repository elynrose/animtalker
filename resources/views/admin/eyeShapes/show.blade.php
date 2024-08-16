@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.eyeShape.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.eye-shapes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.eyeShape.fields.shape') }}
                        </th>
                        <td>
                            {{ $eyeShape->shape }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eyeShape.fields.icon') }}
                        </th>
                        <td>
                            @if($eyeShape->icon)
                                <a href="{{ $eyeShape->icon->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $eyeShape->icon->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.eye-shapes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection