@extends('layouts.admin')

@section('title', __('admin.reports'))

@section('content')
  @if (count($reports) > 0)
      <div class="contentContainer">
        {{-- Search Section --}}
      <form class="form-inline row" action="{{ route('admin.reports.search') }}" method="GET">
            <div class="input-group mb-3 col-sm-6 col-xs-5">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="material-icons">search</i></span>
              </div>
              <input type="text" id="query" name="query" class="form-control" placeholder="Enter report's title..." aria-label="Search" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3 col-sm-4 col-xs-4">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="inputGroupSelect01">Search By</label>
                </div>
                <select name="searchBy" id="searchBy" class="custom-select" id="searchBy">
                  <option value="title" selected>Title</option>
                  <option value="tags">Tags</option>
                  <option value="group">Group</option>
                  <option value="user">Author</option>
                </select>
            </div>
            <div class="mb-3 col-sm-2 col-xs-3">
                <button type="submit" class="btn btn-primary btn-block">Search</button>            
            </div>
        </form>

        {{-- Table Section --}}
        <div class="table-responsive">
          <table class="col-md-12 col-sm-12 col-xs-12 mdl-data-table mdl-js-data-table mdl-shadow--2dp table">
              <thead>
                  <th>#</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('adminReports.title') }}</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('adminReports.description') }}</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('adminReports.createdAt') }}</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('adminReports.author') }}</th>
                  <th></th>
                </thead>
      
                <tbody>
                  
                  @foreach ($reports as $report)
                    
                    <tr>
                      <th>{{ $report->id }}</th>
                      <td class="mdl-data-table__cell--non-numeric">{{ $report->title }}</td>
                      <td class="mdl-data-table__cell--non-numeric">{{ substr($report->description, 0, 50) }}{{ strlen($report->description) > 50 ? "..." : "" }}</td>
                      <td class="mdl-data-table__cell--non-numeric">{{ date('M j, Y', strtotime($report->created_at)) }}</td>
                      <td class="mdl-data-table__cell--non-numeric">{{ $report->user->name }}</td>
                      <td class="mdl-data-table__cell--non-numeric">
                        <a href="{{ route('reports.show', $report->id) }}" class="btn btn-success btn-sm">{{ __('adminReports.viewButton') }}</a>
                        <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-primary btn-sm">{{ __('adminReports.editButton') }}</a>
                      </td>
                    </tr>
      
                  @endforeach
      
                </tbody>      
            </table>
          </div>
      </div>
  @else
    <h5>{{ __('adminReports.noReports') }}</h4>
  @endif
@endsection



{{-- This script changes the placeholder of the search input according to search by selection by the user --}}
<script>
  document.addEventListener('DOMContentLoaded', function(){ 
    const select = document.querySelector('#searchBy');
    select.addEventListener('change', function() {
      const query = document.querySelector('#query');
      if (select.value == 'tags') {
        query.placeholder = "Enter report's tags separated by comma (Tag1, Tag2... etc.)";
      } else if (select.value == 'user') {
        query.placeholder = "Enter report's author name...";
      } else if (select.value == 'group') {
        query.placeholder = "Enter report's group title...";
      } else {
        query.placeholder = "Enter report's title...";
      }
    })

  })
</script>