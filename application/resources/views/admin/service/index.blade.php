@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10">
            <div class="card-body p-0">
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                        <tr>
                            <th>@lang('S.N.')</th>
                            {{-- <th>@lang('Parent')</th> --}}
                            <th>@lang('Name')</th>
                            {{-- <th>@lang('Products')</th> --}}
                            <th>@lang('Status')</th>
                            <th>@lang('Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($services as $service)
                        <tr>
                            <td data-label="@lang('S.N')">{{ $services->firstItem() + $loop->index }}</td>
                            {{-- <td data-label="@lang('Parent')">@php echo serviceTitle($service->parent); @endphp</td> --}}
                            <td data-label="@lang('Name')">{{ __($service->name) }}</td>
                            {{-- <td data-label="@lang('Products')">{{ productCount($service->id) }}</td> --}}
                            <td data-label="@lang('Status')">
                                @php echo @$service->statusBadge; @endphp
                            </td>
                            <td data-label="@lang('Action')">
                                <button type="button" class="icon-btn updateBtn" data-id="{{ $service->id }}" data-name="{{ __($service->name) }}" data-parent="{{ $service->parent }}" data-status="{{ $service->status }}" data-toggle="tooltip"  data-original-title="@lang('Edit')">
                                    <i class="las la-list text-shadow"></i>
                                </button>
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
            @if($services->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($services) }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Category modal --}}
<div id="serviceModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.service.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Name')<span class="text-danger">*</span></label>
                        <div class="input-group has_append">
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                    <input type="text" name="parent" class="form-control d-none" value="0">
                    <div class="form-group">
                        <label  for="name"> @lang('Status'):</label>
                        <select name="status" class="form-control" id="statusSelect">
                            <option value="0">@lang('Inactive')</option>
                            <option value="1">@lang('Active')</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
    <button type="button" class="btn btn-sm btn--primary box--shadow1 text--small addBtn"><i class="fa fa-fw fa-plus"></i>
        @lang('Add New')
    </button>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            var modal   = $('#serviceModal');
            var action  = `{{ route('admin.service.store') }}`;
            var editAction  = `{{ route('admin.service.edit') }}`;

            $('.addBtn').on( 'click', function(){
                modal.find('.modal-title').text("@lang('Add Service')");
                modal.find('form').attr('action', action);
                $('#parentSelect').attr('disabled', false);
                modal.modal('show');
            });

            modal.on('shown.bs.modal', function (e) {
                $(document).off('focusin.modal');
            });

            $('.updateBtn').on( 'click', function () {
                var data = $(this).data();
                window.location.href = `${editAction}/${data.id}`;
            })

            modal.on('hidden.bs.modal', function () {
                modal.find('form')[0].reset();
            });
        })(jQuery);
    </script>
@endpush
