@extends($activeTemplate.'layouts.'.$layout)

@section('content')

<section class="conact-area {{ $layout == 'master' ? '' : 'py-60'}}">
    <div class="{{ $layout == 'master' ? '' : 'container'}}">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="view-ticket-wrap">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                        <h5 class="mt-0">
                            @php echo $myTicket->statusBadge; @endphp
                            [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
                        </h5>
                        @if($myTicket->status != 3 && $myTicket->user)
                        <button class="btn btn-danger close-button btn-sm confirmationBtn" type="button" data-question="@lang('Are you sure to close this ticket?')" data-action="{{ route('ticket.close', $myTicket->id) }}"><i class="fa fa-lg fa-times-circle"></i>
                        </button>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($myTicket->status != 4)
                            <form method="post" action="{{ route('ticket.reply', $myTicket->id) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="col-sm-12">
                                    <label class="form-label">@lang('Message')</label>
                                    <textarea name="message" id="inputMessage" rows="6" class="form--control" required>{{old('message')}}</textarea>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group right attachments mb-3">
                                        <input type="file" multiple class="form--control mb-2" name="attachments[]" id="fileInput" data-max_length="5" placeholder="@lang('Attachments')">
                                        <p>@lang('Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')</p>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="attachments-box" id="previewContainer">

                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <button class="btn btn--base border-none" type="submit" id="recaptcha"><i class="fa fa-paper-plane"></i>&nbsp;@lang('Reply')</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>



























                <div class=" mt-4">
                    <div class="card-body">
                        @foreach($messages as $message)
                            @if($message->admin_id == 0)
                                <div class="row user-ticket-warap  my-3 py-3 mx-2">
                                    <div class="col-md-3 border-end text-end">
                                        <h5 class="my-3">{{ $message->ticket->name }}</h5>
                                    </div>
                                    <div class="col-md-9">
                                        <p class="text-muted fw-bold my-3">
                                            @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                        <p>{{$message->message}}</p>
                                        @if($message->attachments->count() > 0)
                                            <div class="mt-2">
                                                @foreach($message->attachments as $k=> $image)
                                                    <a href="{{route('ticket.download',encrypt($image->id))}}" class="me-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="row admin-ticket-warap my-3 py-3 mx-2">
                                    <div class="col-md-3 border-end text-end">
                                        <h5 class="my-3">{{ $message->admin->name }}</h5>
                                        <p class="lead text-muted">@lang('Staff')</p>
                                    </div>
                                    <div class="col-md-9">
                                        <p class="text-muted fw-bold my-3">
                                            @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                        <p>{{$message->message}}</p>
                                        @if($message->attachments->count() > 0)
                                            <div class="mt-2">
                                                @foreach($message->attachments as $k=> $image)
                                                    <a href="{{route('ticket.download',encrypt($image->id))}}" class="me-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

    <x-confirmation-modal></x-confirmation-modal>
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

            $(document).ready(function() {
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
            });
        })(jQuery);
    </script>
@endpush
