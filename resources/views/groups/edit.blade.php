@extends('layouts.app')

@section('title', __('groups.editGroup').': '.$group->title)

@section('content')

{{-- content and form --}}
<div class="row justify-content-center py-4">
    <div class="col-md-11 col-11 col-xl-8">

        {{-- Edit Report Details --}}
        <div class="card">
            <div class="card-header h3">{{ __('groups.editDetails') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ action('GroupController@update', $group->title) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('groups.title') }}</span>
                            </div>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $group->title }}">
                        </div>                          
                    </div>
                    <div class="container">
                            <div class="row justify-content-between">
                                <button type="submit" class="my-2 col-sm-3 col-12 btn btn-primary">{{ __('groups.editButton') }}</button>
                                <button id="deleteGroupButton" type="button" class="my-2 col-sm-3 col-12 btn btn-danger">{{ __('groups.deleteButton') }}</button>
                            </div>                                         
                    </div>
                </form>
                {{-- Delete Report Form, will be submitted once the #deleteGroupButton is clicked --}}
                <form id="deleteGroupForm" action="{{ action('GroupController@destroy', $group->title) }}" method="POST">
                        @csrf
                        @method('delete')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
    
    document.addEventListener('DOMContentLoaded', function(){
        const deleteButton = document.querySelector('#deleteGroupButton')
        deleteButton.addEventListener('click', function(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if (result.value) {
                    document.querySelector('#deleteGroupForm').submit()
                }
            })

        })
    })
</script>