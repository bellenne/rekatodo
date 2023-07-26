<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Список дел</title>
    <link rel="stylesheet" href="{{asset("bootstrap/css/bootstrap.css")}}">
    <link rel="stylesheet" href="{{asset("style.css")}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css'>
    <script src="{{asset("bootstrap/js/bootstrap.js")}}"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-1">
    <a class="navbar-brand" href="#">ToDo</a>
    <button class="navbar-toggler" type="button" id="mobile-menu-button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav  flex-grow-1">
            <li class="nav-item active">
                <a class="nav-link" href="{{route("index")}}">Мои списки</a>
            </li>
        </ul>
        <ul class="navbar-nav ">
            <li class="nav-item ">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Выйти</a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </ul>
    </div>
</nav>
    <div class="container">
        <form action="{{route("search")}}" method="GET" class="row mt-3">
            <div class="col-10">
                <input type="text" name="title" class="form-control" placeholder="Поиск">
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary w-100">Поиск</button>
            </div>
        </form>
    </div>
    <div class="container mt-2">
        <form action="{{route("filter")}}" class="form-control" method="get">
        <h5 class="text-center">Поиск по тегам</h5>
            <div class="row ms-1" id="filter-tags-list">
            @foreach($tags as $tag)

                <div class="form-check col-auto">
                    <input class="form-check-input" @if(isset($tagsFind)) @foreach($tagsFind as $tagSelect) @if($tagSelect->id == $tag->id) checked @endif @endforeach @endif type="checkbox" name="tags[]" value="{{$tag->id}}" id="filter{{$tag->id}}">
                    <label class="form-check-label" for="filter{{$tag->id}}">{{$tag->name}}</label>
                </div>
            @endforeach
            </div>
            <button type="submit" class="btn btn-secondary w-100 mt-3" id="filterSearch">Искать</button>
        </form>
    </div>
    <div class="container mt-2">
        <a href="{{route("index")}}" class="btn btn-danger w-100">Сбросить все фильтры</a>
    </div>
    @yield("content")

</body>
</html>
