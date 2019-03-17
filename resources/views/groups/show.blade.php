@extends('layouts.app')

@section('title', $group->title)

@section('content')
    <div class="border-bottom row reportDetailsHeader">
        <div class="col-md-6 col-xs-12">
                <span class="h1 pr-4 whiteText">{{ $group->title }}</span>
                <p class="d-inline-block description">{{__('groups.createdAt') }} {{ date('M j, Y', strtotime($group->created_at)) }}</p>        
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="pb-4">
                    <span class="h5 pr-4 whiteText">{{ __('groups.membersCount') }}</span>
                <h5 class="d-inline"><span class="badge badge-primary">{{ $group->membersCount() }}</span></h2>
                </div>     
                <div>
                    <span class="h5 pr-4 whiteText">{{ __('groups.reportsCount') }}</span>
                    <h5 class="d-inline"><span class="badge badge-primary">{{ $group->reportsCount() }}</span></h2>
            </div>                 
        </div>
    </div>        
    <div class="contentContainerDefault">
        <h3 class="border-bottom-0 pb-4">{{ __('groups.members') }}</h1>
            {{-- Table Section --}}
            <div class="table-responsive">
                <table class="col-md-12 col-sm-12 col-xs-12 mdl-data-table mdl-js-data-table mdl-shadow--2dp table">
                    <thead>
                        <th class="mdl-data-table__cell--non-numeric">{{ __('users.name') }}</th>
                        <th class="mdl-data-table__cell--non-numeric">{{ __('users.email') }}</th>
                        <th class="mdl-data-table__cell--non-numeric">{{ __('users.roles') }}</th>
                        <th class="mdl-data-table__cell--non-numeric">{{ __('users.groupsCount') }}</th>
                        <th class="mdl-data-table__cell--non-numeric">{{ __('users.createdAt') }}</th>
                    </thead>
        
                    <tbody>
                        @foreach ($users as $user)
                
                        <tr>
                            <td class="mdl-data-table__cell--non-numeric">{{ $user->name }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ $user->email }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ $user->getCurrentRoles() }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ $user->groupsCount() }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ date('M j, Y', strtotime($user->created_at)) }}</td>
                        </tr>
                        @endforeach                
                    </tbody>      
                </table>
            </div>    
            <div class="row justify-content-center">
                    {{ $users->links() }}
            </div>      
    </div>
@endsection