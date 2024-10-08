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
                    <form method="POST" action="{{ route('frontend.characters.store') }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf

                        <div class="form-group mb-5" id="custom">
                            <label for="custom_prompt">{{ trans('cruds.character.fields.custom_prompt') }}</label>
                            <textarea class="form-control mb-3" name="version" id="version" rows="6" oninput="autoExpand(this)">{{ old('custom_prompt', '') }}</textarea>
                            <input type="hidden" id="prompt" name="prompt" value="{{ $character->custom_prompt }}">
                            @if($errors->has('custom_prompt'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('custom_prompt') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.character.fields.custom_prompt_helper') }}</span>
                        </div>

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

@endsection

@section('scripts')
@parent
<script>

$(function() {
    $('#save').on('click', function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Check if the required fields are provided
            var name = "{{ $character->name }}";  
            var version = $('#version').val();
            var prompt =  $('#prompt').val(); // Get the character ID
            var new_prompt = prompt + version;

            if (version.trim() === '') {
                // Flash an error message
                $('.error').text('Write the changes you want to see in the character.').show();
                return;
            }
           
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                url: "{{ route('frontend.characters.store') }}",
                type: "POST",
                data: 'name=' + name + '&new_prompt=' + new_prompt + '&parent_id' + {{ $character->id }} + '&user_id=' + {{ Auth::id() }},
                success: function(response) {
                    // Handle the success response
                    console.log(response);
                    //get image and prompt from response from parsed json
                    var image = response.image;
                    var prompt = response.prompt;
                    var id = response.id;
                    if(image!==''){
                    // Display the image and prompt
                   
                } else {
                    $('.error').text(response.error).show();
                }
                },
                error: function(xhr, status, error) {
                   
                    console.log(xhr.responseText);
                }
            });
        });
});
</script>
@endsection
