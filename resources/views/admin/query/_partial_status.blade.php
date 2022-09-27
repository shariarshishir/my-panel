@switch($collection->state)
    @case(1)
       <span class="text-danger">Pending</span>
        @break
    @case(2)
        <span class="text-info">Processed</span>
        @break
    @case(3)
        <span class="text-success">Ordered</span>
            @break
    @case(4)
        Cancel
        @break
    @default

@endswitch
