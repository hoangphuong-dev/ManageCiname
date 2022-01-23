<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Filters\FavoriteFilters;
use App\Models\Filters\JobApplyFIlters;
use App\Models\Filters\JobBeLongToHospitalFilters;
use App\Models\Filters\JobFilters;
use App\Models\HospitalInfo;
use App\Models\HospitalType;
use App\Models\Job;
use App\Models\JobApplyStatus;
use App\Models\JobImage;
use App\Models\JobPostApply;
use App\Models\JobProcess;
use App\Models\Tag;
use App\Models\User;
use App\Services\UploadImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobRepository
{
    protected $job;
    protected $jobProcess;
    protected $jobImage;
    protected $uploadImageService;
    protected $tag;
    protected $hospitalType;
    protected $hospitalInfo;
    protected $comment;

    public function __construct(
        Job $job,
        JobProcess $jobProcess,
        JobImage $jobImage,
        UploadImageService $uploadImageService,
        Tag $tag,
        HospitalType $hospitalType,
        HospitalInfo $hospitalInfo,
        Comment $comment
    ) {
        $this->job = $job;
        $this->jobProcess = $jobProcess;
        $this->jobImage = $jobImage;
        $this->uploadImageService = $uploadImageService;
        $this->tag = $tag;
        $this->hospitalType = $hospitalType;
        $this->hospitalInfo = $hospitalInfo;
        $this->comment = $comment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list($request, $userId)
    {
        $callable = function (&$query) use ($userId) {
            if ($userId !== null) {
                $query->where('user_id', $userId);
            } else {
                $query->whereRaw('1 = 2');
            }
        };

        $builder = $this->job->query()
            ->show()
            ->with(['processes', 'images', 'tags'])
            ->with(['jobApplyPending' => $callable, 'jobApplyReject' => $callable, 'favorites' => $callable])
            ->filters(new JobFilters($request));

        return $builder->paginate($request->query('limit', 10));
    }

    public function getListFromHospital($request, $hospitalId)
    {
        $builder = $this->job->query()
            ->where('user_id', $hospitalId)
            ->with(['processes', 'images', 'tags'])
            ->withCount('jobApply')
            ->filters(new JobFilters($request));
        return $builder->paginate($request->query('limit', 10));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id, $userId)
    {
        $callable = function (&$query) use ($userId) {
            $query->where('user_id', $userId);
        };
        return $this->job->query()
            ->with(['processes', 'images', 'tags'])
            ->when($userId, function ($query) use ($callable) {
                $query->with(['jobApplyPending' => $callable, 'jobApplyReject' => $callable, 'favorites' => $callable]);
            })
            ->findOrFail($id);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  array $data
     *
     * @return true
     * @throws \Throwable $e
     */
    public function store($data)
    {
        DB::beginTransaction();

        try {
            $job = $this->job->create($data);

            if (!empty(array_filter($data['images']))) {
                $imagesData = $this->prepareImagesData($data['images'], $job->id);
                $job->images()->insert($imagesData);
            }

            $processesData = $this->prepareImagesData($data['job_process'], $job->id);
            $job->processes()->insert($processesData);

            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollback();
            throw ($e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array $data
     * @param  int  $id
     *
     * @return true
     * @throws \Throwable $e
     */
    public function update($data, $id)
    {
        DB::beginTransaction();

        try {
            $job = $this->job->findOrFail($id);
            $job->update($data);

            if (!empty(array_filter($data['images']))) {
                $imagesData = $this->prepareImagesData($data['images'], $job->id);
                $job->images()->insert($imagesData);
            }

            if ($data['images_delete']) {
                $imageIds = collect($data['images_delete'])->pluck('id')->toArray();
                $imagePaths = collect($data['images_delete'])->pluck('path')->toArray();

                $this->jobImage->destroy($imageIds);
                foreach ($imagePaths as $imagePath) {
                    $this->uploadImageService->removeImage($imagePath);
                }
            }

            foreach ($data['job_process'] as $dataProcess) {
                $jobProcessId = isset($dataProcess['id']) ? $dataProcess['id'] : null;
                $this->jobProcess->updateOrCreate(
                    [
                        'id' => $jobProcessId,
                        'job_id' => $job->id,
                    ],
                    [
                        'content' => $dataProcess['content'],
                        'order' => $dataProcess['order'],
                    ]
                );
            }
            if ($data['job_process_delete']) {
                $this->jobProcess->destroy($data['job_process_delete']);
            }

            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollback();
            throw ($e);
        }
    }

    /**
     * @param  array  $imagesData
     * @param  int  $jobId
     *
     * @return array $imagesData
     */
    public function prepareImagesData($imagesData, $jobId)
    {
        foreach ($imagesData as $key => $imageData) {
            $imagesData[$key]['job_id'] =  $jobId;
        }

        return $imagesData;
    }

    /**
     * @param  array  $processesData
     * @param  int  $jobId
     *
     * @return array $processesData
     */
    public function prepareProcessesData($processesData, $jobId)
    {
        foreach ($processesData as $key => $processData) {
            $processesData[$key]['job_id'] =  $jobId;
        }

        return $processesData;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return true
     * @throws \Throwable $e
     */
    public function delete($id)
    {
        try {
            $job = $this->jobProcess->findOrFail($id);
            $job = $job->delete();

            return true;
        } catch (\Throwable $e) {
            DB::rollback();
            throw ($e);
        }
    }

    private function withAllRelation(&$model, $relations)
    {
        $model->with($relations)->with('user.hospitalInfo:address,user_id')->with('user:name,id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListJobFavorite($request, $userId, $relations = ['processes', 'images', 'tags'])
    {
        $callable = function (&$query) use ($userId) {
            $query->where('user_id', $userId);
        };
        $model = $this->job->query()
            ->show()
            ->join('job_favorites as jf', 'jf.job_id', 'jobs.id')
            ->where('jf.user_id', $userId)
            ->select('jobs.*')
            ->orderBy('jf.id', 'DESC')
            ->with(['jobApplyPending' => $callable, 'jobApplyReject' => $callable])
            ->filters(new FavoriteFilters($request));
        $this->withAllRelation($model, $relations);

        return $model->paginate($request->query('limit', 10));
    }

    public function getTag()
    {
        return $this->tag->get();
    }

    public function getHospitalType()
    {
        return $this->hospitalType->get();
    }

    public function getJobRelated($id)
    {
        $job = Job::findOrFail($id);
        return Job::with('images')->where('user_id', $job->user_id)->get();
    }

    public function getJobApply($request, $userId, $type)
    {
        $model = $this->job->query()
            ->join('job_apply_statuses as jas', 'jas.job_id', 'jobs.id')
            ->orderBy('jas.updated_at', 'DESC')
            ->where('jas.user_id', $userId)
            ->when($type, function ($query, $type) {
                if ($type === 'apply') {
                    $query->where('jas.status', JobApplyStatus::PENDING);
                } else {
                    $query->whereIn('jas.status', [JobApplyStatus::SUCCESS, JobApplyStatus::REJECT]);
                }
            })
            ->selectRaw('jobs.id, jobs.name, jas.times')
            ->with('processes:job_id,id,order,content')
            ->when($type, function ($query, $type) {
                $with = function ($relation) use (&$query) {
                    $query->with($relation, function ($builder) {
                        $builder->selectRaw('id,times,job_id,status')->with('jobPostApply', function ($builder) {
                            $builder->orderBy('id', 'asc')->selectRaw('job_process_id,job_apply_status_id,status,updated_at');
                        });
                    });
                };

                if ($type === 'apply') {
                    $with('jobApplyPending');
                } else {
                    $with('jobApplyDone');
                }
            })
            ->filters(new JobApplyFIlters($request))
            ->paginate($request->query('limit', 10));
        return $model;
    }

    public function reviewingUserJob($jobId, $userId, $viewType)
    {
        try {
            $job = $this->job->query()->findOrFail($jobId);

            $load = null;
            if ($viewType === "pending") {
                $load = 'jobApplyPending';
            } else if ($viewType === "done") {
                $load = 'jobApplyDone';
            } else if ($viewType === "reject") {
                $load = 'jobApplyReject';
            }

            $job->load([$load => function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->with('jobPostApply');
            }]);

            $job->load('processes');

            return $job;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getListCaretakerApplyJob($jobId)
    {
        $job = $this->job->query()
            ->select('id')->findOrFail($jobId);
        $job->load('processes');
        $job->load(['jobApply' => function ($query) {
            $query->with(['jobPostApply', 'user.userInfo']);
        }]);
        return $job;
    }

    public function getJobBeLongToHospital($hospitalId, $request)
    {
        return $this->job->query()
            ->where('user_id', $hospitalId)
            ->select(['id', 'name', 'created_at', 'updated_at', 'status'])
            ->orderBy('created_at', 'desc')
            ->filters(new JobBeLongToHospitalFilters($request))
            ->paginate($request->query('limit', 10));
    }

    public function getAllRelated($jobId)
    {
        $job = $this->job->query()
            ->findOrFail($jobId);
        $job->load([
            'user.hospitalInfo',
            'processes',
            'images',
            'tags'
        ]);
        return $job;
    }

    public function getJobDetailWithProcess($jobId, $userId, $jobApplyId)
    {
        $callable = function (&$query) use ($userId) {
            $query->where('user_id', $userId);
        };
        $job = $this->getAllRelated($jobId);
        $job->load(['jobApplyPending' => $callable, 'jobApplyReject' => $callable, 'favorites' => $callable]);
        $job->load(['jobApply' => function ($query) use ($jobApplyId) {
            $query->where('id', $jobApplyId)
                ->with('jobPostApply');
        }]);

        return [
            $job,
            $job->jobApply
        ];
    }

    public function approvalJob($jobId)
    {
        $this->job->query()->findOrFail($jobId)->update([
            'status' => Job::STATUS_PUBLIC
        ]);
    }

    /**
     *
     * @return bool
     */
    public function checkDeleteProcess($jobId, $jobPrrocessId): bool
    {
        $check = JobPostApply::query()
            ->where('job_process_id', $jobPrrocessId)
            ->exists();

        return !$check;
    }

    public function checkJobBelongToUser($userId, $jobId)
    {
        $job = $this->job->query()->where([
            'id' => $jobId,
            'user_id' => $userId
        ])->first();

        if (is_null($job)) {
            return false;
        }
        return $job;
    }

    public function caretakerCommentJob($data, $jobId)
    {

        DB::beginTransaction();

        try {
            $caretaker = User::findOrFail(Auth::guard('caretaker')->user()->id);
            $job = $this->job->findOrFail($jobId);

            $caretaker->comments()->create([
                'job_id' => $jobId,
                'content' => $data['content'],
                'status' => Comment::COMMENT_STATUS_SHOW,
            ]);

            if (isset($data['favorable_interview']) || isset($data['favorable_interview'])) {
                $caretaker->rating()->updateOrCreate([
                    'job_id' => $jobId,
                    'user_id' => $caretaker->id,
                ], [
                    'favorable_interview' => isset($data['favorable_interview']) ? $data['favorable_interview'] : 0,
                    'atmosphere_interview' => isset($data['atmosphere_interview']) ? $data['atmosphere_interview'] : 0,
                ]);
            }

            $job->update([
                'rate_count' => $job->ratings->count(),
                'rate_average' => $job->toltalAvgRating,
            ]);

            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollback();
            throw ($e);
        }
    }

    public function getListComment($request, $jobId)
    {
        $comments = $this->comment->query()
            ->where('job_id', $jobId)
            ->with('user')
            ->paginate($request->query('limit', 10));

        return $comments;
    }

    public function updateStatusComment($status, $commentId)
    {
        $comment = $this->comment->query()
            ->where('id', $commentId)
            ->update(['status' => $status]);

        return true;
    }
}
