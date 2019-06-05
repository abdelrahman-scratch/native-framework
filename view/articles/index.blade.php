@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            @foreach($articles as $articleItem)
                <h1>{{$articleItem->title}}</h1>
                <p>
                    {{$articleItem->content}}
                </p>
                <div>
                    <span class="badge badge-secondary">Posted {{$articleItem->created_at}}</span>
                    <span class="badge badge-primary">Author: {{$articleItem->name}}</span>
                </div>
            @endforeach
        </div>
        <nav aria-label="Page navigation example ">
            <ul class="pagination py-4">
                @for($i=1; $i<=$pagesCount; $i++)
                    <li class="page-item"><a class="page-link" href="/articles?page={{$i}}">{{$i}}</a></li>
                @endfor
            </ul>
        </nav>
    </div>

@endsection
