@extends($activeTemplate.'layouts.frontend')
@section('content')

    <section class="login-area py-60" >
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wyg">
                        @php
                            echo $cookie->data_values->description
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('style')
<style>
    .wyg ul{
        margin-bottom: 20px;
    }
</style>
@endpush

