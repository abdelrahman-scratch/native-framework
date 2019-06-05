<div class="container py-4">
    @php
        $errors = \Framework\Session::flash("errors");
    @endphp
    @if(isset($errors) && !empty($errors))
        @foreach($errors as $error)
            <div class="alert alert-danger" role="alert">
                {{$error}}
            </div>
        @endforeach

    @endif
</div>