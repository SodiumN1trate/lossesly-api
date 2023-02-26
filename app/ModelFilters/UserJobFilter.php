<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class UserJobFilter extends ModelFilter
{
    public function id($id)
    {
        return $this->where('id', $id);
    }

    public function jobName($job_name)
    {
        return $this->whereLike('job_name', $job_name);
    }

    public function jobDescription($job_description)
    {
        return $this->where('job_description', $job_description);
    }
    public function price($price)
    {
        return $this->whereBetween('price', $price);
    }

    public function user($user_id)
    {
        return $this->where('user_id', $user_id);
    }

    public function expert($expert_id)
    {
        return $this->where('expert_id', $expert_id);
    }

    public function status($status_id)
    {
        return $this->where('status_id', $status_id);
    }

    public function started($started)
    {
        return $this->where('started', $started);
    }

    public function end($end)
    {
        return $this->where('end', $end);
    }
    public $relations = [];
}
