@extends('layouts.app')

@section('title', $report->title)

@section('content')
    <div class="border-bottom row reportDetailsHeader">
            <div class="col-md-6 col-xs-12">
                <span class="h1 pr-4 whiteText">{{ $report->title }}</span>
                <p class="d-inline-block description">{{__('reports.createdAt') }} {{ date('M j, Y', strtotime($report->created_at)) }}</p>        
                <p class="description">
                        {{ $report->description }}
                </p>        
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="pb-4">
                        <span class="h5 pr-4 whiteText">{{ __('reports.group') }}</span>
                    <h5 class="d-inline"><span class="badge badge-primary">{{ $report->group->title }}</span></h2>
                    </div>     
                    <div>
                        <span class="h5 pr-4 whiteText">{{ __('reports.tags') }}</span>
                        @foreach ($report->tags as $tag)
                            <h5 class="d-inline"><span class="badge badge-secondary">{{ $tag->title }}</span></h2>
                        @endforeach   
                </div>                 
            </div>
    </div>
    <div class="contentContainerDefault">
            <div id="myModal" class="modal">

                    <!-- The Close Button -->
                    <span class="close">&times;</span>
                  
                    <!-- Modal Content (The Image) -->
                    <img class="modal-content" id="img01">
                  
                    <!-- Modal Caption (Image Text) -->
                    <div id="caption"></div>
            </div>      
            <div class="row">
                <div id="filesContainer" class="filesContainer col-md-6 col-xs-12">
                    <h5 class="pb-2">{{ __('reports.pictures')}}</h5>
                    @if (!$report->images())
                        <span>{{ __('reports.noPictures')}}</span>
                    @else
                        <div class="row">
                        @foreach ($report->images() as $image)
                            <div class="col-4 m-4">
                                <img id="myImg" class="image img-fluid" src="{{route('serveReportFile', ['filePath' => $image->path])}}" />
                            </div>
                        @endforeach
                        </div>
                    @endif
                </div>
                <div class="filesContainer col-md-6 col-xs-12">
                    <h5 class="pb-2">{{ __('reports.audios')}}</h5>
                    @if (!$report->images())
                        <span>{{ __('reports.noAudios')}}</span>
                    @else
                        @foreach ($report->audios() as $audio)
                            <audio controls src="{{route('serveReportFile', ['filePath' => $audio->path])}}">
                            </audio>
                        @endforeach
                    @endif
                </div>
            </div>
    </div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function(){
    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var filesContainer = document.getElementById('filesContainer');
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    filesContainer.onclick = function(event){
        if (event.target.classList.contains('image')) {
            modal.style.display = "block";
            modalImg.src = event.target.src;
            captionText.innerHTML = event.target.alt;
        }
    }
    
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() { 
        modal.style.display = "none";
    }
})
</script>