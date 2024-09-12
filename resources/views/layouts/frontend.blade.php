<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    @yield('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.home') }}">
                                    {{ __('Home') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.characters.index') }}">
                                    {{ __('Characters') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.clips.index') }}">
                                    {{ __('Clips') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.pricing') }}">
                                    {{ __('Pricing') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('frontend.credits.index') }}">
                                    @php
                                  $credit = App\Models\Credit::where('email', Auth::user()->email)->sum('points')
                                    @endphp
                                    {{ __('Credits') }} <span>(@if($credit <=0 ){{'0'}}@else{{ $credit ??  0 }}@endif)</span>
                                </a>
                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if(Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{ route('frontend.profile.index') }}">{{ __('My profile') }}</a>

                                    @can('user_management_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('cruds.userManagement.title') }}
                                        </a>
                                    @endcan
                                    @can('permission_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.permissions.index') }}">
                                            {{ trans('cruds.permission.title') }}
                                        </a>
                                    @endcan
                                    @can('role_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.roles.index') }}">
                                            {{ trans('cruds.role.title') }}
                                        </a>
                                    @endcan
                                    @can('user_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.users.index') }}">
                                            {{ trans('cruds.user.title') }}
                                        </a>
                                    @endcan
                                    @can('character_setting_access')
                                        <a class="dropdown-item disabled" href="#">
                                            {{ trans('cruds.characterSetting.title') }}
                                        </a>
                                    @endcan
                                    @can('background_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.backgrounds.index') }}">
                                            {{ trans('cruds.background.title') }}
                                        </a>
                                    @endcan
                                    @can('age_group_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.age-groups.index') }}">
                                            {{ trans('cruds.ageGroup.title') }}
                                        </a>
                                    @endcan
                                    @can('gender_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.genders.index') }}">
                                            {{ trans('cruds.gender.title') }}
                                        </a>
                                    @endcan
                                    @can('body_type_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.body-types.index') }}">
                                            {{ trans('cruds.bodyType.title') }}
                                        </a>
                                    @endcan
                                    @can('head_shape_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.head-shapes.index') }}">
                                            {{ trans('cruds.headShape.title') }}
                                        </a>
                                    @endcan
                                    @can('hair_color_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.hair-colors.index') }}">
                                            {{ trans('cruds.hairColor.title') }}
                                        </a>
                                    @endcan
                                    @can('hair_length_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.hair-lengths.index') }}">
                                            {{ trans('cruds.hairLength.title') }}
                                        </a>
                                    @endcan
                                    @can('hair_style_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.hair-styles.index') }}">
                                            {{ trans('cruds.hairStyle.title') }}
                                        </a>
                                    @endcan
                                    @can('eye_color_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.eye-colors.index') }}">
                                            {{ trans('cruds.eyeColor.title') }}
                                        </a>
                                    @endcan
                                    @can('eye_shape_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.eye-shapes.index') }}">
                                            {{ trans('cruds.eyeShape.title') }}
                                        </a>
                                    @endcan
                                    @can('nose_shape_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.nose-shapes.index') }}">
                                            {{ trans('cruds.noseShape.title') }}
                                        </a>
                                    @endcan
                                    @can('mouth_shape_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.mouth-shapes.index') }}">
                                            {{ trans('cruds.mouthShape.title') }}
                                        </a>
                                    @endcan
                                    @can('facial_expression_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.facial-expressions.index') }}">
                                            {{ trans('cruds.facialExpression.title') }}
                                        </a>
                                    @endcan
                                    @can('emotion_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.emotions.index') }}">
                                            {{ trans('cruds.emotion.title') }}
                                        </a>
                                    @endcan
                                    @can('skin_tone_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.skin-tones.index') }}">
                                            {{ trans('cruds.skinTone.title') }}
                                        </a>
                                    @endcan
                                    @can('dress_style_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.dress-styles.index') }}">
                                            {{ trans('cruds.dressStyle.title') }}
                                        </a>
                                    @endcan
                                    @can('prop_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.props.index') }}">
                                            {{ trans('cruds.prop.title') }}
                                        </a>
                                    @endcan
                                    @can('posture_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.postures.index') }}">
                                            {{ trans('cruds.posture.title') }}
                                        </a>
                                    @endcan
                                    @can('zoom_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.zooms.index') }}">
                                            {{ trans('cruds.zoom.title') }}
                                        </a>
                                    @endcan
                                    @can('dress_color_access')
                                        <a class="dropdown-item ml-3" href="{{ route('frontend.dress-colors.index') }}">
                                            {{ trans('cruds.dressColor.title') }}
                                        </a>
                                    @endcan
                                    @can('character_access')
                                        <a class="dropdown-item" href="{{ route('frontend.characters.index') }}">
                                            {{ trans('cruds.character.title') }}
                                        </a>
                                    @endcan
                                    @can('clip_access')
                                        <a class="dropdown-item" href="{{ route('frontend.clips.index') }}">
                                            {{ trans('cruds.clip.title') }}
                                        </a>
                                    @endcan
                                    @can('credit_access')
                                        <a class="dropdown-item" href="{{ route('frontend.credits.index') }}">
                                            {{ trans('cruds.credit.title') }}
                                        </a>
                                    @endcan
                                    @can('payment_access')
                                        <a class="dropdown-item" href="{{ route('frontend.payments.index') }}">
                                            {{ trans('cruds.payment.title') }}
                                        </a>
                                    @endcan

                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if(session('message'))
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        </div>
                    </div>
                </div>
            @endif
            @if($errors->count() > 0)
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                <ul class="list-unstyled mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
@yield('scripts')

</html>