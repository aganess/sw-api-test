<?php

namespace api\modules\v1\traits;

use Yii;
use yii\filters\auth\QueryParamAuth;

trait SettingsTrait
{
    /**
     * @return array|array[]
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // Разрешить доступ с указанных доменов:
                'Origin' => ['https://editor.swagger.io', 'https://editor-next.swagger.io'],
                'Access-Control-Request-Method' => ['POST', 'GET', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
            ],
        ];

        $behaviors['authenticator']['class'] = QueryParamAuth::class;
        $behaviors['authenticator']['tokenParam'] = 'authKey';

        return $behaviors;
    }

    /**
     * @return void
     */
    private function accessControls()
    {
        // Разрешить доступ с указанных доменов:
        header('Access-Control-Allow-Origin: https://editor.swagger.io');
        header('Access-Control-Allow-Origin: https://editor-next.swagger.io');

        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    }

    /**
     * @param $status
     * @param $name
     * @param $message
     * @return array
     */
    private function asError($status, $name, $message): array
    {
        Yii::$app->response->statusCode = $status;

        return [
            'message' => $message,
            'status' => $status,
            'name' => $name,
        ];
    }
}