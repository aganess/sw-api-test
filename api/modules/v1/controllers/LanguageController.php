<?php

namespace api\modules\v1\controllers;

use core\forms\LanguageForm;
use core\services\languages\LanguageHandler;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\helpers\Json;
use yii\rest\Controller;
use api\modules\v1\traits\SettingsTrait;
use core\repositories\LanguageRepository;
use core\services\languages\LanguageService;
use yii\web\HttpException;

class LanguageController extends Controller
{
    use SettingsTrait;

    public LanguageService $languageService;
    public LanguageRepository $languageRepository;

    /**
     * @param $id
     * @param $module
     * @param LanguageService $languageService
     * @param LanguageRepository $languageRepository
     * @param array $config
     */
    public function __construct($id, $module, LanguageService $languageService, LanguageRepository $languageRepository, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->languageService = $languageService;
        $this->languageRepository = $languageRepository;
    }

    /**
     * @return array|ActiveRecord[]
     */
    public function actionIndex(): array
    {
        return $this->languageRepository->getAll();
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

        $language = $this->languageRepository->getById($id);

        if ($language) {
            return [
                'code' => 200,
                'language' => $language
            ];
        }

        Yii::$app->response->setStatusCode(404);
        return [
            'code' => 404,
            'message' => 'Language not found'
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

            $model = new LanguageForm();
            $model->attributes = $data;

            if ($model->validate()) {

                $languageHandler = new LanguageHandler($data['languageName'], $data['isoCode'], $data['status']);
                $createLanguage = $this->languageService->add($languageHandler);

                return [
                    'status' => 200,
                    'message' => 'Language successfully created',
                    'languageId' => $createLanguage->getId()
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

            $model = new LanguageForm();
            $model->attributes = $data;

            if ($model->validate()) {
                $id = Yii::$app->request->get('id');
                $entity = $this->languageRepository->getById($id);

                if (empty($entity)) {
                    Yii::$app->response->setStatusCode(404);
                    return [
                        'code' => 404,
                        'message' => 'Language not found'
                    ];
                }

                $languageHandler = new LanguageHandler($data['languageName'], $data['isoCode'], $data['status']);
                $updateLanguage = $this->languageService->edit($entity, $languageHandler);

                return [
                    'status' => 200,
                    'message' => 'Language successfully updated',
                    'languageId' => $updateLanguage->getId()
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

            $entity = $this->languageRepository->getById($id);
            if (empty($entity)) {
                Yii::$app->response->setStatusCode(404);
                return [
                    'code' => 404,
                    'message' => 'Language not found'
                ];
            }
            $this->languageService->remove($entity);
            return [
                'status' => 200,
                'message' => 'Language successfully deleted',
                'languageId' => $entity->getId()
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