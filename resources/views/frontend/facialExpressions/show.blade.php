@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.facialExpression.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.facial-expressions.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.facialExpression.fields.expression') }}
                                    </th>
                                    <td>
                                        {{ $facialExpression->expression }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.facialExpression.fields.icon') }}
                                    </th>
                                    <td>
                                        @if($facialExpression->icon)
                                            <a href="{{ $facialExpression->icon->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $facialExpression->icon->getUrl('thumb') }}">
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.facial-expressions.index') }}">
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