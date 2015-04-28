<?php

namespace Officium\Framework\Models;


interface SessionStorable {

    /**
     * Stores properties to the session.
     *
     * @return void
     */
    public function saveToSession();
}