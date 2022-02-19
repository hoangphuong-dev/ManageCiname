<?php

namespace App\Services;

use App\Exceptions\ApprovalJobProcessException;
use App\Http\Requests\UpdateJobRequest;
use App\Http\Resources\CaretakerListApplyJobResource;
use App\Http\Resources\CaretakerProcessJobResource;
use App\Http\Resources\CaretakerResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\JobApplyResource;
use App\Http\Resources\JobRelatedResource;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Models\JobApplyStatus;
use App\Models\JobPostApply;
use App\Models\User;
use App\Repositories\JobFavoriteRepository;
use App\Repositories\JobRepository;
use Carbon\Carbon;
use App\Repositories\JobPostApplyRepository;
use App\Repositories\JobProcessRepository;
use Illuminate\Support\Facades\DB;
use App\Repositories\JobApplyStatusRepository;
use App\Repositories\UserRepository;

class JobService extends BaseService
{
    protected $jobRepository;
    protected $uploadImageService;
    protected $jobFavoriteRepository;
    protected $jobPostApplyRepository;
    protected $jobProcessRepository;
    protected $jobApplyStatusRepository;
    protected $userRepository;

    public function __construct(
        JobRepository $jobRepository,
        UploadImageService $uploadImageService,
        JobFavoriteRepository $jobFavoriteRepository,
        JobPostApplyRepository $jobPostApplyRepository,
        JobProcessRepository $jobProcessRepository,
        JobApplyStatusRepository $jobApplyStatusRepository,
        UserRepository $userRepository
    ) {
        $this->jobRepository = $jobRepository;
        $this->uploadImageService = $uploadImageService;
        $this->jobFavoriteRepository = $jobFavoriteRepository;
        $this->jobPostApplyRepository = $jobPostApplyRepository;
        $this->jobProcessRepository = $jobProcessRepository;
        $this->jobApplyStatusRepository = $jobApplyStatusRepository;
        $this->userRepository = $userRepository;
    }

    public function list($request)
    {
        $userId = $this->getUserId('caretaker');
        $job = $this->jobRepository->list($request, $userId);
        return JobResource::collection($job);
    }

    public function getListFromHospital($request)
    {
        $hospitalId = $this->getUserId('hospital');
        $job = $this->jobRepository->getListFromHospital($request, $hospitalId);
        return JobResource::collection($job);
    }

    public function show($id)
    {
        $userId = $this->getUserId('caretaker');
        $job = $this->jobRepository->show($id, $userId);
        return JobResource::make($job);
    }

    public function store($request)
    {
        $data = $request->validated();
        $data['user_id'] =  $this->getUserId('hospital');
        $data['status'] = Job::STATUS_WAITING;
        $data['comapany_establishment'] = Carbon::parse($data['comapany_establishment']);

        if (!empty(array_filter($data['images']))) {
            $images = [];
            foreach ($data['images'] as $image) {
                $image = $this->uploadImageService->uploadImage($image, 'jobs');
                array_push($images, $image);
            }

            $data['images'] = $images;
        }

        return $this->jobRepository->store($data);
    }

    public function update(UpdateJobRequest $request, $id)
    {
        $data = $request->validated();
        $data['user_id'] =  $this->getUserId('hospital');
        $data['comapany_establishment'] = Carbon::parse($data['comapany_establishment']);
        if (!empty(array_filter($data['images']))) {
            $images = [];
            foreach ($data['images'] as $image) {
                $image = $this->uploadImageService->uploadImage($image, 'jobs');
                array_push($images, $image);
            }

            $data['images'] = $images;
        }

        return $this->jobRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->jobRepository->delete($id);
    }

    public function getListJobFavorite($request)
    {
        $userId = $this->getUserId('caretaker');

        $jobs = $this->jobRepository->getListJobFavorite($request, $userId, [
            'images', 'tags'
        ]);

        return JobResource::collection($jobs);
    }

    public function toggleFavorite($fill)
    {
        $userId = $this->getUserId('caretaker');
        $isFavorite = $fill['isFavorite'];
        $jobId = $fill['job_id'];

        if ($isFavorite) {
            return $this->jobFavoriteRepository->deleteFavorite($userId, $jobId);
        } else {
            return $this->jobFavoriteRepository->make($userId, $jobId);
        }
    }

