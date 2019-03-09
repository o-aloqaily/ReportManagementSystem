@extends('layouts.admin')

@section('title', __('admin.groups'))

@section('content')
  @if (count($groups) > 0)
      <div class="contentContainer">
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
                    <a href="{{ route('groups.show', $group->title) }}" class="btn btn-success btn-sm">{{ __('groups.viewButton') }}</a>
                    <a href="{{ route('groups.edit', $group->title) }}" class="btn btn-primary btn-sm">{{ __('groups.editButton') }}</a>
                  </td>
                </tr>
  
              @endforeach
  
            </tbody>      
           </table>
          </div>
      </div>
  @else
    <h5>{{ __('groups.noGroups') }}</h4>
  @endif
@endsection

