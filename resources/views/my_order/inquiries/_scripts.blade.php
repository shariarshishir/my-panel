@push('js')
<script>
      $('#po-table').DataTable({
         "order": [[ 0, "desc" ]],
         "columnDefs" : [
            {targets: [0], visible:false}
         ],
     });

</script>
@endpush
