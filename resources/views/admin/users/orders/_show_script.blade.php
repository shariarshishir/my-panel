@push('js')
    <script>
        $(document).on('click', '.colorSizeModal', function(){
            $(this).siblings('#colorSizeModal').modal('show');
        });
        $(document).on('click', '.add-shipping-charge', function(){
              $('.shipping-charge-block').toggle();
        });

        function addMoreShippingCharge()
        {
            var html = '<tr>';
            html += '<td data-title="Shipping Method"> <select class="form-select form-control" aria-label="Default select example" name="shipping[shipping_method][]" required> <option value="" selected>select</option>  @foreach ($shippingMethod as $list ) <option value="{{$list}}">{{$list}}</option>@endforeach</select></td>';
            html += '<td data-title="Shipment Type"> <select class="form-select form-control" aria-label="Default select example" name="shipping[shipment_type][]" required> <option value="" selected>select</option>  @foreach ($shipMentType as $list ) <option value="{{$list}}">{{$list}}</option>@endforeach</select></td>';
            html += '<td data-title="UOM"> <select class="form-select form-control" aria-label="Default select example" name="shipping[uom][]" required> <option value="" selected> select</option>  @foreach ($uom as $list ) <option value="{{$list}}">{{$list}}</option>@endforeach</select></td>';
            html += '<td data-title="Per UOM Price($)"><input type="number" name="shipping[unit_price][]" class="shipping-unit-price form-control" required /></td>';
            html += '<td data-title="QTY"><input type="number" name="shipping[qty][]" class="shipping-qty form-control" required /></td>';
            html += '<td data-title="Total($)"><input type="number" name="shipping[total][]" class="shipping-total form-control" readonly required /></td>';
            html += '<td><a href="javascript:void(0);" class="btn btn-danger remove-shipping-charge-tr" onclick="removeShippingChargeTr(this)"><i class="fas fa-minus"></i></a></td>';
            html += '</tr>';
            $('.shipping-charge-table tbody').append(html);
        }
        function removeShippingChargeTr(el)
        {
            $(el).parent().parent().remove();
        }

        $(document).on('input', '.shipping-qty', function(){
              var unit_price_value=$(this).closest('tr').find('.shipping-unit-price').val();
              if(unit_price_value == 0){
                  alert('please provide unit price');
                  return false;
              }
              var get_total= unit_price_value * $(this).val();

              $(this).closest('tr').find('.shipping-total').val(parseFloat(get_total).toFixed(2));
              grandTotal();
        });
        $(document).on('input', '.shipping-unit-price', function () {
            var unit_price_value=$(this).val();
            var qty=$(this).closest('tr').find('.shipping-qty').val();
            if(unit_price_value != 0 && qty != 0){
                var get_total= qty * $(this).val();
                $(this).closest('tr').find('.shipping-total').val(parseFloat(get_total).toFixed(2));
                grandTotal();
            }

        });

        function grandTotal() {
            var grandTotal = 0;
            $(".shipping-total").each(function() {
                grandTotal += Number($(this).val()) || 0;
            });
            $(".shipping-grand-total").text(parseFloat(grandTotal).toFixed(2));
            $('input[name=grand_total]').val(parseFloat(grandTotal).toFixed(2));
        }

        $(document).on('click', '.remove-shipping-charge-tr', function(){
            grandTotal();
        });




    </script>
@endpush
