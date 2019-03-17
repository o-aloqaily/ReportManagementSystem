@extends('layouts.app')

@section('title', __('user.groups'))

@section('content')
      <div class="contentContainerDefault">
      @if (count($groups) > 0)
        <h3 class="border-bottom-0 pb-4">{{ __('groups.userHeading') }}</h1>
        {{-- Table Section --}}
        <div class="table-responsive">
          <table class="col-md-12 col-sm-12 col-xs-12 mdl-data-table mdl-js-data-table mdl-shadow--2dp table">
            <thead>
              <th class="mdl-data-table__cell--non-numeric">{{ __('groups.title') }}</th>
              <th class="mdl-data-table__cell--non-numeric">{{ __('groups.membersCount') }}</th>
              <th class="mdl-data-table__cell--non-numeric">{{ __('groups.createdAt') }}</th>
              <th></th>
            </thead>
  
            <tbody>
              
              @foreach ($groups as $group)
                
                <tr>
                  <td class="mdl-data-table__cell--non-numeric">{{ $group->title }}</td>
                  <td class="mdl-data-table__cell--non-numeric">{{ $group->membersCount() }}</td>
                  <td class="mdl-data-table__cell--non-numeric">{{ date('M j, Y', strtotime($group->created_at)) }}</td>
                  <td class="mdl-data-table__cell--non-numeric">
                    <a href="{{ route('groups.show', $group->title) }}" class="btn btn-success btn-sm btn-block">{{ __('groups.viewButton') }}</a>
                  </td>
                </tr>
  
              @endforeach
  
            </tbody>      
          </table>
        </div>
        <div class="row justify-content-center">
            {{ $groups->links() }}
        </div>
        @else
        <h5>{{ __('groups.noGroups') }}</h4>
        @endif    
      </div>
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