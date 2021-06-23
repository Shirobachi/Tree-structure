    @foreach($childs as $child)
            @if(count($child->childs))

                <div class="accordion-item">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tree-{{$child->id}}">
                        {{$child->title}}
                        <i onclick="_new({{$child->id}})" class="bi bi-plus"></i>
                    </button>
                    <div id="tree-{{$child->id}}" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            @include('child',['childs' => $child->childs])
                        </div>
                    </div>
                </div>
            @else
            <li class="list-group-item">
                {{$child->title}}
                <i onclick="_new({{$child->id}})" class="bi bi-plus"></i>
            </li>
            @endif
    @endforeach