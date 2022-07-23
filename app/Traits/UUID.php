<?php

namespace App\Traits;


trait UUID
{
    protected static function boot ()
    {        
        parent::boot();
    }

    // Tells the database not to auto-increment this field
    public function getIncrementing ()
    {
        return false;
    }

    // Helps the application specify the field type in the database
    public function getKeyType ()
    {
        return 'string';
    }
}