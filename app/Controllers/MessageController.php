<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class MessageController extends ResourceController
{
    protected $modelName = 'App\Models\MessageModel';
    protected $format    = 'json';

    public function index()
    {
        try {
            return $this->respond($this->model->findAll());
        } catch (\Exception $e) {
            return $this->failServerError('An error occurred while processing your request');
        }
    }

    public function show($id = null)
    {
        if (is_null($id)) {
            return $this->fail('Missing id');
        }

        $message = $this->model->find($id);

        if (is_null($message)) {
            return $this->failNotFound('Message not found');
        }

        return $this->respond($message);
    }

    public function create()
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|valid_email',
            'message' => 'required'
        ];

        $data = $this->request->getJSON(true);

        if (array_key_exists('filter', $data)) {
            return $this->respondCreated($data);
        }

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $message = $this->model->create($data);
        if ($message) {
            $email = \Config\Services::email();

            $email->setFrom('contact@lapinou.tech', 'Portfolio Lapinou.tech');
            $email->setTo('p.coelho@lapinou.tech');
            $email->setSubject('Nouveau message reçu');
            $email->setMessage('Tu as reçu un nouveau message de' + $message['first_name'] + ' ' + $data . ['last_name'] + '.\n Pour voir son message, clique sur le lien suivant: https://secure.lapinou.tech/messages/' + $message['id']);

            if (!$email->send()) {
                log_message('error', 'Failed to send email: ' . $email->printDebugger(['headers']));
            }

            return $this->respondCreated($message);
        }
        if (is_null($message)) {
            return $this->fail('An error occurred while processing your request');
        }

        return $this->fail($this->model->errors());
    }

    public function markAsRead($id = null)
    {
        $data = $this->model->find($id);

        if ($data == null) {
            return $this->failNotFound('Message not found');
        }

        if ($data['is_read'] == 1) {
            return $this->fail('Message already marked as read');
        } else {
            $data['is_read'] = 1;
        }

        if ($this->model->update($id, $data)) {
            return $this->respondUpdated($data);
        }

        return $this->fail($this->model->errors());
    }

    public function markAsAnswered($id = null)
    {
        $data = $this->model->find($id);

        if ($data == null) {
            return $this->failNotFound('Message not found');
        }

        if ($data['is_answered'] == 1) {
            return $this->fail('Message already marked as answered');
        } else {
            $data['is_answered'] = 1;
        }

        if ($this->model->update($id, $data)) {
            return $this->respondUpdated($data);
        }

        return $this->fail($this->model->errors());
    }

    public function delete($id = null)
    {
        if ($this->model->find($id) == null) {
            return $this->failNotFound('Message not found');
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted();
        }

        return $this->fail($this->model->errors());
    }
}
