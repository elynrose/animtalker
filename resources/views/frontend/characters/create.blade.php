@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <h3> {{ trans('cruds.character.title') }}</h3>
            <div class="card" id="step1">


                <div class="card-body">
                <p class="display-5 mb-5">{{ trans('cruds.character.desc') }}</p>

                    <div class="alert alert-danger error" style="display:none;"></div>
                    <div class="alert alert-success success" style="display:none;"></div>
                    <form method="POST" action="{{ route('frontend.characters.store') }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                       <!-- <p><a onclick="toggleWizard();" class="btn btn-primary btn-sm"> Use the wizard</a></p>-->

                        <div class="form-group mb-5">
                            <label class="required" for="name">{{ trans('cruds.character.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.character.fields.name_helper') }}</span>
                        </div>

<!---->
                        <div class="form-group mb-5" id="custom">
                            <label for="custom_prompt">{{ trans('cruds.character.fields.custom_prompt') }}</label>
                            <textarea class="form-control mb-3" name="custom_prompt" id="custom_prompt" rows="6"  placeholder="Example: A beautiful young lady from the 16th century">{{ old('custom_prompt', '') }}</textarea>
                            <p> <a href="javascript();"  class="mt-2" id="refine">{{ trans('cruds.character.fields.refine_prompt') }}</a></p>

                            @if($errors->has('custom_prompt'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('custom_prompt') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.character.fields.custom_prompt_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="prompt"></label>
                            <textarea class="form-control mb-3" name="script" id="script" rows="6"  placeholder="What do you want your character to say">{{ old('script', '') }}</textarea>
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
                    

                        <div class="form-group mt-4">
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <button class="btn btn-danger btn-block" id="save" type="submit">
                                {{ trans('global.generate') }}
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
@parent
<script>

    $('#save').click(function(e) {
        e.preventDefault();
        var name = $('#name').val();
        var prompt = $('#custom_prompt').val();
        var script = $('#script').val();
        var voice = $('#voice').val();

        if(prompt == '' || script == '' || voice == '') {
            return;
        }

        //send headers
        $('#save').text('Working...');
        $('#save').attr('disabled', true);
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            url: "{{ route('frontend.characters.store') }}",
            type: 'POST',
            data: {
                name: name,
                custom_prompt: prompt,
                script: script,
                voice: voice,
                user_id: {{ Auth::id() }},
            },
            success: function(response) {
                
               location.href = '/clips';
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert('An error occurred: ' + error);
            }
        });
    });

</script>
@endsection
