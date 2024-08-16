@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.gender.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.genders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.gender.fields.type') }}
                        </th>
                        <td>
                            {{ $gender->type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gender.fields.icon') }}
                        </th>
                        <td>
                            @if($gender->icon)
                                <a href="{{ $gender->icon->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $gender->icon->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.genders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection