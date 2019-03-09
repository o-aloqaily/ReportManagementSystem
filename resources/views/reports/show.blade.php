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
                        <span class="h5 pr-4 whiteText">Group </span>
                    <h5 class="d-inline"><span class="badge badge-primary">{{ $report->group->title }}</span></h2>
                    </div>     
                    <div>
                        <span class="h5 pr-4 whiteText">Tags </span>
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
                <div class="filesContainer col-md-6 col-xs-12">
                    <h5 class="pb-2">{{ __('reports.pictures')}}</h5>
                    @if (!$report->images())
                        <span>This report has no pictures.</span>
                    @else
                        @foreach ($report->images() as $image)
                            <img id="myImg" class="image" src="{{route('serveReportImage', ['filePath' => $image->path])}}" />
                        @endforeach
                    @endif
                </div>
                <div class="filesContainer col-md-6 col-xs-12">
                    <h5 class="pb-2">{{ __('reports.audios')}}</h5>
                    @if (!$report->images())
                        <span>This report has no audio files.</span>
                    @else
                        @foreach ($report->audios() as $audio)
                            <audio controls src="{{route('serveReportImage', ['filePath' => $audio->path])}}">
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
    var img = document.getElementById('myImg');
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
    }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() { 
    modal.style.display = "none";
    }
})
</script>