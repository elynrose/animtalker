<?php
Route::get('run-video', function () {
   return Artisan::call('app:get-video');
});
Route::get('optimize-clear', function () {
    Artisan::call('optimize:clear');
});
Route::get('storage-link', function () {
    Artisan::call('storage:link');
});
Route::get('composer-update', function () {
    shell_exec('composer update');
});
Route::get('key-generate', function () {
    shell_exec('key:generate');
});

Route::view('/', 'welcome');
Route::post('/getVideoStatus', 'VideoWebHookController@getVideoStatus')->name('videoStatus');
Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', '2fa', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Age Group
    Route::delete('age-groups/destroy', 'AgeGroupController@massDestroy')->name('age-groups.massDestroy');
    Route::post('age-groups/media', 'AgeGroupController@storeMedia')->name('age-groups.storeMedia');
    Route::post('age-groups/ckmedia', 'AgeGroupController@storeCKEditorImages')->name('age-groups.storeCKEditorImages');
    Route::resource('age-groups', 'AgeGroupController');

    // Gender
    Route::delete('genders/destroy', 'GenderController@massDestroy')->name('genders.massDestroy');
    Route::post('genders/media', 'GenderController@storeMedia')->name('genders.storeMedia');
    Route::post('genders/ckmedia', 'GenderController@storeCKEditorImages')->name('genders.storeCKEditorImages');
    Route::resource('genders', 'GenderController');

    // Body Type
    Route::delete('body-types/destroy', 'BodyTypeController@massDestroy')->name('body-types.massDestroy');
    Route::post('body-types/media', 'BodyTypeController@storeMedia')->name('body-types.storeMedia');
    Route::post('body-types/ckmedia', 'BodyTypeController@storeCKEditorImages')->name('body-types.storeCKEditorImages');
    Route::resource('body-types', 'BodyTypeController');

    // Hair Color
    Route::delete('hair-colors/destroy', 'HairColorController@massDestroy')->name('hair-colors.massDestroy');
    Route::post('hair-colors/media', 'HairColorController@storeMedia')->name('hair-colors.storeMedia');
    Route::post('hair-colors/ckmedia', 'HairColorController@storeCKEditorImages')->name('hair-colors.storeCKEditorImages');
    Route::resource('hair-colors', 'HairColorController');

    // Hair Length
    Route::delete('hair-lengths/destroy', 'HairLengthController@massDestroy')->name('hair-lengths.massDestroy');
    Route::post('hair-lengths/media', 'HairLengthController@storeMedia')->name('hair-lengths.storeMedia');
    Route::post('hair-lengths/ckmedia', 'HairLengthController@storeCKEditorImages')->name('hair-lengths.storeCKEditorImages');
    Route::resource('hair-lengths', 'HairLengthController');

    // Hair Style
    Route::delete('hair-styles/destroy', 'HairStyleController@massDestroy')->name('hair-styles.massDestroy');
    Route::post('hair-styles/media', 'HairStyleController@storeMedia')->name('hair-styles.storeMedia');
    Route::post('hair-styles/ckmedia', 'HairStyleController@storeCKEditorImages')->name('hair-styles.storeCKEditorImages');
    Route::resource('hair-styles', 'HairStyleController');

    // Eye Color
    Route::delete('eye-colors/destroy', 'EyeColorController@massDestroy')->name('eye-colors.massDestroy');
    Route::post('eye-colors/media', 'EyeColorController@storeMedia')->name('eye-colors.storeMedia');
    Route::post('eye-colors/ckmedia', 'EyeColorController@storeCKEditorImages')->name('eye-colors.storeCKEditorImages');
    Route::resource('eye-colors', 'EyeColorController');

    // Eye Shape
    Route::delete('eye-shapes/destroy', 'EyeShapeController@massDestroy')->name('eye-shapes.massDestroy');
    Route::post('eye-shapes/media', 'EyeShapeController@storeMedia')->name('eye-shapes.storeMedia');
    Route::post('eye-shapes/ckmedia', 'EyeShapeController@storeCKEditorImages')->name('eye-shapes.storeCKEditorImages');
    Route::resource('eye-shapes', 'EyeShapeController');

    // Skin Tone
    Route::delete('skin-tones/destroy', 'SkinToneController@massDestroy')->name('skin-tones.massDestroy');
    Route::post('skin-tones/media', 'SkinToneController@storeMedia')->name('skin-tones.storeMedia');
    Route::post('skin-tones/ckmedia', 'SkinToneController@storeCKEditorImages')->name('skin-tones.storeCKEditorImages');
    Route::resource('skin-tones', 'SkinToneController');

    // Facial Expression
    Route::delete('facial-expressions/destroy', 'FacialExpressionController@massDestroy')->name('facial-expressions.massDestroy');
    Route::post('facial-expressions/media', 'FacialExpressionController@storeMedia')->name('facial-expressions.storeMedia');
    Route::post('facial-expressions/ckmedia', 'FacialExpressionController@storeCKEditorImages')->name('facial-expressions.storeCKEditorImages');
    Route::resource('facial-expressions', 'FacialExpressionController');

    // Dress Style
    Route::delete('dress-styles/destroy', 'DressStyleController@massDestroy')->name('dress-styles.massDestroy');
    Route::post('dress-styles/media', 'DressStyleController@storeMedia')->name('dress-styles.storeMedia');
    Route::post('dress-styles/ckmedia', 'DressStyleController@storeCKEditorImages')->name('dress-styles.storeCKEditorImages');
    Route::resource('dress-styles', 'DressStyleController');

    // Background
    Route::delete('backgrounds/destroy', 'BackgroundController@massDestroy')->name('backgrounds.massDestroy');
    Route::post('backgrounds/media', 'BackgroundController@storeMedia')->name('backgrounds.storeMedia');
    Route::post('backgrounds/ckmedia', 'BackgroundController@storeCKEditorImages')->name('backgrounds.storeCKEditorImages');
    Route::resource('backgrounds', 'BackgroundController');

    // Emotion
    Route::delete('emotions/destroy', 'EmotionController@massDestroy')->name('emotions.massDestroy');
    Route::post('emotions/media', 'EmotionController@storeMedia')->name('emotions.storeMedia');
    Route::post('emotions/ckmedia', 'EmotionController@storeCKEditorImages')->name('emotions.storeCKEditorImages');
    Route::resource('emotions', 'EmotionController');

    // Props
    Route::delete('props/destroy', 'PropsController@massDestroy')->name('props.massDestroy');
    Route::resource('props', 'PropsController');

    // Character
    Route::delete('characters/destroy', 'CharacterController@massDestroy')->name('characters.massDestroy');
    Route::post('characters/media', 'CharacterController@storeMedia')->name('characters.storeMedia');
    Route::post('characters/ckmedia', 'CharacterController@storeCKEditorImages')->name('characters.storeCKEditorImages');
    Route::resource('characters', 'CharacterController');

    // Payments
    Route::delete('payments/destroy', 'PaymentsController@massDestroy')->name('payments.massDestroy');
    Route::resource('payments', 'PaymentsController');

    // Credits
    Route::delete('credits/destroy', 'CreditsController@massDestroy')->name('credits.massDestroy');
    Route::resource('credits', 'CreditsController');

    // Clips
    Route::delete('clips/destroy', 'ClipsController@massDestroy')->name('clips.massDestroy');
    Route::post('clips/media', 'ClipsController@storeMedia')->name('clips.storeMedia');
    Route::post('clips/ckmedia', 'ClipsController@storeCKEditorImages')->name('clips.storeCKEditorImages');
    Route::resource('clips', 'ClipsController');


    // Head Shape
    Route::delete('head-shapes/destroy', 'HeadShapeController@massDestroy')->name('head-shapes.massDestroy');
    Route::resource('head-shapes', 'HeadShapeController');

    // Nose Shape
    Route::delete('nose-shapes/destroy', 'NoseShapeController@massDestroy')->name('nose-shapes.massDestroy');
    Route::resource('nose-shapes', 'NoseShapeController');

    // Mouth Shape
    Route::delete('mouth-shapes/destroy', 'MouthShapeController@massDestroy')->name('mouth-shapes.massDestroy');
    Route::resource('mouth-shapes', 'MouthShapeController');

    // Posture
    Route::delete('postures/destroy', 'PostureController@massDestroy')->name('postures.massDestroy');
    Route::resource('postures', 'PostureController');

    // Zoom
    Route::delete('zooms/destroy', 'ZoomController@massDestroy')->name('zooms.massDestroy');
    Route::resource('zooms', 'ZoomController');

    // Dress Color
    Route::delete('dress-colors/destroy', 'DressColorController@massDestroy')->name('dress-colors.massDestroy');
    Route::resource('dress-colors', 'DressColorController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
        Route::post('profile/two-factor', 'ChangePasswordController@toggleTwoFactor')->name('password.toggleTwoFactor');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth', '2fa']], function () {
    Route::get('/home', 'HomeController@index')->name('home');


    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Age Group
    Route::delete('age-groups/destroy', 'AgeGroupController@massDestroy')->name('age-groups.massDestroy');
    Route::post('age-groups/media', 'AgeGroupController@storeMedia')->name('age-groups.storeMedia');
    Route::post('age-groups/ckmedia', 'AgeGroupController@storeCKEditorImages')->name('age-groups.storeCKEditorImages');
    Route::resource('age-groups', 'AgeGroupController');

    // Gender
    Route::delete('genders/destroy', 'GenderController@massDestroy')->name('genders.massDestroy');
    Route::post('genders/media', 'GenderController@storeMedia')->name('genders.storeMedia');
    Route::post('genders/ckmedia', 'GenderController@storeCKEditorImages')->name('genders.storeCKEditorImages');
    Route::resource('genders', 'GenderController');

    // Body Type
    Route::delete('body-types/destroy', 'BodyTypeController@massDestroy')->name('body-types.massDestroy');
    Route::post('body-types/media', 'BodyTypeController@storeMedia')->name('body-types.storeMedia');
    Route::post('body-types/ckmedia', 'BodyTypeController@storeCKEditorImages')->name('body-types.storeCKEditorImages');
    Route::resource('body-types', 'BodyTypeController');

    // Hair Color
    Route::delete('hair-colors/destroy', 'HairColorController@massDestroy')->name('hair-colors.massDestroy');
    Route::post('hair-colors/media', 'HairColorController@storeMedia')->name('hair-colors.storeMedia');
    Route::post('hair-colors/ckmedia', 'HairColorController@storeCKEditorImages')->name('hair-colors.storeCKEditorImages');
    Route::resource('hair-colors', 'HairColorController');

    // Hair Length
    Route::delete('hair-lengths/destroy', 'HairLengthController@massDestroy')->name('hair-lengths.massDestroy');
    Route::post('hair-lengths/media', 'HairLengthController@storeMedia')->name('hair-lengths.storeMedia');
    Route::post('hair-lengths/ckmedia', 'HairLengthController@storeCKEditorImages')->name('hair-lengths.storeCKEditorImages');
    Route::resource('hair-lengths', 'HairLengthController');

    // Hair Style
    Route::delete('hair-styles/destroy', 'HairStyleController@massDestroy')->name('hair-styles.massDestroy');
    Route::post('hair-styles/media', 'HairStyleController@storeMedia')->name('hair-styles.storeMedia');
    Route::post('hair-styles/ckmedia', 'HairStyleController@storeCKEditorImages')->name('hair-styles.storeCKEditorImages');
    Route::resource('hair-styles', 'HairStyleController');

    // Eye Color
    Route::delete('eye-colors/destroy', 'EyeColorController@massDestroy')->name('eye-colors.massDestroy');
    Route::post('eye-colors/media', 'EyeColorController@storeMedia')->name('eye-colors.storeMedia');
    Route::post('eye-colors/ckmedia', 'EyeColorController@storeCKEditorImages')->name('eye-colors.storeCKEditorImages');
    Route::resource('eye-colors', 'EyeColorController');

    // Eye Shape
    Route::delete('eye-shapes/destroy', 'EyeShapeController@massDestroy')->name('eye-shapes.massDestroy');
    Route::post('eye-shapes/media', 'EyeShapeController@storeMedia')->name('eye-shapes.storeMedia');
    Route::post('eye-shapes/ckmedia', 'EyeShapeController@storeCKEditorImages')->name('eye-shapes.storeCKEditorImages');
    Route::resource('eye-shapes', 'EyeShapeController');

    // Skin Tone
    Route::delete('skin-tones/destroy', 'SkinToneController@massDestroy')->name('skin-tones.massDestroy');
    Route::post('skin-tones/media', 'SkinToneController@storeMedia')->name('skin-tones.storeMedia');
    Route::post('skin-tones/ckmedia', 'SkinToneController@storeCKEditorImages')->name('skin-tones.storeCKEditorImages');
    Route::resource('skin-tones', 'SkinToneController');

    // Facial Expression
    Route::delete('facial-expressions/destroy', 'FacialExpressionController@massDestroy')->name('facial-expressions.massDestroy');
    Route::post('facial-expressions/media', 'FacialExpressionController@storeMedia')->name('facial-expressions.storeMedia');
    Route::post('facial-expressions/ckmedia', 'FacialExpressionController@storeCKEditorImages')->name('facial-expressions.storeCKEditorImages');
    Route::resource('facial-expressions', 'FacialExpressionController');

    // Dress Style
    Route::delete('dress-styles/destroy', 'DressStyleController@massDestroy')->name('dress-styles.massDestroy');
    Route::post('dress-styles/media', 'DressStyleController@storeMedia')->name('dress-styles.storeMedia');
    Route::post('dress-styles/ckmedia', 'DressStyleController@storeCKEditorImages')->name('dress-styles.storeCKEditorImages');
    Route::resource('dress-styles', 'DressStyleController');

    // Background
    Route::delete('backgrounds/destroy', 'BackgroundController@massDestroy')->name('backgrounds.massDestroy');
    Route::post('backgrounds/media', 'BackgroundController@storeMedia')->name('backgrounds.storeMedia');
    Route::post('backgrounds/ckmedia', 'BackgroundController@storeCKEditorImages')->name('backgrounds.storeCKEditorImages');
    Route::resource('backgrounds', 'BackgroundController');

    // Emotion
    Route::delete('emotions/destroy', 'EmotionController@massDestroy')->name('emotions.massDestroy');
    Route::post('emotions/media', 'EmotionController@storeMedia')->name('emotions.storeMedia');
    Route::post('emotions/ckmedia', 'EmotionController@storeCKEditorImages')->name('emotions.storeCKEditorImages');
    Route::resource('emotions', 'EmotionController');

    // Props
    Route::delete('props/destroy', 'PropsController@massDestroy')->name('props.massDestroy');
    Route::resource('props', 'PropsController');

    // Character
    Route::delete('characters/destroy', 'CharacterController@massDestroy')->name('characters.massDestroy');
    Route::post('characters/media', 'CharacterController@storeMedia')->name('characters.storeMedia');
    Route::post('characters/ckmedia', 'CharacterController@storeCKEditorImages')->name('characters.storeCKEditorImages');
    Route::resource('characters', 'CharacterController');

    // Payments
    Route::delete('payments/destroy', 'PaymentsController@massDestroy')->name('payments.massDestroy');
    Route::resource('payments', 'PaymentsController');

    // Credits
    Route::delete('credits/destroy', 'CreditsController@massDestroy')->name('credits.massDestroy');
    Route::resource('credits', 'CreditsController');

    // Clips
    Route::delete('clips/destroy', 'ClipsController@massDestroy')->name('clips.massDestroy');
    Route::post('clips/media', 'ClipsController@storeMedia')->name('clips.storeMedia');
    Route::post('clips/ckmedia', 'ClipsController@storeCKEditorImages')->name('clips.storeCKEditorImages');
    Route::resource('clips', 'ClipsController');
    Route::get('clips/webhook', 'ClipsController@webhook')->name('clips.webhook');
    Route::get('clips/{id}/create', 'ClipsController@create')->name('myclips.create');


    // Head Shape
    Route::delete('head-shapes/destroy', 'HeadShapeController@massDestroy')->name('head-shapes.massDestroy');
    Route::resource('head-shapes', 'HeadShapeController');

    // Nose Shape
    Route::delete('nose-shapes/destroy', 'NoseShapeController@massDestroy')->name('nose-shapes.massDestroy');
    Route::resource('nose-shapes', 'NoseShapeController');

    // Mouth Shape
    Route::delete('mouth-shapes/destroy', 'MouthShapeController@massDestroy')->name('mouth-shapes.massDestroy');
    Route::resource('mouth-shapes', 'MouthShapeController');

    // Posture
    Route::delete('postures/destroy', 'PostureController@massDestroy')->name('postures.massDestroy');
    Route::resource('postures', 'PostureController');

    // Zoom
    Route::delete('zooms/destroy', 'ZoomController@massDestroy')->name('zooms.massDestroy');
    Route::resource('zooms', 'ZoomController');

    // Dress Color
    Route::delete('dress-colors/destroy', 'DressColorController@massDestroy')->name('dress-colors.massDestroy');
    Route::resource('dress-colors', 'DressColorController');

    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
    Route::post('profile/toggle-two-factor', 'ProfileController@toggleTwoFactor')->name('profile.toggle-two-factor');
});
Route::group(['namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Two Factor Authentication
    if (file_exists(app_path('Http/Controllers/Auth/TwoFactorController.php'))) {
        Route::get('two-factor', 'TwoFactorController@show')->name('twoFactor.show');
        Route::post('two-factor', 'TwoFactorController@check')->name('twoFactor.check');
        Route::get('two-factor/resend', 'TwoFactorController@resend')->name('twoFactor.resend');
    }
});
