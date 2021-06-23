    @foreach($childs as $child)
            @if(count($child->childs))

                <div class="accordion-item">
                    <button class="accordion-button{{$child->parentId == NULL ? '' : ' collapsed'}}" aria-expanded="true" type="button" data-bs-toggle="collapse" data-bs-target="#tree-{{$child->id}}">
                        {{$child->title}}
                        <div class="icons ps-3">
                            <i onclick="_new({{$child->id}})" class="bi bi-file-earmark-plus"></i>
                            <i onclick='_edit({{$child->id}}, "{{$child->title}}")' class="bi bi-pencil-square"></i>
                            <i onclick='_delete({{$child->id}})' class="bi bi-file-earmark-x"></i>
                        </div>
                    </button>
                    <div id="tree-{{$child->id}}" class="accordion-collapse collapse{{$child->parentId == NULL ? ' show' : ''}}">
                        <div class="accordion-body">
                            @include('child',['childs' => $child->childs])
                        </div>
                    </div>
                </div>
            @else
            <li class="list-group-item">
                {{$child->title}}
                <span style="cursor: pointer;" class="icons ps-3">
                    <i onclick="_new({{$child->id}})" class="bi bi-file-earmark-plus"></i>
                    <i onclick='_edit({{$child->id}}, "{{$child->title}}")' class="bi bi-pencil-square"></i>
                    <i onclick='_delete({{$child->id}})' class="bi bi-file-earmark-x"></i>
                </span>
            </li>
            @endif
    @endforeach