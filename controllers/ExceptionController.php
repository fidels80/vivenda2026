<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class ExceptionController extends Controller
{

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionErrorHandler()
    {
        $exception = Yii::$app->errorHandler->exception;

        // Here we can save the exception to the exception queue , Then deal with the difference according to the feedback information bug

        // There are different response handling methods for different exception throws
        switch (get_class($exception)) {
            case 'app\exceptions\ApiException':
                // Respond to json
                Yii::$app->response->format = Response::FORMAT_JSON;
                $data = [
                    'code' => $exception->getCode(),
                    'msg' => $exception->getMessage(),
                ];

                return $data;
            case 'app\exceptions\HttpException':
                // Response view
                return $this->render('error', [
                    'code' => $exception->getCode(),
                    'msg' => $exception->getMessage(),
                ]);
            default:
                echo 'not get exception';
        }
        exit;
    }
}
?>