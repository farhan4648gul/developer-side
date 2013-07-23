@layout($syslayout)

@section('content')
<div class="page-header">
    <h3>{{Lang::line('admin.configmanagement')->get()}}</h3>
</div>
<div class="row-fluid">
	<div class="span12 pull-left">
	{{ Form::open('admin/system/sysConfig', 'POST', array('id' => 'editUserForm', 'class' => 'form-horizontal')) }}
	{{ Form::control_group(Form::label('pagination', Str::title(Lang::line('global.pagination')->get()),array('class'=>'span10','style'=>'text-align:left')),Form::mini_text('pagination',$pagination,array('placeholder'=>'20')), $pagination_cond);}}
	{{ Form::control_group(Form::label('loginexpired', Str::title(Lang::line('global.loginexpired')->get()),array('class'=>'span10','style'=>'text-align:left')),Form::mini_text('loginexpired',$loginexpired,array('placeholder'=>'15')), $loginexpired_cond);}}
	{{ Form::control_group(Form::label('emailnotices', Str::title(Lang::line('global.emailnotices')->get()),array('class'=>'span10','style'=>'text-align:left')),Form::small_select('emailnotices', array(Str::title(Lang::line('global.no')->get()),Str::title(Lang::line('global.yes')->get())),$emailnotices), $emailnotices_cond);}}
    <div class="form-actions">
	    <button type="submit" class="btn pull-right btn-primary">{{ Str::title(Lang::line('global.edit')->get()) }}</button>
  	</div>
	{{ Form::close()}}

@endsection