@extends('layouts.app')

@section('title', __('users.editUser').': '.$user->name)

@section('head')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.18.10/slimselect.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.18.10/slimselect.min.css" rel="stylesheet">
@endsection

@section('content')

{{-- content and form --}}
<div class="row justify-content-center py-4">
    <div class="col-md-11 col-11 col-xl-8">

        {{-- Edit Report Details --}}
        <div class="card">
            <div class="card-header h3">{{ __('users.editUser') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ action('UserController@update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        {{-- name field --}}
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('users.name') }}</span>
                            </div>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                        </div>

                        {{-- email field --}}
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('users.email') }}</span>
                            </div>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                        </div>

                        {{-- password field --}}
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('users.changePassword') }}</span>
                            </div>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <div class="container row mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('users.groups') }}</span>
                            </div>
                            <div class="flex-grow-1 px-2">
                                <select id="multiple" name="groups[]" multiple>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->title }}" @if($user->groups->contains($group->title)) selected @endif>{{ $group->title }}</option>
                                    @endforeach
                                </select>            
                            </div>
                        </div>
                        <div class="form-group d-flex">
                                <span class="input-group-text">Roles</span>
                                <div class="col-sm-10">
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="userRole" value="User" name="userRole" checked disabled>
                                    <label class="form-check-label" for="userRole">User</label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="adminRole" name="adminRole" @if($user->isAdmin()) checked @endif>
                                    <label class="form-check-label" for="adminRole">Admin</label>
                                </div>
    
                                </div>
                            
                    </div>
                    <div class="container">
                            <div class="row justify-content-between">
                                <button type="submit" class="my-2 col-sm-3 col-12 btn btn-primary">{{ __('users.editButton') }}</button>
                                <button id="deleteUserButton" type="button" class="my-2 col-sm-3 col-12 btn btn-danger">{{ __('users.deleteButton') }}</button>
                            </div>                                         
                    </div>
                </form>
                {{-- Delete Report Form, will be submitted once the #deleteUserButton is clicked --}}
                <form id="deleteUserForm" action="{{ action('UserController@destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('delete')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function(){
    new SlimSelect({
        select: '#multiple'
    })

})
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
    
    document.addEventListener('DOMContentLoaded', function(){
        const deleteButton = document.querySelector('#deleteUserButton')
        deleteButton.addEventListener('click', function(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete!'
            })
            .then((result) => {
                if (result.value) {
                    document.querySelector('#deleteUserForm').submit()
                }
            })

        })
    })
</script>