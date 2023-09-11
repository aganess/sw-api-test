<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\db\StaleObjectException;
use yii\helpers\Json;
use yii\rest\Controller;
use api\modules\v1\traits\SettingsTrait;
use yii\web\HttpException;
use core\forms\BookForm;
use core\repositories\BookRepository;
use core\services\books\BookHandler;
use core\services\books\BookService;

class BookController extends Controller
{
    use SettingsTrait;

    private BookService $bookService;
    private BookRepository $bookRepository;

    /**
     * @param $id
     * @param $module
     * @param BookService $bookService
     * @param BookRepository $bookRepository
     * @param array $config
     */
    public function __construct($id, $module, BookService $bookService, BookRepository $bookRepository, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->bookService = $bookService;
        $this->bookRepository = $bookRepository;
    }

    /**
     * @return int[]
     */
    public function actionIndex(): array
    {
        return $this->bookRepository->getAll();
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

        $book = $this->bookRepository->getById($id);

        if ($book) {
            return [
                'code' => 200,
                'book' => $book
            ];
        }

        Yii::$app->response->setStatusCode(404);
        return [
            'code' => 404,
            'message' => 'Book not found'
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

            $model = new BookForm();
            $model->attributes = $data;

            if ($model->validate()) {

                $bookHandle = new BookHandler($data['authorId'], $data['languageId'], $data['genreId'], $data['name'], $data['description'], $data['numPages'], $data['status']);
                $createBook = $this->bookService->add($bookHandle);
                return [
                    'status' => 200,
                    'message' => 'Book successfully created',
                    'bookId' => $createBook->getId()
                ];
            }

            $errors = $model->errors;
            Yii::$app->response->setStatusCode(400);
            return [
                'status' => 400,
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
        try {
            $data = Json::decode(Yii::$app->getRequest()->getRawBody());

            if (!$data) {
                throw new HttpException(400, 'Invalid request data');
            }

            $model = new BookForm();
            $model->attributes = $data;

            if ($model->validate()) {
                $id = Yii::$app->request->get('id');
                $entity = $this->bookRepository->getById($id);

                if (empty($entity)) {
                    Yii::$app->response->setStatusCode(404);
                    return [
                        'code' => 404,
                        'message' => 'Author not found'
                    ];
                }

                $bookHandle = new BookHandler($data['authorId'], $data['languageId'], $data['genreId'], $data['name'], $data['description'], $data['numPages'], $data['status']);
                $updateBook = $this->bookService->edit($entity, $bookHandle);

                return [
                    'status' => 200,
                    'message' => 'Book successfully updated',
                    'authorId' => $updateBook->getId()
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

            $entity = $this->bookRepository->getById($id);
            if (empty($entity)) {
                Yii::$app->response->setStatusCode(404);
                return [
                    'code' => 404,
                    'message' => 'Book not found'
                ];
            }
            $this->bookService->remove($entity);
            return [
                'status' => 200,
                'message' => 'Book successfully deleted',
                'bookId' => $entity->getId()
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