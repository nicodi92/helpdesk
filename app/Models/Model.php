<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    /**
     * The created at human accessor.
     *
     * @return string
     */
    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * The updated at human accessor.
     *
     * @return string
     */
    public function getUpdatedAtHumanAttribute()
    {
        return $this->updated_at->diffForHumans();
    }

    /**
     * Returns the models ID with a proceeding hash.
     *
     * @return string
     */
    public function getHashIdAttribute()
    {
        return '#'.$this->id;
    }
}
