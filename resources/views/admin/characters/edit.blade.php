@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.character.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.characters.update", [$character->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.character.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $character->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="scene_id">{{ trans('cruds.character.fields.scene') }}</label>
                <select class="form-control select2 {{ $errors->has('scene') ? 'is-invalid' : '' }}" name="scene_id" id="scene_id" required>
                    @foreach($scenes as $id => $entry)
                        <option value="{{ $id }}" {{ (old('scene_id') ? old('scene_id') : $character->scene->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('scene'))
                    <div class="invalid-feedback">
                        {{ $errors->first('scene') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.scene_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="gender_id">{{ trans('cruds.character.fields.gender') }}</label>
                <select class="form-control select2 {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender_id" id="gender_id" required>
                    @foreach($genders as $id => $entry)
                        <option value="{{ $id }}" {{ (old('gender_id') ? old('gender_id') : $character->gender->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('gender'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gender') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.gender_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="age_group_id">{{ trans('cruds.character.fields.age_group') }}</label>
                <select class="form-control select2 {{ $errors->has('age_group') ? 'is-invalid' : '' }}" name="age_group_id" id="age_group_id" required>
                    @foreach($age_groups as $id => $entry)
                        <option value="{{ $id }}" {{ (old('age_group_id') ? old('age_group_id') : $character->age_group->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('age_group'))
                    <div class="invalid-feedback">
                        {{ $errors->first('age_group') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.age_group_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="body_type_id">{{ trans('cruds.character.fields.body_type') }}</label>
                <select class="form-control select2 {{ $errors->has('body_type') ? 'is-invalid' : '' }}" name="body_type_id" id="body_type_id">
                    @foreach($body_types as $id => $entry)
                        <option value="{{ $id }}" {{ (old('body_type_id') ? old('body_type_id') : $character->body_type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('body_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('body_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.body_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="hair_color_id">{{ trans('cruds.character.fields.hair_color') }}</label>
                <select class="form-control select2 {{ $errors->has('hair_color') ? 'is-invalid' : '' }}" name="hair_color_id" id="hair_color_id">
                    @foreach($hair_colors as $id => $entry)
                        <option value="{{ $id }}" {{ (old('hair_color_id') ? old('hair_color_id') : $character->hair_color->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('hair_color'))
                    <div class="invalid-feedback">
                        {{ $errors->first('hair_color') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.hair_color_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="hair_lenght_id">{{ trans('cruds.character.fields.hair_lenght') }}</label>
                <select class="form-control select2 {{ $errors->has('hair_lenght') ? 'is-invalid' : '' }}" name="hair_lenght_id" id="hair_lenght_id">
                    @foreach($hair_lenghts as $id => $entry)
                        <option value="{{ $id }}" {{ (old('hair_lenght_id') ? old('hair_lenght_id') : $character->hair_lenght->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('hair_lenght'))
                    <div class="invalid-feedback">
                        {{ $errors->first('hair_lenght') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.hair_lenght_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="hair_style_id">{{ trans('cruds.character.fields.hair_style') }}</label>
                <select class="form-control select2 {{ $errors->has('hair_style') ? 'is-invalid' : '' }}" name="hair_style_id" id="hair_style_id">
                    @foreach($hair_styles as $id => $entry)
                        <option value="{{ $id }}" {{ (old('hair_style_id') ? old('hair_style_id') : $character->hair_style->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('hair_style'))
                    <div class="invalid-feedback">
                        {{ $errors->first('hair_style') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.hair_style_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="head_shape_id">{{ trans('cruds.character.fields.head_shape') }}</label>
                <select class="form-control select2 {{ $errors->has('head_shape') ? 'is-invalid' : '' }}" name="head_shape_id" id="head_shape_id">
                    @foreach($head_shapes as $id => $entry)
                        <option value="{{ $id }}" {{ (old('head_shape_id') ? old('head_shape_id') : $character->head_shape->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('head_shape'))
                    <div class="invalid-feedback">
                        {{ $errors->first('head_shape') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.head_shape_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="nose_shape_id">{{ trans('cruds.character.fields.nose_shape') }}</label>
                <select class="form-control select2 {{ $errors->has('nose_shape') ? 'is-invalid' : '' }}" name="nose_shape_id" id="nose_shape_id">
                    @foreach($nose_shapes as $id => $entry)
                        <option value="{{ $id }}" {{ (old('nose_shape_id') ? old('nose_shape_id') : $character->nose_shape->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('nose_shape'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nose_shape') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.nose_shape_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="mouth_shape_id">{{ trans('cruds.character.fields.mouth_shape') }}</label>
                <select class="form-control select2 {{ $errors->has('mouth_shape') ? 'is-invalid' : '' }}" name="mouth_shape_id" id="mouth_shape_id">
                    @foreach($mouth_shapes as $id => $entry)
                        <option value="{{ $id }}" {{ (old('mouth_shape_id') ? old('mouth_shape_id') : $character->mouth_shape->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('mouth_shape'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mouth_shape') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.mouth_shape_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="eye_shape_id">{{ trans('cruds.character.fields.eye_shape') }}</label>
                <select class="form-control select2 {{ $errors->has('eye_shape') ? 'is-invalid' : '' }}" name="eye_shape_id" id="eye_shape_id">
                    @foreach($eye_shapes as $id => $entry)
                        <option value="{{ $id }}" {{ (old('eye_shape_id') ? old('eye_shape_id') : $character->eye_shape->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('eye_shape'))
                    <div class="invalid-feedback">
                        {{ $errors->first('eye_shape') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.eye_shape_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="eye_color_id">{{ trans('cruds.character.fields.eye_color') }}</label>
                <select class="form-control select2 {{ $errors->has('eye_color') ? 'is-invalid' : '' }}" name="eye_color_id" id="eye_color_id">
                    @foreach($eye_colors as $id => $entry)
                        <option value="{{ $id }}" {{ (old('eye_color_id') ? old('eye_color_id') : $character->eye_color->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('eye_color'))
                    <div class="invalid-feedback">
                        {{ $errors->first('eye_color') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.eye_color_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="skin_tone_id">{{ trans('cruds.character.fields.skin_tone') }}</label>
                <select class="form-control select2 {{ $errors->has('skin_tone') ? 'is-invalid' : '' }}" name="skin_tone_id" id="skin_tone_id">
                    @foreach($skin_tones as $id => $entry)
                        <option value="{{ $id }}" {{ (old('skin_tone_id') ? old('skin_tone_id') : $character->skin_tone->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('skin_tone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('skin_tone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.skin_tone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="facial_expression_id">{{ trans('cruds.character.fields.facial_expression') }}</label>
                <select class="form-control select2 {{ $errors->has('facial_expression') ? 'is-invalid' : '' }}" name="facial_expression_id" id="facial_expression_id">
                    @foreach($facial_expressions as $id => $entry)
                        <option value="{{ $id }}" {{ (old('facial_expression_id') ? old('facial_expression_id') : $character->facial_expression->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('facial_expression'))
                    <div class="invalid-feedback">
                        {{ $errors->first('facial_expression') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.facial_expression_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="emotion_id">{{ trans('cruds.character.fields.emotion') }}</label>
                <select class="form-control select2 {{ $errors->has('emotion') ? 'is-invalid' : '' }}" name="emotion_id" id="emotion_id">
                    @foreach($emotions as $id => $entry)
                        <option value="{{ $id }}" {{ (old('emotion_id') ? old('emotion_id') : $character->emotion->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('emotion'))
                    <div class="invalid-feedback">
                        {{ $errors->first('emotion') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.emotion_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="dress_style_id">{{ trans('cruds.character.fields.dress_style') }}</label>
                <select class="form-control select2 {{ $errors->has('dress_style') ? 'is-invalid' : '' }}" name="dress_style_id" id="dress_style_id">
                    @foreach($dress_styles as $id => $entry)
                        <option value="{{ $id }}" {{ (old('dress_style_id') ? old('dress_style_id') : $character->dress_style->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('dress_style'))
                    <div class="invalid-feedback">
                        {{ $errors->first('dress_style') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.dress_style_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="dress_colors">{{ trans('cruds.character.fields.dress_color') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('dress_colors') ? 'is-invalid' : '' }}" name="dress_colors[]" id="dress_colors" multiple>
                    @foreach($dress_colors as $id => $dress_color)
                        <option value="{{ $id }}" {{ (in_array($id, old('dress_colors', [])) || $character->dress_colors->contains($id)) ? 'selected' : '' }}>{{ $dress_color }}</option>
                    @endforeach
                </select>
                @if($errors->has('dress_colors'))
                    <div class="invalid-feedback">
                        {{ $errors->first('dress_colors') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.dress_color_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="props">{{ trans('cruds.character.fields.props') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('props') ? 'is-invalid' : '' }}" name="props[]" id="props" multiple>
                    @foreach($props as $id => $prop)
                        <option value="{{ $id }}" {{ (in_array($id, old('props', [])) || $character->props->contains($id)) ? 'selected' : '' }}>{{ $prop }}</option>
                    @endforeach
                </select>
                @if($errors->has('props'))
                    <div class="invalid-feedback">
                        {{ $errors->first('props') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.props_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="posture_id">{{ trans('cruds.character.fields.posture') }}</label>
                <select class="form-control select2 {{ $errors->has('posture') ? 'is-invalid' : '' }}" name="posture_id" id="posture_id">
                    @foreach($postures as $id => $entry)
                        <option value="{{ $id }}" {{ (old('posture_id') ? old('posture_id') : $character->posture->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('posture'))
                    <div class="invalid-feedback">
                        {{ $errors->first('posture') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.posture_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="character_zoom_id">{{ trans('cruds.character.fields.character_zoom') }}</label>
                <select class="form-control select2 {{ $errors->has('character_zoom') ? 'is-invalid' : '' }}" name="character_zoom_id" id="character_zoom_id">
                    @foreach($character_zooms as $id => $entry)
                        <option value="{{ $id }}" {{ (old('character_zoom_id') ? old('character_zoom_id') : $character->character_zoom->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('character_zoom'))
                    <div class="invalid-feedback">
                        {{ $errors->first('character_zoom') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.character_zoom_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="caption">{{ trans('cruds.character.fields.caption') }}</label>
                <input class="form-control {{ $errors->has('caption') ? 'is-invalid' : '' }}" type="text" name="caption" id="caption" value="{{ old('caption', $character->caption) }}">
                @if($errors->has('caption'))
                    <div class="invalid-feedback">
                        {{ $errors->first('caption') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.caption_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="custom_prompt">{{ trans('cruds.character.fields.custom_prompt') }}</label>
                <textarea class="form-control {{ $errors->has('custom_prompt') ? 'is-invalid' : '' }}" name="custom_prompt" id="custom_prompt">{{ old('custom_prompt', $character->custom_prompt) }}</textarea>
                @if($errors->has('custom_prompt'))
                    <div class="invalid-feedback">
                        {{ $errors->first('custom_prompt') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.custom_prompt_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="avatar">{{ trans('cruds.character.fields.avatar') }}</label>
                <div class="needsclick dropzone {{ $errors->has('avatar') ? 'is-invalid' : '' }}" id="avatar-dropzone">
                </div>
                @if($errors->has('avatar'))
                    <div class="invalid-feedback">
                        {{ $errors->first('avatar') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.avatar_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.character.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $character->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.character.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    Dropzone.options.avatarDropzone = {
    url: '{{ route('admin.characters.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="avatar"]').remove()
      $('form').append('<input type="hidden" name="avatar" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="avatar"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($character) && $character->avatar)
      var file = {!! json_encode($character->avatar) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="avatar" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
@endsection