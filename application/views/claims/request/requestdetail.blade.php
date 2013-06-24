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
  <div class="span12" style='padding:5px;'>
    <a href="#addResitModal" role="button" class="btn btn-info pull-right" data-toggle="modal" style='margin-bottom:10px;margin-left:5px'><i class="icon-upload icon-white"></i>&nbsp;Bulk Upload</a>
    <a href="#addDetailModal" role="button" class="btn pull-right" data-toggle="modal" style='margin-bottom:10px;margin-left:5px'><i class="icon-plus"></i>&nbsp;Add Details</a>
  </div>
</div>
<div class="row-fluid" >
  <div class="span12">
    <div id="dataList" class="rows-fluid show-grid">
      {{ $detailList }}
    </div>
    <div class="form-actions">
      <button id="submitClaims" class="btn pull-right btn-primary" data-loading-text="Submitting..."><i class="icon-ok icon-white"></i>&nbsp;&nbsp;Submit Claims</button>
    </div>
  </div>
</div>


<!-- Modal -->
<div id="addDetailModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Add New Detail</h3>
</div>
<div class="modal-body">
{{ Form::open('admin/user/role', 'POST', array('id' => 'addDetailForm', 'class' => 'form-horizontal')) }}
  <div class="control-group">
    <label class="control-label" for="detaildate">Date</label>
    <div class="controls">
    	{{ Form::hidden('claimid',$claimID)}}
      {{ Form::hidden('detailId')}}
      {{ Form::xlarge_text('detaildate',null,array('placeholder'=>'Type Date','required','id'=>'detaildate')) }}
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="detaildesc">Description</label>
    <div class="controls">
     	{{ Form::xlarge_textarea('detaildesc',null,array('rows' => '3')) }}
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="detailfrom">Origin</label>
    <div class="controls">
     	{{ Form::xlarge_text('detailfrom',null,array('placeholder'=>'Type Origin Location')) }}
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="detailto">Destination</label>
    <div class="controls">
     	{{ Form::xlarge_text('detailto',null,array('placeholder'=>'Type Destination')) }}
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="detailmile">Milage</label>
    <div class="controls">
     	{{ Form::xlarge_text('detailmile',null,array('placeholder'=>'Type Mileage Value')) }}
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="detailtoll">Toll</label>
    <div class="controls">
     	{{ Form::xlarge_text('detailtoll',null,array('placeholder'=>'Type Toll Value')) }}
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="detailpark">Parking</label>
    <div class="controls">
      {{ Form::xlarge_text('detailpark',null,array('placeholder'=>'Type Parking Value')) }}
    </div>
  </div>
{{ Form::close()}}
</div>
<div class="modal-footer">
  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  <button id="addDetailBtn" class="btn btn-primary">Save</button>
</div>
</div>

<div id="addResitModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Upload Receipt</h3>
</div>
<div class="modal-body">
{{ Form::inline_open_for_files('admin/user/role', 'POST', array('id' => 'addResitForm',)); }}
{{ Form::hidden('claimid',$claimID)}}
{{ Form::hidden('claimdetailid'); }}
<a class = "btn btn-info fileinput-button"><i class="icon-upload  icon-white"></i>&nbsp;Browse</a>
{{ Form::file('fileInput',array('id'=>'fileInput')) }}
{{ Form::close(); }}
  <div id="progress" class="pull-right">
        <div class="bar"></div>
  </div>
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
{{ HTML::script('js/jquery.fileupload.js'); }}
{{ HTML::script('js/jquery.iframe-transport.js'); }}
<script>
	$(function() {
	  $( "#detaildate" ).datepicker({
	      showWeek: true,
	      firstDay: 1,
        dateFormat:"dd-mm-yy",
	      showButtonPanel: true
	    });
  	});

    $('#addDetailBtn').click(function() {
      
      $.post('{{ url('claims/request/addDetail'); }}', $("#addDetailForm").serialize(),function(data) {
              sourcedata = data;
            }).success(function() { 
              $("#dataList" ).empty().html( sourcedata );
              $("#addDetailForm :input").val('');
              $("#addDetailForm :input[name='claimid']").val({{URI::segment(4)}});
              $('#addDetailModal').modal('hide');
            });

    });

    $('#submitClaims').click(function() {
      
      $.post('{{ url('claims/request/submitClaims'); }}', "&claimid="+{{ URI::segment(4) }},function(data) {
              url = data;
            }).success(function() { 
              $('#actionStatModal').modal('toggle');
              $('#actionStat').removeClass().addClass('alert alert-success').text('Success!!!');

              setTimeout('window.location.href="{{ url("'+url+'"); }}";',2000);

            });

    });

  function editDetail(id){

    $('#addDetailModal').modal('toggle');

    $.get('{{ url('claims/request/detailinfo') }}', { id: id },function(data,status){

      $('#addDetailForm input[name="detailId"]' ).val(id);

      for (x in data)
      {   
        if(x == 'detaildesc'){
          console.log(data[x]);
          $('#addDetailForm textarea[name="detaildesc"]' ).val(data[x]).text(data[x]);
        }else{
          $('#addDetailForm input[name="'+ x +'"]' ).val(data[x]);
        }
        
      }

      },"json");

  }

  function deleteDetail(id){

      $.post('{{ url('claims/request/deleteDetail'); }}', "id="+id+"&claimid="+{{ URI::segment(4) }} ,function(data) {
            sourcedata = data;
          }).success(function() {
              $( "#dataList" ).empty().append( sourcedata );
            });
  }

  function uploadResit(id){

    $('#addResitModal').modal('toggle');
    $('#addResitForm input[name="claimdetailid"]' ).val(id);

    $.get('{{ url('claims/request/receipt') }}', { id: id },function(data,status){

      $('#recCoru .carousel-inner').empty();
      for (x in data)
      {   
        if(x == 1){
          $('#recCoru .carousel-inner').append('<div class="active item"><img src="{{ url("'+ data[x ]+'")}}" width="200px" height="200px"></div>');
        }else{
          $('#recCoru .carousel-inner').append('<div class="item"><img src="{{ url("'+ data[x ]+'")}}" width="200px" height="200px"></div>');
        }
        
      }

    },"json");

  }

    $('#addResitForm a').click(function(){
        $(this).parent().find('#fileInput').click();
    });

    $('#addResitModal').on('shown', function () {
      $('#fileInput').css('display','none');
      $('#progress').removeClass();
      $('#progress .bar').text('');
    })

    $('#addResitModal').on('hidden', function () {
      $('#fileInput').css('display','none');
      $('#progress').removeClass();
      $('#progress .bar').text('');
      $('#addResitForm input[name="claimdetailid"]' ).val('');
    })

    $('#addResitForm').fileupload({
        url: '{{ url('claims/request/upload'); }}',
        dataType: 'json',
        done: function (e, data) {
          console.log(data.result.files);
          $('#recCoru .carousel-inner').prepend('<div class="active item"><img src="{{ url("'+ data+'")}}"></div>');
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);

            $('#progress').addClass('progress progress-info progress-striped');
            $('#progress .bar').css('width',progress + '%');

            if(progress == 100){
                $('#progress').removeClass().addClass('alert alert-success');
                $('#progress .bar').text('Success!!!');
                // $('#addResitModal').delay(1000).modal('hide');
            }
        }
    });

</script>
@endsection