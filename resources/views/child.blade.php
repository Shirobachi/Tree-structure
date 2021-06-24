    @foreach($childs as $child)
            @php $parent=count($child->childs)>0 @endphp

            @if($parent)
                <div class="accordion-item">
                <button class="accordion-button{{$child->parentId == NULL ? '' : ' collapsed'}}" aria-expanded="true" type="button" data-bs-toggle="collapse" data-bs-target="#tree-{{$child->id}}">
            @else
                <li class="list-group-item">
            @endif
                {{$child->title}}

            @if($parent)
                <div style="cursor: pointer;" class="icons ps-3">
            @else
                <span style="cursor: pointer;" class="icons ps-3">
            @endif

            <i onclick="_new({{$child->id}})" class="bi bi-file-earmark-plus text-success" data-bs-toggle="tooltip" title="Add new child.."></i>
            @if($child->parentId != null)
                <i onclick='_edit({{$child->id}}, "{{$child->title}}")' class="bi bi-pencil-square text-warning" data-bs-toggle="tooltip" title="Edit name.."></i>
                <i onclick='_delete({{$child->id}})' class="bi bi-file-earmark-x text-danger"  data-bs-toggle="tooltip" title="Delete element.."></i>
                <a href="{{url('tree')}}/{{$child->id}}/move"><i class="bi bi-box-arrow-up-right text-info"  data-bs-toggle="tooltip" title="Move somewhere else.."></i></a>
            @endif
            @if(App\Models\tree::where('parentId', $child->parentId) -> where('owner', $child->owner) -> get() -> count() > 1)
                @if(App\Models\tree::where('parentId', $child->parentId)-> where('owner', $child->owner) -> orderBy('sort') -> first() -> sort == $child -> sort)
                    <a href="{{url('tree')}}/{{$child->id}}/sort/down"><i class="bi bi-arrow-down-square text-primary"  data-bs-toggle="tooltip" title="Move down 👇"></i></a>
                @elseif(App\Models\tree::where('parentId', $child->parentId)-> where('owner', $child->owner) -> orderBy('sort', 'desc') -> first() -> sort == $child -> sort)
                    <a href="{{url('tree')}}/{{$child->id}}/sort/up"><i class="bi bi-arrow-up-square text-primary"  data-bs-toggle="tooltip" title="Move up 👆" ></i></a>
                @else
                    <a href="{{url('tree')}}/{{$child->id}}/sort/down"><i class="bi bi-arrow-down-square text-primary"  data-bs-toggle="tooltip" title="Move down 👇"></i></a>
                    <a href="{{url('tree')}}/{{$child->id}}/sort/up"><i class="bi bi-arrow-up-square text-primary"  data-bs-toggle="tooltip" title="Move up 👆" ></i></a>
                @endif
            @endif
            
            @if($parent)
                </div>
                </button>
                <div id="tree-{{$child->id}}" class="accordion-collapse collapse{{$child->parentId == NULL ? ' show' : ''}}">
                    <div class="accordion-body">
                        @include('child',['childs' => $child->childs])
                    </div>
                </div>
            </div>
            @else
                </span>
                </li>
            @endif
    @endforeach