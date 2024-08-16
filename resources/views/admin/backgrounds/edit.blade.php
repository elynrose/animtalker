@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.background.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.backgrounds.update", [$background->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="background_title">{{ trans('cruds.background.fields.background_title') }}</label>
                <input class="form-control {{ $errors->has('background_title') ? 'is-invalid' : '' }}" type="text" name="background_title" id="background_title" value="{{ old('background_title', $background->background_title) }}" required>
                @if($errors->has('background_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('background_title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.background.fields.background_title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="scene">{{ trans('cruds.background.fields.scene') }}</label>
                <textarea class="form-control {{ $errors->has('scene') ? 'is-invalid' : '' }}" name="scene" id="scene" required>{{ old('scene', $background->scene) }}</textarea>
                @if($errors->has('scene'))
                    <div class="invalid-feedback">
                        {{ $errors->first('scene') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.background.fields.scene_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="icon">{{ trans('cruds.background.fields.icon') }}</label>
                <div class="needsclick dropzone {{ $errors->has('icon') ? 'is-invalid' : '' }}" id="icon-dropzone">
                </div>
                @if($errors->has('icon'))
                    <div class="invalid-feedback">
                        {{ $errors->first('icon') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.background.fields.icon_helper') }}</span>
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
    Dropzone.options.iconDropzone = {
    url: '{{ route('admin.backgrounds.storeMedia') }}',
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
      $('form').find('input[name="icon"]').remove()
      $('form').append('<input type="hidden" name="icon" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="icon"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($background) && $background->icon)
      var file = {!! json_encode($background->icon) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="icon" value="' + file.file_name + '">')
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