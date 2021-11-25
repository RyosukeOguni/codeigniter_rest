<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\NewsModel;

class News extends ResourceController
{
  protected $modelName = NewsModel::class;
  protected $format = 'json';
  protected $model;
  /**
   * Return an array of resource objects, themselves in array format
   *
   * @return mixed
   */
  public function index()
  {
    $response = [
      'status' => 200,
      'error' => null,
      'news' => $this->model->findAll(),
    ];
    return $this->respond($response);
  }

  /**
   * Return the properties of a resource object
   *
   * @return mixed
   */
  public function show($id = null)
  {
    $news = $this->model->find($id);
    if ($news === null) {
      return $this->failNotFound('No news found');
    }

    $response = [
      'status' => 200,
      'error' => null,
      'news' => $news,
    ];

    return $this->respond($response);
  }

  /**
   * Create a new resource object, from "posted" parameters
   *
   * @return mixed
   */
  public function create()
  {
    if (!$this->validate(
      [
        'title' => 'required|min_length[3]|max_length[255]',
        'body' => 'required',
      ]
    )) {
      $errors = implode(' ', $this->validator->getErrors());
      return $this->failValidationErrors($errors);
    }
    $this->model->insert(
      [
        'title' => $this->request->getPost('title'),
        'slug' => url_title(
          $this->request->getPost('title'),
          '-',
          true
        ),
        'body' => $this->request->getPost('body'),
      ]
    );

    $response = [
      'status' => $this->codes['created'],
      'error' => null,
      'messages' => [
        'succcess' => 'News successfully created',
      ]
    ];
    return $this->respondCreated($response);
  }

  /**
   * Add or update a model resource, from "posted" properties
   *
   * @return mixed
   */
  public function update($id = null)
  {
    if ($this->request->getMethod() === 'patch') {
      return $this->fail('PATCH is not implemented');
    }

    if (!$this->validate(
      [
        'title' => 'required|min_length[3]|max_length[255]',
        'body' => 'required',
      ]
    )) {
      $errors = implode(' ', $this->validator->getErrors());

      return $this->failValidationError($errors);
    }

    $news = $this->model->find($id);
    if ($news === null) {
      return $this->failNotFound('No news found');
    }

    $input = $this->request->getRawInput();
    $data = [
      'title' => $input['title'],
      'slug' => url_title(
        $input['title'],
        '-',
        true
      ),
      'body' => $input['body']
    ];
    $this->model->update($id, $data);

    $response = [
      'status' => $this->codes['updated'],
      'error' => null,
      'messages' => [
        'success' => 'News successfully updated',
      ]
    ];

    return $this->respond($response);
  }

  /**
   * Delete the designated resource object from the model
   *
   * @return mixed
   */
  public function delete($id = null)
  {
    $news = $this->model->find($id);
    if ($news === null) {
      return $this->failNotFound('No news found');
    }
    $this->model->where('id', $id)->delete();
    $response = [
      'status' => $this->codes['deleted'],
      'error' => null,
      'messages' => [
        'success' => 'News successfully deleted',
      ]
    ];
    return $this->respondDeleted($response);
  }
}
