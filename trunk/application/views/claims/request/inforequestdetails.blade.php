@layout('layouts.system')

@section('content')
<div class="page-header">
  <h3>Claims Request Information</h3>
</div>

@include('claims.request.share.appInfo')
@include('claims.request.share.detailList')


@endsection
@section('scripts')
<script>

  function uploadResit(id){

    $('#addResitModal').modal('toggle');
    $('#addResitForm input[name="claimdetailid"]' ).val(id);

    $.get('{{ url('claims/request/receipt') }}', { id: id },function(data,status){

      $('#recCoru .carousel-inner').empty();
      for (x in data)
      {   

        if(x == 1){
          $('#recCoru .carousel-inner').append('<div class="active item"><img src="{{ url("'+ data[x ]+'")}}" width="150" height="150"></div>');
        }else{
          $('#recCoru .carousel-inner').append('<div class="item"><img src="{{ url("'+ data[x ]+'")}}" width="150" height="150"></div>');
        }
        
      }

    },"json");

  }




</script>
@endsection