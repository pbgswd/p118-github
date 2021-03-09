<?php

namespace App\Services;


use App\Adapters\Proofreader\AgreementProofreaderAdapter;
use App\Adapters\Proofreader\BaseProofreaderAdapter;
use App\Adapters\Proofreader\BylawProofreaderAdapter;
use App\Adapters\Proofreader\CommitteePostProofreaderAdapter;
use App\Adapters\Proofreader\CommitteeProofreaderAdapter;
use App\Adapters\Proofreader\EmploymentProofreaderAdapter;
use App\Adapters\Proofreader\FeatureProofreaderAdapter;
use App\Adapters\Proofreader\MeetingProofreaderAdapter;
use App\Adapters\Proofreader\MemoriamProofreaderAdapter;
use App\Adapters\Proofreader\OrganizationProofreaderAdapter;
use App\Adapters\Proofreader\PageProofreaderAdapter;
use App\Adapters\Proofreader\PolicyProofreaderAdapter;
use App\Adapters\Proofreader\PostProofreaderAdapter;
use App\Adapters\Proofreader\VenueProofreaderAdapter;
use Illuminate\Support\Facades\DB;

class ProofreaderService
{
    /**
     * @var  BaseProofreaderAdapter[]
     */
    protected $adapters = [];

    public function __construct()
    {
        $this->adapters = [
            new AgreementProofreaderAdapter,
            new BylawProofreaderAdapter,
            new CommitteeProofreaderAdapter,
            new CommitteePostProofreaderAdapter,
            new EmploymentProofreaderAdapter,
            new FeatureProofreaderAdapter,
            new MeetingProofreaderAdapter,
            new MemoriamProofreaderAdapter,
            new OrganizationProofreaderAdapter,
            new PostProofreaderAdapter,
            new PageProofreaderAdapter,
            new PolicyProofreaderAdapter,
            new VenueProofreaderAdapter,
        ];
    }

    public function getContentNames(): array
    {
        $names = [];
        foreach ($this->adapters as $adapter)
        {
            $names[] = [
                'name' => $adapter->getContentName(),
                'title' => $adapter->getMeta()['name']
                ];
        }
        return $names;
    }

    public function sync()
    {
        DB::statement('CREATE TEMPORARY TABLE seen_links(link varchar(255))');

        foreach ($this->adapters as $adapter)
        {
            $data = $adapter->getAll();

            foreach ($data as $row)
            {
                DB::table('proofreader')
                    ->upsert(
                        [
                            [
                                'admin_link' => $adapter->getAdminRoute($row),
                                'pub_link' => $adapter->getPublicRoute($row),
                                'title' => $row->title ?? $row->name,
                                'content_type' => $adapter->getContentName(),
                                'content_title' => $adapter->getMeta()['name'],
                                'content_updated_at' => $row['updated_at'],
                                'created_at' => now(),
                                'updated_at' => now(),
                            ],
                        ],
                        ['link'],
                        ['content_updated_at', 'updated_at']);

                DB::table('seen_links')->insert(['link' => $adapter->getAdminRoute($row)]);
            }
        }

        DB::delete('DELETE pr
            FROM proofreader pr
            LEFT JOIN seen_links sl ON pr.admin_link = sl.link
            WHERE sl.link IS NULL');
    }
}













