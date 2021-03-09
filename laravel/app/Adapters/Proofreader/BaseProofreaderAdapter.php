<?php


namespace App\Adapters\Proofreader;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


abstract class BaseProofreaderAdapter
{
    public const NAME = 'name';
    public const PUB_ROUTE_LIST = 'pub_route_list';
    public const ADMIN_ROUTE_LIST = 'admin_route_list';
    public const PUB_ROUTE = 'pub_route';
    public const ADMIN_ROUTE = 'admin_route';

    protected $contentClass;
    protected $contentName;
    protected $instance;

    abstract public function getAdminRoute(array $row): string;
    abstract public function getPublicRoute(array $row): string;

    public function getAll(): Collection
    {
        return $this->getInstance()::all();
    }

    public function getContentClass(): string
    {
        return $this->contentClass;
    }

    public function getContentName(): string
    {
        return $this->contentName;
    }


    public function getDatum($metaKey): string
    {
        return $this->getMeta()[$metaKey] ?? '';
    }

    public function getInstance(): Model
    {
        if (!$this->instance) {

            $this->instance = (new \ReflectionClass($this->contentClass))->newInstance();
        }

        return $this->instance;
    }
}
