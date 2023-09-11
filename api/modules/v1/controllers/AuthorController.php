<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\db\StaleObjectException;
use core\services\authors\AuthorHandler;
use core\services\authors\AuthorService;
use yii\web\HttpException;
use api\modules\v1\traits\SettingsTrait;
use core\forms\AuthorForm;
use core\repositories\AuthorRepository;

/**
 *
 * @property-read void $author
 */
class AuthorController extends Controller
{
    use SettingsTrait;

    private AuthorService $authorService;
    private AuthorRepository $authorRepository;

    /**
     * @param $id
     * @param $module
     * @param AuthorService $authorService
     * @param AuthorRepository $authorRepository
     * @param array $config
     */
    public function __construct($id, $module, AuthorService $authorService, AuthorRepository $authorRepository, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authorService = $authorService;
        $this->authorRepository = $authorRepository;
    }


    /**
     * @return int[]
     */
    public function actionIndex(): array
    {
        return $this->authorRepository->getAll();
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

        $author = $this->authorRepository->getById($id);

        if ($author) {
            return [
                'code' => 200,
                'author' => $author
            ];
        }

        Yii::$app->response->setStatusCode(404);
        return [
            'code' => 404,
            'message' => 'Author not found'
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function actionCreate(): array
    {
        $this->accessControls();

        try {
            $data = Json::decode(Yii::$app->getRequest()->getRawBody());

            if (!$data) {
                return $this->asError(400, 'Bad Request', 'Invalid request data');
            }

            $model = new AuthorForm();
            $model->attributes = $data;

            if ($model->validate()) {
                $birthdate = new \DateTime($data['birthdate']);
                $authorHandle = new AuthorHandler($data['name'], $birthdate->format('Y-m-d'), $data['biography'], $data['status']);
                $createAuthor = $this->authorService->add($authorHandle);

                return [
                    'status' => 200,
                    'message' => 'Author successfully created',
                    'authorId' => $createAuthor->getId()
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
     * @throws \Exception
     */
    public function actionUpdate(): array
    {
        $this->accessControls();

        try {
            $data = Json::decode(Yii::$app->getRequest()->getRawBody());

            if (!$data) {
                throw new HttpException(400, 'Invalid request data');
            }

            $model = new AuthorForm();
            $model->attributes = $data;

            if ($model->validate()) {
                $id = Yii::$app->request->get('id');
                $entity = $this->authorRepository->getById($id);

                if (empty($entity)) {
                    Yii::$app->response->setStatusCode(404);
                    return [
                        'code' => 404,
                        'message' => 'Author not found'
                    ];
                }

                $birthdate = new \DateTime($data['birthdate']);
                $authorHandle = new AuthorHandler($data['name'], $birthdate->format('Y-m-d'), $data['biography'], $data['status']);

                $updateAuthor = $this->authorService->edit($entity, $authorHandle);
                return [
                    'status' => 200,
                    'message' => 'Author successfully updated',
                    'authorId' => $updateAuthor->getId()
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
     * @return array|void
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete()
    {
        $this->accessControls();

        try {
            $id = Yii::$app->request->get('id');

            if (!$id) {
                throw new HttpException(400, 'Invalid request data');
            }

            $entity = $this->authorRepository->getById($id);
            if (empty($entity)) {
                Yii::$app->response->setStatusCode(404);
                return [
                    'code' => 404,
                    'message' => 'Author not found'
                ];
            }
            $this->authorService->remove($entity);
            return [
                'status' => 200,
                'message' => 'Author successfully deleted',
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