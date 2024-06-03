@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <link rel="icon" href="{{ asset('img/logo-nav.png') }}" type="image/x-icon">

</head>

<body>
    @section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="d-flex gap-4 align-items-center">
                            <a href="{{ route('show_product') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                    viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                                </svg>
                            </a>
                            <h2 class="fw-bold mb-0">Profile Details</h2>
                        </div>

                        <div id="contentProfile">
                            <div class="card shadow mx-auto py-2 px-3 mt-3" style="width: 50%">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h2 class="fw-bold mb-3">Details</h2>
                                        <button class="btn btn-outline-secondary fw-bold" id="btnEdit">
                                            Edit
                                        </button>
                                    </div>
                                    <hr class="mt-3">
                                    <div class="mt-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-secondary">Name</span>
                                            <span class="fw-bold">{{ $user->name }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-secondary">Email</span>
                                            <span class="fw-bold">{{ $user->email }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-secondary">Role</span>
                                            <span class="fw-bold">{{ $user->is_admin ? 'Admin' : 'Member' }}</span>
                                        </div>
                                        @if ($user->created_at)
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="text-secondary">Account Created</span>
                                                <span class="fw-bold">{{ $user->created_at->format('d F Y') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="contentEdit" style="display: none;">
                            <div class="card shadow mx-auto py-2 px-3 mt-3" style="width: 50%">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h2 class="fw-bold mb-3">Edit Details</h2>
                                    </div>
                                    <hr class="mt-3">
                                    <div class="mt-4">
                                        <form action="{{ route('edit_profile') }}" method="post">
                                            @csrf
                                            <label for="name" class="mb-1">Name : </label>
                                            <input type="text" name="name" value="{{ $user->name }}"
                                                placeholder="masukkan nama..." class="form-control mb-3" required>
                                            <label for="name" class="mb-1">Email : </label>
                                            <input type="text" name="email" value="{{ $user->email }}"
                                                placeholder="masukkan email..." class="form-control mb-3" required>
                                            <label for="name" class="mb-1">Role : </label>
                                            <input type="text" name="role"
                                                value="{{ $user->is_admin ? 'Admin' : 'Member' }}"
                                                class="form-control bg-secondary" style="--bs-bg-opacity: .2" readonly>
                                            <p class="mb-3 text-danger" style="font-size: 12px;">Role can't be changed!</p>
                                            <label for="name" class="mb-1">Password : </label>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="masukkan password baru...">
                                            <p class="mb-3 text-secondary" style="font-size: 12px;">Ignore if you don't want
                                                to
                                                change the password</p>
                                            <label for="name" class="mb-1">Confirm Password : </label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="konfirmasi password">
                                            <p class="mb-3 text-secondary" style="font-size: 12px;">Ignore if you don't want
                                                to
                                                change the password</p>
                                            <div class="d-flex justify-content-end gap-2">
                                                <button class="btn btn-danger" id="btnCancel">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Change Profile
                                                    Details</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="{{ asset('js/profile.js') }}"></script>
        @endsection


</body>

</html>
