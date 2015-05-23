<?php

namespace Officium\Framework\Models;

interface Saveable {

    /**
     * Stores properties to the session.
     *
     * @param User $user
     *
     * @return void
     */
    public function save(User $user);
}