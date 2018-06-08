<?php
/* Объявляем пространство имен */
namespace app\controllers;

use frontend\models\ContactForm;
use Yii;

use yii\web\Controller;
use frontend\models\ContactForm;


/* Расширяем класс Controller */

class IndexController extends Controller
{

    /* Объявляем функцию */
    public function actionContact()
    {
        /* Для страницы контактов можно использовать свой слой */
        $this->layout = 'contacts';
    /* @var $model ContactForm*/
        /* Создаем экземпляр класса */
        $model = new ContactForm();
            /* получаем данные из формы и запускаем функцию отправки contact, если все хорошо,
            выводим сообщение об удачной отправке сообщения на почту */
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['emailto'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
                /* иначе выводим форму обратной связи */
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
}

?>