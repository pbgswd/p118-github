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
                'route' => 'agreements_list_public',
                'admin_route' => 'agreements_list',
            ],
            'Bylaw' => [
                'name' => 'Constitution & Bylaws',
                'route' => 'bylaws_list_public',
                'admin_route' => 'admin_bylaws_list',
            ],
            'Committee' => [
                'name' => 'Committees',
                'route' => 'committees',
                'admin_route' => 'committees_list',
            ],
            'CommitteePost' => [
                'name' => 'Committee Posts',
                'route' => 'committees',
                'admin_route' => 'committees_list',
            ],
            'Employment' => [
                'name' => 'Job Postings',
                'route' => 'jobs_list',
                'admin_route' => 'admin_employment_list',
            ],
            'Executive' => [
                'name' => 'Local 118 Executive',
                'route' => 'executive',
                'admin_route' => 'admin_executives',
            ],
            'Feature' => [
                'name' => 'Feature',
                'route' => 'features',
                'admin_route' => 'admin_features_list',
            ],
            'Organization' => [
                'name' => 'Organizations',
                'route' => 'organizations',
                'admin_route' => 'organizations_list',
            ],
            'Meeting' => [
                'name' => 'Meeting Minutes',
                'route' => 'list_meetings',
                'admin_route' => 'meetings_list',
            ],
            'Memoriam' => [
                'name' => 'In Memoriam',
                'route' => 'memoriam_list',
                'admin_route' => 'admin_memoriam_list',
            ],
            'Page' => [
                'name' => 'Pages',
                'route' => 'pages',
                'admin_route' => 'pages_list',
            ],
            'Policy' => [
                'name' => 'Policies',
                'route' => 'policies_list_public',
                'admin_route' => 'policies_list',
            ],
            'Post' => [
                'name' => 'Posts',
                'route' => 'posts',
                'admin_route' => 'posts_list',
            ],
            'Topic' => [
                'name' => 'Topics',
                'route' => 'topics',
                'admin_route' => 'topics_list',
            ],
            'Venue' => [
                'name' => 'Venues',
                'route' => 'venues',
                'admin_route' => 'venues_list',
            ],
        ];
    }
}
