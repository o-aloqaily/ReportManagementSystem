@extends('layouts.app')

@section('title', 'New Report')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header h3">{{ __('createReport.formTitle') }}</div>
            <div class="card-body">
                <form class="col-md-6 col-xs-8 col-sm-8" method="POST" enctype="multipart/form-data" action="{{ action('ReportController@store') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="h5" for="title">{{ __('createReport.titleField') }}</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label class="h5" for="description">{{ __('createReport.description') }}</label>
                        <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="h5" for="group">{{ __('createReport.group') }}</label>
                        <select class="form-control" id="group" name="group">
                            @foreach($groups as $group)
                            <option value="{{ $group->title }}">{{ $group->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="h5" for="photos">{{ __('createReport.uploadImages') }} <span class="h6">{{ __('createReport.uploadImagesHelper') }}</span></label>
                        <input id="photos" class="d-block" type="file" name="photos[]" accept=".gif,.jpg,.jpeg,.png" multiple>
                    </div>
                    <div class="form-group">
                        <label class="h5" for="audios">{{ __('createReport.uploadAudios') }} <span class="h6">{{ __('createReport.uploadAudiosHelper') }}</span></label>
                        <input type="file" class="d-block" name="audios[]" accept=".mp3" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('createReport.submitButton') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection