<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository
{
    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function list($request)
    {
        $check = $request->status || $request->status === '0' ? true : false;
        return $this->contact->query()
            ->when($request->name, function ($query) use ($request) {
                return $query->where("name", "like", "%{$request->name}%");
            })
            ->when($check, function ($query) use ($request) {
                return $query->where("status", $request->status);
            })
            ->when($request->type, function ($query) use ($request) {
                return $query->where("type", $request->type);
            })
            ->paginate($request->query('limit', 10));
    }

    public function show($id)
    {
        $contact = $this->contact->findOrFail($id);
        if ($contact->status === Contact::CONTACT_STATUS_UNREAD) {
            $contact->update(['status' => Contact::CONTACT_STATUS_READ]);
        };

        return $contact;
    }

    public function answerContact($id, $answer_content)
    {
        $contact = $this->contact->findOrFail($id);
        $contact->update(['answer_content' => $answer_content]);

        return $contact;
    }

    public function destroy($id)
    {
        $contact =  $this->contact->findOrFail($id);
        return $contact->delete();
    }

    public function store($data) {
        $this->contact->create($data);
    }
}
