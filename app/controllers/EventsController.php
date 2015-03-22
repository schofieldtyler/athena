<?php namespace Zeropingheroes\Lanager;

use Zeropingheroes\Lanager\Events\EventService,
	Zeropingheroes\Lanager\EventTypes\EventTypeService;
use View, Notification, Redirect;

class EventsController extends BaseController {

	protected $route = 'events';

	public function __construct()
	{
		parent::__construct();
		$this->service = new EventService($this);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$options['orderBy'] = ['start'];
		$eagerLoad = ['type', 'eventSignups'];

		$events = $this->service->all($options, $eagerLoad);

		return View::make('events.index')
					->with('title','Events')
					->with('events', $events);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$eventTypes = (new EventTypeService($this))->lists('name','id');

		return View::make('events.create')
					->with('title','Create Event')
					->with('eventTypes',$eventTypes)
					->with('event', null);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$eagerLoad = [
			'type',
			'eventSignups',
			'eventSignups.user.state.application',
			'eventSignups.user.state.server',
		];

		$event = $this->service->single($id, $eagerLoad);

		return View::make('events.show')
					->with('title',$event->name)
					->with('event',$event);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$event = $this->service->single($id);
		$eventTypes = ['' => ''] + (new EventTypeService($this))->lists('name','id');

		return View::make('events.edit')
					->with('title','Edit Event')
					->with('eventTypes',$eventTypes)
					->with('event',$event);
	}

	public function destroySucceeded( BaseResourceService $service )
	{
		Notification::success( $service->messages() );
		return Redirect::route( $this->route . '.index', [$service->resourceIds(), 'tab' => 'list'] );
	}

}