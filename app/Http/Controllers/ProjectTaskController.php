<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use Illuminate\Http\Request;


class ProjectTaskController extends Controller
{

    private $repository;
    private $service;

    /**
     * @param ProjectTaskRepository $repository
     * @param ProjectTaskService $service
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function index($id)
    {
        return $this->repository->findWhere(['project_id' => $id]);
    }

    /**
     * @param Request $request
     * @return array|mixed
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * @param $id
     * @param $taskId
     * @return mixed
     */
    public function show($id, $taskId)
    {
        return $this->repository->findWhere(['project_id' => $id, 'id' => $taskId]);
    }

    /**
     * @param Request $request
     * @param $id
     * @param $taskId
     */
    public function update(Request $request, $id, $taskId)
    {
        $this->service->update($request->all(), $taskId);
    }


    /**
     * @param $taskId
     */
    public function destroy($taskId)
    {
        $this->repository->delete($taskId);
    }
}
