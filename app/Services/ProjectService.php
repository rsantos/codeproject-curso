<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectMemberValidator;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

class ProjectService
{
	protected $repository;
	protected $validator;
	/**
	 * @var ProjectMemberRepository
	 */
	private $projectMemberRepository;
	/**
	 * @var ProjectMemberValidator
	 */
	private $projectMemberValidator;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Storage
     */
    private $storage;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator, ProjectMemberRepository $projectMemberRepository, ProjectMemberValidator $projectMemberValidator, Filesystem $filesystem, Storage $storage)
	{
		$this->repository = $repository;
		$this->validator = $validator;
		$this->projectMemberRepository = $projectMemberRepository;
		$this->projectMemberValidator = $projectMemberValidator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
    }

	public function addMember(array $data)
	{
		try {
			$this->projectMemberValidator->with($data)->passesOrFail();
			return $this->projectMemberRepository->create($data);
		} catch(ValidatorException $e){
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	public function removeMember($projectId, $userId)
	{
        $member = $this->projectMemberRepository->skipPresenter()->findWhere(['project_id' => $projectId, 'user_id' => $userId]);

        return $this->projectMemberRepository->delete($member->id);
	}

	public function members($projectId){
		return $this->projectMemberRepository->skipPresenter()->findWhere(['project_id' => $projectId]);
	}

	public function isMember($projectId, $userId)
	{
		return $this->repository->hasMember($projectId, $userId);
	}

	public function create(array $data)
	{
		try {
			$this->validator->with($data)->passesOrFail();
			return $this->repository->create($data);
		} catch(ValidatorException $e){
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	public function update(array $data, $id)
	{
		try {
			$this->validator->with($data)->passesOrFail();
			return $this->repository->update($data, $id);
		} catch(ValidatorException $e){
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}
	}

    public function createFile(array $data)
    {
        $project = $this->repository->skipPresenter()->find($data['project_id']);
        $projectFile = $project->files()->create($data);

        $this->storage->put($projectFile->id.".".$data['extension'], $this->filesystem->get($data['file']));
    }

}