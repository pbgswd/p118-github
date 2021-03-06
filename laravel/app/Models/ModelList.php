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
    public static function getModelList(): arraya
    {
        //metadata
        return [
            'Agreement' => [
                'name' => 'Agreements',
                'pub_route_list' => 'agreements_list_public',
                'admin_route_list' => 'agreements_list',
                'pub_route' => 'agreement_show',
                'admin_route' => 'agreement_edit',
            ],
            'Bylaw' => [
                'name' => 'Constitution & Bylaws',
                'pub_route_list' => 'bylaws_list_public',
                'admin_route_list' => 'admin_bylaws_list',
                'pub_route' => 'bylaw_show',
                'admin_route' => 'admin_bylaw_edit',
            ],
            'Committee' => [
                'name' => 'Committees',
                'pub_route_list' => 'committees',
                'admin_route_list' => 'committees_list',
                'pub_route' => 'committee',
                'admin_route' => 'committee_edit',
            ],
            'CommitteePost' => [
                'name' => 'Committee Posts',
                'pub_route_list' => 'committees',
                'admin_route_list' => 'committees_list',
                'pub_route' => 'public_committee_post_show',
                'admin_route' => 'admin_committee_post_edit',
            ],
            'Employment' => [
                'name' => 'Job Postings',
                'pub_route_list' => 'jobs_list',
                'admin_route_list' => 'admin_employment_list',
                'pub_route' => 'job_view',
                'admin_route' => 'admin_employment_edit',
            ],
            'Executive' => [
                'name' => 'Local 118 Executive',
                'pub_route_list' => 'executive',
                'admin_route_list' => 'admin_executives',
                'pub_route' => 'executive',
                'admin_route' => 'admin_executive_edit',
            ],
            'Feature' => [
                'name' => 'Feature',
                'pub_route_list' => 'features',
                'admin_route_list' => 'admin_features_list',
                'pub_route' => 'feature',
                'admin_route' => 'admin_feature_edit',
            ],
            'Organization' => [
                'name' => 'Organizations',
                'pub_route_list' => 'organizations',
                'admin_route_list' => 'organizations_list',
                'pub_route' => 'organization',
                'admin_route' => 'organization_edit',
            ],
            'Meeting' => [
                'name' => 'Meeting Minutes',
                'pub_route_list' => 'list_meetings',
                'admin_route_list' => 'meetings_list',
                'pub_route' => 'meeting',
                'admin_route' => 'meeting_edit',
            ],
            'Memoriam' => [
                'name' => 'In Memoriam',
                'pub_route_list' => 'memoriam_list',
                'admin_route_list' => 'admin_memoriam_list',
                'pub_route' => 'memoriam',
                'admin_route' => 'admin_memoriam_edit',
            ],
            'Page' => [
                'name' => 'Pages',
                'pub_route_list' => 'pages',
                'admin_route_list' => 'pages_list',
                'pub_route' => 'page_show',
                'admin_route' => 'page_edit',
            ],
            'Policy' => [
                'name' => 'Policies',
                'pub_route_list' => 'policies_list_public',
                'admin_route_list' => 'policies_list',
                'pub_route' => 'policy_show_public',
                'admin_route' => 'admin_policy_edit',
            ],
            'Post' => [
                'name' => 'Posts',
                'pub_route_list' => 'posts',
                'admin_route_list' => 'posts_list',
                'pub_route' => 'post_show',
                'admin_route' => 'post_edit',
            ],
            'Topic' => [
                'name' => 'Topics',
                'pub_route_list' => 'topics',
                'admin_route_list' => 'topics_list',
                'pub_route' => 'topic_show',
                'admin_route' => 'topic_edit',
            ],
            'Venue' => [
                'name' => 'Venues',
                'pub_route_list' => 'venues',
                'admin_route_list' => 'venues_list',
                'pub_route' => 'venue',
                'admin_route' => 'venue_edit',
            ],
        ];
    }
}
