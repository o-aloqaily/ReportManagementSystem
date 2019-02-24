@extends('layouts.admin')

@section('title', __('admin.reports'))

@section('content')
  @if (count($reports) > 0)
      <div class="contentContainer">
          <table class="col-md-12 mdl-data-table mdl-js-data-table mdl-shadow--2dp">
              <thead>
                  <th>#</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('adminReports.title') }}</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('adminReports.description') }}</th>
                  <th class="mdl-data-table__cell--non-numeric">{{ __('adminReports.createdAt') }}</th>
                  <th></th>
                </thead>
      
                <tbody>
                  
                  @foreach ($reports as $report)
                    
                    <tr>
                      <th>{{ $report->id }}</th>
                      <td class="mdl-data-table__cell--non-numeric">{{ $report->title }}</td>
                      <td class="mdl-data-table__cell--non-numeric">{{ substr($report->description, 0, 50) }}{{ strlen($report->description) > 50 ? "..." : "" }}</td>
                      <td class="mdl-data-table__cell--non-numeric">{{ date('M j, Y', strtotime($report->created_at)) }}</td>
                      <td class="mdl-data-table__cell--non-numeric">
                        <a href="{{ route('reports.show', $report->id) }}" class="btn btn-success btn-sm">{{ __('adminReports.viewButton') }}</a>
                        <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-primary btn-sm">{{ __('adminReports.editButton') }}</a>
                      </td>
                    </tr>
      
                  @endforeach
      
                </tbody>      
            </table>
      </div>
  @else
    <h5>{{ __('adminReports.noReports') }}</h4>
  @endif
@endsection
