<?php

namespace App\Traits;

trait WithRelationalSort
{
    /* TODO refactor this to a parameter, config.. ? make it more flexible*/
    private array $relation_map = [
        'businessRequest' => 'business_requests',
        'hall' => 'halls',
    ];

    /**
     * Maps the sort_by parameter to a column and a type (direct or relation)
     * [type => direct|relation, column => column_name]
     * Eloquent doesn't support sorting polymorphic relationships out of the box
     * Used for sortPolymorphic scope
     *
     * @param string $sort_by
     * @return string[]
     */
    public function resolveSortByParameter(string $sort_by): array
    {
        $params = explode('.', $sort_by);

        return count($params) > 1
            ? ['type' => 'relation', 'relation' => $this->relation_map[$params[0]], 'column' => $params[1]]
            : ['type' => 'direct', 'relation' => 'none', 'column' => $sort_by];
    }
}
