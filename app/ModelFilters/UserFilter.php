<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{
    protected $blacklist = ['secretMethod'];

    // This will filter 'company_id' OR 'company'
    public function id($id)
    {
        return $this->where('id', $id);
    }

    public function name($name)
    {
        return $this->where('name', $name);
    }

    public function surname($surname)
    {
        return $this->where('surname', $surname);
    }

    public function email($email)
    {
        return $this->where('email', $email);
    }

    public function gender($gender)
    {
        return $this->where('gender', $gender);
    }

    public function rating($rating)
    {
        return $this->where('rating', $rating);
    }

    public function location($location)
    {
        return $this->where('location', $location);
    }

    public function speciality($speciality)
    {
        return $this->related('specialities', 'speciality_id', '=', $speciality);
    }

    public function price($price)
    {
        return $this->related('specialities', 'price_per_hour', '=', $price);
    }

}
