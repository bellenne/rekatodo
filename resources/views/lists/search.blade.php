@extends("layouts.start")
@section("content")
    <div class="container mt-2">
        <h1 class="text-center">Список листов</h1>
        <div class="accordion d-flex flex-column-reverse" id="lists">
            @if($from != "share")
                <div class="accordion-item order-1">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdd">Добавить новый список</button>
                    </h2>
                    <div id="collapseAdd" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <form id="formAdd" action="{{route("list.create")}}" class="form-control p-2">
                                @csrf
                                <label for="title" class="form-label">Введите название списка</label>
                                <input type="text" name="title" class="form-control">
                                <input type="text" hidden value="{{Auth::user()->id}}" name="user_id" class="form-control">
                                <button type="submit" class="btn mt-2 w-100 btn-success">Добавить список</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            @foreach($lists as $list)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button @if($from != "share") collapsed @endif d-flex justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$list["id"]}}"  aria-expanded="false" aria-controls="collapseOne">
                            <h5 class="flex-grow-1 title" data-id="{{$list["id"]}}">{{$list["title"]}}</h5>
                            <div class="button-group">
                                <a href="#" class="btn-gr edit" onclick="listEdit(this)"><i class="fi fi-sr-pencil"></i></a>
                                <a href="#" class="btn-gr remove" onclick="listRemove(this)"><i class="fi fi-sr-trash"></i></a>
                                <a href="#" data-list-id="{{$list["id"]}}" onclick="listShare(this)" class="btn-gr share"><i class="fi fi-sr-share"></i></a>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse{{$list["id"]}}" class="accordion-collapse collapse @if($from == "share") show @endif" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @foreach($tasks as $task)
                                @if($task["list_id"] == $list["id"])
                                    <div class="task @if($task["isCompleted"]) completed @endif" onclick="taskClick(this)">
                                        @if($task["preview"] != NULL)
                                            <div class="task-preview">
                                                <a href="{{$task["preview"]}}" target="_blank" class="full-width">
                                                    <img src="{{$task["preview"]}}" alt="">
                                                </a>
                                            </div>
                                        @endif
                                        <div class="title-task">
                                            <h6 class="tags-list">
                                                @foreach($tags as $tag)
                                                    @if($tag->task_id == $task["id"])
                                                        <span onmouseleave="checkBoxML()" onmouseenter="checkBoxME()" class="badge {{$randomColor[rand(0,5)]}}">{{$tag->name}} <a
                                                                href="#" data-tag-id={{$tag->id}} class="tag-remove" onclick="tagRemove (this)"><i class="fi fi-sr-circle-xmark"></i></a></span>
                                                    @endif
                                                @endforeach
                                                <a href="#" class="add-tag badge text-bg-dark" onmouseleave="checkBoxML()" onmouseenter="checkBoxME()" onclick="addTag(this)" data-task-id="{{$task["id"]}}" ><i class="fi fi-br-plus-small"></i></a>
                                            </h6>
                                            <h2 class="title">{{$task["title"]}}</h2>
                                        </div>
                                        <div class="check-box" onmouseleave="checkBoxML()" onmouseenter="checkBoxME()">
                                            <input onchange="checkBoxChange(this)" type="checkbox" @if($task["isCompleted"]) checked @endif name="isCompleted" data-id="{{$task["id"]}}">
                                        </div>
                                        <div class="button-group" onmouseenter="checkBoxME()" onmouseleave="checkBoxML()" data-task-id-removed={{$task["id"]}}>
                                            <a href="#" class="task-btn task-edit" onclick="taskEdit (this)" data-task-title="{{$task["title"]}}" data-task-id-edit="{{$task["id"]}}"><i class="fi fi-sr-pencil"></i></a>
                                            <a href="#" class="task-btn task-remove" onclick="taskRemove (this)"><i class="fi fi-sr-trash"></i></a>
                                        </div>
                                    </div>

                                @endif
                            @endforeach
                            @if($from != "search")
                                <a href="#" class="addNewTask" onclick="addNewTask(this)" data-list-id="{{$list["id"]}}">
                                    <div class="task">
                                        <div class="task-preview">
                                            <h1><i class="fi fi-sr-square-plus"></i></h1>
                                        </div>
                                        <div class="title-task" style="margin-bottom: 0">
                                            <h5 class="title">Добавить новый пункт</h5>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal" id="copyModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Поделиться</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Ссылка на ваш лист скопирована</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактирование</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEdit" class="form-control">
                        @csrf
                        <label for="title" class="form-label">Введите новое название списка</label>
                        <input type="text" id="titleEdit" name="title" class="form-control">
                        <input type="text" id="IdEdit" hidden name="id"  class="form-control">
                        <input type="text" id="userId" hidden name="user_id" value="{{Auth::user()->id}}" class="form-control">
                        <button type="submit" class="btn mt-2 w-100 btn-success">Сохранить</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="addTagModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавить тег</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTagAdd" class="form-control">
                        @csrf
                        <label for="title" class="form-label">Введите тег</label>
                        <input type="text" id="name" name="name" class="form-control">
                        <input type="text" id="task_id" hidden name="task_id"  class="form-control">
                        <button type="submit" class="btn mt-2 w-100 btn-success">Сохранить</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="addTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавить задачу</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="taskAdd" action="{{route("task.create")}}" enctype="multipart/form-data" class="form-control">
                        @csrf
                        <label for="title" class="form-label">Задача</label>
                        <input type="text" required id="titleEdit" name="title" class="form-control">
                        <div class="mt-2 mb-2">
                            <label for="formFile" class="form-label">Загрузить изображение</label>
                            <input class="form-control" accept="image/*" type="file" name="preview" id="formFile">
                        </div>
                        <input type="text" id="username" hidden name="user" value="{{Auth::user()->name}}" class="form-control">
                        <input type="text" id="listId" hidden name="list_id" class="form-control">
                        <button type="submit" class="btn mt-2 w-100 btn-success">Сохранить</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактирование задачи</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="taskEditAll" action="{{route("task.edit.all")}}" enctype="multipart/form-data" class="form-control">
                        @csrf
                        <label for="title" class="form-label">Задача</label>
                        <input type="text" required id="titleTaskEdit" name="title" class="form-control">
                        <div class="container mt-3" id="imgBLock">
                            <img src="" alt="" id="taskEditImg" class="task-edit-img">
                            <button class="btn btn-danger" id="removePreview" data-task-id-img="">Удалить</button>
                        </div>
                        <div class="mt-2 mb-2" >
                            <label for="formFile" class="form-label">Загрузить изображение</label>
                            <input class="form-control" accept="image/*" type="file" name="preview" id="formFileTaskEdit">
                        </div>
                        <input type="text" id="task-id-edit" hidden name="task_id" class="form-control">
                        <input type="text" id="task-user-edit" hidden name="user" value="{{Auth::user()->name}}" class="form-control">
                        <button type="submit" class="btn mt-2 w-100 btn-success">Сохранить</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" id="openModal" hidden class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#copyModal"></button>
    <button type="button" id="openModalEdit" hidden class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal"></button>
    <button type="button" id="openModalAddTask" hidden class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal"></button>
    <button type="button" id="openModalAddTag" hidden class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTagModal"></button>
    <button type="button" id="openModalEditTask" hidden class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal"></button>

    <script>
        function checkBoxME(){
            $(".task").removeAttr("onclick");
        }
        function checkBoxML() {
            $(".task").attr("onclick","taskClick(this)");
        }
        function taskClick(e) {
            $(e).children(".check-box").children("input").click();
        }
        function checkBoxChange (e) {
            let isChecked;
            if ($(e).is(':checked')) {
                isChecked = 1;
                $(e).parent().parent().addClass("completed");
            }else{
                isChecked = 0;
                $(e).parent().parent().removeClass("completed");
            }
            let data = {"_token": "{{csrf_token()}}", "id": $(e).attr("data-id"), "isCompleted": isChecked, "action":"completed"};
            $.ajax({
                url: "{{route("task.edit")}}",
                method: 'get',
                dataType: 'json',
                data: data,
                success: function (data) {
                    // console.log(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

        function addNewTask (ths) {
            $("#listId").val($(ths).attr("data-list-id"));
            $("#openModalAddTask").click();
        }
        function taskRemove (e) {
            event.preventDefault();
            let data ={"_token":"{{csrf_token()}}", "id":$(e).parent().attr("data-task-id-removed")};
            $.ajax({
                url: "{{route("task.remove")}}",
                method: 'delete',
                dataType: 'json',
                data: data,
                success: function (data) {
                    if(data["status"]==200){
                        $(`[data-task-id-removed=${data["task_id"]}]`).parent().remove();
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        function taskEdit (e) {
            event.preventDefault();
            $("#titleTaskEdit").val($(e).attr("data-task-title"));
            $("#task-id-edit").val($(e).attr("data-task-id-edit"));
            $("#removePreview").attr("data-task-id-img", $(e).attr("data-task-id-edit"));
            if($(e).parent().parent().children(".task-preview").length > 0){
                $("#taskEditImg").parent().css("display","block")
                $("#taskEditImg").attr("src", $(e).parent().parent().children(".task-preview").children("a").children("img").attr("src"));
            }else{
                $("#taskEditImg").parent().css("display","none");
            }
            $("#openModalEditTask").click();
        }
        $("#removePreview").click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{route("task.edit")}}",
                method: 'get',
                dataType: 'json',
                data: {"id":$("#removePreview").attr("data-task-id-img"), "action":"imgDelete"},
                success: function (data) {
                    $("#imgBLock").css("display","none");
                    $("#imgBLock").css("display","none");
                    $(`[data-task-id-removed=${data["id"]}]`).parent().children(".task-preview").remove();
                    console.log(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        function listEdit (e) {
            $("#titleEdit").val($(e).parent().parent().children("h5").text());
            $("#IdEdit").val($(e).parent().parent().children("h5").attr("data-id"));
            $("#openModalEdit").click();
        }
        function listRemove (e) {
            let data = {"_token":'{{csrf_token()}}', "id": $(e).parent().parent().children("h5").attr("data-id")};
            $.ajax({
                url: "{{route("list.remove")}}",
                method: 'delete',
                dataType: 'json',
                data: data,
                success: function (data) {
                    console.log(data);
                    if(data["status"] == 200){
                        reloadContent($("#"+data["id"]).parent(), 'remove');
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        function listShare (e) {
            $.ajax({
                url: "{{route("shareGetLink")}}",
                method: 'get',
                dataType: 'json',
                data: {"_token": "{{ csrf_token() }}", "list_id": $(e).attr("data-list-id"), "user_id": {{Auth::user()->id}}},
                success: function (data) {
                    copyLink(data);
                    $("#openModal").click();
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

        function addTag (e) {
            $("#openModalAddTag").click();
            $("#task_id").val($(e).attr("data-task-id"));
        }
        function tagRemove (e) {
            let data = {"_token":"{{csrf_token()}}", "id": $(e).attr("data-tag-id")};
            $.ajax({
                url: "{{route("tag.remove")}}",
                method: 'delete',
                dataType: 'json',
                data: data,
                success: function (data) {
                    if(data["status"]==200){
                        $(`[data-tag-id=${data["tag_id"]}]`).parent().remove();
                        checkBoxML();
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

        function copyLink(copytext) {
            var tempInput = document.createElement("input");
            tempInput.value = copytext;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
        }

        $("#formEdit").submit(function (e) {
            e.preventDefault();
            var data = $("#formEdit").serializeArray();
            $.ajax({
                url: "{{route("list.edit")}}",
                method: 'get',
                dataType: 'json',
                data: data,
                success: function (data) {
                    console.log(data);
                    reloadContent(data, "edit");
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
        $("#formAdd").submit(function (e) {
            e.preventDefault();
            var data = $("#formAdd").serializeArray();
            $.ajax({
                url: "{{route("list.create")}}",
                method: 'get',
                dataType: 'json',
                data: data,
                success: function (data) {
                    // copyLink(data);
                    // $("#openModal").click();
                    console.log(data);
                    reloadContent(data, 'add');
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
        $("#taskAdd").submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);
            $.ajax({
                url: "{{route("task.create")}}",
                method: 'post',
                contentType:false,
                processData:false,
                dataType: 'json',
                data: data,
                success: function (data) {
                    reloadList(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
        $("#formTagAdd").submit(function (e) {
            e.preventDefault();
            let data = $(this).serializeArray();
            $.ajax({
                url: "{{route("tag.create")}}",
                method: 'get',
                dataType: 'json',
                data: data,
                success: function (data) {
                    reloadTags(data["name"],data["task_id"], data["randomColor"], data["id"]);
                    console.log(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
        $("#taskEditAll").submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);

            $.ajax({
                url: "{{route("task.edit.all")}}",
                method: 'post',
                contentType:false,
                processData:false,
                dataType: 'json',
                data: data,
                success: function (data) {
                    // console.log( );
                    if($(`[data-task-id-removed=${data["id"]}]`).parent().children(".task-preview").length ==0 && data["previewExist"] == true){
                        $(`[data-task-id-removed=${data["id"]}]`).parent().children(".title-task").before(
                            '<div class="task-preview">'+
                            `<a href="${data["data"]["preview"]}" target="_blank" class="full-width">`+
                            `<img src="${data["data"]["preview"]}" alt="">`+
                            '</a>'+
                            '</div>'
                        );
                        $("#imgBLock img").attr("src", data["data"]["preview"]);
                        $("#imgBLock").css("display","block");
                    }else{
                        if(data["previewExist"] == true) {
                            $("#taskEditImg").attr("src", data["data"]["preview"]);
                            $(`[data-task-id-removed=${data["id"]}]`).parent().children(".task-preview").children("a").attr("href", data["data"]["preview"]);
                            $(`[data-task-id-removed=${data["id"]}]`).parent().children(".task-preview").children("a").children("img").attr("src", data["data"]["preview"]);
                        }else{
                            $(`[data-task-id-removed=${data["id"]}]`).parent().children(".task-preview").remove();
                        }
                    }
                    $(`[data-task-id-removed=${data["id"]}]`).parent().children(".title-task").children(".title").text(data["data"]["title"]);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });


        function reloadContent(data, action) {
            if(action == "edit"){
                $(`[data-id=${data["id"]}]`).text(data["title"]);
                $(".btn-close").click();
            }else if(action == "remove"){
                data.remove();
            }else if(action == "add"){
                $(".accordion").append(
                    '<div class="accordion-item">'+
                    '<h2 class="accordion-header">'+
                    '<button class="accordion-button collapsed d-flex justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'+data["id"]+'"  aria-expanded="false" aria-controls="collapseOne">'+
                    '<h5 class="flex-grow-1 title" data-id="'+data["id"]+'">'+data["title"]+'</h5>'+
                    '<div class="button-group">'+
                    '<a href="#" class="btn-gr edit" onclick="listEdit(this)"><i class="fi fi-sr-pencil"></i></a>'+
                    '<a href="#" class="btn-gr remove" onclick="listRemove(this)"><i class="fi fi-sr-trash"></i></a>'+
                    '<a href="#" data-list-id="'+data["id"]+'" onclick="listShare(this)" class="btn-gr share"><i class="fi fi-sr-share"></i></a>'+
                    '</div>'+
                    '</button></h2>'+
                    '<div id="collapse'+data["id"]+'" class="accordion-collapse collapse" data-bs-parent="#accordionExample">'+
                    '<div class="accordion-body">'+
                    '<a href="#" class="addNewTask" onclick="addNewTask(this)" data-list-id="'+data["id"]+'">'+
                    '<div class="task">'+
                    '<div class="task-preview">'+
                    '<h1><i class="fi fi-sr-square-plus"></i></h1>'+
                    '</div>'+
                    '<div class="title-task" style="margin-bottom: 0">'+
                    '<h5 class="title">Добавить новый пункт</h5>'+
                    '</div>'+
                    '</div>'+
                    '</a>'+
                    '</div>'+
                    '</div>'+
                    '</div>'
                );
            }

        }
        function reloadList(data) {
            if(data['preview'] != null){
                $("#collapse"+data["list_id"]+" .accordion-body .addNewTask").before(
                    '<div class="task" onclick="taskClick(this)">'+
                    '<div class="task-preview">'+
                    '<a href="'+data["preview"]+'" target="_blank" class="full-width">'+
                    '<img src="'+data["preview"]+'" alt="">'+
                    '</a>'+
                    '</div>'+
                    '<div class="title-task">'+
                    '<h6 class="tags-list">'+
                    '<a href="#" onmouseleave="checkBoxML()" onmouseenter="checkBoxME()" class="add-tag badge text-bg-dark" data-task-id="'+data["id"]+'" ><i class="fi fi-br-plus-small"></i></a>'+
                    '</h6>'+
                    '<h2 class="title">'+data["title"]+'</h2></div>'+
                    '<div class="check-box" onmouseleave="checkBoxML()" onmouseenter="checkBoxME()">'+
                    '<input onchange="checkBoxChange(this)" type="checkbox" name="isCompleted" data-id="'+data["id"]+'">'+
                    '</div>'+
                    '<div class="button-group" onmouseleave="checkBoxML()" onmouseenter="checkBoxME()" data-task-id-removed="'+data["id"]+'">'+
                    '<a href="#" onclick="taskEdit (this)" class="task-btn task-edit" data-task-title="'+data["title"]+'" data-task-id-edit="'+data["id"]+'"><i class="fi fi-sr-pencil"></i></a>'+
                    '<a href="#" onclick="taskRemove (this)" class="task-btn task-remove"><i class="fi fi-sr-trash"></i></a>'+
                    '</div>'+
                    '</div>'
                );
            }else{
                $("#collapse"+data["list_id"]+" .accordion-body .addNewTask").before(
                    '<div class="task" onclick="taskClick(this)">'+
                    '<div class="title-task">'+
                    '<h6 class="tags-list">'+
                    '<a href="#" onmouseleave="checkBoxML()" onmouseenter="checkBoxME()" class="add-tag badge text-bg-dark" data-task-id="'+data["id"]+'" data-task-id-edit="'+data["id"]+'"><i class="fi fi-br-plus-small"></i></a>'+
                    '</h6>'+
                    '<h2 class="title">'+data["title"]+'</h2></div>'+
                    '<div class="check-box" onmouseleave="checkBoxML()" onmouseenter="checkBoxME()">'+
                    '<input onchange="checkBoxChange(this)" type="checkbox" name="isCompleted" data-id="'+data["id"]+'">'+
                    '</div>'+
                    '<div class="button-group" onmouseleave="checkBoxML()" onmouseenter="checkBoxME()" data-task-id-removed='+data["id"]+'>'+
                    '<a href="#" onclick="taskEdit (this)" class="task-btn task-edit" data-task-title="'+data["title"]+'" data-task-id-edit="'+data["id"]+'"><i class="fi fi-sr-pencil"></i></a>'+
                    '<a href="#" onclick="taskRemove (this)" class="task-btn task-remove"><i class="fi fi-sr-trash"></i></a>'+
                    '</div>'+
                    '</div>'
                );
            }
        }
        function reloadTags(text, task_id, randomColor, id) {
            let rand = Math.floor(Math.random()*6);
            $(`[data-task-id=${task_id}]`).before('<span class="badge '+randomColor[rand]+'">'+text+
                '<a href="#" onmouseleave="checkBoxML()" onmouseenter="checkBoxME()" data-tag-id="'+id+'" class="tag-remove" onclick="tagRemove (this)"><i class="fi fi-sr-circle-xmark"></i></a></span>&nbsp;');
            $("#filter-tags-list").append(
                '<div class="form-check col-auto">'+
                '<input class="form-check-input" type="checkbox" name="tags[]" value="'+id+'" data-filter-tag="'+id+'" id="filter'+id+'">'+
                '<label class="form-check-label" for="filter'+id+'">'+text+'</label>'+
                '</div>'
            );
        }

    </script>
@endsection
