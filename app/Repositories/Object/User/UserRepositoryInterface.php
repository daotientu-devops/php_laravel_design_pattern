<?php

namespace App\Repositories\Object\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    // Lấy limit user đầu tiên hiển thị lên list
    public function getTopUsers($limit);
}
