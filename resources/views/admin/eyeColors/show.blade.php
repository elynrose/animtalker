@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.eyeColor.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.eye-colors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.eyeColor.fields.color') }}
                        </th>
                        <td>
                            {{ $eyeColor->color }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eyeColor.fields.icon') }}
                        </th>
                        <td>
                            @if($eyeColor->icon)
                                <a href="{{ $eyeColor->icon->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $eyeColor->icon->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.eye-colors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection