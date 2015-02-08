<?php namespace Zeropingheroes\Lanager\Api\v1;

use Zeropingheroes\Lanager\PlaylistItemVotes\PlaylistItemVoteService,
	Zeropingheroes\Lanager\PlaylistItemVotes\PlaylistItemVoteTransformer;

class PlaylistItemVotesController extends BaseController {

	public function __construct()
	{
		parent::__construct();
		$this->service = new PlaylistItemVoteService($this);
		$this->transformer = new PlaylistItemVoteTransformer;
	}

}