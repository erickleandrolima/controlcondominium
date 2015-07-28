@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
       <h1>{{ Lang::get('dwellers.createDweller') }}</h1>
    </div>
</div>

{{ Form::open(array('route' => 'dwellers.store', 'class' => 'form-horizontal')) }}

        <div class="form-group">
            {{ Form::label(Lang::get('app.name'), Lang::get('app.name'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('name', Input::old('name'), array('class'=>'form-control', 'placeholder'=> Lang::get('app.name'))) }}
            </div>
        </div>

         {{ Form::hidden('user_id', Auth::id()) }}

        <div class="form-group">
            {{ Form::label(Lang::get('app.status'), Lang::get('app.status'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                {{ Form::select('situation', [
                   '1' => 'Ocupado',
                   '0' => 'Desocupado',]
                ) }}
            </div>

        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('dwellers.numberApartament'), Lang::get('dwellers.numberApartament'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{Form::select('number_apartament', $apartments, 0)}}
            </div>
        </div>


<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit(Lang::get('app.create'), array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('dwellers.index', Lang::get('app.cancel'), null, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop


