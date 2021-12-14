<?php

namespace App\Repositories\Admin\Picklists;

use App\Models\Admin\Picklists\Treatment;
use App\Repositories\AbstractRepository;

class TreatmentRepositoryEloquent extends AbstractRepository implements TreatmentRepository
{
	protected $query;

	function __construct(Treatment $query)
	{
		$this->query = $query;
	}

    public function datatablesIndex()
    {
        return $this->query->whereRaw("1=?",[1]);
    }
}