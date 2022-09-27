@push('js')

    <script type="text/javascript">
        // var path = "{{ route('get.supplier.location.data') }}";
        // $('input.typeahead').typeahead({
        //     source:  function (query, process) {
        //     return $.get(path, { query: query }, function (data) {
        //             return process(data);
        //         });
        //     }
        // });

    // $(document).ready(function(){
    //     $.ajax({
    //         type:'get',
    //         url:'{{route("get.supplier.location.data")}}',
    //         success:function(response){
    //             var custArray=response;
    //             var dataCust={};
    //             var dataCust2= {};
    //             for(var i= 0; i< custArray.length; i++){
    //                console.log(custArray[i]);
    //             }
    //             $('input#search-location').autocomplete({
    //                 data:response,
    //             });
    //         }
    //     })
    // });

    $(document).ready(function () {
        var factory = $('.get-checked-value');
  			var checked_id = [];
	  		$.each(factory, function() {
	  			var $this = $(this);
	  			if($this.is(":checked")) {
                  checked_id.push($this.attr('data-id'));
	  			}
	  		});

        size_li = $("#myList li").length;
        x=3;
        if(checked_id.length != 0){
                var checked_id_get= Math.max.apply(Math,checked_id);
                x=checked_id_get + 1;
            }
        $('#myList li:lt('+x+')').show();
        $('#loadMore').click(function () {
            x= (x+5 <= size_li) ? x+5 : size_li;
            $('#myList li:lt('+x+')').show();
            $('#showLess').show();
            if(x == size_li){
                $('#loadMore').hide();
            }
        });
        $('#showLess').click(function () {
            x=(x-5<0) ? 3 : x-5;
            $('#myList li').not(':lt('+x+')').hide();
            $('#loadMore').show();
            $('#showLess').show();
            if(x == 3){
                $('#showLess').hide();
            }
        });
    });

    </script>
@endpush
