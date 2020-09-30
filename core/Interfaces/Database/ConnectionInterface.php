<?php

namespace core\Interfaces\Database;

interface ConnectionInterface
{
    public function connect();

    public function query($query);
}
?>