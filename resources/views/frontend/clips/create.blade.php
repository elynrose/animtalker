@extends('layouts.frontend')
@section('content')
<div class="container">
<h3 class="mb-5">{{ trans('global.create') }} {{ trans('cruds.clip.title_singular') }}     </h3>
@if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
    <div class="row justify-content-center">
        
        <div class="col-md-12">

            <div class="card">
           
                <div class="card-body">
                    
                <div class="row">
                    <div class="col-md-6">
                    @if($character->avatar)
                    <img src="{{ $character->avatar->getUrl('thumb') }}" width="100%">
                    @endif

                    </div>
                    <div class="col-md-6">

                    <form method="POST" action="{{ route("frontend.clips.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                       
                        <div class="form-group">
                            <label for="prompt">{{ trans('cruds.clip.fields.prompt') }}</label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="prompt" id="prompt">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="write">Write</button>
                                </div>
                            </div>
                            @if($errors->has('prompt'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('prompt') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('script') ? 'has-error' : '' }}">
                            <label for="script"> {{ trans('cruds.clip.fields.script') }}</label>
                            <textarea class="form-control" name="script" id="script" oninput="limitCharacters(this, 255)">{{ old('script') }}</textarea>
                            <p class="text-muted text-right" id="script_count">0/255</p>
                            @if($errors->has('script'))
                                <p class="help-block text-danger">{{ $errors->first('script') }}</p>
                            @endif
                            <p class="helper-block" style="color:#6c757d;">
                            </p>
                        </div>

                        <div class="form-group">
                            <label>{{ trans('cruds.clip.fields.voice') }}</label>
                            <select class="form-control" name="voice" id="voice">
                                <option value disabled {{ old('voice', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Clip::VOICE as $key => $label)
                                    <option value="{{ $key }}" {{ old('voice', 'alloy') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('voice'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('voice') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.clip.fields.status_helper') }}</span>
                        </div>
                        


                     <!--      <div class="form-group">
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
                            <label for="music_layer">{{ trans('cruds.clip.fields.music_layer') }}</label>
                            <div class="needsclick dropzone" id="music_layer-dropzone">
                            </div>
                            @if($errors->has('music_layer'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('music_layer') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.clip.fields.music_layer_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="i_own_music" value="0">
                                <input type="checkbox" name="i_own_music" id="i_own_music" value="1" {{ old('i_own_music', 0) == 1 ? 'checked' : '' }}>
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
                                    <option value="{{ $key }}" {{ old('status', '1') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                            <input class="form-control" type="number" name="cost" id="cost" value="{{ old('cost', '') }}" step="1">
                            @if($errors->has('cost'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cost') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.clip.fields.cost_helper') }}</span>
                        </div>-->
                        <div class="form-group">
                            <div class="row">
                            @foreach(App\Models\Clip::PRIVACY_RADIO as $key => $label)
                            
                                <div class="col-md-3">
                                    <input type="radio" id="privacy_{{ $key }}" name="privacy" value="{{ $key }}" {{ old('privacy', '0') === (string) $key ? 'checked' : '' }}>
                                    <label for="privacy_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                            </div>
                            @if($errors->has('privacy'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('privacy') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.clip.fields.privacy_helper') }}</span>
                        </div>
                        <div class="form-group">
                            @if(!empty(Request::segment(2)))
                            <input type="hidden" name="character_id" value="{{ Request::segment(2) }}">
                            <input type="hidden" name="image_path" value="{{ $character->avatar->getUrl() }}">
                            @endif
                            <button class="btn btn-danger btn-lg" type="submit">
                                {{ trans('cruds.clip.generate') }}
                            </button>
                        </div>
                    </form>

                    </div>
                    </div>

                    <!---Display the characters Photo -->
                  
                   
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
$(function() {
    $('#write').click(function() {
        var prompt = $('#prompt').val();
        if(prompt == ''){
            return;
        }
        //send headers
        $('#script').val('Loading...');
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            url: '{{ route('frontend.clips.openai') }}',
            type: 'POST',
            data: {
                topic: prompt
            },
            success: function(response) {
                console.log(response);
                //parse the response and display the first choice in the textarea
                $('#script').val(response);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert('An error occurred: ' + error);
            }
        });
    });
    });
</script>
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
    Dropzone.options.musicLayerDropzone = {
    url: '{{ route('frontend.clips.storeMedia') }}',
    maxFilesize: 5, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').find('input[name="music_layer"]').remove()
      $('form').append('<input type="hidden" name="music_layer" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="music_layer"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($clip) && $clip->music_layer)
      var file = {!! json_encode($clip->music_layer) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="music_layer" value="' + file.file_name + '">')
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

function limitCharacters(textarea, maxChar){
    var text = textarea.value;
    var textLength = text.length;
    if(textLength > maxChar){
        textarea.value = text.substr(0, maxChar);
    }
    $('#script_count').text(textLength + '/' + maxChar);
}
</script>
@endsection