<?php

namespace Grayloon\Magento\Models;

use Illuminate\Database\Eloquent\Model;

class MagentoCustomAttribute extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributing relational model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attributable()
    {
        return $this->morphTo();
    }
}
