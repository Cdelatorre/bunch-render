@extends($activeTemplate.'layouts.master')
@section('content')

    <div class="dashboard-boarder">
        <div class="row gy-4">
            <div class="col-lg-12">
                <form action="{{route('ticket.store')}}" method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Name')</label>
                                <input type="text" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}" class="form--control" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Email Address')</label>
                                <input type="email" name="email" value="{{@$user->email}}" class="form--control" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Subject')</label>
                                <input type="text" name="subject" value="{{old('subject')}}" class="form--control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label class="form-label">@lang('Priority')</label>
                                    <select name="priority" class="select form--control" required>
                                        <option value="" disabled selected>@lang('Select Priority')</option>
                                        <option value="3">@lang('High')</option>
                                        <option value="2">@lang('Medium')</option>
                                        <option value="1">@lang('Low')</option>
                                    </select>
                            </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label">@lang('Message')</label>
                            <textarea name="message" id="inputMessage" rows="6" class="form--control" required>{{old('message')}}</textarea>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-group right attachments">
                                <label for="fileInput" class="form--control mb-2">@lang('Attachments')</label>
                                <input type="file" multiple class="form--control" name="attachments[]" id="fileInput" data-max_length="5" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx">


                                <p>@lang('Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')</p>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="attachments-box" id="previewContainer">

                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn--base border-none" type="submit" id="recaptcha"><i class="fa fa-paper-plane"></i>&nbsp;@lang('Submit')</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }

        #previewContainer {
            display: none;
        }
        .attachments-box{
            display: inline-flex !important;
        }

    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
                const maxFiles = $('#fileInput').data('max_length');
                $('#fileInput').on('change', function(event) {
                    const previewContainer = $('#previewContainer');
                    previewContainer.empty();

                    const files = event.target.files;

                    if (files.length > maxFiles) {
                        $('#fileInput').val('');
                        Toast.fire({
                                icon: 'error',
                                title: 'You\'ve added maximum number of file'
                            });
                        return false;
                    }

                    for (const file of files) {
                        const attachmentItem = $('<div class="attachments-box__item"></div>');

                        if (file.type === 'application/pdf' || file.type === 'application/msword' || file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                            const icon = $('<i class="fas fa-file"></i>');
                            attachmentItem.append(icon);
                        } else {
                            const image = $('<img>');
                            image.attr('src', URL.createObjectURL(file));
                            attachmentItem.append(image);
                        }

                        const closeIcon = $('<div class="close-icon"><i class="las la-times delete-preview-image"></i></div>');
                        attachmentItem.append(closeIcon);

                        const deleteButton = attachmentItem.find('.delete-preview-image');
                        deleteButton.on('click', function() {
                            attachmentItem.remove();
                        });

                        previewContainer.append(attachmentItem);
                    }

                    previewContainer.css('display', 'block');
                });
        })(jQuery);
    </script>
@endpush
