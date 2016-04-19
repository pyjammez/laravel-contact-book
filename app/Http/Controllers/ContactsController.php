<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ContactRequest;
use App\Repositories\ContactRepository;
use App\Contact;
use Auth;
use App\Helpers\ActiveCampaignHelper;

class ContactsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ContactRepository $repo, Request $request)
    {
        $contacts = ($query = $request->get('query'))
            ?  $repo->getBySearchQuery($query)
            :  $repo->getAll();

        $view = ($request->ajax()) ? '_contact_list' : 'index';

        return view("contacts.$view", ['contacts' => $contacts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Contact $contact)
    {
        return view('contacts.edit', [
            'action' => 'Add',
            'contact' => $contact
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request, ActiveCampaignHelper $ac)
    {
        $contact = new Contact($request->all());
        $contact->users_id = Auth::id();
        $contact->save();

        $list_id = Auth::user()->list_id;

        $response = $ac->addContact($contact, $list_id);

        if ($response['success']) {
            $contact->subscriber_id = $response['msg'];
            $contact->save();
        } else {
            $response['msg'] .= "Contact is not saved to ActiveCampaign. We will
            need to add a syncing option on the main page.";
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact, $id)
    {
        return view('contacts.edit', [
            'action' => 'Edit',
            'contact' => $contact::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, ActiveCampaignHelper $ac, Contact $contact, $id)
    {
        $contact = $contact::find($id);
        $subscriber_id = $contact->subscriber_id;
        $requests = $request->all();
        $list_id = Auth::user()->list_id;

        foreach ($requests as $key => $value) {
            if (isset($contact->$key)) {
                $contact->$key = $value;
            }
        }

        $contact->save();

        if ($subscriber_id) {
            $response = $ac->updateContact($contact, $contact->subscriber_id, $list_id);
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact, ActiveCampaignHelper $ac, $id)
    {
        $contact = $contact::find($id);

        // if active campaign wasn't working, there is no subscriber id
        if($contact->subscriber_id) {
            $response = $ac->deleteContact($contact->subscriber_id);
        } else {
            $response = ['success' => 1];
        }

        $contact->delete();

        return response()->json($response);
    }
}
