@extends('layouts.adminPanel')

@section('title', __('admin.reports'));

@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1>{{ __('admin.reports') }}</h1>
  </div>
  @if (count($reports) > 0)
    <div class="row">
      <div class="col-md-12">
        <table class="table">
          <thead>
            <th>#</th>
            <th>{{ __('adminReports.title') }}</th>
            <th>{{ __('adminReports.description') }}</th>
            <th>{{ __('adminReports.createdAt') }}</th>
            <th></th>
          </thead>

          <tbody>
            
            @foreach ($reports as $report)
              
              <tr>
                <th>{{ $report->id }}</th>
                <td>{{ $report->title }}</td>
                <td>{{ substr($report->description, 0, 50) }}{{ strlen($report->description) > 50 ? "..." : "" }}</td>
                <td>{{ date('M j, Y', strtotime($report->created_at)) }}</td>
                <td>
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
</main>
@endsection
