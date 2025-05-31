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
                                <th>@lang('Icon')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Products')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td data-label="@lang('S.N')">{{ $categories->firstItem() + $loop->index }}</td>
                                <td data-label="@lang('Icon')">@php echo $category->icon; @endphp</td>
                                <td data-label="@lang('Name')">{{ __($category->name) }}</td>
                                <td data-label="@lang('Products')">{{ productCount($category->id) }}</td>
                                <td data-label="@lang('Status')">
                                    @php echo @$category->statusBadge; @endphp
                                </td>
                                <td data-label="@lang('Action')">
                                    <button type="button" class="icon-btn updateBtn" data-id="{{ $category->id }}" data-name="{{ __($category->name) }}" data-icon="{{ $category->icon }}" data-status="{{ $category->status }}" data-banner="{{ getImage(getFilePath('activity').'/'.@$category->banner) }}" data-toggle="tooltip"  data-original-title="@lang('Edit')">
                                        <i class="las la-pen text-shadow"></i>
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
                @if($categories->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($categories) }}
                </div>
                @endif
            </div>
        </div>
    </div>

{{-- Category modal --}}
<div id="categoryModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.category.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Name')<span class="text-danger">*</span></label>
                        <div class="input-group has_append">
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>@lang('Icon')<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control iconPicker icon" autocomplete="off"
                            name="icon" placeholder="@lang('Icone')..." required >
                            <span class="input-group-text  input-group-addon icon-preview" data-icon="las la-home"
                                role="iconpicker">
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>@lang('Banner')<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input name="image" type="file" class="file w-100" multiple id="fileInput" accept=".jpg, .png, .jpeg" />
                        </div>
                        <img class="banner" src="" style="height: 150px; width: 100%; object-fit: cover">
                    </div>

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


@push('style-lib')
    <link href="{{ asset('assets/admin/css/fontawesome-iconpicker.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/fontawesome-iconpicker.js') }}"></script>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            var modal   = $('#categoryModal');
            var action  = `{{ route('admin.category.store') }}`;

            $('.addBtn').on( 'click', function(){
                modal.find('.modal-title').text("@lang('Add Category')");
                modal.find('form').attr('action', action);
                modal.modal('show');
            });

            modal.on('shown.bs.modal', function (e) {
                $(document).off('focusin.modal');
            });

            $('.updateBtn').on( 'click', function () {
                var data = $(this).data();
                modal.find('.modal-title').text("@lang('Update Category')");
                modal.find('[name=name]').val($(this).data('name'));
                modal.find('[name=icon]').val($(this).data('icon'));
                modal.find('.banner').attr('src', $(this).data('banner'));

                $('#statusSelect').val($(this).data('status'));

                var icon = $(this).data('icon');
                modal.find('.icon-preview').html(icon);

                modal.find('form').attr('action', `${action}/${data.id}`);
                modal.modal('show');
            })

            modal.on('hidden.bs.modal', function () {
                modal.find('form')[0].reset();
            });

            $('.iconPicker').iconpicker().on('iconpickerSelected', function (e) {
                $(this).closest('.form-group').find('.iconpicker-input').val(`<i class="${e.iconpickerValue}"></i>`);
            });

        })(jQuery);
    </script>
@endpush
