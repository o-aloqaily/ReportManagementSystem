@extends('layouts.app')

@section('title', __('reports.editReport').' Report: '.$report->title)

@section('content')
{{-- content and form --}}
<div class="row justify-content-center py-4">
    <div class="col-md-11 col-11 col-xl-8">

        {{-- Edit Report Details --}}
        <div class="card">
            <div class="card-header h3">{{ __('editReport.editDetails') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ action('ReportController@update', $report->id) }}">
                    {{ csrf_field() }}
                    @method('PUT')
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('editReport.titleField') }}</span>
                            </div>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $report->title }}">
                        </div>                          
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('editReport.description') }}</span>
                            </div>
                            <textarea class="form-control" id="description" rows="3" name="description" aria-label="description">{{ $report->description }}</textarea>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="group">{{ __('editReport.group') }}</label>
                            </div>
                            <select class="custom-select form-control" id="group" name="group">
                                @foreach($groups as $group)
                                    <option
                                    @if($group->title == $report->group->title) selected @endif value="{{ $group->title }}">{{ $group->title }}</option>
                                @endforeach
                            </select>
                        </div>    
                    </div>
                    <div class="alert alert-info" role="alert">
                        {{ __('editReport.tagsHelper') }}
                        <br>
                        {{ __('editReport.blankSpaces') }}
                    </div>                      
                    <div class="form-group">                        
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('editReport.tags') }}</span>
                            </div>
                        <input type="text" class="form-control" id="tags" name="tags" placeholder="{{ __('editReport.tagsHelper') }}" value="@foreach($report->tags as $tag){{$tag->title.','}}@endforeach">
                    </div> 
                    </div>
                    <div class="container">
                            <div class="row justify-content-between">
                                <button type="submit" class="my-2 col-sm-3 col-12 btn btn-primary">{{ __('editReport.editButton') }}</button>
                                <button id="deleteReportButton" type="button" class="my-2 col-sm-3 col-12 btn btn-danger">{{ __('editReport.deleteButton') }}</button>
                            </div>                                         
                    </div>
                </form>
                
                {{-- Delete Report Form, will be submitted once the #deleteReportButton is clicked --}}
                <form id="deleteReportForm" action="{{ action('ReportController@destroy', $report->id) }}" method="POST">
                        @csrf
                        @method('delete')
                </form>

            </div>
        </div>


        {{-- Manage Reports Images --}}
        <div class="card my-4">
            <div class="card-header h3">{{ __('editReport.editImages') }}</div>
            <div class="card-body">
                <div id="myModal" class="modal">
    
                        <!-- The Close Button -->
                        <span class="close">&times;</span>
                        
                        <!-- Modal Content (The Image) -->
                        <img class="modal-content" id="img01">
                        
                        <!-- Modal Caption (Image Text) -->
                        <div id="caption"></div>
                </div>      
                    <div class="container-fluid">
                        @if (!$report->images())
                            <span>This report has no pictures.</span>
                        @else
                            <div class="row filesContainer">
                                @foreach ($report->images() as $image)
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 py-4 px-4">
                                            <div class="row">
                                                <form id="deleteImageRequest" action="{{ action('FileController@removeReportFile', $report->id) }}" method="POST"> {{ csrf_field() }}
                                                    <input type="hidden" name="filePath" value="{{ $image->path }}">
                                                    <input type="hidden" name="fileId" value="{{ $image->id }}">
                                                    <button class="deleteFileButton" type="button"><i class="deleteFileIcon material-icons">remove_circle</i></button>
                                                </form>
                                            </div>
                                            <img class="image img-fluid" src="{{route('serveReportFile', ['filePath' => $image->path])}}" />
                                        </div> 
                                @endforeach
                            </div>
                        @endif
                        {{-- Upload new report images --}}
                        <div class="py-4">
                            <form method="POST" enctype="multipart/form-data" action="{{ action('ReportController@uploadImages', $report->id) }}">
                                {{ csrf_field() }}
                                <div class="row justify-content-center">
                                        <div class="input-group col-sm-10 col-12 my-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{{ __('editReport.uploadImages') }}</span>
                                            </div>
                                            <div class="custom-file">
                                                <input class="custom-file-input" id="photos" type="file" name="photos[]" accept="{{ '.'.implode(', .', config('files.allowedImagesExtensions')) }}" multiple>
                                                <label class="custom-file-label" id="uploadPhotosLabel" for="photos">{{ __('editReport.uploadImages') }}</label>
                                            </div>
                                        </div>  
                                        <button type="submit" class="my-2 col-sm-2 col-11 btn btn-primary">{{ __('editReport.upload') }}</button>                                  
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div> 

        {{-- Manage Reports Audio Files --}}
        <div class="card my-4">
            <div class="card-header h3">{{ __('editReport.editAudios') }}</div>
            <div class="card-body">
                    <div class="container-fluid">
                        @if (!$report->audios())
                            <span>This report has no audio files.</span>
                        @else
                            <div class="row filesContainer">
                                @foreach ($report->audios() as $audio)
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 py-4 px-4">
                                            <div class="row">
                                                <form action="{{ action('FileController@removeReportFile', $report->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="filePath" value="{{ $audio->path }}">
                                                    <input type="hidden" name="fileId" value="{{ $audio->id }}">
                                                    <button class="deleteFileButton" type="button"><i class="deleteFileIcon material-icons">remove_circle</i></button>
                                                </form>
                                            </div>
                                            <div class="row">
                                                <audio controls src="{{route('serveReportFile', ['filePath' => $audio->path])}}">
                                                </audio>
                                            </div>
                                        </div> 
                                @endforeach
                            </div>
                        @endif
                        {{-- Upload new report audio files --}}
                        <div class="py-4">
                            <form method="POST" enctype="multipart/form-data" action="{{ action('ReportController@uploadAudios', $report->id) }}">
                                {{ csrf_field() }}
                                <div class="row justify-content-center">
                                        <div class="input-group col-sm-10 col-12 my-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{{ __('editReport.uploadAudios') }}</span>
                                            </div>
                                            <div class="custom-file">
                                                <input class="custom-file-input" id="audios" type="file" name="audios[]" accept="{{ '.'.implode(', .', config('files.allowedAudioFilesExtensions')) }}" multiple>
                                                <label class="custom-file-label" id="uploadAudiosLabel" for="audios">{{ __('createReport.uploadAudios') }}</label>
                                            </div>
                                        </div>  
                                        <button type="submit" class="my-2 col-sm-2 col-11 btn btn-primary">{{ __('editReport.upload') }}</button>                                  
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>             
    </div>
</div>
@endsection

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('photos').addEventListener('change', function (e) {
            var files = [];
            for (var i = 0; i < $(this)[0].files.length; i++) {
                files.push($(this)[0].files[i].name);
            }

            if (files.length > 1)
                document.getElementById('uploadPhotosLabel').innerHTML = files.length + ' files selected';
            else
                document.getElementById('uploadPhotosLabel').innerHTML = files.join(', ');
        });

        document.getElementById('audios').addEventListener('change', function (e) {
            var files = [];
            for (var i = 0; i < $(this)[0].files.length; i++) {
                files.push($(this)[0].files[i].name);
            }

            if (files.length > 1)
                document.getElementById('uploadAudiosLabel').innerHTML = files.length + ' files selected';
            else
                document.getElementById('uploadAudiosLabel').innerHTML = files.join(', ');
        });


    })
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script>
        document.addEventListener('DOMContentLoaded', function(){
            // Get the modal
            var modal = document.getElementById('myModal');
        
            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var filesContainers = document.getElementsByClassName('filesContainer');
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");

            // transform the HTMLCollection to array, then add an event listener to each
            // to listen for clicks and call appropriate functions
            [...filesContainers].forEach((container) => {
                container.onclick = function(event){
                    if (event.target.classList.contains('deleteFileButton') || event.target.classList.contains('deleteFileIcon')) {
                        fireSwal(event)
                    } else if (event.target.classList.contains('image')) {
                        modal.style.display = "block";
                        modalImg.src = event.target.src;
                        captionText.innerHTML = event.target.alt;
                    } else {
                        return;
                    }
                }
            })
        



            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];
        
            // When the user clicks on <span> (x), close the modal
            span.onclick = function() { 
                modal.style.display = "none";
            }



            function fireSwal(event){
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
                        if (event.target.parentElement.tagName == 'BUTTON') // the icon was clicked, so propagate to the form by going to the second parent
                            event.target.parentElement.parentElement.submit();
                        else // the actuall button was clicked, so the next direct parent is the form
                            event.target.parentElement.submit();
                    }
                })
            }
        })
</script>


<script>
// document.addEventListener('DOMContentLoaded', function(){
//     const button = document.querySelector('.deleteFileButton')
//     button.addEventListener('click', function(){
//         Swal.fire({
//             title: 'Are you sure?',
//             text: "You won't be able to revert this!",
//             type: 'warning',
//             showCancelButton: true,
//             confirmButtonColor: '#3085d6',
//             cancelButtonColor: '#d33',
//             confirmButtonText: 'Yes, delete it!'
//         })
//         .then((result) => {
//             if (result.value) {
//                 button.parentElement.submit();
//             }
//         })
//     })
// })
</script>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const deleteButton = document.querySelector('#deleteReportButton')
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
                    document.querySelector('#deleteReportForm').submit()
                }
            })

        })
    })
</script>