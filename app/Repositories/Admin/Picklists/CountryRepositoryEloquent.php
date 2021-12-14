<?php

namespace App\Repositories\Admin\Picklists;

use App\Models\Admin\Picklists\Country;
use App\Repositories\AbstractRepository;

class CountryRepositoryEloquent extends AbstractRepository implements CountryRepository
{
	protected $query;

	function __construct(Country $query)
	{
		$this->query = $query;
	}

    public function datatablesIndex()
    {
        return $this->query->whereRaw("1=?",[1]);
    }
}