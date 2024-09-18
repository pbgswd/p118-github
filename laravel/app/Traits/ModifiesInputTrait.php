<?php

namespace App\Traits;

/**
 * Trait ModifiesInputTrait.
 */
trait ModifiesInputTrait
{
    /**
     * @var bool
     */
    protected $isInputModified = false;

    /**
     * Wrapper to ensure input data is only modified once.
     *
     * @param  string[]  $keys
     */
    public function all($keys = null): array
    {
        // $this->all() can be called many times, but we only want to modify the data once.
        if (! $this->isInputModified) {
            $this->modifyInput();
            $this->isInputModified = true;
        }

        return parent::all($keys);
    }

    /**
     * Overwrite the input parameters for this Request.
     */
    protected function modifyInput(): void
    {
        // use $this->merge() to modify input parameters
    }
}
