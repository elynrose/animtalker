@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.character.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.characters.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.name') }}
                                    </th>
                                    <td>
                                        {{ $character->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.scene') }}
                                    </th>
                                    <td>
                                        {{ $character->scene->background_title ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.gender') }}
                                    </th>
                                    <td>
                                        {{ $character->gender->type ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.age_group') }}
                                    </th>
                                    <td>
                                        {{ $character->age_group->age ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.body_type') }}
                                    </th>
                                    <td>
                                        {{ $character->body_type->body ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.hair_color') }}
                                    </th>
                                    <td>
                                        {{ $character->hair_color->color ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.hair_lenght') }}
                                    </th>
                                    <td>
                                        {{ $character->hair_lenght->lenght ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.hair_style') }}
                                    </th>
                                    <td>
                                        {{ $character->hair_style->style ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.head_shape') }}
                                    </th>
                                    <td>
                                        {{ $character->head_shape->shape ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.nose_shape') }}
                                    </th>
                                    <td>
                                        {{ $character->nose_shape->shape ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.mouth_shape') }}
                                    </th>
                                    <td>
                                        {{ $character->mouth_shape->shape ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.eye_shape') }}
                                    </th>
                                    <td>
                                        {{ $character->eye_shape->shape ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.eye_color') }}
                                    </th>
                                    <td>
                                        {{ $character->eye_color->color ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.skin_tone') }}
                                    </th>
                                    <td>
                                        {{ $character->skin_tone->tone ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.facial_expression') }}
                                    </th>
                                    <td>
                                        {{ $character->facial_expression->expression ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.emotion') }}
                                    </th>
                                    <td>
                                        {{ $character->emotion->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.dress_style') }}
                                    </th>
                                    <td>
                                        {{ $character->dress_style->style ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.dress_color') }}
                                    </th>
                                    <td>
                                        @foreach($character->dress_colors as $key => $dress_color)
                                            <span class="label label-info">{{ $dress_color->color }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.props') }}
                                    </th>
                                    <td>
                                        @foreach($character->props as $key => $props)
                                            <span class="label label-info">{{ $props->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.posture') }}
                                    </th>
                                    <td>
                                        {{ $character->posture->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.character_zoom') }}
                                    </th>
                                    <td>
                                        {{ $character->character_zoom->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.caption') }}
                                    </th>
                                    <td>
                                        {{ $character->caption }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.custom_prompt') }}
                                    </th>
                                    <td>
                                        {{ $character->custom_prompt }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.avatar') }}
                                    </th>
                                    <td>
                                        @if($character->avatar)
                                            <a href="{{ $character->avatar->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $character->avatar->getUrl('thumb') }}">
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.character.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $character->user->name ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.characters.index') }}">
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