<?php

namespace ThallesTeodoro\BaseAdmin\App\Repositories;

use stdClass;
use App\Models\User;
use Illuminate\Support\Collection;
use ThallesTeodoro\BaseAdmin\App\Interfaces\UserRepositoryInterface;

class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct(new User());
    }

    /**
     * Make the search query
     *
     * @param string $search
     * @param int $pagination
     *
     * @return Collection
     */
    public function search(string $search, int $id_user_auth) : Collection
    {
        $users = $this->model
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orderBy('name', 'ASC')
            ->where('id', '<>', $id_user_auth)
            ->get()
            ->toArray();

        $users = $this->arrayToStdClass($users);
        $users = new Collection($users);

        return $users;
    }

    /**
     * Return all itens orderly
     *
     * @param string $order_by
     * @param string $order_direction
     * @return Collection
     */
    public function allOrderly(string $order_by, string $order_direction, int $id_user_auth) : Collection
    {
        $users = $this->model
            ->orderBy($order_by, $order_direction)
            ->where('id', '<>', $id_user_auth)
            ->get()
            ->toArray();

        $users = $this->arrayToStdClass($users);
        $users = new Collection($users);

        return $users;
    }

    /**
     * Return the auth user
     *
     * @return stdClass|null
     */
    public function getAuthUser() :? stdClass
    {
        $user = auth()->user()->toArray();
        $user = $this->arrayToStdClass($user);

        return $user;
    }
}
