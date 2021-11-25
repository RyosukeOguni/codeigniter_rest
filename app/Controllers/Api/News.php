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
    //
  }

  /**
   * Add or update a model resource, from "posted" properties
   *
   * @return mixed
   */
  public function update($id = null)
  {
    //
  }

  /**
   * Delete the designated resource object from the model
   *
   * @return mixed
   */
  public function delete($id = null)
  {
    //
  }
}
