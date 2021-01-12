<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * @mixin Builder
 */
class AgentInbox extends Model
{
    use SoftDeletes;
    public $table = 'agent_inboxes';

}
