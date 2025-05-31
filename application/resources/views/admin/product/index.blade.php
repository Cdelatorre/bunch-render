@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex flex-wrap gap-2 justify-content-end">
                <form action="" method="GET" class="form-inline ml-1">
                    <div class="input-group justify-content-end">
                        <input type="text" name="search" class="form-control" placeholder="@lang('Search by Title')"
                            value="{{ old('search', request()->search) }}">
                        <button class="btn btn--primary input-group-text" type="submit"><i
                                class="fa fa-search"></i></button>
                    </div>
                </form>
                <a href="{{ route('admin.product.export') }}" class="btn btn--primary box--shadow1 btn-export">
                    <i class="fas fa-cloud-download-alt"></i>@lang('Export Excel')
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('S.L')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Owner')</th>
                                    {{-- <th>@lang('Price')</th> --}}
                                    <th>@lang('Users')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('admin.product.edit', $product->id) }}">
                                                {{ @$product->title }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($product->user_id != 0)
                                                {{ @$product->user->fullname }}
                                                <br><a
                                                    href="{{ route('admin.users.detail', $product->user->id) }}">{{ '@' . $product->user->username }}</a>
                                            @else
                                                @lang('Admin')
                                            @endif
                                        </td>

                                        {{-- <td>{{ showAmount(@$product->price, 2) }}</td> --}}
                                        <td>
                                            {{ $product->bid_count }}
                                        </td>
                                        <td>
                                            @php echo @$product->statusBadge; @endphp
                                        </td>
                                        <td class="d-flex justify-content-end">

                                            <div class="button--group">
                                                <a title="@lang('Edit')"
                                                    href="{{ route('admin.product.edit', $product->id) }}"
                                                    class="btn btn-sm btn--primary">
                                                    <i class="las la-edit"></i>
                                                </a>
                                                <button title="@lang('Remove')" class="btn btn-sm btn--danger confirmationBtn"
                                                    data-action="{{ route('admin.product.remove',$product->id) }}"
                                                    data-question="@lang('Are you sure to remove this item?')">
                                                    <i class="la la-trash"></i>
                                                </button>

                                                <a title="@lang('List')"
                                                    href="{{ route('admin.product.users.list', $product->id) }}"
                                                    class="btn btn-sm btn--primary">
                                                    <i class="las la-list"></i>
                                                </a>

                                                @if($product->status == 0)
                                                    <a title="@lang('Approved')" class="btn btn-sm btn--primary confirmationBtn"
                                                        data-question="@lang('Are you sure to approved this auction?')"
                                                        data-action="{{ route('admin.product.approve', $product->id) }}" data-id="{{$product->id}}">
                                                        <i class="las la-check-square"></i>
                                                    </a>
                                                @endif

                                                @if($product->status == 0 || $product->status == 3)
                                                <a href="javascript:void(0)" title="@lang('Reject')" class="btn btn-sm btn--danger rejectBtn" data-id="{{ $product->id }}" data-reason="{{ $product->reason }}"><i class="fas fa-ban"></i>
                                                </a>
                                                @endif
                                                <x-confirmation-modal></x-confirmation-modal>
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
                    <div class="row">
                        <div class="col-lg-12 pb-3">
                            <div class="card-footer py-4">
                                {{ paginateLinks($products) }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>





    {{-- REJECT MODAL --}}
<div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Reject Gym')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.product.reject')}}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to reject this autction')?</p>

                    <div class="form-group">
                        <label class="fw-bold mt-2">@lang('Reason for Rejection')</label>
                        <textarea name="message" maxlength="255" class="form-control" rows="5"
                            required>{{ old('message') }}</textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.product.create')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="fa fa-fw fa-plus"></i>
        @lang('Add New')
    </a>
@endpush


@push('script')
<script>
    (function ($) {
        "use strict";
        $('.rejectBtn').on('click', function () {
            var reason = $(this).data('reason');
            var modal = $('#rejectModal');
            modal.find('textarea[name=message]').val(reason);
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush




