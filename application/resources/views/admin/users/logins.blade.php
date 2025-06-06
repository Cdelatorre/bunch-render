@extends('admin.layouts.app')

@section('panel')
<div class="row">

    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">

                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Login at')</th>
                                <th>@lang('IP')</th>
                                <th>@lang('Browser and OS')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loginLogs as $log)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.users.detail', $log->user_id) }}">{{
                                        @$log->user->fullname }}</a>
                                </td>

                                <td>
                                    {{showDateTime($log->created_at) }}
                                </td>

                                <td>
                                  <td>
                                    @if($log->user_ip)
                                        <a href="{{ route('admin.report.login.ipHistory', $log->user_ip) }}">
                                            {{ $log->user_ip }}
                                        </a>
                                    @else
                                        &mdash;
                                    @endif
                                </td>
                                </td>

                                <td>
                                    {{ __($log->browser) }}, {{ __($log->os) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            @if($loginLogs->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($loginLogs) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>


</div>
@endsection
