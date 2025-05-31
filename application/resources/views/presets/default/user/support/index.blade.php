@extends($activeTemplate.'layouts.master')
@section('content')

    <div class="row gy-4 justify-content-center">
        <div class="col-lg-12 mb-3">
            <div class="text-end">
                <a href="{{route('ticket.open') }}" class="btn btn--sm btn--base border-none mb-2"> <i class="fa fa-plus"></i> @lang('New Ticket')</a>
            </div>
        </div>
        <div class="col-lg-12 pb-30">
            <div class="dark-to-light-table">
                <table class="table table--responsive--lg table-boarder">
                    <thead>
                        <tr>
                            <th>@lang('TICKET NO')</th>
                            <th>@lang('SUBJECT')</th>
                            <th>@lang('PRIORITY')</th>
                            <th>@lang('STATUS')</th>
                            <th>@lang('LAST REPLY')</th>
                            <th>@lang('ACTION')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($supports as $support)
                            <tr>
                                <td data-label="@lang('TICKET NO')">#{{ $support->ticket }}</td>

                                <td data-label="@lang('SUBJECT')">
                                    {{ __($support->subject) }}
                                </td>

                                <td data-label="@lang('PRIORITY')">
                                    @if($support->priority == 1)
                                        <span class="badge bg-dark">@lang('Low')</span>
                                    @elseif($support->priority == 2)
                                        <span class="badge bg-success">@lang('Medium')</span>
                                    @elseif($support->priority == 3)
                                        <span class="badge bg-primary">@lang('High')</span>
                                    @endif
                                </td>

                                <td data-label="@lang('STATUS')">
                                    @php echo $support->statusBadge; @endphp
                                </td>

                                <td data-label="@lang('LAST REPLY')">
                                    {{ __($support->supportMessage->last()->message) }}
                                </td>

                                <td data-label="@lang('ACTION')">
                                    <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn--base btn--sm border-none">
                                        <i class="las la-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
            <div class="row">
                <div class="col-lg-12">
                    @if($supports->hasPages())
                        <div class="text-end py-4">
                            {{ paginateLinks($supports) }}
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
@endsection