    public function applyJob($jobId)
    {
        try {
            DB::beginTransaction();

            $userId = $this->getUserId('caretaker');

            $jobApplyStatus = $this->jobApplyStatusRepository->applyJob($userId, $jobId);

            $process = $this->jobProcessRepository->findFirstProcess($jobId);

            $jobApplyStatus->jobPostApply()->create([
                'job_process_id' => $process->id
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception(__('Có lỗi trong quá trình thực thi !'));
        }
    }

    public function getTag()
    {
        return $this->jobRepository->getTag();
    }

    public function getHospitalType()
    {
        return $this->jobRepository->getHospitalType();
    }

    public function getJobRelated($id)
    {
        return $this->jobRepository->getJobRelated($id);
    }

    public function getJobApply($request, $type)
    {
        $userId = $this->getUserId('caretaker');
        $jobs = $this->jobRepository->getJobApply($request, $userId, $type);

        return JobApplyResource::collection($jobs);
    }

    public function reviewingUserJob($jobId, $userId, $viewType)
    {
        try {
            $job = $this->jobRepository->reviewingUserJob($jobId, $userId, $viewType);
            $user = $this->userRepository->getCaretaker($userId);

            return [
                CaretakerProcessJobResource::make($job),
                CaretakerResource::make($user)
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function caretakerJobProcess($fill)
    {
        try {
            DB::beginTransaction();

            $userId = $this->getUserId('hospital');
            $jobId = $fill['job_id'];

            $job = $this->jobRepository->checkJobBelongToUser($userId, $jobId);

            if ($job === false) {
                throw new ApprovalJobProcessException(__('permission denied for this job'));
            }

            $status = $fill['status'];
            $jobApplyStatusId = $fill['jobApplyStatusId'];
            $processId = $fill['processId'];

            $statusUpdate = null;
            if ($status === 'done') {
                $statusUpdate = JobPostApply::JOB_DONE_STATUS;
            } else if ($status === 'reject') {
                $statusUpdate = JobPostApply::JOB_REJECT_STATUS;
            }

            if (is_null($statusUpdate)) {
                throw new \Exception('');
            }

            $this->jobPostApplyRepository->update($jobApplyStatusId, $processId, $statusUpdate);

            if ($statusUpdate === JobPostApply::JOB_REJECT_STATUS) {
                DB::commit();
                $this->jobApplyStatusRepository->updateById($jobApplyStatusId, [
                    'status' => JobApplyStatus::REJECT
                ]);
                return 'reject';
            }

            $nextProcess = $this->jobProcessRepository->findNextProcess($processId);

            if (is_null($nextProcess)) {
                DB::commit();
                $this->jobApplyStatusRepository->updateById($jobApplyStatusId, [
                    'status' => JobApplyStatus::SUCCESS
                ]);
                return 'done';
            }

            $this->jobPostApplyRepository->make([
                'job_apply_status_id' => $jobApplyStatusId,
                'job_process_id' => $nextProcess->id
            ]);

            DB::commit();
            return 'pending';
        } catch (ApprovalJobProcessException $e) {
            DB::rollback();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception(__('Có lỗi trong quá trình thực thi !'));
        }
    }

    public function getListCaretakerApplyJob($jobId)
    {
        $job = $this->jobRepository->getListCaretakerApplyJob($jobId);
        return CaretakerListApplyJobResource::make($job);
    }

    public function getAllRelated($jobId)
    {
        $job = $this->jobRepository->getAllRelated($jobId);
        return [
            $job->isShowApprovalButton(),
            JobRelatedResource::make($job),
        ];
    }

    public function getJobDetailWithProcess($jobId, $jobApplyId)
    {
        $userId = $this->getUserId('caretaker');
        list($job, $jobApply) = $this->jobRepository->getJobDetailWithProcess($jobId, $userId, $jobApplyId);
        return [
            JobRelatedResource::make($job),
            $jobApply
        ];
    }
    public function approvalJob($jobId)
    {
        return $this->jobRepository->approvalJob($jobId);
    }

    public function checkDeleteProcess($jobId, $jobPrrocessId)
    {
        return $this->jobRepository->checkDeleteProcess($jobId, $jobPrrocessId);
    }

    public function caretakersRelated($jobId)
    {
        return $this->jobRepository->caretakersRelated($jobId);
    }

    public function caretakerCommentJob($request, $jobId)
    {
        $data = $request->validated();
        return $this->jobRepository->caretakerCommentJob($data, $jobId);
    }

    public function getListComment($request, $jobId)
    {
        $userId = $this->getUserId('hospital');
        $comments = $this->jobRepository->getListComment($request, $jobId);

        return CommentResource::collection($comments);
    }

    public function updateStatusComment($request, $commentId)
    {
        $status = $request->status;
        return $this->jobRepository->updateStatusComment($status, $commentId);
    }
}
