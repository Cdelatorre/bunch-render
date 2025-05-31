@extends($activeTemplate.'layouts.master')
@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="show-filter mb-3 text-end">
            <button type="button" class="btn btn--base btn--sm border-none showFilterBtn btn-sm"><i class="las la-check"></i>
                @lang('Apply')</button>
        </div>
    </div>
    <div class="col-md-12">
        <div class="responsive-filter-card">
            <form>
                <div class="d-flex flex-wrap gap-4">
                    <div class="flex-grow-1">
                        <label>@lang('Transaction Number')</label>
                        <input type="text" name="search" value="{{ request()->search }}"
                            class="form--control">
                    </div>
                    <div class="flex-grow-1">
                        <label>@lang('Type')</label>
                        <select name="type" class="form--control select">
                            <option value="">@lang('All')</option>
                            <option value="+" @selected(request()->type == '+')>@lang('Plus')</option>
                            <option value="-" @selected(request()->type == '-')>@lang('Minus')</option>
                        </select>
                    </div>
                    <div class="flex-grow-1">
                        <label>@lang('Remark')</label>
                        <select class="form--control select" name="remark">
                            <option value="">@lang('Any')</option>
                            @foreach($remarks as $remark)
                            <option value="{{ $remark->remark }}" @selected(request()->remark ==
                                $remark->remark)>{{ __(keyToTitle($remark->remark)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-grow-1 align-self-end">
                        <button class="btn btn--base border-none w-100"><i class="las la-filter"></i>
                            @lang('Filter')</button>
                    </div>
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
                        <th>@lang('DATE')</th>
                        <th>@lang('TRANSACTION ID')</th>
                        <th>@lang('AMOUNT')</th>
                        <th>@lang('POST BALANCE')</th>
                        <th>@lang('DETAILS')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $trx)
                        <tr>
                            <td data-label="@lang('S.N')">{{ $loop->iteration }}</td>
                            <td data-label="@lang('DATE')">
                                {{ showDateTime($trx->created_at, 'd M, Y H:s:ia') }}
                                <br>{{ diffForHumans($trx->created_at)}}
                            </td>
                            <td data-label="@lang('TRANSACTION ID')">{{ @$trx->trx }}</td>
                            <td data-label="@lang('AMOUNT')" class="budget">
                                <span class="fw-bold @if($trx->trx_type == '+')text-success @else text-danger @endif">
                                    {{ $trx->trx_type }} {{showAmount($trx->amount)}} {{ $general->cur_text }}
                                </span>
                            </td>
                            <td data-label="@lang('POST BALANCE')" class="budget">
                                {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                            </td>

                            <td data-label="@lang('VIEW')">
                                {{ __($trx->details) }}
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
                @if($transactions->hasPages())
                    <div class="text-end py-4">
                        {{ paginateLinks($transactions) }}
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>

@endsection
