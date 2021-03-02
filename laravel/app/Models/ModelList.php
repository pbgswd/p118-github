<?php

namespace App\Models;


class ModelList
{
    /**
     * @param $model
     * @return string[]
     */
    public function getModelInfo(string $model): array
    {
        $arr = $this->getModelList();
        return $arr[$model];
    }

    /**
     * @return \string[][]
     */
    public static function getModelList(): array
    {
        return [
            'Agreement' => [
                'name' => 'Agreements',
                'pub_route_list' => 'agreements_list_public',
                'admin_route_list' => 'agreements_list',

            ],
            'Bylaw' => [
                'name' => 'Constitution & Bylaws',
                'pub_route_list' => 'bylaws_list_public',
                'admin_route_list' => 'admin_bylaws_list',
            ],
            'Committee' => [
                'name' => 'Committees',
                'pub_route_list' => 'committees',
                'admin_route_list' => 'committees_list',
            ],
            'CommitteePost' => [
                'name' => 'Committee Posts',
                'pub_route_list' => 'committees',
                'admin_route_list' => 'committees_list',
            ],
            'Employment' => [
                'name' => 'Job Postings',
                'pub_route_list' => 'jobs_list',
                'admin_route_list' => 'admin_employment_list',
            ],
            'Executive' => [
                'name' => 'Local 118 Executive',
                'pub_route_list' => 'executive',
                'admin_route_list' => 'admin_executives',
            ],
            'Feature' => [
                'name' => 'Feature',
                'pub_route_list' => 'features',
                'admin_route_list' => 'admin_features_list',
            ],
            'Organization' => [
                'name' => 'Organizations',
                'pub_route_list' => 'organizations',
                'admin_route_list' => 'organizations_list',
            ],
            'Meeting' => [
                'name' => 'Meeting Minutes',
                'pub_route_list' => 'list_meetings',
                'admin_route_list' => 'meetings_list',
            ],
            'Memoriam' => [
                'name' => 'In Memoriam',
                'pub_route_list' => 'memoriam_list',
                'admin_route_list' => 'admin_memoriam_list',
            ],
            'Page' => [
                'name' => 'Pages',
                'pub_route_list' => 'pages',
                'admin_route_list' => 'pages_list',
            ],
            'Policy' => [
                'name' => 'Policies',
                'pub_route_list' => 'policies_list_public',
                'admin_route_list' => 'policies_list',
            ],
            'Post' => [
                'name' => 'Posts',
                'pub_route_list' => 'posts',
                'admin_route_list' => 'posts_list',
            ],
            'Topic' => [
                'name' => 'Topics',
                'pub_route_list' => 'topics',
                'admin_route_list' => 'topics_list',
            ],
            'Venue' => [
                'name' => 'Venues',
                'pub_route_list' => 'venues',
                'admin_route_list' => 'venues_list',
            ],
        ];
    }
}
