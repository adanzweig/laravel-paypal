<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<form id="paypal-form">
    @csrf
    <button type="button" id="ppb">Pay with paypal</button>
</form>
<script>
    $(document).ready(function(){
        $('#ppb').on('click',function(){
            $.ajax({
                url:'{{ route('create-paypal-order') }}',
                method:'POST',
                data:{
                    _token:$('input[name="_token"]').val()
                },
                success:function(response){
                    if(response.url){
                        window.location.href= response.url;
                    }
                }
            })
        })
    })
</script>
