@extends($activeTemplate.'layouts.master')

@section('content')

    <div class="row gy-4 justify-content-center">
        <div class="col-12 mt-5">
            <h4 class="site-title">@lang('Gym Reviews')</h4>
        </div>
        <div class="col-lg-12 pb-30">
            <div class="dark-to-light-table">
                <table class="table table--responsive--lg table-boarder">
                    <thead>
                        <tr>
                            <th>@lang('S.N')</th>
                            <th>@lang('User Name')</th>
                            <th>@lang('Rating')</th>
                            {{-- <th>@lang('Status')</th> --}}
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reviews as $review)
                            <tr>
                                <td data-label="S.N">{{ $loop->iteration }}</td>
                                <td data-label="User Name">{{ @$review->review->lastname }} {{ @$review->review->firstname }}</td>
                                <td data-label="Rating">{{ @$review->rating }}</td>
                                {{-- <td data-label="Status">{!! @$review->statusBadge !!}</td> --}}
                                <td data-label="View">
                                    <div class="button--group">
                                        <a title="@lang('Details')" href="javascript:void(0)" class="btn btn--sm btn--base detailsBtn border-none" data-id="{{$review->id}}" data-message="{{ $review->message }}" data-status="{{ $review->status }}" >
                                            <i class="las la-eye"></i>
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
                    @if ($reviews->hasPages())
                        <div class="text-end py-4">
                            {{ paginateLinks($reviews) }}
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>

    {{-- REJECT MODAL --}}
    <div id="reviewDetailsModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog custom--modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('Message')!</h1>
                    <button type="button" class="btn--close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <form method="POST" action="{{ route('user.reviews.history.store') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <p class="review-message"></p>
                        </div>
                        {{-- <div class="list-group-wrap-bidding mt-3">
                            <select name="status" class="form-control form-select form-dark-select">
                                <option value="0">@lang('Disabled')</option>
                                <option value="1">@lang('Enabled')</option>
                            </select>
                        </div> --}}
                    </div>
                    {{-- <div class="modal-footer p-3">
                        <button type="submit" class="btn--sm btn btn--base" data-bs-dismiss="modal">@lang('Save')</button>
                    </div> --}}
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
            var modal = $('#reviewDetailsModal');
            var id = $(this).data('id');
            var status = $(this).data('status');
            var message = $(this).data('message');

            modal.find('[name=id]').val(id);
            modal.find('[name=status]').val(status);
            modal.find('.review-message').html(message);

            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush




