<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ArticleController extends ResourceController
{
    protected $modelName = 'App\Models\ArticleModel';
    protected $format    = 'json';
    /**
     * Return an array of Articles, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    /**
     * Return the properties of an Article.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        if (is_null($id)) {
            return $this->fail('Missing id');
        }

        if (is_null($this->model->find($id))) {
            return $this->failNotFound('Article not found');
        }

        return $this->respond($this->model->find($id));
    }

    /**
     * Create a new Article, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $rules = [
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required|is_not_unique[category.id]'
        ];

        $article = $this->request->getJSON(true);

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        if ($this->model->insert($article)) {
            return $this->respondCreated($article);
        }

        return $this->fail($this->model->errors());
    }

    /**
     * Update an ArticleModel, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        if (is_null($id)) {
            return $this->fail('Missing id');
        }

        if (is_null($this->model->find($id))) {
            return $this->failNotFound('Article not found');
        }

        $data = $this->request->getJSON(true);

        if ($this->model->update($id, $data)) {
            return $this->respondUpdated($data);
        }

        return $this->fail($this->model->errors());
    }

    /**
     * Delete the designated Article from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        if (is_null($id)) {
            return $this->fail('Missing id');
        }

        if (is_null($this->model->find($id))) {
            return $this->failNotFound('Article not found');
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted($id);
        }

        return $this->fail($this->model->errors());
    }
}
