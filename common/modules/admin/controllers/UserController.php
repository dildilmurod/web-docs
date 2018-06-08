<?php
namespace common\modules\admin\controllers;


use common\helpers\Stat;
use common\models\MyConfig;
use common\models\User;
use common\models\UserAuthoritiesLink;
use common\models\UserMenus;
use common\models\UserSearch;
use common\modules\admin\models\Role;
use common\rbac\models\AuthItem;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     *
     * @param  integer $id The user id.
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $user = $this->findModel($id);
        
        return $this->render('view', [                    
            'model' => $user,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $user = new User(['scenario' => 'create']);
        $role = new Role();

        if ($user->load(Yii::$app->request->post())
            && $role->load(Yii::$app->request->post())
            && $user->validate())
        {
            $user->setPassword($user->password);
            $user->generateAuthKey();
            
            if ($user->save()) 
            {
                $role->deleteAll('user_id = :id AND item_name IN ("'.implode('","',ArrayHelper::map(AuthItem::getRoles(),'name','name')).'")',[':id'=>$user->getId()]);
                foreach($role->item_name as $roleItem)
                {   $roleModel = new Role();
                    $roleModel->item_name = $roleItem;
                    $roleModel->user_id = $user->getId();
                    $roleModel->created_at = time();
                    $roleModel->save(false);
                }
            }
            else
            {
                $role->item_name = ($user->roles==null)?null:ArrayHelper::map($user->roles,'item_name','item_name');
                return $this->render('create', [
                    'user' => $user,
                    'role' => $role,
                ]);
            }

            return $this->redirect(['view', 'id' => $user->id]);
        } 
        else 
        {
            $role->item_name = ($user->roles==null)?null:ArrayHelper::map($user->roles,'item_name','item_name');
            return $this->render('create', [
                'user' => $user,
                'role' => $role,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param  integer $id The user id.
     * @return string|\yii\web\Response
     *
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {

        // get role
        $role = Role::findOne(['user_id' => $id]);

        // get user details
        /**
         * @var User $user
         * @var $role Role
         */
        $user = $this->findModel($id);

        // only The Creator can update everyone`s roles
        // admin will not be able to update role of theCreator
        if (!Yii::$app->user->can('Admin') && $role != null  && $role->item_name === 'Admin')
        {
            return $this->goHome();
        }
        if($role == null) {
            $role = new Role();
            $role->user_id = $user->id;
        }
        // load user data with role and validate them
        if ($user->load(Yii::$app->request->post())
            && $role->load(Yii::$app->request->post())
            && $user->validate())
        {
            // only if user entered new password we want to hash and save it
            if ($user->password) 
            {
                $user->setPassword($user->password);
            }
            
            $role->deleteAll('user_id = :id AND item_name IN ("'.implode('","',ArrayHelper::map(AuthItem::getRoles(),'name','name')).'")',[':id'=>$id]);
            foreach($role->item_name as $roleItem)
            {   $roleModel = new Role();
                $roleModel->item_name = $roleItem;
                $roleModel->user_id = $id;
                $roleModel->created_at = time();
                $roleModel->save(false);
            }
            $user->save(false);

            return $this->redirect(['view', 'id' => $user->id]);
        }
        else 
        {
            $role->item_name = ($user->roles==null)?null:ArrayHelper::map($user->roles,'item_name','item_name');
            return $this->render('update', [
                'user' => $user,
                'role' => $role,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param  integer $id The user id.
     * @return \yii\web\Response
     *
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        // delete this user's role from auth_assignment table
        if ($role = Role::find()->where(['user_id'=>$id])->one()) 
        {
            $role->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param  integer $id The user id.
     * @return User The loaded model.
     *
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) 
        {
            return $model;
        } 
        else 
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionAddMenu($id)
    {
        $model = $this->findModel($id);
        $fields = Yii::$app->request->post('multiSelectData');

        foreach ($fields as $field)
        {
            $ae = new UserMenus();
            $ae->user_id = $model->id;
            $ae->menu_id = (int)$field;
            if ($ae->validate()){
                $ae->save();
            } else {
                echo 0;
                return;
            }
        }
        echo 200;
    }

    /**
     * @param $id
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionRemoveMenu($id)
    {
        $model = $this->findModel($id);
        $fields = Yii::$app->request->post('multiSelectData');

        foreach ($fields as $field)
        {
            $ae = UserMenus::findOne(['user_id' => $model->id, 'menu_id'=>(int)$field]);
            if ($ae == null)
            {
                echo 0;
                return;
            }
            if (!$ae->delete()){
                echo 0;
                return;
            }
        }
        echo 200;
    }
}