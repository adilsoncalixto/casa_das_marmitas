@extends('layouts.master')
@section('title', 'Visualizar Produto')

@section('jquery_content')
@endsection

@section('content')
	<h3 class="page-header">{{'Visualizar Produto #'.$produto->id}}</h3>

	<div class="row">
		<div class="col-md-6">
      		<p><strong>Nome:</strong></p>
  	  		<p>{{ $produto->nome }}</p>
    	</div>
    	<div class="col-md-2">
      		<p><strong>Custo:</strong></p>
  	  		<p>{{ $produto->getCusto() }}</p>
    	</div>
    	<div class="col-md-4">
      		<p><strong>Tamanho:</strong></p>
  	  		<p>{{ $produto->getTamanho() }}</p>
    	</div>
	</div>

	<div class="row">
    	<div class="col-md-12">
      		<p><strong>Ingredientes:</strong></p>
  	  		<p>{{ $produto->ingredientes }}</p>
    	</div>
    </div>

	<hr />
 	<div id="actions" class="row">
   		<div class="col-md-12">     		
	 		<a href="{{ URL::to('produto/' . $produto->id . '/edit') }}" class="btn btn-warning">Alterar</a>
	 		<a href="#" class="btn btn-danger" data-toggle="modal" data-target="#delete-modal">Excluir</a>
	 		<a href="javascript:history.back()" class="btn btn-default">Cancelar</a>
   		</div>
 	</div>
@endsection