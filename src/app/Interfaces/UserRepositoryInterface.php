<?php

namespace ThallesTeodoro\BaseAdmin\App\Interfaces;

use stdClass;
use Illuminate\Support\Collection;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Make the search query
     *
     * @param string $search
     * @param int $pagination
     *
     * @return Collection
     */
    function search(string $search, int $id_user_auth) : Collection;

    /**
     * Return all itens orderly
     *
     * @param string $order_by
     * @param string $order_direction
     * @return Collection
     */
    function allOrderly(string $order_by, string $order_direction, int $id_user_auth) : Collection;

    /**
     * Return the auth user
     *
     * @return stdClass|null
     */
    function getAuthUser() :? stdClass;
}
