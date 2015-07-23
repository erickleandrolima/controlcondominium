@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>{{ Lang::get('expenses.editExpense') }}</h1>

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
            {{ Form::label(Lang::get('expenses.date'), Lang::get('expenses.date'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('date_expense', Input::old('date_expense'), array('class'=>'date form-control', 'placeholder'=> Lang::get('expenses.date'))) }}
            </div>
        </div>

        {{ Form::hidden('user_id', Auth::id()) }}

        <div class="form-group">
            {{ Form::label(Lang::get('expenses.description'), Lang::get('expenses.description'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::textarea('description', Input::old('description'), array('class'=>'form-control', 'placeholder'=> Lang::get('expenses.description'))) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('expenses.value'), Lang::get('expenses.value'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('value', Input::old('value'), array('class'=>'money form-control', 'placeholder'=> Lang::get('expenses.value'))) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('expenses.monthReference'), Lang::get('expenses.monthReference'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                 {{Form::select('date_reference', $months, Input::old('date_reference'))}}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('expenses.category'), Lang::get('expenses.category'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                 {{Form::select('id_category', $categories, Input::old('id_category'))}}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('expenses.dweller'), Lang::get('expenses.dweller'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                 {{Form::select('id_dweller', $dwellers, Input::old('id_dweller'))}}
            </div>
        </div>



<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit(Lang::get('app.update'), array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('expenses.index', Lang::get('app.cancel'), null, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop