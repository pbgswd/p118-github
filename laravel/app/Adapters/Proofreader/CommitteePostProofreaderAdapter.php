<?php

namespace App\Adapters\Proofreader;

use App\Models\CommitteePost;
use Illuminate\Database\Eloquent\Collection;

class CommitteePostProofreaderAdapter extends BaseProofreaderAdapter
{
    /**
     * CommitteePostProofreaderAdapter constructor.
     */
    public function __construct()
    {
        $this->contentClass = CommitteePost::class;
        $this->contentName = 'CommitteePost';
    }

    /**
     * @return string[]
     */
    public function getMeta(): array
    {
        // Committee Model - specific to this class
        return [
            self::NAME => 'Committee Posts',
            self::PUB_ROUTE_LIST => 'committee',
            self::ADMIN_ROUTE_LIST => 'committee_posts_list',
            self::PUB_ROUTE => 'public_committee_post_show',
            self::ADMIN_ROUTE => 'admin_committee_post_edit',
        ];
    }

    public function getAdminRoute($row): string
    {
        return route('admin_committee_post_edit', [$row->committee->slug, $row->slug]);
    }

    public function getPublicRoute($row): string
    {
        return route('public_committee_post_show', [$row->committee->slug, $row->slug]);
    }

    public function getAll(): Collection
    {
        return $this->getInstance()::with('committee')->get();
    }
}
