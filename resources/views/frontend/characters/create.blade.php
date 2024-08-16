@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.character.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('frontend.characters.store') }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.character.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.character.fields.name_helper') }}</span>
                        </div>

                        <div id="accordion">

                            <!-- Scene Section -->
                            <div class="card">
                                <div class="card-header" id="sceneHeading">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#sceneCollapse" aria-expanded="true" aria-controls="sceneCollapse">
                                            Scene
                                        </button>
                                    </h5>
                                </div>
                                <div id="sceneCollapse" class="collapse show" aria-labelledby="sceneHeading" data-parent="#accordion">
                                    <div class="card-body">
                                        @foreach($scenes as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 scene-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="scene_id" id="scene_id">
                                    </div>
                                </div>
                            </div>

                            <!-- Character Details Section -->
                            <div class="card">
                                <div class="card-header" id="characterDetailsHeading">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#characterDetailsCollapse" aria-expanded="false" aria-controls="characterDetailsCollapse">
                                            Character Details
                                        </button>
                                    </h5>
                                </div>
                                <div id="characterDetailsCollapse" class="collapse" aria-labelledby="characterDetailsHeading" data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- Gender -->
                                        <h6 class="mb-3">Gender</h6>
                                        @foreach($genders as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 gender-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="gender_id" id="gender_id">

                                        <!-- Age Group -->
                                        <h6 class="mb-3">Age Group</h6>
                                        @foreach($age_groups as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 age-group-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="age_group_id" id="age_group_id">

                                        <!-- Body Type -->
                                        <h6 class="mb-3">Body Type</h6>
                                        @foreach($body_types as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 body-type-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="body_type_id" id="body_type_id">
                                    </div>
                                </div>
                            </div>

                            <!-- Appearance Section -->
                            <div class="card">
                                <div class="card-header" id="appearanceHeading">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#appearanceCollapse" aria-expanded="false" aria-controls="appearanceCollapse">
                                            Appearance
                                        </button>
                                    </h5>
                                </div>
                                <div id="appearanceCollapse" class="collapse" aria-labelledby="appearanceHeading" data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- Hair Color -->
                                        <h6 class="mb-3">Hair Color</h6>
                                        @foreach($hair_colors as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 hair-color-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="hair_color_id" id="hair_color_id">

                                        <!-- Hair Length -->
                                        <h6 class="mb-3">Hair Length</h6>
                                        @foreach($hair_lenghts as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 hair-length-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="hair_lenght_id" id="hair_lenght_id">

                                        <!-- Hair Style -->
                                        <h6 class="mb-3">Hair Style</h6>
                                        @foreach($hair_styles as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 hair-style-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="hair_style_id" id="hair_style_id">

                                        <!-- Head Shape -->
                                        <h6 class="mb-3">Head Shape</h6>
                                        @foreach($head_shapes as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 head-shape-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="head_shape_id" id="head_shape_id">

                                        <!-- Nose Shape -->
                                        <h6 class="mb-3">Nose Shape</h6>
                                        @foreach($nose_shapes as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 nose-shape-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="nose_shape_id" id="nose_shape_id">

                                        <!-- Mouth Shape -->
                                        <h6 class="mb-3">Mouth Shape</h6>
                                        @foreach($mouth_shapes as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 mouth-shape-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="mouth_shape_id" id="mouth_shape_id">

                                        <!-- Eye Shape -->
                                        <h6 class="mb-3">Eye Shape</h6>
                                        @foreach($eye_shapes as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 eye-shape-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="eye_shape_id" id="eye_shape_id">

                                        <!-- Eye Color -->
                                        <h6 class="mb-3">Eye Color</h6>
                                        @foreach($eye_colors as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 eye-color-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="eye_color_id" id="eye_color_id">

                                        <!-- Skin Tone -->
                                        <h6 class="mb-3">Skin Tone</h6>
                                        @foreach($skin_tones as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 skin-tone-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="skin_tone_id" id="skin_tone_id">
                                    </div>
                                </div>
                            </div>

                            <!-- Expressions Section -->
                            <div class="card">
                                <div class="card-header" id="expressionsHeading">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#expressionsCollapse" aria-expanded="false" aria-controls="expressionsCollapse">
                                            Expressions
                                        </button>
                                    </h5>
                                </div>
                                <div id="expressionsCollapse" class="collapse" aria-labelledby="expressionsHeading" data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- Facial Expression -->
                                        <h6 class="mb-3">Facial Expression</h6>
                                        @foreach($facial_expressions as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 facial-expression-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="facial_expression_id" id="facial_expression_id">

                                        <!-- Emotion -->
                                        <h6 class="mb-3">Emotion</h6>
                                        @foreach($emotions as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 emotion-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="emotion_id" id="emotion_id">
                                    </div>
                                </div>
                            </div>

                            <!-- Clothing Section -->
                            <div class="card">
                                <div class="card-header" id="clothingHeading">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#clothingCollapse" aria-expanded="false" aria-controls="clothingCollapse">
                                            Clothing
                                        </button>
                                    </h5>
                                </div>
                                <div id="clothingCollapse" class="collapse" aria-labelledby="clothingHeading" data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- Dress Style -->
                                        <h6 class="mb-3">Dress Style</h6>
                                        @foreach($dress_styles as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 dress-style-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="dress_style_id" id="dress_style_id">

                                        <!-- Dress Colors -->
                                        <h6 class="mb-3">Dress Colors</h6>
                                        @foreach($dress_colors as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 dress-color-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="dress_colors[]" id="dress_colors">

                                        <!-- Props -->
                                        <h6 class="mb-3">Props</h6>
                                        @foreach($props as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 props-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="props[]" id="props">
                                    </div>
                                </div>
                            </div>

                            <!-- Posture and Zoom Section -->
                            <div class="card">
                                <div class="card-header" id="postureZoomHeading">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#postureZoomCollapse" aria-expanded="false" aria-controls="postureZoomCollapse">
                                            Posture and Zoom
                                        </button>
                                    </h5>
                                </div>
                                <div id="postureZoomCollapse" class="collapse" aria-labelledby="postureZoomHeading" data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- Posture -->
                                        <h6 class="mb-3">Posture</h6>
                                        @foreach($postures as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 posture-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="posture_id" id="posture_id">

                                        <!-- Character Zoom -->
                                        <h6 class="mb-3">Character Zoom</h6>
                                        @foreach($character_zooms as $id => $entry)
                                            <button type="button" class="btn btn-outline-primary mb-2 character-zoom-btn" data-value="{{ $id }}">{{ $entry }}</button>
                                        @endforeach
                                        <input type="hidden" name="character_zoom_id" id="character_zoom_id">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group mt-4">
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <button class="btn btn-danger" id="save" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="card">
                <div class="card-body sprite">
            <p><img src="{{asset('images/loading.webp')}}" width="100%"  alt="Generated Image" id="image"></p>
            <div id="prompt mt-4"></div>
        </div></div></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        // Ensure all buttons that aren't meant to submit the form have type="button"
        $('button').not('[type="submit"]').attr('type', 'button');

        // Function to handle button group selections and assign the selected value to the hidden input
        function handleButtonGroup(buttonClass, hiddenFieldId) {
            $(buttonClass).on('click', function() {
                $(buttonClass).removeClass('active');  // Remove 'active' class from all buttons in the group
                $(this).addClass('active');            // Add 'active' class to the clicked button
                $(hiddenFieldId).val(parseInt($(this).data('value')));  // Set the hidden input value to the button's integer data-value
            });
        }

        // Initialize button groups for each field
        handleButtonGroup('.scene-btn', '#scene_id');
        handleButtonGroup('.gender-btn', '#gender_id');
        handleButtonGroup('.age-group-btn', '#age_group_id');
        handleButtonGroup('.body-type-btn', '#body_type_id');
        handleButtonGroup('.hair-color-btn', '#hair_color_id');
        handleButtonGroup('.hair-length-btn', '#hair_lenght_id');
        handleButtonGroup('.hair-style-btn', '#hair_style_id');
        handleButtonGroup('.head-shape-btn', '#head_shape_id');
        handleButtonGroup('.nose-shape-btn', '#nose_shape_id');
        handleButtonGroup('.mouth-shape-btn', '#mouth_shape_id');
        handleButtonGroup('.eye-shape-btn', '#eye_shape_id');
        handleButtonGroup('.eye-color-btn', '#eye_color_id');
        handleButtonGroup('.skin-tone-btn', '#skin_tone_id');
        handleButtonGroup('.facial-expression-btn', '#facial_expression_id');
        handleButtonGroup('.emotion-btn', '#emotion_id');
        handleButtonGroup('.dress-style-btn', '#dress_style_id');
        handleButtonGroup('.posture-btn', '#posture_id');
        handleButtonGroup('.character-zoom-btn', '#character_zoom_id');

        // Function to handle multiple selections for Dress Colors and Props (arrays of integers)
        function toggleMultipleSelections(buttonClass, hiddenFieldName) {
            $(buttonClass).on('click', function() {
                var hiddenFieldSelector = `input[name="${hiddenFieldName}[]"]`;
                var value = parseInt($(this).data('value')); // Ensure the value is an integer
                if ($(this).hasClass('active')) {
                    // If the button was already active, remove it from the list
                    $(hiddenFieldSelector).each(function(){
                        if (parseInt($(this).val()) == value) {
                            $(this).remove();
                        }
                    });
                    $(this).removeClass('active');
                } else {
                    // Otherwise, add the value to the list
                    $('<input>').attr({
                        type: 'hidden',
                        name: `${hiddenFieldName}[]`,
                        value: value
                    }).appendTo('form');
                    $(this).addClass('active');
                }
            });
        }

        toggleMultipleSelections('.dress-color-btn', 'dress_colors');
        toggleMultipleSelections('.props-btn', 'props');

        // Handle form submission
        $('#save').on('click', function(e) {
            e.preventDefault(); // Prevent the default form submission
            // Check if the required fields are provided
            var name = $('#name').val();
            var sceneId = $('#scene_id').val();
            var genderId = $('#gender_id').val();
            var ageGroupId = $('#age_group_id').val();

            if (name.trim() === '' || sceneId.trim() === '' || genderId.trim() === '' || ageGroupId.trim() === '') {
                // Flash an error message
                alert('Please fill in all required fields.');
                return;
            }

            // Continue with form submission
            // Get the form data
            var formData = $('form').serialize();

            // Send the form data using AJAX
            $.ajax({
                url: "{{ route('frontend.characters.store') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    // Handle the success response
                    console.log(response);
                    //get image and prompt from response from parsed json
                    var image = response.image;
                    var prompt = response.prompt;

                    // Display the image and prompt
                    $('#image').attr('src', image);
                    $('#prompt').text(prompt);

                },
                error: function(xhr, status, error) {
                    // Handle the error response
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
</script>
@endsection
