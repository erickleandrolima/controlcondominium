@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Edit Expense</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($expense, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('expenses.update', $expense->id))) }}

        <div class="form-group">
            {{ Form::label('date_expense', 'Data:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('date_expense', Input::old('date_expense'), array('class'=>'date form-control', 'placeholder'=>'Date_expense')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('description', 'Descrição:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::textarea('description', Input::old('description'), array('class'=>'form-control', 'placeholder'=>'Description')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('value', 'Valor:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('value', Input::old('value'), array('class'=>'money form-control', 'placeholder'=>'Value')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Mês de Referência', 'Mês de Referência:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                 {{Form::select('date_reference', $months, Input::old('date_reference'))}}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Categoria', 'Categoria:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                 {{Form::select('id_category', $categories, Input::old('id_category'))}}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Morador', 'Morador:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                 {{Form::select('id_dweller', $dwellers, Input::old('id_dweller'))}}
            </div>
        </div>



<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Atualizar', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('expenses.index', 'Cancelar', null, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop