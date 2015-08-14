<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;


class ProjectNoteController extends Controller
{

    private $repository;
    private $service;

    /**
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteService $service
     */
    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
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
     * @param $noteId
     * @return mixed
     */
    public function show($id, $noteId)
    {
        return $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
    }

    /**
     * @param Request $request
     * @param $id
     * @param $noteId
     */
    public function update(Request $request, $id, $noteId)
    {
        $this->service->update($request->all(), $noteId);
    }


    /**
     * @param $noteId
     */
    public function destroy($noteId)
    {
        $this->repository->delete($noteId);
    }
}
