<?php

namespace App\Services;

use App\Helper\ImageHelper;
use App\Http\Resources\ContactResource;
use App\Http\Resources\HospitalResource;
use App\Repositories\MasterDataRepository;
use App\Repositories\ProfileRepository;

class ProfileService extends BaseService
{
    protected $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function getProfileHospital()
    {
        $hospital = $this->profileRepository->getProfileHospital();
        return HospitalResource::make($hospital);
    }

    public function updateProfileHospital($request)
    {
        $data = $request->validated();

        $data['image'] = array_filter($data['image'], function ($v) {
            return !is_null($v) && $v !== '';
        });
        if (!empty(array_filter($data['image_new']))) {
            foreach ($data['image_new'] as $image) {
                $imageNew = ImageHelper::upload($image);

                array_push($data['image'], $imageNew);
            }
        }

        return $this->profileRepository->updateProfileHospital($data);
    }

    public function updateProfileCaretaker($request)
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $image = ImageHelper::upload($data['image']);

            $data['image'] = $image;
        }

        return $this->profileRepository->updateProfileCaretaker($data);
    }
}
