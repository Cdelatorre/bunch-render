@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex flex-wrap justify-content-end">
                <form>
                    <div class="input-group search">
                        <input type="text" name="search" class="form-control form--control"
                            value="{{ request()->search }}" placeholder="@lang('Search by transactions')">
                        <button type="submit" class="input-group-text btn btn--base border-none"><i
                                class="las la-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="row gy-4 justify-content-center">
        <div class="col-lg-12 pb-30">
            <div class="dark-to-light-table">
                <table class="table table--responsive--lg table-boarder">
                    <thead>
                        <tr>
                            <th>@lang('S.N')</th>
                            <th>@lang('TRANSACTION ID')</th>
                            <th>@lang('GATEWAY NAME')</th>
                            <th>@lang('AMOUNT')</th>
                            <th>@lang('STATUS')</th>
                            <th>@lang('DATE')</th>
                            <th>@lang('View')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deposits as $deposit)
                            <tr>
                                <td data-label="@lang('S.N')">{{ $loop->iteration }}</td>
                                <td data-label="@lang('TRANSACTION ID')">{{ @$deposit->trx }}</td>
                                <td data-label="@lang('GATEWAY NAME')">{{ __($deposit->gateway?->name) }}</td>
                                <td data-label="@lang('AMOUNT')">
                                    <strong>{{ showAmount($deposit->final_amo) }}
                                        {{ __($deposit->method_currency) }}</strong>

                                    <strong title="@lang('Amount with charge')">
                                        {{ showAmount($deposit->amount + $deposit->charge) }} {{ __($general->cur_text) }}
                                    </strong>
                                </td>
                                <td data-label="@lang('STATUS')">@php echo $deposit->statusBadge @endphp</td>
                                <td data-label="@lang('DATE')">
                                    {{ showDateTime($deposit->created_at, 'd M, Y H:s:ia') }}
                                </td>
                                <td data-label="@lang('VIEW')">
                                    @php
                                        $details = $deposit->detail != null ? json_encode($deposit->detail) : null;
                                    @endphp

                                    <a href="javascript:void(0)"
                                        class="btn btn--base btn--sm border-none @if ($deposit->method_code >= 1000) detailBtn @else disabled @endif"
                                        @if ($deposit->method_code >= 1000) data-info="{{ $details }}" @endif
                                        @if ($deposit->status == 3) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif>
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
                    @if ($deposits->hasPages())
                        <div class="text-end py-4">
                            {{ paginateLinks($deposits) }}
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>

    {{-- APPROVE MODAL --}}
    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog custom--modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <span class="close" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <ul class="list-group userData mb-2">
                    </ul>
                    <div class="feedback"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--sm btn--base" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');

                var userData = $(this).data('info');
                var html = '';
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list--group--item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);


                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
