@extends('layouts.template')

@section('content')
<div class="container my-0">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header" style="background-image: linear-gradient(135deg, #f5e0c3, #e4b47d); color: #783b31; text-align: center; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                    <h4 style="margin-top: 8px;">{{ __('Profile') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-4">
                        <div class="col-md-12">
                            @if($user->avatar)
                                <img src="{{ asset('storage/photos/'.$user->avatar) }}" class="img-thumbnail rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/profile-default.jpg') }}" class="img-thumbnail rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                            @endif
                            <h5 class="mt-3" style="color: #783b31;">{{ $user->nama }}</h5>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('profile.update', $user->user_id) }}" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf

                        <div class="form-group mb-3">
                            <label for="username" class="col-form-label" style="color: #B3846C;">{{ __('Username') }}</label>
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}" required autocomplete="username">
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama" class="col-form-label" style="color: #B3846C;">{{ __('Nama') }}</label>
                            <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $user->nama) }}" required autocomplete="nama">
                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="old_password" class="col-form-label" style="color: #B3846C;">{{ __('Password Lama') }}</label>
                            <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" autocomplete="old-password">
                            @error('old_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="col-form-label" style="color: #B3846C;">{{ __('Password Baru') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password-confirm" class="col-form-label" style="color: #B3846C;">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                        </div>

                        <div class="form-group mb-4">
                            <label for="avatar" class="col-form-label" style="color: #B3846C;">{{ __('Ganti Foto Profil') }}</label>
                            <div class="input-group">
                                <input id="avatar" type="file" class="form-control rounded-left @error('avatar') is-invalid @enderror" name="avatar" style="border: none; padding: 0;">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-hover btn-custom" style="background-image: linear-gradient(135deg, #f5e0c3, #e4b47d); color: #783b31;">
                                        {{ __('Simpan Perubahan') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .no-border {
        border: none;
        padding: 0; 
    }

    .btn-hover {
        transition: transform 0.3s ease; /* Smooth transition for the scaling effect */
    }

    .btn-hover:hover {
        transform: scale(1.1); /* Scale the button to 1.2 times its size on hover */
    }
</style>
@endsection
