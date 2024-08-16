@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.clip.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.clips.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.clip.fields.character') }}
                        </th>
                        <td>
                            {{ $clip->character->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clip.fields.script') }}
                        </th>
                        <td>
                            {{ $clip->script }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clip.fields.audio_file') }}
                        </th>
                        <td>
                            @if($clip->audio_file)
                                <a href="{{ $clip->audio_file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clip.fields.music_layer') }}
                        </th>
                        <td>
                            @if($clip->music_layer)
                                <a href="{{ $clip->music_layer->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clip.fields.i_own_music') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $clip->i_own_music ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clip.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Clip::STATUS_SELECT[$clip->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clip.fields.video') }}
                        </th>
                        <td>
                            @if($clip->video)
                                <a href="{{ $clip->video->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clip.fields.cost') }}
                        </th>
                        <td>
                            {{ $clip->cost }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.clip.fields.privacy') }}
                        </th>
                        <td>
                            {{ App\Models\Clip::PRIVACY_RADIO[$clip->privacy] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.clips.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection