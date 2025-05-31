@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
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
                                <td data-label="@lang('Name')">{{ __(@$data->getUser->fullname) }} <br>
                                    <a href="{{ route('admin.users.detail', $data->user_id) }}" target="_blank">{{ @$data->getUser->username }}</a>
                                </td>
                                <td data-label="@lang('Gym')">
                                    <a href="" target="_blank">{{ __($data->getProduct->title) }}</a>
                                </td>
                                <td data-label="@lang('Winning Date')">{{ showDateTime($data->created_at) }}</td>
                                <td data-label="@lang('Status')">
                                    @php echo @$data->statusBadge; @endphp
                                </td>
                                <td data-label="@lang('Action')">
                                    <button type="button" class="icon-btn bid-details" data-toggle="tooltip" data-original-title="@lang('Details')"
                                            data-user="{{ $data->getUser }}">
                                        <i class="las la-eye"></i>
                                    </button>
                                    <button type="button" class="icon-btn btn--success productDeliveredBtn" data-toggle="tooltip" data-original-title="@lang('Delivered')" data-id="{{ $data->id }}" {{ $data->status ? 'disabled':'' }}>
                                        <i class="las la-check"></i>
                                    </button>
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
            @if ($winners->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($winners) }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- User information modal --}}
<div id="bidModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('User Information')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                   <div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Name')
                                <span class="user-name"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Mobile')
                                <span class="user-mobile"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Email')
                                <span class="user-email"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Address')
                                <span class="user-address"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('State')
                                <span class="user-state"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Zip Code')
                                <span class="user-zip"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('City')
                                <span class="user-city"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Country')
                                <span class="user-country"></span>
                            </li>
                        </ul>
                   </div>
                   <input type="hidden" name="bid_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--close btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Product Delivered Confirmation --}}
<div id="productDeliveredModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Product Delivered Confirmation')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Is the product delivered')</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-block">@lang('Yes')</button>
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
            $('.bid-details').on( 'click', function(){
                var modal = $('#bidModal');
                var user  = $(this).data().user;
                modal.find('.user-name').text(user.firstname+' '+user.lastname);
                modal.find('.user-mobile').text(user.mobile);
                modal.find('.user-email').text(user.email);
                modal.find('.user-address').text(user.address.address);
                modal.find('.user-state').text(user.address.state);
                modal.find('.user-zip').text(user.address.zip);
                modal.find('.user-city').text(user.address.city);
                modal.find('.user-country').text(user.address.country);
                modal.modal('show');
            });

            $('.productDeliveredBtn').on( 'click', function(){
                var modal = $('#productDeliveredModal');
                modal.find('[name=id]').val($(this).data('id'));
                modal.modal('show');

            });

            $('#bidModal').on('hidden.bs.modal', function () {
                $('#bidModal form')[0].reset();
            });


        })(jQuery);
    </script>
@endpush
