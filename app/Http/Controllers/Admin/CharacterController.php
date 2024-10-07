<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCharacterRequest;
use App\Http\Requests\StoreCharacterRequest;
use App\Http\Requests\UpdateCharacterRequest;
use App\Models\AgeGroup;
use App\Models\Background;
use App\Models\BodyType;
use App\Models\Character;
use App\Models\DressColor;
use App\Models\DressStyle;
use App\Models\Emotion;
use App\Models\EyeColor;
use App\Models\EyeShape;
use App\Models\FacialExpression;
use App\Models\Gender;
use App\Models\HairColor;
use App\Models\HairLength;
use App\Models\HairStyle;
use App\Models\HeadShape;
use App\Models\MouthShape;
use App\Models\NoseShape;
use App\Models\Posture;
use App\Models\Prop;
use App\Models\SkinTone;
use App\Models\User;
use App\Models\Zoom;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CharacterController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('character_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $characters = Character::with(['scene', 'gender', 'age_group', 'body_type', 'hair_color', 'hair_lenght', 'hair_style', 'head_shape', 'nose_shape', 'mouth_shape', 'eye_shape', 'eye_color', 'skin_tone', 'facial_expression', 'emotion', 'dress_style', 'dress_colors', 'props', 'posture', 'character_zoom', 'user', 'media'])->orderby('id', 'desc')->get();

        return view('admin.characters.index', compact('characters'));
    }

    public function create()
    {
        abort_if(Gate::denies('character_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

        return view('admin.characters.create', compact('age_groups', 'body_types', 'character_zooms', 'dress_colors', 'dress_styles', 'emotions', 'eye_colors', 'eye_shapes', 'facial_expressions', 'genders', 'hair_colors', 'hair_lenghts', 'hair_styles', 'head_shapes', 'mouth_shapes', 'nose_shapes', 'postures', 'props', 'scenes', 'skin_tones', 'users'));
    }

    public function store(StoreCharacterRequest $request)
    {
        $character = Character::create($request->all());
        $character->dress_colors()->sync($request->input('dress_colors', []));
        $character->props()->sync($request->input('props', []));
        if ($request->input('avatar', false)) {
            $character->addMedia(storage_path('tmp/uploads/' . basename($request->input('avatar'))))->toMediaCollection('avatar', 's3', 'images');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $character->id]);
        }

        return redirect()->route('admin.characters.index');
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

        return view('admin.characters.edit', compact('age_groups', 'body_types', 'character', 'character_zooms', 'dress_colors', 'dress_styles', 'emotions', 'eye_colors', 'eye_shapes', 'facial_expressions', 'genders', 'hair_colors', 'hair_lenghts', 'hair_styles', 'head_shapes', 'mouth_shapes', 'nose_shapes', 'postures', 'props', 'scenes', 'skin_tones', 'users'));
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

        return redirect()->route('admin.characters.index');
    }

    public function show(Character $character)
    {
        abort_if(Gate::denies('character_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $character->load('scene', 'gender', 'age_group', 'body_type', 'hair_color', 'hair_lenght', 'hair_style', 'head_shape', 'nose_shape', 'mouth_shape', 'eye_shape', 'eye_color', 'skin_tone', 'facial_expression', 'emotion', 'dress_style', 'dress_colors', 'props', 'posture', 'character_zoom', 'user');

        return view('admin.characters.show', compact('character'));
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
}
