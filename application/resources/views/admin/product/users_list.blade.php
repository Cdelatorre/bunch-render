@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex flex-wrap justify-content-end">
                <form action="" method="GET" class="form-inline">
                    <div class="input-group justify-content-end">
                        <input type="text" name="search" class="form-control" placeholder="@lang('Search by Title')"
                            value="{{ old('search', request()->search) }}">
                        <button class="btn btn--primary input-group-text" type="submit"><i
                                class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Request Time')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($productUsers as $productUser)
                                    <tr>
                                        <td data-label="S.N">{{ $loop->iteration }}</td>
                                        <td data-label="Name">{{ @$productUser->user->fullname }}</td>
                                        <td data-label="Title">{{ @$productUser->product->title }}</td>
                                        <td data-label="Price">{{ showAmount(@$productUser->price, 2) }}</td>
                                        <td data-label="Request Time">
                                            {{ showDateTime($productUser->created_at, 'd M, Y H:s:ia') }}
                                        </td>
                                        @php
                                            /*  ───────────────────────────────────────────────────
                                                Si el producto no tiene imágenes aún, usamos
                                                un placeholder genérico (/uploads/product/default/placeholder.png).
                                                Ajusta la ruta/archivo a tu conveniencia.
                                                ─────────────────────────────────────────────────── */
                                            $image = $productUser->product->productImages->first();   // ← first() devuelve null si no hay filas

                                            if ($image) {
                                                $mainImageUrl = getImage(getFilePath('product') . '/' . $image->path . '/' . $image->image);
                                            } else {
                                                // fallback
                                                $mainImageUrl = asset('uploads/product/default/placeholder.png');
                                            }
                                        @endphp


                                        <td data-label="Action">
                                            <div class="button--group">
                                                <a title="@lang('Details')" href="javascript:void(0)" class="btn btn--sm btn--primary detailsBtn" data-bidder="{{ $productUser->user->fullname }}" data-price="{{ $productUser->price }}" data-time="{{showDateTime($productUser->created_at, 'd M, Y H:s:ia')}}" data-image="{{ $mainImageUrl }}">
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

                    @if ($productUsers->hasPages())
                        <div class="card-footer py-4">
                            {{ paginateLinks($productUsers) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>




    <div id="biddingDetailsModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog custom--modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('Request Information')!</h1>
                    <button type="button" class="btn--close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>

                    <div class="modal-body">
                        <img class="gig-img my-3"  width="100%" height="200px" src="{{ getImage(getFilePath('product') . '/'.@$product->path .'/' .@$product->image)}}" alt="@lang('Product Image')">

                        <h6 class="card-title">@lang('Product Information')</h6>
                        <div class="list-group-wrap-bidding">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>@lang('Name')</span>
                                    <span><a target="_blank" href="{{ getProductUrl($product) }}"> {{ __($product->title) }}</a></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>@lang('Price')</span>
                                    <span>{{showAmount($product->price, 0)}}</span>
                                </li>
                            </ul>
                        </div>
                        <h6 class="card-title">@lang('User Information')</h6>
                        <div class="list-group-wrap-bidding">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>@lang('Name')</span>
                                    <span class="bidder-bidder"></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>@lang('Price')</span>
                                    <span class="bidding-price"></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>@lang('Time')</span>
                                    <span class="bidding-time">{{showAmount($product->price, 0)}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">

                    <button type="reset" class="btn--sm btn btn--primary" data-bs-dismiss="modal">@lang('Close')</button>
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
                var modal = $('#biddingDetailsModal');
                modal.find('.bidding-price').text($(this).data('price'));
                modal.find('.bidding-time').text($(this).data('time'));
                modal.find('.bidder-bidder').text($(this).data('bidder'));
                modal.find('.gig-img').attr('src', $(this).data('image'));
                modal.modal('show');
            });
        })(jQuery);
    </script>
    @endpush

@push('breadcrumb-plugins')
    <a href="{{route('admin.product.create')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="fa fa-fw fa-plus"></i>
        @lang('Add New')
    </a>
@endpush
