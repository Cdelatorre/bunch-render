@extends($activeTemplate.'layouts.master')

@section('content')

    <div class="row gy-4 justify-content-center">
        <div class="col-12 mt-5">
            <h4 class="site-title">@lang('Gym Visits')</h4>
        </div>
        <div class="col-lg-12 pb-30">
            <div class="dark-to-light-table">
                <table class="table table--responsive--lg table-boarder">
                    <thead>
                        <tr>
                            <th>@lang('S.N')</th>
                            <th>@lang('User Name')</th>
                            <th>@lang('Email')</th>
                            <th>@lang('Phone')</th>
                            <th>@lang('Visit Time')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productUsers as $productUser)
                            <tr>
                                <td data-label="S.N">{{ $loop->iteration }}</td>
                                <td data-label="User Name">{{ @$productUser->user->lastname }} {{ @$productUser->user->firstname }}</td>
                                <td data-label="Email">{{ @$productUser->user->email }}</td>
                                <td data-label="Phone">+ {{ @$productUser->user->mobile }}</td>
                                <td data-label="Visit Time">
                                    {{ showDateTime($productUser->visit_time, 'd M, Y H:s A') }}
                                </td>
                                <td data-label="Status">{!! @$productUser->statusBadge !!}</td>
                                <td data-label="View">
                                    <div class="button--group">
                                        <a title="@lang('Details')" href="javascript:void(0)" class="btn btn--sm btn--base detailsBtn border-none" data-id="{{$productUser->id}}" data-status="{{ $productUser->status }}" >
                                            <i class="las la-edit"></i>
                                        </a>
                                    </div>
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
                    @if ($productUsers->hasPages())
                        <div class="text-end py-4">
                            {{ paginateLinks($productUsers) }}
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>

    {{-- REJECT MODAL --}}
    <div id="requestDetailsModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog custom--modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('Update Information')!</h1>
                    <button type="button" class="btn--close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <form method="POST" action="{{ route('user.request.history.store') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="list-group-wrap-bidding mt-3">
                            <select name="status" class="form-control form-select form-dark-select">
                                <option value="requested">@lang('Requested')</option>
                                <option value="scheduled">@lang('Scheduled')</option>
                                <option value="cancelled">@lang('Cancelled')</option>
                                <option value="completed">@lang('Completed')</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer p-3">
                        <button type="submit" class="btn--sm btn btn--base" data-bs-dismiss="modal">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



@push('script')
<script>
    (function ($) {
        "use strict";
        $('.detailsBtn').on('click', function () {
            var modal = $('#requestDetailsModal');
            var id = $(this).data('id');
            var status = $(this).data('status');

            modal.find('[name=id]').val(id);
            modal.find('[name=status]').val(status);

            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush




