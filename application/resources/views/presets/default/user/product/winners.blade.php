@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-lg-12 pb-30">
            <div class="dark-to-light-table">
                <table class="table table--responsive--lg table-boarder">
                    <thead>
                        <tr>
                            <th>@lang('S.N.')</th>
                            <th>@lang('Name')</th>
                            <th>@lang('Gym')</th>
                            <th>@lang('Winning Date')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($winners as $data)
                            <tr>
                                <td data-label="@lang('S.N')">{{ $loop->iteration }}</td>
                                <td data-label="@lang('Name')">{{ __($data->getUser->fullname) }} <br>
                                    <a href="{{ route('admin.users.detail', $data->getUser->id) }}"
                                        target="_blank">{{ $data->getUser->username }}</a>
                                </td>
                                <td data-label="@lang('Gym')">
                                    <a href="" target="_blank">{{ __($data->getProduct->title) }}</a>
                                </td>
                                <td data-label="@lang('Winning Date')">{{ showDateTime($data->created_at) }}</td>
                                <td data-label="@lang('Status')">
                                    @php echo @$data->statusBadge; @endphp
                                </td>
                                <td data-label="@lang('Action')">
                                    <a href="javascript:void(0)" title="@lang('Details')" data-original-title="@lang('Details')" data-user="{{ $data->getUser }}" class="btn btn--sm btn--base border-none bid-details mb-1">
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
                    @if ($winners->hasPages())
                        <div class="text-end py-4">
                            {{ paginateLinks($winners) }}
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>






    {{-- User information modal --}}
    <div id="bidModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog custom--modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Winner Information')</h5>
                    <button type="button" class="btn--close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">

                            <ul class="list-group">
                                <li class="list--group--item d-flex justify-content-between align-items-center">
                                    @lang('Name')
                                    <span class="user-name"></span>
                                </li>
                                <li class="list--group--item d-flex justify-content-between align-items-center">
                                    @lang('Mobile')
                                    <span class="user-mobile"></span>
                                </li>
                                <li class="list--group--item d-flex justify-content-between align-items-center">
                                    @lang('Email')
                                    <span class="user-email"></span>
                                </li>
                                <li class="list--group--item d-flex justify-content-between align-items-center">
                                    @lang('Address')
                                    <span class="user-address"></span>
                                </li>
                                <li class="list--group--item d-flex justify-content-between align-items-center">
                                    @lang('State')
                                    <span class="user-state"></span>
                                </li>
                                <li class="list--group--item d-flex justify-content-between align-items-center">
                                    @lang('Zip Code')
                                    <span class="user-zip"></span>
                                </li>
                                <li class="list--group--item d-flex justify-content-between align-items-center">
                                    @lang('City')
                                    <span class="user-city"></span>
                                </li>
                                <li class="list--group--item d-flex justify-content-between align-items-center">
                                    @lang('Country')
                                    <span class="user-country"></span>
                                </li>
                            </ul>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--base" data-bs-dismiss="modal">@lang('Close')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Product Delivered Confirmation --}}

@endsection


@push('script')
    <script>
        (function($) {
            "use strict";
            $('.bid-details').on( 'click', function() {
                var modal = $('#bidModal');
                var user = $(this).data().user;
                modal.find('.user-name').text(user.firstname + ' ' + user.lastname);
                modal.find('.user-mobile').text(user.mobile);
                modal.find('.user-email').text(user.email);
                modal.find('.user-address').text(user.address.address);
                modal.find('.user-state').text(user.address.state);
                modal.find('.user-zip').text(user.address.zip);
                modal.find('.user-city').text(user.address.city);
                modal.find('.user-country').text(user.address.country);
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
