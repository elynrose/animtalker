@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ageGroup.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.age-groups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ageGroup.fields.age') }}
                        </th>
                        <td>
                            {{ $ageGroup->age }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ageGroup.fields.icon') }}
                        </th>
                        <td>
                            @if($ageGroup->icon)
                                <a href="{{ $ageGroup->icon->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $ageGroup->icon->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.age-groups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection