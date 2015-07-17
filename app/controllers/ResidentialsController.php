<?php

class ResidentialsController extends BaseController {

	/**
	 * Residential Repository
	 *
	 * @var Residential
	 */
	protected $residential;

	public function __construct(Residential $residential)
	{
		$this->residential = $residential;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$residentials = $this->residential->all();

		return View::make('residentials.index', compact('residentials'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('residentials.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Residential::$rules);

		if ($validation->passes())
		{
			$this->residential->create($input);

			return Redirect::route('residentials.index');
		}

		return Redirect::route('residentials.create')
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
		$residential = $this->residential->find($id);

		if (is_null($residential))
		{
			return Redirect::route('residentials.index');
		}

		return View::make('residentials.edit', compact('residential'));
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
		$validation = Validator::make($input, Residential::$rules);

		if ($validation->passes())
		{
			$residential = $this->residential->find($id);
			$residential->update($input);

			return Redirect::route('residentials.index', $id);
		}

		return Redirect::route('residentials.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->residential->find($id)->delete();

		return Redirect::route('residentials.index');
	}

}
