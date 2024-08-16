<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'character_setting_access',
            ],
            [
                'id'    => 18,
                'title' => 'age_group_create',
            ],
            [
                'id'    => 19,
                'title' => 'age_group_edit',
            ],
            [
                'id'    => 20,
                'title' => 'age_group_show',
            ],
            [
                'id'    => 21,
                'title' => 'age_group_delete',
            ],
            [
                'id'    => 22,
                'title' => 'age_group_access',
            ],
            [
                'id'    => 23,
                'title' => 'gender_create',
            ],
            [
                'id'    => 24,
                'title' => 'gender_edit',
            ],
            [
                'id'    => 25,
                'title' => 'gender_show',
            ],
            [
                'id'    => 26,
                'title' => 'gender_delete',
            ],
            [
                'id'    => 27,
                'title' => 'gender_access',
            ],
            [
                'id'    => 28,
                'title' => 'body_type_create',
            ],
            [
                'id'    => 29,
                'title' => 'body_type_edit',
            ],
            [
                'id'    => 30,
                'title' => 'body_type_show',
            ],
            [
                'id'    => 31,
                'title' => 'body_type_delete',
            ],
            [
                'id'    => 32,
                'title' => 'body_type_access',
            ],
            [
                'id'    => 33,
                'title' => 'hair_color_create',
            ],
            [
                'id'    => 34,
                'title' => 'hair_color_edit',
            ],
            [
                'id'    => 35,
                'title' => 'hair_color_show',
            ],
            [
                'id'    => 36,
                'title' => 'hair_color_delete',
            ],
            [
                'id'    => 37,
                'title' => 'hair_color_access',
            ],
            [
                'id'    => 38,
                'title' => 'hair_length_create',
            ],
            [
                'id'    => 39,
                'title' => 'hair_length_edit',
            ],
            [
                'id'    => 40,
                'title' => 'hair_length_show',
            ],
            [
                'id'    => 41,
                'title' => 'hair_length_delete',
            ],
            [
                'id'    => 42,
                'title' => 'hair_length_access',
            ],
            [
                'id'    => 43,
                'title' => 'hair_style_create',
            ],
            [
                'id'    => 44,
                'title' => 'hair_style_edit',
            ],
            [
                'id'    => 45,
                'title' => 'hair_style_show',
            ],
            [
                'id'    => 46,
                'title' => 'hair_style_delete',
            ],
            [
                'id'    => 47,
                'title' => 'hair_style_access',
            ],
            [
                'id'    => 48,
                'title' => 'eye_color_create',
            ],
            [
                'id'    => 49,
                'title' => 'eye_color_edit',
            ],
            [
                'id'    => 50,
                'title' => 'eye_color_show',
            ],
            [
                'id'    => 51,
                'title' => 'eye_color_delete',
            ],
            [
                'id'    => 52,
                'title' => 'eye_color_access',
            ],
            [
                'id'    => 53,
                'title' => 'eye_shape_create',
            ],
            [
                'id'    => 54,
                'title' => 'eye_shape_edit',
            ],
            [
                'id'    => 55,
                'title' => 'eye_shape_show',
            ],
            [
                'id'    => 56,
                'title' => 'eye_shape_delete',
            ],
            [
                'id'    => 57,
                'title' => 'eye_shape_access',
            ],
            [
                'id'    => 58,
                'title' => 'skin_tone_create',
            ],
            [
                'id'    => 59,
                'title' => 'skin_tone_edit',
            ],
            [
                'id'    => 60,
                'title' => 'skin_tone_show',
            ],
            [
                'id'    => 61,
                'title' => 'skin_tone_delete',
            ],
            [
                'id'    => 62,
                'title' => 'skin_tone_access',
            ],
            [
                'id'    => 63,
                'title' => 'facial_expression_create',
            ],
            [
                'id'    => 64,
                'title' => 'facial_expression_edit',
            ],
            [
                'id'    => 65,
                'title' => 'facial_expression_show',
            ],
            [
                'id'    => 66,
                'title' => 'facial_expression_delete',
            ],
            [
                'id'    => 67,
                'title' => 'facial_expression_access',
            ],
            [
                'id'    => 68,
                'title' => 'dress_style_create',
            ],
            [
                'id'    => 69,
                'title' => 'dress_style_edit',
            ],
            [
                'id'    => 70,
                'title' => 'dress_style_show',
            ],
            [
                'id'    => 71,
                'title' => 'dress_style_delete',
            ],
            [
                'id'    => 72,
                'title' => 'dress_style_access',
            ],
            [
                'id'    => 73,
                'title' => 'background_create',
            ],
            [
                'id'    => 74,
                'title' => 'background_edit',
            ],
            [
                'id'    => 75,
                'title' => 'background_show',
            ],
            [
                'id'    => 76,
                'title' => 'background_delete',
            ],
            [
                'id'    => 77,
                'title' => 'background_access',
            ],
            [
                'id'    => 78,
                'title' => 'emotion_create',
            ],
            [
                'id'    => 79,
                'title' => 'emotion_edit',
            ],
            [
                'id'    => 80,
                'title' => 'emotion_show',
            ],
            [
                'id'    => 81,
                'title' => 'emotion_delete',
            ],
            [
                'id'    => 82,
                'title' => 'emotion_access',
            ],
            [
                'id'    => 83,
                'title' => 'prop_create',
            ],
            [
                'id'    => 84,
                'title' => 'prop_edit',
            ],
            [
                'id'    => 85,
                'title' => 'prop_show',
            ],
            [
                'id'    => 86,
                'title' => 'prop_delete',
            ],
            [
                'id'    => 87,
                'title' => 'prop_access',
            ],
            [
                'id'    => 88,
                'title' => 'character_create',
            ],
            [
                'id'    => 89,
                'title' => 'character_edit',
            ],
            [
                'id'    => 90,
                'title' => 'character_show',
            ],
            [
                'id'    => 91,
                'title' => 'character_delete',
            ],
            [
                'id'    => 92,
                'title' => 'character_access',
            ],
            [
                'id'    => 93,
                'title' => 'payment_create',
            ],
            [
                'id'    => 94,
                'title' => 'payment_edit',
            ],
            [
                'id'    => 95,
                'title' => 'payment_show',
            ],
            [
                'id'    => 96,
                'title' => 'payment_delete',
            ],
            [
                'id'    => 97,
                'title' => 'payment_access',
            ],
            [
                'id'    => 98,
                'title' => 'credit_create',
            ],
            [
                'id'    => 99,
                'title' => 'credit_edit',
            ],
            [
                'id'    => 100,
                'title' => 'credit_show',
            ],
            [
                'id'    => 101,
                'title' => 'credit_delete',
            ],
            [
                'id'    => 102,
                'title' => 'credit_access',
            ],
            [
                'id'    => 103,
                'title' => 'clip_create',
            ],
            [
                'id'    => 104,
                'title' => 'clip_edit',
            ],
            [
                'id'    => 105,
                'title' => 'clip_show',
            ],
            [
                'id'    => 106,
                'title' => 'clip_delete',
            ],
            [
                'id'    => 107,
                'title' => 'clip_access',
            ],
            [
                'id'    => 108,
                'title' => 'head_shape_create',
            ],
            [
                'id'    => 109,
                'title' => 'head_shape_edit',
            ],
            [
                'id'    => 110,
                'title' => 'head_shape_show',
            ],
            [
                'id'    => 111,
                'title' => 'head_shape_delete',
            ],
            [
                'id'    => 112,
                'title' => 'head_shape_access',
            ],
            [
                'id'    => 113,
                'title' => 'nose_shape_create',
            ],
            [
                'id'    => 114,
                'title' => 'nose_shape_edit',
            ],
            [
                'id'    => 115,
                'title' => 'nose_shape_show',
            ],
            [
                'id'    => 116,
                'title' => 'nose_shape_delete',
            ],
            [
                'id'    => 117,
                'title' => 'nose_shape_access',
            ],
            [
                'id'    => 118,
                'title' => 'mouth_shape_create',
            ],
            [
                'id'    => 119,
                'title' => 'mouth_shape_edit',
            ],
            [
                'id'    => 120,
                'title' => 'mouth_shape_show',
            ],
            [
                'id'    => 121,
                'title' => 'mouth_shape_delete',
            ],
            [
                'id'    => 122,
                'title' => 'mouth_shape_access',
            ],
            [
                'id'    => 123,
                'title' => 'posture_create',
            ],
            [
                'id'    => 124,
                'title' => 'posture_edit',
            ],
            [
                'id'    => 125,
                'title' => 'posture_show',
            ],
            [
                'id'    => 126,
                'title' => 'posture_delete',
            ],
            [
                'id'    => 127,
                'title' => 'posture_access',
            ],
            [
                'id'    => 128,
                'title' => 'zoom_create',
            ],
            [
                'id'    => 129,
                'title' => 'zoom_edit',
            ],
            [
                'id'    => 130,
                'title' => 'zoom_show',
            ],
            [
                'id'    => 131,
                'title' => 'zoom_delete',
            ],
            [
                'id'    => 132,
                'title' => 'zoom_access',
            ],
            [
                'id'    => 133,
                'title' => 'dress_color_create',
            ],
            [
                'id'    => 134,
                'title' => 'dress_color_edit',
            ],
            [
                'id'    => 135,
                'title' => 'dress_color_show',
            ],
            [
                'id'    => 136,
                'title' => 'dress_color_delete',
            ],
            [
                'id'    => 137,
                'title' => 'dress_color_access',
            ],
            [
                'id'    => 138,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
