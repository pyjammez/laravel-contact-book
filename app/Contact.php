<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'custom_1', 'custom_2', 'custom_3', 'custom_4', 'custom_5'];
    
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $phone;
    protected $custom_1;
    protected $custom_2;
    protected $custom_3;
    protected $custom_4;
    protected $custom_5;
}
