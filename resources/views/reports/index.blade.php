@extends('layouts.app')

@section('title', __('user.reports'))

@section('content')
  @if (count($reports) > 0)
      <div class="contentContainerDefault">
        <h3 class="border-bottom-0 pb-4">{{ __('reports.userHeading') }}</h1>
        {{-- Search Section --}}
        <form class="form-inline row" action="{{ route('admin.reports.search') }}" method="GET">
            <div class="input-group mb-3 col-sm-6 col-xs-5">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="material-icons">search</i></span>
              </div>
              <input type="text" id="query" name="query" class="form-control" placeholder="{{ __('reports.enterTitle') }}" aria-label="Search" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3 col-sm-4 col-xs-4">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="searchBy">{{ __('reports.searchBy') }}</label>
                </div>
                <select name="searchBy" id="searchBy" class="custom-select" id="searchBy">
                  <option value="title" selected>{{ __('reports.title') }}</option>
                  <option value="tag">{{ __('reports.tag') }}</option>
                  <option value="group">{{ __('reports.group') }}</option>
                  <option value="user">{{ __('reports.author') }}</option>
                </select>
            </div>
            <div class="mb-3 col-sm-2 col-xs-3">
                <button type="submit" class="btn btn-primary btn-block">{{ __('reports.searchButton') }}</button>            
            </div>
        </form>

        {{-- Table Section --}}
        <div class="table-responsive">
          <table class="col-md-12 col-sm-12 col-xs-12 mdl-data-table mdl-js-data-table mdl-shadow--2dp table">
              <thead>
                  <th>#</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('reports.title') }}</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('reports.description') }}</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('reports.createdAt') }}</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('reports.author') }}</th>
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
                        <a href="{{ route('reports.show', $report->id) }}" class="btn btn-success btn-sm">{{ __('reports.viewButton') }}</a>
                        <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-primary btn-sm">{{ __('reports.editButton') }}</a>
                      </td>
                    </tr>
      
                  @endforeach
      
                </tbody>      
            </table>
          </div>
          <div class="row justify-content-center">
            {{ $reports->links() }}
        </div>  
      </div>
  @else
    <h5>{{ __('reports.noReports') }}</h4>
  @endif
@endsection



{{-- This script changes the placeholder of the search input according to search by selection by the user --}}
<script>
  document.addEventListener('DOMContentLoaded', function(){ 
    const select = document.querySelector('#searchBy');
    select.addEventListener('change', function() {
      const query = document.querySelector('#query');
      if (select.value == 'tag') {
        query.placeholder = __('reports.enterTag');
      } else if (select.value == 'user') {
        query.placeholder = __('reports.enterUser');
      } else if (select.value == 'group') {
        query.placeholder = __('reports.enterGroup');
      } else {
        query.placeholder = __('reports.enterTitle');
      }
    })

  })
</script>