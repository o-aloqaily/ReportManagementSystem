@extends('layouts.app')

@section('title', __('groups.addGroup'))

@section('content')

{{-- content and form --}}
<div class="row justify-content-center py-4">
    <div class="col-md-11 col-11 col-xl-8">

        {{-- Edit Report Details --}}
        <div class="card">
            <div class="card-header h3">{{ __('groups.addGroup') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ action('GroupController@store') }}">
                    @csrf
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('groups.title') }}</span>
                            </div>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>                          
                    </div>
                    <button type="submit" class="my-2 col-12 btn btn-primary">{{ __('groups.addGroupButton') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection