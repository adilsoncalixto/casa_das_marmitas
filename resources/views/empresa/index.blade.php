@extends('layouts.master')
@section('title', 'Lista de Empresas')

@section('content')
	<div id="top" class="row">
		<div class="col-sm-3">
			<h2>Empresas</h2>
		</div>
		<div class="col-sm-6">			
			<div class="input-group h2">
				<input name="data[search]" class="form-control" id="search_query" type="text" placeholder="Pesquisar Empresas">
				<input type="hidden" id="query" value="">
				<span class="input-group-btn">
					<button id="search_btn" class="btn btn-primary" type="submit">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</span>
			</div>
			
		</div>
		<div class="col-sm-3">
			<a href="{{ URL::to('empresa/create') }}" class="btn btn-primary pull-right h2">Nova Empresa</a>
		</div>
	</div> <!-- /#top --> 
 
 	<hr />
 	
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif	

<div class="content">
	@include('empresa.paginacao')
</div> 	
@endsection

@section('jquery_content')
	<script type="text/javascript">
		$(document).on('click', '.pagination a', event =>  {
            event.preventDefault();
			//console.log($(this).attr('href').split('page='));
			var page = event.target.href.split('page=')[1];
			getEmpresas(page);
		});

		$(document).on('click', '#search_btn', event => {
			event.preventDefault();
			$("#query").val($("#search_query").val());
			getEmpresas(1);
		});

		function getEmpresas(page) {
			loadPage('empresas', page);		
		}		
	</script>
@endsection