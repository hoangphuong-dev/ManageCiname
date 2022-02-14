<?php

namespace App\Services;

use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\User;
use App\Repositories\ContactRepository;
use Illuminate\Support\Facades\Auth;

class ContactService extends BaseService
{
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function list($request)
    {
        $contacts = $this->contactRepository->list($request);

        return ContactResource::collection($contacts);
    }

    public function show($id)
    {
        return $this->contactRepository->show($id);
    }

    public function answerContact($id, $request)
    {
        $answer_content = $request->answer_content;
        return $this->contactRepository->answerContact($id, $answer_content);
    }

    public function destroy($id)
    {
        return $this->contactRepository->destroy($id);
    }

    public function store($request) {
        $data = $request->validated();
        $user = Auth::guard('caretaker')->user();
        if(is_null($user)) {
            $data['sender_id'] =  Auth::guard('hospital')->user()->id;
            $data['type'] = Contact::CONTACT_TYPE_HOSPITAL;
        } else {
            $data['sender_id'] =  Auth::guard('caretaker')->user()->id;
            $data['type'] = Contact::CONTACT_TYPE_CARETAKER;
        }
        $data['status'] = Contact::CONTACT_STATUS_UNREAD;
        return $this->contactRepository->store($data);
    }
}
