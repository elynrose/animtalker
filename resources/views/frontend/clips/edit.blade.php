@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.clip.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.clips.update", [$clip->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="character_id">{{ trans('cruds.clip.fields.character') }}</label>
                            <select class="form-control select2" name="character_id" id="character_id" required>
                                @foreach($characters as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('character_id') ? old('character_id') : $clip->character->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('character'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('character') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.clip.fields.character_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="script">{{ trans('cruds.clip.fields.script') }}</label>
                            <textarea class="form-control" name="script" id="script" required>{{ old('script', $clip->script) }}</textarea>
                            @if($errors->has('script'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('script') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.clip.fields.script_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="audio_file">{{ trans('cruds.clip.fields.audio_file') }}</label>
                            <div class="needsclick dropzone" id="audio_file-dropzone">
                            </div>
                            @if($errors->has('audio_file'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('audio_file') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.clip.fields.audio_file_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="i_own_music" value="0">
                                <input type="checkbox" name="i_own_music" id="i_own_music" value="1" {{ $clip->i_own_music || old('i_own_music', 0) === 1 ? 'checked' : '' }}>
                                <label for="i_own_music">{{ trans('cruds.clip.fields.i_own_music') }}</label>
                            </div>
                            @if($errors->has('i_own_music'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('i_own_music') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.clip.fields.i_own_music_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.clip.fields.status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Clip::STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', $clip->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.clip.fields.status_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="video">{{ trans('cruds.clip.fields.video') }}</label>
                            <div class="needsclick dropzone" id="video-dropzone">
                            </div>
                            @if($errors->has('video'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('video') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.clip.fields.video_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="cost">{{ trans('cruds.clip.fields.cost') }}</label>
                            <input class="form-control" type="number" name="cost" id="cost" value="{{ old('cost', $clip->cost) }}" step="1">
                            @if($errors->has('cost'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cost') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.clip.fields.cost_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.clip.fields.privacy') }}</label>
                            @foreach(App\Models\Clip::PRIVACY_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="privacy_{{ $key }}" name="privacy" value="{{ $key }}" {{ old('privacy', $clip->privacy) === (string) $key ? 'checked' : '' }}>
                                    <label for="privacy_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('privacy'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('privacy') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.clip.fields.privacy_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    Dropzone.options.audioFileDropzone = {
    url: '{{ route('frontend.clips.storeMedia') }}',
    maxFilesize: 100, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 100
    },
    success: function (file, response) {
      $('form').find('input[name="audio_file"]').remove()
      $('form').append('<input type="hidden" name="audio_file" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="audio_file"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($clip) && $clip->audio_file)
      var file = {!! json_encode($clip->audio_file) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="audio_file" value="' + file.file_name + '">')
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
<script>
    Dropzone.options.videoDropzone = {
    url: '{{ route('frontend.clips.storeMedia') }}',
    maxFilesize: 100, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 100
    },
    success: function (file, response) {
      $('form').find('input[name="video"]').remove()
      $('form').append('<input type="hidden" name="video" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="video"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($clip) && $clip->video)
      var file = {!! json_encode($clip->video) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="video" value="' + file.file_name + '">')
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