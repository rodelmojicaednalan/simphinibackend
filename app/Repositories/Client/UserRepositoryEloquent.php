<?php

namespace App\Repositories\Client;

use App\Models\User;
use App\Repositories\AbstractRepository;

class UserRepositoryEloquent extends AbstractRepository implements UserRepository
{
	protected $query;

	function __construct(User $query)
	{
		$this->query = $query;
	}

    public function datatablesIndex()
    {
			return $this->query->whereRaw("1=?", [1]);
    }
}