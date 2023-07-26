@extends("layouts.start")
@section("content")
    <div class="container mt-2">
        <h1 class="text-center">Список дел пользователя {{$user}}</h1>
        <div class="accordion" id="lists">
{{--        @foreach($lists as $list)--}}
            <div class="accordion-item">
                <h2 class="accordion-header">

                    <div class="accordion-button">{{$list->title}}</div>
{{--                    <button class="accordion-button collapsed d-flex justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$list->id}}" aria-expanded="false" aria-controls="collapseOne">--}}
{{--                        <h5 class="flex-grow-1">{{$list->title}}</h5>--}}
{{--                        <a href="#" data-list-id="{{$list->id}}" class="share"><i class="fi fi-sr-share"></i></a>--}}
{{--                    </button>--}}
                </h2>
                <div id="collapse{{$list->id}}" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        @foreach($tasks as $task)
                            @if($task->list_id == $list->id)
                                <div class="task @if($task->isCompleted) completed @endif">
                                    @if($task->preview != NULL)
                                        <div class="task-preview">
                                            <a href="{{$task->preview}}" target="_blank" class="full-width">
                                                <img src="{{$task->preview}}" alt="">
                                            </a>
                                        </div>
                                    @endif
                                    <div class="title-task">
                                        <h6 class="tags-list">
                                            @foreach($tags as $tag)
                                                @if($tag->task_id == $task->id)
                                                    <span class="badge {{$randomColor[rand(0,6)]}}">{{$tag->name}}</span>
                                                @endif
                                            @endforeach
                                        </h6>
                                        <h2 class="title">{{$task->title}}</h2></div>
                                    <div class="check-box">
                                        <input type="checkbox" disabled @if($task->isCompleted) checked @endif name="isCompleted" id="{{$task->id}}">
                                    </div>
                                </div>

                            @endif
                        @endforeach

                    </div>
                </div>
            </div>
{{--        @endforeach--}}
        </div>
    </div>
@endsection
