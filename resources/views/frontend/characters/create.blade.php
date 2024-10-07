@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <h3> {{ trans('cruds.character.title') }}</h3>
        <p>{{ trans('cruds.character.desc') }}</p>
            <div class="card" id="step1">
             

                <div class="card-body">
                    <div class="alert alert-danger error" style="display:none;"></div>
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

<!--
                        <div class="form-group mb-5" id="custom">
                            <label for="custom_prompt">{{ trans('cruds.character.fields.custom_prompt') }}</label>
                            <textarea class="form-control mb-3" name="custom_prompt" id="custom_prompt" rows="6" oninput="autoExpand(this)">{{ old('custom_prompt', '') }}</textarea>
<p><a href="javascript();"  class="mt-2" id="refine">{{ trans('cruds.character.fields.refine_prompt') }}</a></p>

                            @if($errors->has('custom_prompt'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('custom_prompt') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.character.fields.custom_prompt_helper') }}</span>
                        </div>
-->
                        

                       

                        <div id="wizard" style="display:block;">
                        <!--Radio button for aspect ratio-->
                                
                            <!--   <div class="card">
                                <div class="card-header">
                                    <h6>{{ trans('cruds.character.fields.aspect_ratio') }}</h6>
                                </div>
                             <div class="card-body">
                                    
                                    <div class="row">
                                    <div class="col-md-6">
                                    <input type="radio" name="aspect_ratio" id="aspect_ratio_1" value="9:16">
                                    <label for="aspect_ratio_1">9:16</label>
                                    </div>
                                    <div class="col-md-6">
                                    <input type="radio" name="aspect_ratio" id="aspect_ratio_2" value="16:9">
                                    <label for="aspect_ratio_2">16:9</label>
                                    </div>
                                    </div>
                                 </div>
                            </div>-->

                          <div class="form-group mb-5">
                                <label>{{ trans('cruds.character.fields.is_realistic') }}</label>
                                <select class="form-control" name="is_realistic" id="is_realistic">
                                <option value="1">{{ trans('cruds.character.cartoon') }}</option>
                                <option value="2">{{ trans('cruds.character.realistic') }}</option>
                                </select>
                            </div>

                      

                            <div class="form-group mb-5">
                            <label>{{ trans('cruds.character.fields.art') }}</label>
                            <select class="form-control" name="art_style" id="art_style">
                                <option value disabled {{ old('art_style', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Character::ART as $key => $label)
                                    <option value="{{ $key }}" {{ old('art_style', 'alloy') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('art_style'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('art_style') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.clip.fields.status_helper') }}</span>
                        </div>

                    

                        

                        <div id="accordion">

                            <!-- Scene Section -->
                            <div class="card mb-3">
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
                            <div class="card mb-3">
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
                            <div class="card mb-3">
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
                            <div class="card mb-3">
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
                            <div class="card mb-3">
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
                            <div class="card mb-3">
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
</div>
                        <div class="form-group mt-4">
                        <input type="hidden" name="aspect_ratio" value="16:9" id="aspect_ratio">
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <button class="btn btn-danger" id="save" type="submit">
                                {{ trans('global.generate') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card" id="step2">
                <div class="card-header"> {{ trans('cruds.clip.desc') }} </div>
                    <div class="card-body">
                    <form method="POST" action="{{ route("frontend.clips.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                       
                        <!--add voice selection -->

                        <div class="form-group">
                            <label class="required" for="prompt">{{ trans('cruds.clip.fields.prompt') }}</label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="prompt" id="prompt" required>
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
                            <textarea class="form-control" name="script" id="script">{{ old('script') }}</textarea>
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
                            <input type="hidden" name="character_id" id="character_id"  value="">
                            <input type="hidden" name="image_path" id="image_path" value="">
                            <button class="btn btn-danger btn-lg" type="submit">
                                {{ trans('global.animate') }}
                            </button>
                        </div>
                    </form>

                    </div>
            </div>

        </div>
        <div class="col-md-4 text-center">
            <div class="card shadow" id="character_box">
                <div class="card-header"> {{ trans('cruds.character.title_singular') }}</div>
                <div class="card-body sprite">
            <p id="loading" style="display:none;"><img src="{{asset('images/loading.gif')}}" width="64" ><br> Loading ...</p>
            <p id="img_wrap" style="display:none;"><img src="" width="100%"  alt="Generated Image" id="image"></p>
            <div id="prompt mt-4"></div>
        </div></div></div>
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

    $(document).ready(function(){

        //if button data-value is empty, hide it
        $('button').each(function(){
            if($(this).data('value') == ''){
                $(this).hide();
            }
        });
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

        $('#img_wrap, .error, #loading, #step2').hide();

        // Handle form submission
        $('#save').on('click', function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Check if the required fields are provided

            var name = $('#name').val();
            var aspectRatio = $('#aspect_ratio').val();
            var sceneId = $('#scene_id').val();
            var genderId = $('#gender_id').val();
            var ageGroupId = $('#age_group_id').val();
            var characterId = $('#character_id').val();

            if (name.trim() === '') {
                // Flash an error message
                $('.error').text('Character name required.').show();
                return;
            }
            $('.error').hide();
            $('#step1').slideUp('slow').hide();
            $('#step2').show();

            // Continue with form submission
            // Get the form data
            var formData = $('form').serialize();
            $('#loading').show();
            // Send the form data using AJAX
            $('#save').attr('disabled', true);
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
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
                    var id = response.id;
                    if(image!==''){
                    // Display the image and prompt
                    $('#image').attr('src', image);
                    $('#prompt').text(prompt);
                    $('#loading').hide();
                    $('#image_path').val(image);
                    $('#character_id').val(id);
                    $('#img_wrap').show();
                    $('#save').attr('disabled', false);
                } else {
                    $('.error').text(response.error).show();
                }
                },
                error: function(xhr, status, error) {
                    // Handle the error response
                    //alert error message
                    $('#save').attr('disabled', false);
                    $('#img_wrap').hide();
                    $('#loading').hide();
                    $('#img_wrap', '#image').hide();
                    $('#step1').show();
                    $('#step2').hide();
                    $('.error').text('An error occurred. Please try again.');
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
<script>
                     /*       function toggleWizard() {
                                var wizard = document.getElementById("wizard");
                                var customPrompt = document.getElementById("custom");
                                var button = document.querySelector("#step1 a");

                                if (wizard.style.display === "none") {
                                    wizard.style.display = "block";
                                    customPrompt.style.display = "none";
                                    button.textContent = "Use Custom Prompt";
                                } else {
                                    wizard.style.display = "none";
                                    customPrompt.style.display = "block";
                                    button.textContent = "Use Wizard";
                                }
                            }

                            function autoExpand(textarea) {
                                textarea.style.height = 'auto';
                                textarea.style.height = textarea.scrollHeight + 'px';
                            }
*/
                            //when refinePrompt is clicked, send the value in custom_prompt to the server ClipsController@refinePrompt

                         
                            $(function(){
                                $('#refine').click(function(e) {
                                    e.preventDefault();
                                    var customPrompt = $('#custom_prompt').val();
                                    if(customPrompt == ''){
                                        return;
                                    }
                                    //send headers
                                    $('#custom_prompt').val('Loading...');
                                    $.ajax({
                                        headers: {
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                        },
                                        url: '{{ route('frontend.character.refine') }}',
                                        type: 'POST',
                                        data: {
                                            topic: customPrompt
                                        },
                                        success: function(response) {
                                            console.log(response);
                                            //parse the response and display the first choice in the textarea
                                            $('#custom_prompt').val(response);
                                        },
                                        error: function(xhr, status, error) {
                                            console.log(xhr.responseText);
                                            alert('An error occurred: ' + error);
                                        }
                                    });
                                });
                            });
                                
                        </script>
@endsection
