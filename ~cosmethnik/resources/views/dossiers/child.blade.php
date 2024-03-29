<ul class="nav nav-treeview" style="display: block;">
    @foreach($childs as $child)
        <li class="nav-item">
            <a onclick="getDetails({{ $child->id }} , {{ $id }} , '{{ $child->title }}')" class="nav-link" style="cursor: pointer">
                <i class="nav-icon fas fa-folder"></i>
                <p>
                    {{ $child->title }}
                </p>
            </a>
            @if(count($child->childs))
                @include('dossiers.child',['childs' => $child->childs])
            @endif
        </li>
    @endforeach
</ul>
