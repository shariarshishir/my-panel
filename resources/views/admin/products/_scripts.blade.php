@push('js')
    <script>

        $(document).on('click','input[name=priority_level]',function() {
                var cnfrm = confirm('Are you sure?');
                if(cnfrm != true)
                {
                    return false;
                }
                $('#priority_level_form').submit();
            })
    </script>
@endpush
