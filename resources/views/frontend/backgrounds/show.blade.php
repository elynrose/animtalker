@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.background.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.backgrounds.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.background.fields.background_title') }}
                                    </th>
                                    <td>
                                        {{ $background->background_title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.background.fields.scene') }}
                                    </th>
                                    <td>
                                        {{ $background->scene }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.background.fields.icon') }}
                                    </th>
                                    <td>
                                        @if($background->icon)
                                            <a href="{{ $background->icon->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $background->icon->getUrl('thumb') }}">
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.backgrounds.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection