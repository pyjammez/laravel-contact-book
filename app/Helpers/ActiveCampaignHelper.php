<?php

namespace App\Helpers;

use ActiveCampaign;

class ActiveCampaignHelper
{
    protected $ac;
    
    public function __construct()
    {
        $this->ac = new ActiveCampaign('https://genesisdigital530.api-us1.com', 'a962c383895cb4020c27e8fb0bdcb45bac723b4f81de01e7262b588775df8382b3c6136b');
        if (!(int)$this->ac->credentials_test()) {
            return [
                'success' => false, 
                'msg' => "<p>Access denied: Invalid credentials (URL and/or API key).</p>"
            ];
        }
    }
    
    public function addList($user)
    {
        $list = array(
    		"name" => $user->name,
            "sender_name"    => "My Company",
            "sender_addr1"   => "123 S. Street",
            "sender_city"    => "Chicago",
            "sender_zip"     => "60601",
            "sender_country" => "USA",
    	);
        
    	$result = $this->ac->api("list/add", $list);

        if (!$success = (int)$result->success) {
            $msg = "<p>Adding list failed. Error returned: " . $result->error . "</p>";
        } else {
            $msg = (int)$result->id;
        }
        
        return [
            'success' => $success,
            'msg' => $msg
        ];
    }
    
    public function addContact($contact, $list_id)
    {
        $data = [
    		"email"               => $contact->email,
    		"first_name"          => $contact->first_name,
    		"last_name"           => $contact->last_name,
            "phone"               => $contact->phone,
            "field[1,0]"          => $contact->custom_1,
            "field[2,0]"          => $contact->custom_2,
            "field[3,0]"          => $contact->custom_3,
            "field[4,0]"          => $contact->custom_4,
            "field[5,0]"          => $contact->custom_5,
    		"p[$list_id]"         => $list_id,
    		"status[1]"           => 1, // "Active" status
    	];
        
    	$result = $this->ac->api("contact/add", $data);
    	
        if (!$success = (int)$result->success) {
            $msg = "<p>Adding contact failed. Error returned: " . $result->error . "</p>";
    	} else {
            $msg = (int)$result->subscriber_id;
        }
        
        return [
            'success' => $success,
            'msg' => $msg
        ];
    }
    
    public function deleteContact($id)
    {
        $data = [
            "id" => $id,
        ];

        $result = $this->ac->api("contact/delete", $data);

        if (!$success = (int)$result->success) {
            $msg = "<p>Deleting contact failed. Error returned: " . $result->error . "</p>";
        } else {
            $msg = "";
        }
        
        return [
            'success' => $success,
            'msg' => $msg
        ];
    }
    
    public function updateContact($contact, $id, $list_id)
    {
        $data = [
            "id"                  => $id,
    		"email"               => $contact->email,
    		"first_name"          => $contact->first_name,
    		"last_name"           => $contact->last_name,
            "phone"               => $contact->phone,
            "field[1,0]"          => $contact->custom_1,
            "field[2,0]"          => $contact->custom_2,
            "field[3,0]"          => $contact->custom_3,
            "field[4,0]"          => $contact->custom_4,
            "field[5,0]"          => $contact->custom_5,
            "p[$list_id]"         => $list_id,
    	];
        
        $result = $this->ac->api("contact/edit", $data);
        
        if (!$success = (int)$result->success) {
            $msg = "<p>Editing contact failed. Error returned: " . $result->error . "</p>";
        } else {
            $msg = "";
        }
        
        return [
            'success' => $success,
            'msg' => $msg
        ];
    }
}