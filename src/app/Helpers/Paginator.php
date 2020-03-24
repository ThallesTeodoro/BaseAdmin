<?php

namespace ThallesTeodoro\BaseAdmin\App\Helpers;

class Paginator
{
    /**
     * Make the paginator
     *
     * @param [type] $items
     * @param integer $perPage
     * @param [type] $page
     * @param array $options
     * @return void
     */
    public static function make($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);
        return new \Illuminate\Pagination\LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
