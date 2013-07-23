@layout($syslayout)

@section('content')
<div class="page-header">
    <h3>{{ Str::upper(Lang::line('admin.datamanagement')->get()) }}</h3>
</div>
<div class="row-fluid">
  <div class="pull-right">
    <a href="#addDataModal" role="button" class="btn" data-toggle="modal" style='margin-bottom:10px'><i class="icon-plus"></i>&nbsp;{{ Str::title(Lang::line('admin.adddatagroup')->get()) }}</a>
  </div>
</div>

<div id="dataGroupList" class="rows-fluid show-grid">
	{{ $datalist }}
</div>

<div id="addDataModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">{{ Str::title(Lang::line('admin.adddatagroup')->get()) }}</h3>
</div>
<div class="modal-body">
{{ Form::open('admin/user/role', 'POST', array('id' => 'addDataForm', 'class' => 'form-horizontal')) }}
{{ Form::hidden('groupid',NULL)}}
{{ Form::control_group(Form::label('group_name', Str::title(Lang::line('admin.datagroupname')->get())),Form::large_text('group_name',null,array('placeholder'=>Str::title(Lang::line('global.type')->get().' '.Lang::line('admin.datagroupname')->get()),'required'))) }}
{{ Form::control_group(Form::label('group_model', Str::title(Lang::line('admin.datagroupmodel')->get())),Form::large_text('group_model', '', array('placeholder'=>Str::title(Lang::line('global.type')->get().' '.Lang::line('admin.datagroupmodel')->get()),'required'))) }}
{{ Form::control_group(Form::label('group_key', Str::title(Lang::line('admin.datagroupkey')->get())),Form::large_text('group_key', '', array('placeholder'=>Str::title(Lang::line('global.type')->get().' '.Lang::line('admin.datagroupkey')->get()),'required'))) }}
{{ Form::close()}}
</div>
<div class="modal-footer">
  <button class="btn" data-dismiss="modal" aria-hidden="true">{{ Str::title(Lang::line('global.close')->get()) }}</button>
  <button id="addDataGroupBtn" class="btn btn-primary">{{ Str::title(Lang::line('global.save')->get()) }}</button>
</div>
</div>
@endsection
@section('scripts')
<script>

    $('#addDataGroupBtn').click(function() {
      
      $.post('datagroup', $("#addDataForm").serialize(),function(data) {
              sourcedata = data;
            }).success(function() { 
              sourcedata = jQuery.parseJSON(sourcedata);
              console.log(sourcedata);
              if(sourcedata.fail){
                alert(sourcedata.fail);
              }else{
                $( "#dataGroupList" ).empty().html( sourcedata );
                $("#addDataForm :input").val('');
                $('#addDataModal').modal('hide');
              }
                
            });

    });

    function editGroup(id){
      $('#addDataModal').modal('show');
      $('.modal-header #myModalLabel').text("{{ Str::title(Lang::line('admin.editdatagroup')->get()) }}");
      $.get('groupinfo', { groupid: id},function(data,status){
        for (x in data)
        {   
          $('#addDataForm input[name="'+ x +'"]' ).val(data[x]);

        }
      },"json");
    }

  function deleteGroup(id,name){

    var r = confirm("{{ Str::title(Lang::line('admin.deletegroup')->get()) }}" +name.toUpperCase());

    if (r==true){
        $.post("deleteGroup", "groupid="+id+"&name="+name ,function(data) {
              sourcedata = data;
            }).success(function() {
            sourcedata = jQuery.parseJSON(sourcedata);
            if(sourcedata.fail){
              alert(sourcedata.fail);
            }else{
              $( "#dataGroupList" ).empty().append( sourcedata );
            }
              });
    }

  }

</script>
@endsection