<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('character_setting_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/backgrounds*") ? "c-show" : "" }} {{ request()->is("admin/age-groups*") ? "c-show" : "" }} {{ request()->is("admin/genders*") ? "c-show" : "" }} {{ request()->is("admin/body-types*") ? "c-show" : "" }} {{ request()->is("admin/head-shapes*") ? "c-show" : "" }} {{ request()->is("admin/hair-colors*") ? "c-show" : "" }} {{ request()->is("admin/hair-lengths*") ? "c-show" : "" }} {{ request()->is("admin/hair-styles*") ? "c-show" : "" }} {{ request()->is("admin/eye-colors*") ? "c-show" : "" }} {{ request()->is("admin/eye-shapes*") ? "c-show" : "" }} {{ request()->is("admin/nose-shapes*") ? "c-show" : "" }} {{ request()->is("admin/mouth-shapes*") ? "c-show" : "" }} {{ request()->is("admin/facial-expressions*") ? "c-show" : "" }} {{ request()->is("admin/emotions*") ? "c-show" : "" }} {{ request()->is("admin/skin-tones*") ? "c-show" : "" }} {{ request()->is("admin/dress-styles*") ? "c-show" : "" }} {{ request()->is("admin/props*") ? "c-show" : "" }} {{ request()->is("admin/postures*") ? "c-show" : "" }} {{ request()->is("admin/zooms*") ? "c-show" : "" }} {{ request()->is("admin/dress-colors*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-toolbox c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.characterSetting.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('background_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.backgrounds.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/backgrounds") || request()->is("admin/backgrounds/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.background.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('age_group_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.age-groups.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/age-groups") || request()->is("admin/age-groups/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.ageGroup.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('gender_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.genders.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/genders") || request()->is("admin/genders/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.gender.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('body_type_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.body-types.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/body-types") || request()->is("admin/body-types/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.bodyType.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('head_shape_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.head-shapes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/head-shapes") || request()->is("admin/head-shapes/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.headShape.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('hair_color_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.hair-colors.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/hair-colors") || request()->is("admin/hair-colors/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.hairColor.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('hair_length_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.hair-lengths.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/hair-lengths") || request()->is("admin/hair-lengths/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.hairLength.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('hair_style_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.hair-styles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/hair-styles") || request()->is("admin/hair-styles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.hairStyle.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('eye_color_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.eye-colors.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/eye-colors") || request()->is("admin/eye-colors/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.eyeColor.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('eye_shape_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.eye-shapes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/eye-shapes") || request()->is("admin/eye-shapes/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.eyeShape.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('nose_shape_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.nose-shapes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/nose-shapes") || request()->is("admin/nose-shapes/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.noseShape.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('mouth_shape_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.mouth-shapes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/mouth-shapes") || request()->is("admin/mouth-shapes/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.mouthShape.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('facial_expression_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.facial-expressions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/facial-expressions") || request()->is("admin/facial-expressions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.facialExpression.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('emotion_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.emotions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/emotions") || request()->is("admin/emotions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.emotion.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('skin_tone_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.skin-tones.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/skin-tones") || request()->is("admin/skin-tones/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.skinTone.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('dress_style_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.dress-styles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/dress-styles") || request()->is("admin/dress-styles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.dressStyle.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('prop_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.props.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/props") || request()->is("admin/props/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.prop.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('posture_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.postures.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/postures") || request()->is("admin/postures/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.posture.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('zoom_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.zooms.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/zooms") || request()->is("admin/zooms/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.zoom.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('dress_color_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.dress-colors.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/dress-colors") || request()->is("admin/dress-colors/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.dressColor.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('character_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.characters.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/characters") || request()->is("admin/characters/*") ? "c-active" : "" }}">
                    <i class="fa-fw far fa-user c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.character.title') }}
                </a>
            </li>
        @endcan
        @can('clip_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.clips.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/clips") || request()->is("admin/clips/*") ? "c-active" : "" }}">
                    <i class="fa-fw fab fa-youtube c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.clip.title') }}
                </a>
            </li>
        @endcan
        @can('credit_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.credits.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/credits") || request()->is("admin/credits/*") ? "c-active" : "" }}">
                    <i class="fa-fw far fa-star c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.credit.title') }}
                </a>
            </li>
        @endcan
        @can('payment_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.payments.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/payments") || request()->is("admin/payments/*") ? "c-active" : "" }}">
                    <i class="fa-fw far fa-credit-card c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.payment.title') }}
                </a>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>