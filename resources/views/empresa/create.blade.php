@extends('layouts.master')
@section('title', 'Adicionar Empresa')

@section('jquery_content')	
@endsection

@section('content')
	<h3 class="page-header">Adicionar Empresa</h3>

  	@include('layouts.errors')

	{{ Form::open(array('url' => 'empresa')) }}
	    @include('empresa.form_fields')

	    <hr />
	    <div id="actions" class="row">
	  		<div class="col-md-12">
	    		{{ Form::submit('Salvar', array('class' => 'btn btn-primary')) }}
	    		<a href="javascript:history.back()" class="btn btn-default">Cancelar</a>
	    	</div>
  		</div>
	{{ Form::close() }}	
@endsection