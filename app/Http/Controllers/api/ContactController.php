<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function allContact(){
        $contact = Contact::all();
        return response()->json([
            "status"=>"Succes",
            "message"=> "Contact sync succesfully",
            "data"=> $contact
        ]);
    }

    public function storeContacts(Request $request)
    {
        
        $request->validate([
            'contacts' => 'required|array',
            'contacts.*.name' => 'required|string',
            'contacts.*.mobile' => 'required|numeric',
        ]);

        $user = $request->user();
        $arrContacts = [];

        foreach ($request->contacts as $contactData) {
            $contact = new Contact();
            $contact->user_id = $user->id;
            $contact->name = $contactData['name'];
            $contact->mobile = $contactData['mobile'];
            $contact->save();
            $arrContacts[] = $contact;
        }
        return response()->json([
            "status" => "Success",
            "message" => "Contacts synced successfully",
            "data" => $arrContacts
        ]);
    }
}
