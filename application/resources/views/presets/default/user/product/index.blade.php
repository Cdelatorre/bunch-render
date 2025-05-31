@extends($activeTemplate.'layouts.master')

@section('content')

<div class="dashboard-boarder">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex flex-wrap justify-content-end">
                <form action="" method="GET" class="form-inline">
                    <div class="input-group search">
                        <input type="text" name="search" class="form-control form--control" placeholder="@lang('Search by Title')"
                            value="{{ old('search', request()->search) }}">
                        <button class="btn btn--base border-none input-group-text" type="submit"><i
                                class="fa fa-search"></i></button>
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
                            <th>@lang('Title')</th>
                            <th>@lang('Price')</th>
                            <th>@lang('Users')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td data-label="S.N">{{ $loop->iteration }}</td>
                            <td data-label="Title">{{ @$product->title }}</td>


                            <td data-label="Price">{{ showAmount(@$product->price, 2) }}</td>
                            <td data-label="Users">
                                {{ $product->bid_count }}
                            </td>
                            <td data-label="Status">
                                @php echo @$product->statusBadge; @endphp
                            </td>
                            <td data-label="Action">

                                <div class="button--group">


                                    <a title="@lang('Edit')"
                                        href="{{ route('user.product.edit', $product->id) }}"
                                        class="btn btn--sm btn--base border-none mb-1">
                                        <i class="las la-edit"></i>
                                    </a>


                                    @if($product->status != 0 && $product->status != 2 && $product->status != 3)
                                    <a title="@lang('List')"
                                        href="{{ route('user.product.users.list', $product->id) }}"
                                        class="btn btn--sm btn--base border-none mb-1">
                                        <i class="las la-list"></i>
                                    </a>


                                    <a title="@lang('View')" target="_blank"
                                        href="{{ getProductUrl($product) }}"
                                        class="btn btn--sm btn--base border-none mb-1">
                                        <i class="las la-eye"></i>
                                    </a>
                                    @endif

                                    @if($product->status == 3)
                                        <a href="javascript:void(0)" title="@lang('Reject')" class="btn btn--sm btn--danger border-none rejectBtn mb-1" data-id="{{ $product->id }}" data-reason="{{ $product->reason }}"><i class="fas fa-ban"></i>

                                        </a>
                                    @endif

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
            @if ($products->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($products) }}
            </div>
        @endif
        </div>
    </div>
</div>






    {{-- REJECT MODAL --}}
    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
          <div class="modal-dialog custom--modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Reject Product')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>


                    <div class="modal-body">
                        <p>@lang('Reason for Rejection'):</p>

                        <div class="form-group">
                            <textarea name="message" maxlength="255" class="form--control" rows="5"
                                required>{{ old('message') }}</textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--sm btn--base border-none" data-bs-dismiss="modal">@lang('Cancel')</button>
                    </div>

            </div>
        </div>
    </div>

@endsection




@push('script')
<script>
    (function ($) {
        "use strict";
        $('.rejectBtn').on('click', function () {
            var reason = $(this).data('reason');
            var modal = $('#rejectModal');
            modal.find('textarea[name=message]').val(reason);
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush




