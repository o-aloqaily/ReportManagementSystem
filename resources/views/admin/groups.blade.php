@extends('layouts.admin')

@section('title', __('admin.groups'))

@section('content')
  @if (count($groups) > 0)
      <div class="contentContainer">
          <table class="col-md-12 mdl-data-table mdl-js-data-table mdl-shadow--2dp">
              <thead>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('adminGroups.title') }}</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('adminGroups.membersCount') }}</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('adminGroups.createdAt') }}</th>
                  <th></th>
                </thead>
      
                <tbody>
                  
                  @foreach ($groups as $group)
                    
                    <tr>
                      <td class="mdl-data-table__cell--non-numeric">{{ $group->title }}</td>
                      <td class="mdl-data-table__cell--non-numeric">{{ $group->membersCount() }}</td>
                      <td class="mdl-data-table__cell--non-numeric">{{ date('M j, Y', strtotime($group->created_at)) }}</td>
                      <td class="mdl-data-table__cell--non-numeric">
                        <a href="{{ route('groups.show', $group->title) }}" class="btn btn-success btn-sm">{{ __('adminGroups.viewButton') }}</a>
                        <a href="{{ route('groups.edit', $group->title) }}" class="btn btn-primary btn-sm">{{ __('adminGroups.editButton') }}</a>
                      </td>
                    </tr>
      
                  @endforeach
      
                </tbody>      
            </table>
      </div>
  @else
    <h5>{{ __('adminGroups.noGroups') }}</h4>
  @endif
@endsection

