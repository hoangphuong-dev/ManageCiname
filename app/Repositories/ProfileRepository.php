<?php

namespace App\Repositories;

use App\Helper\ImageHelper;
use App\Http\Resources\HospitalResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Models\UserQualification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileRepository
{
    protected $user;
    protected $userEducation;
    protected $userExperience;
    protected $userQualification;

    public function __construct(
        User $user,
        UserEducation $userEducation,
        UserExperience $userExperience,
        UserQualification $userQualification
    ) {
        $this->user = $user;
        $this->userEducation = $userEducation;
        $this->userExperience = $userExperience;
        $this->userQualification = $userQualification;
    }

    public function getProfileHospital()
    {
        $hospital = $this->user->query()
            ->where('id', Auth::guard('hospital')->user()->id)
            ->with(['hospitalInfo'])
            ->firstOrFail();

        return $hospital;
    }

    public function updateProfileHospital($data)
    {
        DB::beginTransaction();

        try {
            $hospital = $this->user->findOrFail(Auth::guard('hospital')->user()->id);

            $hospital->update([
                'name' => $data['name'],
                'email' => $data['email']
            ]);

            $hospital->hospitalInfo()->update([
                'image' => $data['image'],
                'hospital_type_id' => $data['hospital_type_id'],
                'address' => $data['address'],
                'phone' => $data['phone'],
                'content' => $data['content'],
            ]);

            if (!empty(array_filter($data['image_delete']))) {
                ImageHelper::deleteImages($data['image_delete']);
            }
            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollback();
            throw ($e);
        }
    }

    public function profileCareTaker()
    {
        $caretaker = $this->user->query()
            ->where('id', Auth::guard('caretaker')->user()->id)
            ->with(['userInfo', 'educations',  'experiences', 'qualifications'])
            ->firstOrFail();

        return UserResource::make($caretaker);
    }

    public function updateProfileCaretaker($data)
    {

        DB::beginTransaction();

        try {
            $caretaker = $this->user->findOrFail(Auth::guard('caretaker')->user()->id);

            $oldImage = null;
            if (isset($data['image'])) {
                $oldImage = $caretaker->avatar;
            }

            if (isset($data['password'])) {
                if (Hash::check($data['password'], $caretaker->password)) {
                    $caretaker->update([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'avatar' => isset($data['image']) ? $data['image'] : $caretaker->avatar,
                        'password' => Hash::make($data['password_new']),
                    ]);
                } else {
                    //TODO:
                    return  response()->json('err', 500);
                }
            } else {
                $caretaker->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'avatar' => isset($data['image']) ? $data['image'] : $caretaker->avatar,
                ]);
            }
            ImageHelper::deleteImage($oldImage);

            $this->updateUserInfo($caretaker, $data);
            if (isset($data['education'])) {
                $this->updateEducation($caretaker, $data);
            }
            if (isset($data['experiences'])) {
                $this->updateExperiences($caretaker, $data);
            }
            if (isset($data['qualifications'])) {
                $this->updateQualifications($caretaker, $data);
            }


            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollback();
            throw ($e);
        }
    }

    protected function updateUserInfo($caretaker, $data)
    {
        $caretaker->userInfo()->update([
            'name_kana' => $data['name_kana'],
            'name_kana_given' => $data['name_kana_given'],
            'degree_type' => isset($data['degree_type']) ? $data['degree_type'] : null,
            'age_type' => isset($data['age_type']) ? $data['age_type'] : null,
            'postal_code' => isset($data['postal_code']) ? $data['postal_code'] : null,
            'birthday' => isset($data['birthday']) ? $data['birthday'] : null,
            'full_age' => isset($data['full_age']) ? $data['full_age'] : null,
            'gender' => isset($data['gender']) ? $data['gender'] : null,
            'phone' => isset($data['phone']) ? $data['phone'] : null,
            'address' => isset($data['address']) ? $data['address'] : null,
            'address_furigana' => isset($data['address_furigana']) ? $data['address_furigana'] : null,
            'address_other_code' => isset($data['address_other_code']) ? $data['address_other_code'] : null,
            'address_other' => isset($data['address_other']) ? $data['address_other'] : null,
            'address_other_furigana' => isset($data['address_other_furigana']) ? $data['address_other_furigana'] : null,
            'forte_majors' => isset($data['forte_majors']) ? $data['forte_majors'] : null,
            'hobby' => isset($data['hobby']) ? $data['hobby'] : null,
            'sports_cultural' => isset($data['sports_cultural']) ? $data['sports_cultural'] : null,
            'health_status' => isset($data['health_status']) ? $data['health_status'] : null,
            'health_detail' => isset($data['health_detail']) ? $data['health_detail'] : null,
            'pr_myself' => isset($data['pr_myself']) ? $data['pr_myself'] : null,
            'job_target' => isset($data['job_target']) ? $data['job_target'] : null,
        ]);
    }

    protected function updateEducation($caretaker, $data)
    {
        foreach ($data['education'] as $dataEducation) {
            $educationId = isset($dataEducation['id']) ? $dataEducation['id'] : null;
            $caretaker->educations()->updateOrCreate(
                [
                    'id' => $educationId,
                    'user_id' => $caretaker->id,
                ],
                [
                    'name' => $dataEducation['name'],
                    'status' => $dataEducation['status'],
                    'start_date' => $dataEducation['start_date'],
                    'end_date' => $dataEducation['end_date'],
                ]
            );
        }

        if ($data['education_delete']) {
            $this->userEducation->destroy($data['education_delete']);
        }
    }

    protected function updateExperiences($caretaker, $data)
    {
        foreach ($data['experiences'] as $dataExperience) {
            $educationId = isset($dataExperience['id']) ? $dataExperience['id'] : null;
            $this->userExperience->updateOrCreate(
                [
                    'id' => $educationId,
                    'user_id' => $caretaker->id,
                ],
                [
                    'name' => $dataExperience['name'],
                    'time' => $dataExperience['time'],
                    'type' => $dataExperience['type'],
                ]
            );
        }

        if ($data['experiences_delete']) {
            $this->userExperience->destroy($data['experiences_delete']);
        }
    }

    protected function updateQualifications($caretaker, $data)
    {
        foreach ($data['qualifications'] as $dataQualification) {
            $educationId = isset($dataQualification['id']) ? $dataQualification['id'] : null;
            $this->userQualification->updateOrCreate(
                [
                    'id' => $educationId,
                    'user_id' => $caretaker->id,
                ],
                [
                    'name' => isset($dataQualification['name']) ? $dataQualification['name'] : null,
                    'status' => isset($dataQualification['status']) ? $dataQualification['status'] : null,
                    'date' => isset($dataQualification['date']) ? $dataQualification['date'] : null,
                ]
            );
        }

        if ($data['qualifications_delete']) {
            $this->userQualification->destroy($data['qualifications_delete']);
        }
    }
}
