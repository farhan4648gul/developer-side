@layout('layouts.system')

@section('content')
<div class="page-header">
  <h3>Claims Request Information</h3>
</div>
<div class="row-fluid">
  <div class="span12">
    <table class="table table-bordered table-hover" >
      <tbody>
      <tr>
        <td class="span1"><strong>Reference Number</strong></td>
        <td class="span7 muted">{{$app['refno']}}</td>
      </tr>
      <tr>
        <td class="span1"><strong>Claims Category</strong></td>
        <td class="span7 muted">{{$app['category']}}</td>
      </tr>
      <tr>
        <td class="span1"><strong>Date Apply</strong></td>
        <td class="span7 muted">{{$app['applydate']}}</td>
      </tr>
      <tr>
        <td class="span1"><strong>Month Apply For</strong></td>
        <td class="span7 muted">{{$app['applymonth']}}</td>
      </tr>
      <tr>
        <td class="span1"><strong>Status</strong></td>
        <td class="span7 muted">{{$app['status']}}</td>
      </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="row-fluid" >
  <div class="span12">
    <div id="dataList" class="rows-fluid show-grid">
      {{ $detailList }}
    </div>
  </div>
</div>


<!-- Modal -->

<div id="addResitModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Uploaded Receipt</h3>
</div>
<div class="modal-body">
<div id="recCoru" class="carousel slide">
  <!-- Carousel items -->
  <div class="carousel-inner">
    <div class="active item"><img src="{{ url('upload/claims/356a192b7913b04c54574d18c28d46e6395428ab/20130623/1/13/vZgIJVcphiodMOdD1372013927.png')}}" alt=""></div>
    <div class="item"><img src="{{ url('upload/claims/356a192b7913b04c54574d18c28d46e6395428ab/20130623/1/13/vZgIJVcphiodMOdD1372013927.png')}}" alt=""></div>
    <div class="item"><img src="{{ url('upload/claims/356a192b7913b04c54574d18c28d46e6395428ab/20130623/1/13/vZgIJVcphiodMOdD1372013927.png')}}" alt=""></div>
  </div>
  <!-- Carousel nav -->
  <a class="carousel-control left" href="#recCoru" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#recCoru" data-slide="next">&rsaquo;</a>
</div>
</div>
<div class="modal-footer">
  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
</div>
</div>

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