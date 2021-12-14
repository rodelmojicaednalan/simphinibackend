<?php

namespace App\Repositories\Admin;

use App\Models\Admin\AdminUser;
use App\Repositories\AbstractRepository;

class AdminUserRepositoryEloquent extends AbstractRepository implements AdminUserRepository
{
	protected $query;

	function __construct(AdminUser $query)
	{
		$this->query = $query;
	}

    public function datatablesIndex()
    {
        return $this->query->whereRaw("1=?", [1]);
    }
}