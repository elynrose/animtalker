@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.skinTone.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.skin-tones.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.skinTone.fields.tone') }}
                        </th>
                        <td>
                            {{ $skinTone->tone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.skinTone.fields.icon') }}
                        </th>
                        <td>
                            @if($skinTone->icon)
                                <a href="{{ $skinTone->icon->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $skinTone->icon->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.skin-tones.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection