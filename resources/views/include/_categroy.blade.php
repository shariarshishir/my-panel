
    <ul class="sub-level">
        <li class="parent-cat-as-heading">{{$category['name']}}</li>
        @foreach($category['children'] as $childcategory)
            <li class="@php echo ($childcategory['slug'] == $segment3)?' active':''; @endphp">
                <a href="{{route('subcategories.product',['category'=>$category['slug'],'subcategory'=>$childcategory['slug']])}}">
                    {{ $childcategory['name'] }}
                    @if(!empty($childcategory['children']))
                        <span><i class="material-icons dp48">chevron_right</i></span>
                    @endif
                </a>
            </li>
            @if(!empty($childcategory['children']))
            <ul class="sub-level">
                <li class="parent-cat-as-heading">{{$childcategory['name']}}</li>
                @foreach($childcategory['children'] as $childcategory2)
                    <li class="@php echo ($childcategory2['slug'] == $segment4)?' active':''; @endphp">
                        <a href="{{route('sub.subcategories.product',['category'=>$category['slug'],'subcategory'=>$childcategory['slug'],'subsubcategory'=>$childcategory2['slug']])}}">{{ $childcategory2['name'] }}</a>
                    </li>
                @endforeach
            </ul>
            @endif
        @endforeach
    </ul>

