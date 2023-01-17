<?php

namespace UnixDevil\Crawler\Contracts;

use Illuminate\Support\Collection;

interface BaseRepositoryContract
{
    public function find(int $recordID);
    public function create(array $data);
    public function delete(int $recordID);
}
