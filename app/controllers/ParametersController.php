<?php

class ParametersController extends BaseController {

	/**
	 * Parameter Repository
	 *
	 * @var Parameter
	 */
	protected $parameter;

	public function __construct(Parameter $parameter)
	{
		$this->parameter = $parameter;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$parameters = Parameter::where('user_id', Auth::id())->get();

		return View::make('parameters.index', compact('parameters'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Parameter::$rules);

		if ($validation->passes())
		{
			$this->parameter->create($input);

			return Redirect::route('parameters.index');
		}

		return Redirect::route('parameters.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$parameter = $this->parameter->find($id);

		if (is_null($parameter))
		{
			return Redirect::route('parameters.index');
		}

		$path = (!empty($parameter->image)) ? $parameter->image : null;

		return View::make('parameters.edit', compact('parameter', 'path'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Parameter::$rules);

		if ($validation->passes())
		{
			$parameter = $this->parameter->find($id);

			if(!is_null(Input::file('image'))):
				$upload = new Upload(Input::file('image'));
				$input['image'] = $upload->upload();
			else:
			    $input['image'] = $parameter->image;
			endif;    

			$parameter->update($input);

			return Redirect::route('parameters.index')
							->with('success', '<strong>Sucesso</strong> parâmetros atualizados com sucesso');
		}

		return Redirect::route('parameters.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	public static function getImageProfile()
	{
		$parameter = Parameter::where('user_id', Auth::id())->first();
		return (!is_null($parameter)) ? $parameter->image : null;
	}
}
