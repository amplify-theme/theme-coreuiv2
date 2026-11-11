@extends(backpack_view('blank'))

@section('after_styles')
    <style media="screen">
        .backpack-profile-form .required::after {
            content: ' *';
            color: red;
        }
    </style>
@endsection

@php
  $breadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      trans('backpack::base.my_account') => false,
  ];
@endphp

@section('header')
    <section class="content-header animated fadeIn">
        <div class="container-fluid mb-3">
            <h1 class="text-capitalize mb-0" bp-section="page-heading">
                <span>{{ trans('backpack::base.my_account') }}</span>
                <small>Manage account information</small>
            </h1>
        </div>
    </section>
@endsection

@section('content')
    <div class="row">

        @if (session('success'))
        <div class="col-lg-12">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if ($errors->count())
        <div class="col-lg-12">
            <div class="alert alert-danger">
                <ul class="mb-1">
                    @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- UPDATE INFO FORM --}}
        <div class="col-lg-12">
            <form class="form" action="{{ route('backpack.account.info.store') }}"
                  method="post" enctype="multipart/form-data">

                {!! csrf_field() !!}

                <div class="card padding-10">

                    <div class="card-header">
                        {{ trans('backpack::base.update_account_info') }}
                    </div>

                    <div class="card-body backpack-profile-form bold-labels">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                @php
                                    $label = trans('backpack::base.name');
                                    $field = 'name';
                                @endphp
                                <label class="required" for="{{ $field }}">{{ $label }}</label>
                                <input required class="form-control"  id="{{ $field }}" type="text" name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
                            </div>
                            <div class="col-md-6 form-group">
                                @php
                                    $label = config('backpack.base.authentication_column_name');
                                    $field = backpack_authentication_column();
                                @endphp
                                <label class="required" for="{{ $field }}">{{ $label }}</label>
                                <input required class="form-control" id="{{ $field }}"
                                       type="{{ backpack_authentication_column()==backpack_email_column()?'email':'text' }}"
                                       name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
                            </div>
                            <div class="col-md-6 form-group">
                                @php
                                    $label = "Image";
                                    $field = 'image';
                                @endphp
                                <label>{{ $label }}</label>
                                <div class="custom-file">
                                    <input type="file" id="{{ $field }}" name="{{ $field }}"
                                           accept="image/jpeg,image/png,image/gif,image/webp"
                                           class="form-control custom-file-input">
                                    <label class="custom-file-label" for="{{ $field }}">Choose File ...</label>
                                    <span class="invalid-feedback d-block" id="{{ $field }}-error" style="display:none;"></span>
                                    <input type="hidden" name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-2 text-center">
                                    <img src="{{ backpack_avatar_url(backpack_auth()->user()) }}"
                                         alt="{{ backpack_auth()->user()->name }}"
                                         id="image-preview"
                                         height="100" width="100"
                                         style="border-radius:50px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>{{ trans('backpack::base.current_password') }}</label>
                                <input class="form-control" type="password" name="current_password" autocomplete="current-password" value="">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="la la-save"></i> {{ trans('backpack::base.save') }}</button>
                        <a href="{{ backpack_url() }}" class="btn">{{ trans('backpack::base.cancel') }}</a>
                    </div>
                </div>

            </form>
        </div>

        {{-- CHANGE PASSWORD FORM --}}
        <div class="col-lg-12">
            <form class="form" action="{{ route('backpack.account.password') }}" method="post">

                {!! csrf_field() !!}

                <div class="card padding-10">

                    <div class="card-header">
                        {{ trans('backpack::base.change_password') }}
                    </div>

                    <div class="card-body backpack-profile-form bold-labels">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                @php
                                    $label = trans('backpack::base.old_password');
                                    $field = 'old_password';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                            </div>

                            <div class="col-md-4 form-group">
                                @php
                                    $label = trans('backpack::base.new_password');
                                    $field = 'new_password';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                            </div>

                            <div class="col-md-4 form-group">
                                @php
                                    $label = trans('backpack::base.confirm_password');
                                    $field = 'confirm_password';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="la la-save"></i> {{ trans('backpack::base.change_password') }}</button>
                            <a href="{{ backpack_url() }}" class="btn">{{ trans('backpack::base.cancel') }}</a>
                    </div>

                </div>

            </form>
        </div>

        @includeWhen(config('backpack.multi-auth.features.two_factor'), 'backpack.multi-auth::auth._two_factor_section', ['user' => $user])

        @includeWhen(config('backpack.multi-auth.features.passkeys'), 'backpack.multi-auth::auth._passkeys_section', ['user' => $user])

        @includeWhen(config('backpack.multi-auth.socialite.enabled'), 'backpack.multi-auth::auth._socialite_section', ['user' => $user])

    </div>
@endsection

@pushonce('after_scripts')
    <script>
        function showImageError(input, message) {
            var feedback = document.getElementById('image-error');
            feedback.textContent = message;
            feedback.style.display = 'block';
            input.classList.add('is-invalid');
            input.value = '';
            var label = input.parentElement.querySelector('.custom-file-label');
            if (label) {
                label.textContent = 'Choose File ...';
            }
            document.getElementById('image-preview').src = '{{ backpack_avatar_url(backpack_auth()->user()) }}';
        }

        function clearImageError(input) {
            var feedback = document.getElementById('image-error');
            feedback.textContent = '';
            feedback.style.display = 'none';
            input.classList.remove('is-invalid');
        }

        document.getElementById('image').addEventListener('change', function () {
            var file = this.files[0];
            var allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            var maxSize = 5 * 1024 * 1024; // 5MB

            if (!file) {
                clearImageError(this);
                return;
            }

            var label = this.parentElement.querySelector('.custom-file-label');
            if (label) {
                label.textContent = file.name;
            }

            var ext = file.name.split('.').pop().toLowerCase();
            if (!allowed.includes(ext) || !file.type.startsWith('image/')) {
                showImageError(this, 'Invalid file. Please upload a valid image (jpg, jpeg, png, gif, webp, bmp, svg).');
                return;
            }

            if (file.size > maxSize) {
                showImageError(this, 'File is too large. Maximum allowed size is 5MB.');
                return;
            }

            clearImageError(this);

            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('image-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
@endpushonce