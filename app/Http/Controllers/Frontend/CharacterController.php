<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCharacterRequest;
use App\Http\Requests\StoreCharacterRequest;
use App\Http\Requests\UpdateCharacterRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use App\Models\GenerateCharacter;
use App\Models\GenerateAudio;
use Illuminate\Support\Facades\Storage;
use App\Models\Credit;
use Illuminate\Support\Facades\Auth;
use App\Models\SendToOpenai;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Character;
use App\Models\Clip;



class CharacterController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('character_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $characters = Character::with(['user', 'media'])
            ->where('user_id', auth()->id())->orderBy('id', 'desc')
            ->get();

        return view('frontend.characters.index', compact('characters'));
    }

    public function create()
    {
        abort_if(Gate::denies('character_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.characters.create', compact('users'));
    }

  /**
 * Store a newly created resource in storage.
 *
 * @param  \App\Http\Requests\StoreCharacterRequest  $request
 * @return \Illuminate\Http\Response
 */
public function store(StoreCharacterRequest $request)
{
    if($request->custom_prompt){
        $request->validate([
            'custom_prompt' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'script' => 'required|string',
            'voice' => 'required|string',
        ]);

        $prompt = $request->custom_prompt;
        $name = $request->name;
        $script = $request->script;
        $voice = $request->voice;
    
    //Check if the user has enough credits to generate a character
    $credits = new Credit();

    if ($credits->getUserCredits() < 5) {
        //redirect back with an error message
        //send a status with the error message
        return response()->json(['status'=>'error','message' => 'You do not have enough credits to generate a character'], 500);
        exit;
    }

    try {
        // Generate character avatar using an external service
        $new_character = new GenerateCharacter();
        $avatar = $new_character->generate($prompt);

        // Retrieve avatar data from the generation response
        $avatarData = $avatar->getData();
        // Extract the prompt and image URL from the avatar data
        $prompt = $avatarData->prompt ?? null;
        $image = $avatarData->dalle_response->data[0]->url ?? null;

        // Handle error if the image is not generated
        if ($image === null) {
            // Delete the character if image generation fails
            return response()->json(['error' => 'Failed to generate character'], 500);
        }

        // Save the generated image URL to the character's avatar and save it to S3

     //   $path = $character->addMediaFromUrl($image)->toMediaCollection('avatar', 's3', 'photos')->getUrl();


        $character = Character::create([
            'name' => $name,
            'custom_prompt' => $prompt,
            'user_id' => Auth::user()->id,
            'voice' => $voice,
            'script' => $script,
            'avatar_url' => $image,
        ]);





    } catch (\Exception $e) {
        // Delete character and return error if image generation fails
        return response()->json(['error' => 'Failed to generate character: '.$e ], 500);
    }

    




/*
    try {
        // Generate character avatar using an external service
        $new_character = new GenerateCharacter();
        $avatar = $new_character->generate($prompt);

        // Retrieve avatar data from the generation response
        $avatarData = $avatar->getData();
        // Extract the prompt and image URL from the avatar data
        $prompt = $avatarData->prompt ?? null;
        $image = $avatarData->dalle_response->data[0]->url ?? null;

        // Handle error if the image is not generated
        if ($image === null) {
            // Delete the character if image generation fails
            return response()->json(['error' => 'Failed to generate character'], 500);
        }
    } catch (\Exception $e) {
        // Delete character and return error if image generation fails
        return response()->json(['error' => 'Failed to generate character'], 500);
    }

    // Save the generated image URL to the character's avatar and save it to S3
    try {
        
        $character = Character::create([
            'avatar_url' => $image,
            'name' => $name,
            'custom_prompt' => $prompt,
            'user_id' => Auth::user()->id,
        ]);
        
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to save character avatar: '.$e], 500);
    }

    try {

        $path = $character->addMediaFromUrl($image)
        ->toMediaCollection('avatar', 's3', 'photos')
        ->getUrl();
        
        $character->custom_prompt= $prompt;
        $character->avatar_url = $path;
        $character->save();

    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to save character avatar: '.$e], 500);
    }
/*
    // Return a JSON response based on the request type

  
   // $audio  = new GenerateAudio;
   // $mp3Path = $audio->textToSpeech($script, $voice);

//give me the full image path including the http://localhost:8000
    
   $clip = Clip::create([
        'character_id' => $character->id,
        'voice' => $voice,
        'script' => $script,
        'status' => 'new',
        'image_path' => $path,
    ]);


   /* $clip->character_id = $character->id;
    $clip->voice = $voice;
    //$clip->audio_path = $mp3Path;
    $clip->script = $script;
    $clip->status = 'new';
    $clip->avatar = $name;
    $clip->save();
 */

     //Deduct Credits

     $credit = Credit::where('email', Auth::user()->email)->first();
     $credit_balance  = $credit->points - env('IMAGE_CREDIT_DEDUCTION');
     $credit->points = $credit_balance;
     $credit->save();    
    

    } else {
        return response()->json(['error' => 'Failed to generate character'], 500);
    }
}


    public function edit(Character $character)
    {
        abort_if(Gate::denies('character_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $scenes = Background::pluck('background_title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $genders = Gender::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $age_groups = AgeGroup::pluck('age', 'id')->prepend(trans('global.pleaseSelect'), '');

        $body_types = BodyType::pluck('body', 'id')->prepend(trans('global.pleaseSelect'), '');

        $hair_colors = HairColor::pluck('color', 'id')->prepend(trans('global.pleaseSelect'), '');

        $hair_lenghts = HairLength::pluck('lenght', 'id')->prepend(trans('global.pleaseSelect'), '');

        $hair_styles = HairStyle::pluck('style', 'id')->prepend(trans('global.pleaseSelect'), '');

        $head_shapes = HeadShape::pluck('shape', 'id')->prepend(trans('global.pleaseSelect'), '');

        $nose_shapes = NoseShape::pluck('shape', 'id')->prepend(trans('global.pleaseSelect'), '');

        $mouth_shapes = MouthShape::pluck('shape', 'id')->prepend(trans('global.pleaseSelect'), '');

        $eye_shapes = EyeShape::pluck('shape', 'id')->prepend(trans('global.pleaseSelect'), '');

        $eye_colors = EyeColor::pluck('color', 'id')->prepend(trans('global.pleaseSelect'), '');

        $skin_tones = SkinTone::pluck('tone', 'id')->prepend(trans('global.pleaseSelect'), '');

        $facial_expressions = FacialExpression::pluck('expression', 'id')->prepend(trans('global.pleaseSelect'), '');

        $emotions = Emotion::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dress_styles = DressStyle::pluck('style', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dress_colors = DressColor::pluck('color', 'id');

        $props = Prop::pluck('name', 'id');

        $postures = Posture::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $character_zooms = Zoom::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $character->load('scene', 'gender', 'age_group', 'body_type', 'hair_color', 'hair_lenght', 'hair_style', 'head_shape', 'nose_shape', 'mouth_shape', 'eye_shape', 'eye_color', 'skin_tone', 'facial_expression', 'emotion', 'dress_style', 'dress_colors', 'props', 'posture', 'character_zoom', 'user');

        return view('frontend.characters.edit', compact('age_groups', 'body_types', 'character', 'character_zooms', 'dress_colors', 'dress_styles', 'emotions', 'eye_colors', 'eye_shapes', 'facial_expressions', 'genders', 'hair_colors', 'hair_lenghts', 'hair_styles', 'head_shapes', 'mouth_shapes', 'nose_shapes', 'postures', 'props', 'scenes', 'skin_tones', 'users'));
    }

    public function update(UpdateCharacterRequest $request, Character $character)
    {
        $character->update($request->all());
        $character->dress_colors()->sync($request->input('dress_colors', []));
        $character->props()->sync($request->input('props', []));
        if ($request->input('avatar', false)) {
            if (! $character->avatar || $request->input('avatar') !== $character->avatar->file_name) {
                if ($character->avatar) {
                    $character->avatar->delete();
                }
                $character->addMedia(storage_path('tmp/uploads/' . basename($request->input('avatar'))))->toMediaCollection('avatar');
            }
        } elseif ($character->avatar) {
            $character->avatar->delete();
        }

        return redirect()->route('frontend.characters.index');
    }

    public function show(Character $character)
    {
        abort_if(Gate::denies('character_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $character->load('scene', 'gender', 'age_group', 'body_type', 'hair_color', 'hair_lenght', 'hair_style', 'head_shape', 'nose_shape', 'mouth_shape', 'eye_shape', 'eye_color', 'skin_tone', 'facial_expression', 'emotion', 'dress_style', 'dress_colors', 'props', 'posture', 'character_zoom', 'user');

        return view('frontend.characters.show', compact('character'));
    }

    public function destroy(Character $character)
    {
        abort_if(Gate::denies('character_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $character->delete();

        return back();
    }

    public function massDestroy(MassDestroyCharacterRequest $request)
    {
        $characters = Character::find(request('ids'));

        foreach ($characters as $character) {
            $character->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('character_create') && Gate::denies('character_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Character();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }


    
        //create an openai method to generate text with a given prompt
        public function refine(Request $request)
        { 
            $custom_prompt = $request->input('topic');    
            $prompt = "You are an advanced AI system specializing in converting simple, natural language descriptions into detailed, vivid prompts for generating high-quality 3D animated characters and scenes in the style of modern animation movies. Your outputs should provide enough detail for a DALL-E-like API to create visually stunning 3d animations reminiscent of Pixar or Disney styles. You are expected to: Enhance Simplicity with Detail: Transform basic inputs into richly detailed descriptions, specifying character features, clothing textures, emotional expressions, surrounding environments, lighting, and artistic style. Contextual Clarity: Ensure each prompt vividly captures the essence of the character\'s personality, mood, and environment while maintaining clarity and coherence.
Modern Animation Style: Always ensure the prompt reflects high-quality, modern animation styles with realistic lighting, textures, and dynamic elements. The character posing for a shot. The shot should be an eye-level shot ".$custom_prompt;
            $result = SendToOpenai::sendToOpenAI($prompt);
            return $result;
        }
    

        public function version(Request $request)
        {
            $character = Character::find($request->segment(3));
            $prompt = $character->custom_prompt;
            return view('frontend.characters.version', compact('character', 'prompt'));

        }


}
