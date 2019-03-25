@extends('layouts.admin')

@section('title', __('admin.groups'))

@section('content')
      <div class="contentContainer">
        {{-- flash message --}}
        <div class="row justify-content-center">
            @include('flash::message')
            @if ($errors->any())
                <div class="alert alert-danger col-md-8">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif 
        </div>
        <div class="pb-4">
          <a href="{{ route('admin.groups.create') }}" class="btn btn-primary btn-sm col-12 col-sm-3 col-md-2 d-flex justify-content-center align-items-center"><i class="mdl-color-text--white-white-400 material-icons" role="presentation">add</i>{{ __('groups.addGroupButton') }}</a>
        </div>
        @if (count($groups) > 0)
        <div class="table-responsive">
          <table class="col-md-12 col-sm-12 col-xs-12 mdl-data-table mdl-js-data-table mdl-shadow--2dp table">
            <thead>
              <th class="mdl-data-table__cell--non-numeric">{{ __('groups.title') }}</th>
              <th class="mdl-data-table__cell--non-numeric">{{ __('groups.membersCount') }}</th>
              <th class="mdl-data-table__cell--non-numeric">{{ __('groups.reportsCount') }}</th>
              <th class="mdl-data-table__cell--non-numeric">{{ __('groups.createdAt') }}</th>
              <th></th>
            </thead>
  
            <tbody>
              
              @foreach ($groups as $group)
                
                <tr>
                  <td class="mdl-data-table__cell--non-numeric">{{ $group->title }}</td>
                  <td class="mdl-data-table__cell--non-numeric">{{ $group->membersCount() }}</td>
                  <td class="mdl-data-table__cell--non-numeric">{{ $group->reportsCount() }}</td>
                  <td class="mdl-data-table__cell--non-numeric">{{ date('M j, Y', strtotime($group->created_at)) }}</td>
                  <td class="mdl-data-table__cell--non-numeric">
                    <a href="{{ route('groups.show', $group->title) }}" class="btn btn-success btn-sm col-6">{{ __('groups.viewButton') }}</a>
                    <a href="{{ route('admin.groups.edit', $group->title) }}" class="btn btn-primary btn-sm col-6">{{ __('groups.editButton') }}</a>
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

