<?php

namespace App\Controllers\Api;
use CodeIgniter\RESTful\ResourceController;
use App\Models\PostsModel;

class Posts extends ResourceController
{
    protected $format = 'json';
    protected $modelName = 'App\Models\PostsModel';

    public function index()
    {
        $perPage = 4; // posts per page

        $posts = $this->model
            ->select('posts.*, posts_category.cat_name')
            ->join('posts_category', 'posts_category.cid = posts.cat_id')
            ->paginate($perPage);

        return $this->respond([
            'data'  => $posts,
            'pager' => [
                'currentPage' => $this->model->pager->getCurrentPage(),
                'totalPages'  => $this->model->pager->getPageCount(),
                'perPage'     => $perPage,
                'total'       => $this->model->pager->getTotal(),
            ]
        ]);
    }

    public function show($id=null) {
        $db = db_connect();
		$query = $db->query('select * from posts where pid = ?', [(int)$id]);
		$data = $query->getResultArray();
        log_message('info', 'Request received Post: '.$id);
        if(empty($data)) {
            log_message('info', 'Record not found: '.$id);
            return $this->fail('Record not found!', 404);
        }
        return $this->respond($data);
    }

    public function create()
    {
        $data = $this->request->getJSON(true) ?: $this->request->getPost();
        log_message('info', 'Request Data for Create Post: '.json_encode($data));
        if (empty($data['p_title']) || empty($data['p_descr']) || empty($data['cat_id'])) {
            return $this->failValidationErrors('p_title, p_descr, cat_id are required');
        }

        if (! $this->model->insert($data)) {
            return $this->failServerError('Failed to create post');
        }

        $insertId = $this->model->getInsertID();

        return $this->respondCreated([
            'message' => 'Post has been created',
            'pid'     => $insertId,
            'data'    => $data,
        ]);
    }

    public function update($id = null)
    {
        $json = $this->request->getJSON(true);
        log_message('info', 'Request Data for Update Post: '.json_encode($json));
        log_message('info', 'Allowed fields: '.json_encode($this->model->allowedFields));

		$data = $this->model->find($id);
        if(empty($data)) {
            log_message('info', 'Record not found: '.$id);
            return $this->fail('Record not found!', 404);
        }

        if(empty($json)) {
            return $this->fail('There is no data to update!', 400);
        }
        $json['updated_at'] = date('Y-m-d H:i:s');

        // if (! $this->model->where('pid', $id)->update($data)) {
        if (! $this->model->update($id, $json)) {
            log_message('info', 'Failed to update the post: '.$id);
            return $this->failServerError('Failed to update the post');
        }

        return $this->respond([
            'message' => 'Post has been updated',
            'id'      => (int) $id,
            'data'    => $json,
        ]);
    }

    public function delete($id = null)
    {
        $db = db_connect();
        if(empty($id)) {
            return $this->fail('Post id is not provided!', 400);
        }
		$post = $this->model->find($id);
        if(empty($post)) {
            return $this->fail('Record not found!', 404);
        }

        if (! $this->model->delete($id)) {
            return $this->failServerError('Failed to delete the post');
        }

        log_message('info', 'Post '.$id.' has been deleted!');
        return $this->respondDeleted([
            'message' => 'Post has been deleted',
            'id'      => (int) $id,
        ]);
    }

    public function categs() {
		$db = db_connect();
		$query = $db->query('select * from posts_category');
		$data = $query->getResultArray();
        return $this->respond($data);
    }

}