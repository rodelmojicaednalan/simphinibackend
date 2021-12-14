<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Client;
use App\Repositories\AbstractRepository;

class ClientRepositoryEloquent extends AbstractRepository implements ClientRepository
{
	protected $query;

	function __construct(Client $query)
	{
		$this->query = $query;
	}

    public function datatablesIndex()
    {
        return $this->query->whereRaw("1=?",[1]);
    }
}