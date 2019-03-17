@extends('layouts.admin')

@section('title', __('admin.users'))

@section('content')
  @if (count($users) > 0)
      <div class="contentContainer">
          <table class="col-md-12 mdl-data-table mdl-js-data-table mdl-shadow--2dp">
              <thead>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('users.name') }}</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('users.email') }}</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('users.roles') }}</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('users.groupsCount') }}</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('users.createdAt') }}</th>
                  <th></th>
                </thead>
      
                <tbody>
                  
                  @foreach ($users as $user)
                    
                    <tr>
                      <td class="mdl-data-table__cell--non-numeric">{{ $user->name }}</td>
                      <td class="mdl-data-table__cell--non-numeric">{{ $user->email }}</td>
                      <td class="mdl-data-table__cell--non-numeric">{{ $user->getCurrentRoles() }}</td>
                      <td class="mdl-data-table__cell--non-numeric">{{ $user->groupsCount() }}</td>
                      <td class="mdl-data-table__cell--non-numeric">{{ date('M j, Y', strtotime($user->created_at)) }}</td>
                      <td class="mdl-data-table__cell--non-numeric">
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-success btn-sm">{{ __('users.viewButton') }}</a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">{{ __('users.editButton') }}</a>
                      </td>
                    </tr>
      
                  @endforeach
      
                </tbody>      
            </table>
      </div>
  @else
    <h5>{{ __('users.noUsers') }}</h4>
  @endif
@endsection

