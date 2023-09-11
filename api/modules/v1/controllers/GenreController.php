<?php

namespace api\modules\v1\controllers;

use core\forms\GenreForm;
use core\services\genres\GenreHandler;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\helpers\Json;
use yii\rest\Controller;
use api\modules\v1\traits\SettingsTrait;
use core\repositories\GenreRepository;
use core\services\genres\GenreService;
use yii\web\HttpException;

class GenreController extends Controller
{
    use SettingsTrait;

    public GenreService $genreService;
    public GenreRepository $genreRepository;

    /**
     * @param $id
     * @param $module
     * @param GenreService $genreService
     * @param GenreRepository $genreRepository
     * @param array $config
     */
    public function __construct($id, $module, GenreService $genreService, GenreRepository $genreRepository, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->genreService = $genreService;
        $this->genreRepository = $genreRepository;
    }

    /**
     * @return array|ActiveRecord[]
     */
    public function actionIndex(): array
    {
        return $this->genreRepository->getAll();
    }

    /**
     * @return array
     */
    public function actionGet(): array
    {
        $id = Yii::$app->request->get('id');

        if (!$id) {
            return $this->asError(400, 'Bad Request', 'Invalid request data');
        }

        $genre = $this->genreRepository->getById($id);

        if ($genre) {
            return [
                'code' => 200,
                'genre' => $genre
            ];
        }

        Yii::$app->response->setStatusCode(404);
        return [
            'code' => 404,
            'message' => 'Genre not found'
        ];
    }

    /**
     * @return array
     */
    public function actionCreate(): array
    {
        $this->accessControls();

        try {
            $data = Json::decode(Yii::$app->getRequest()->getRawBody());

            if (!$data) {
                return $this->asError(400, 'Bad Request', 'Invalid request data');
            }

            $model = new GenreForm();
            $model->attributes = $data;

            if ($model->validate()) {

                $genreHandler = new GenreHandler($data['genreName'], $data['status']);
                $createGenre = $this->genreService->add($genreHandler);

                return [
                    'status' => 200,
                    'message' => 'Genre successfully created',
                    'authorId' => $createGenre->getId()
                ];

            }

            $errors = $model->errors;
            Yii::$app->response->setStatusCode(400);
            return [
                'status' => 'error',
                'errors' => $errors
            ];

        } catch (HttpException $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return [
                'status' => $e->statusCode,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @return array
     */
    public function actionUpdate(): array
    {
        $this->accessControls();

        try {
            $data = Json::decode(Yii::$app->getRequest()->getRawBody());

            if (!$data) {
                throw new HttpException(400, 'Invalid request data');
            }

            $model = new GenreForm();
            $model->attributes = $data;

            if ($model->validate()) {
                $id = Yii::$app->request->get('id');
                $entity = $this->genreRepository->getById($id);

                if (empty($entity)) {
                    Yii::$app->response->setStatusCode(404);
                    return [
                        'code' => 404,
                        'message' => 'Genre not found'
                    ];
                }

                $genreHandler = new GenreHandler($data['genreName'], $data['status']);
                $updateGenre = $this->genreService->edit($entity, $genreHandler);

                return [
                    'status' => 200,
                    'message' => 'Genre successfully updated',
                    'authorId' => $updateGenre->getId()
                ];

            }
            $errors = $model->errors;
            Yii::$app->response->setStatusCode(400);
            return [
                'status' => 'error',
                'errors' => $errors
            ];

        } catch (HttpException $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return [
                'status' => $e->statusCode,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @return array
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(): array
    {
        $this->accessControls();

        try {
            $id = Yii::$app->request->get('id');

            if (!$id) {
                throw new HttpException(400, 'Invalid request data');
            }

            $entity = $this->genreRepository->getById($id);
            if (empty($entity)) {
                Yii::$app->response->setStatusCode(404);
                return [
                    'code' => 404,
                    'message' => 'Genre not found'
                ];
            }
            $this->genreService->remove($entity);
            return [
                'status' => 200,
                'message' => 'Genre successfully deleted',
                'authorId' => $entity->getId()
            ];
        } catch (HttpException $e) {
            Yii::$app->response->statusCode = $e->statusCode;
            return [
                'status' => $e->statusCode,
                'message' => $e->getMessage()
            ];
        }
    }

}