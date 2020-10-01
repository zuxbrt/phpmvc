<?php

namespace core;

abstract class Controller
{
    /**
     * Get resource.
     */
    public function get($id){}

    /**
     * Create resource.
     */
    public function create(array $data){}

    /**
     * Update resource.
     */
    public function update(array $data){}

    /**
     * Delete resource.
     */
    public function delete(int $id){}
}