<?php

namespace App\Repositories;

use App\Contact;

class ContactRepository
{
    public function getBySearchQuery($query)
    {
        $parts = explode(' ', $query);

        $contacts = Contact::where('first_name', 'LIKE', $parts[0]."%");

        // if they search two words, it's most likely first and last name
        if (count($parts) > 1) {
            $contacts->where('last_name', 'LIKE', $parts[1]."%");
        } else {
            $contacts->orWhere('last_name', 'LIKE', $parts[0]."%")
                     ->orWhere('last_name', 'LIKE', $parts[0]."%")
                     ->orWhere('email', 'LIKE', $parts[0]."%")
                     ->orWhere('phone', 'LIKE', "%".$parts[0]."%");
        }

        return $contacts->get();
    }

    public function getAll()
    {
        return Contact::all();
    }
}