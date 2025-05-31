@extends($activeTemplate.'layouts.master')

@section('content')
        <div class="row gy-4 justify-content-center">
            <div class="col-lg-12 pb-30">
                <div class="dark-to-light-table">
                    <table class="table table--responsive--lg table-boarder">
                        <thead>
                            <tr>
                                <th>@lang('S.N')</th>
                                <th>@lang('Product Name')</th>
                                <th>@lang('Product Price')</th>
                                <th>@lang('View')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($wishlists as $item)
                                <tr>
                                    <td data-label="S.N">{{ $loop->iteration }}</td>
                                    <td data-label="Product Name">
                                        <a title="@lang('Details')" href="{{ getProductUrl(@$item->getProduct) }}" class="policy">
                                            {{ __(@$item->getProduct->title) }}
                                        </a>
                                    </td>
                                    <td data-label="Product Price">{{ showAmount(@$item->getProduct->price,2) }}</td>
                                    <td data-label="View">
                                        <div class="button--group">
                                            <a title="@lang('Delete')" href="{{ route('user.wishlist.delete', $item->id)}}" class="btn btn--sm btn--danger border-none">
                                                <i class="las la-trash"></i>
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


            </div>
            <div class="row">
                <div class="col-lg-12">
                    @if ($wishlists->hasPages())
                        <div class="text-end py-4">
                            {{ paginateLinks($wishlists) }}
                        </div>
                    @endif
                </div>

            </div>
        </div>






@endsection







