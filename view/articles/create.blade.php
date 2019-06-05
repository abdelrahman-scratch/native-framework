@extends('layouts.app')

@section('content')
    <div class="container">

        <form action="/articles/store" method="post">
            <input type="hidden" name="{{\Framework\Constant::CSRF_TOKEN}}" value="{{\Framework\CSRFToken::generate()}}">
            <div class = "form-group">
                <label for = "name">Title</label>
                <input type = "text" class = "form-control" name="title" placeholder = "Article Title" required>
            </div>
            <div class = "form-group">
                <label for = "name">Body</label>
                <textarea class = "form-control" rows = "5" name="content" placeholder = "Article Body" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Create</button>
        </form>



    </div>
@endsection
