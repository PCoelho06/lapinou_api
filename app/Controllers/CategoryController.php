<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class CategoryController extends ResourceController
{
    protected $modelName = 'App\Models\CategoryModel';
    protected $format    = 'json';

    /**
     * Return an array of Categories, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    /**
     * Return the properties of a Category.
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
            return $this->failNotFound('Category not found');
        }

        return $this->respond($this->model->find($id));
    }

    /**
     * Create a new Category, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $rules = [
            'name' => 'required',
        ];

        $category = $this->request->getJSON(true);

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        if ($this->model->insert($category)) {
            return $this->respondCreated($category);
        }

        return $this->fail($this->model->errors());
    }

    /**
     * Update a Category, from "posted" properties.
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
            return $this->failNotFound('Category not found');
        }

        $data = $this->request->getJSON(true);

        if ($this->model->update($id, $data)) {
            return $this->respondUpdated($data);
        }

        return $this->fail($this->model->errors());
    }

    /**
     * Delete the designated Category from the model.
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
            return $this->failNotFound('Category not found');
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted($id);
        }

        return $this->fail($this->model->errors());
    }
}
