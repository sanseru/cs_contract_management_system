# Creating CRUD modals Yii 2

## Message From You:
How to create crud modals using Yii 2 

## Message From ChatGPT:
1. Create a model
Firstly, you need to create a model, which represents the data you want to manipulate.

```php
namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    // ...
}
```

2. Generate CRUD via Gii
Yii 2 comes with a useful tool called Gii, which can automatically generate code for creating, updating, reading and deleting models. To call Gii, browse to Yii 2 development environment URL (e.g., `http://localhost:8080/gii`) and follow the steps:

* Choose "Model Generator"
* Fill in the form:
  * Model Class: `app\models\User`
  * Table Name: `user`
  * Generate Relations: true
  * Generate Labels: true
  * Generate Search Model: true
* Click Preview

When you click Preview, you will see the generated code for the model. This code will have some issues, but we will address them in the next step.

3. Customize generated code
The generated code from Gii might need some small tweaks to work as expected. It is important to inspect the generated code and understand what it does. Here are some common issues that you might encounter and how to fix them:

* Add namespace: Add a namespace for the generated code. This namespace should match the namespace of the model class.

```php
// Generated code

<?php

namespace app\controllers;

use yii\web\Controller;

class UserController extends Controller
{
    // ...
}
```

```php
// Add namespace

namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class UserController extends Controller
{
    // ...
}
```

* Add "use" statements: Add "use" statements to enable using classes without the full namespace inside the controller.

```php
// Generated code

class UserController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
```

```php
// Add "use" statements

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class UserController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
```

* Add actions: If an action is missing (e.g., "delete", "update"), add it to the controller.

```php
// Generated code

class UserController extends Controller
{
    public function actionIndex()
    {
        // ...
    }

    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
```

```php
// Add missing actions

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class UserController extends Controller
{
    public function actionIndex()
    {
        // ...
    }

    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    // Helper function to find the model by ID

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
```

4. Add "modal" views
To display forms within a modal dialog box instead of a separate page, we need to add "modal" views. These views will contain a shortcode, which will display the modal and its contents when clicked. Here are some steps to create the modal views:

* Create views
Create views for every action in the controller. A typical create view is shown below.

```php
<!-- Generated view -->

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
```

```php
<!-- Create view with modal -->

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'header' => '<h2>Create User</h2>',
    'toggleButton' => [
        'label' => 'Create User',
        'class' => 'btn btn-success'
    ]
]);

$form = ActiveForm::begin();

echo $form->field($model, 'name')->textInput(['maxlength' => true]);

echo $form->field($model, 'email')->textInput(['maxlength' => true]);

echo $form->field($model, 'password')->passwordInput(['maxlength' => true]);

echo Html::submitButton('Save', ['class' => 'btn btn-success']);

ActiveForm::end();

Modal::end();

?>
```

* Add scripts
Add JavaScript to handle the AJAX calls and display the modals. Use the modal "id" and "toggleButton" "id" to link the AJAX calls and modal displays, respectively.

```php
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'header' => '<h2>Create User</h2>',
    'toggleButton' => [
        'label' => 'Create User',
        'class' => 'btn btn-success',
        'id' => 'create-user-btn'
    ]
]);

$form = ActiveForm::begin([
    'action' => ['create'],
    'options' => [
        'id' => 'create-user-form'
    ]
]);

echo $form->field($model, 'name')->textInput(['maxlength' => true]);

echo $form->field($model, 'email')->textInput(['maxlength' => true]);

echo $form->field($model, 'password')->passwordInput(['maxlength' => true]);

echo Html::submitButton('Save', ['class' => 'btn btn-success']);

ActiveForm::end();

Modal::end();

?>

<?php
    $createUrl = Yii::$app->urlManager->createUrl('user/create');
    $updateUrl = Yii::$app->urlManager->createUrl(['user/update', 'id' => null]);

    $this->registerJs(
    "$(document).on('click', '#create-user-btn', function() {
        $('#create-user-form').trigger('reset');
        $.get('{$createUrl}', function(data) {
            $('#modal').modal('hide');
            $('#modal').html(data).modal('show');
        });
    });

    $(document).on('submit', '#create-user-form', function() {
        $.ajax({
            url: '{$createUrl}',
            type: 'POST',
            data: $(this).serialize(),
            success: function() {
                $('#modal').modal('hide');
                $.pjax.reload({container:'#items-grid-view'});
            },
            error: function() {
                alert('An error occurred while saving the item.');
            }
        });
        return false;
    });

    $(document).on('click', '.update-btn', function() {
        var id = $(this).data('id');
        $('#update-user-form').trigger('reset');
        $.get('{$updateUrl}' + '/' + id, function(data) {
            $('#modal').modal('hide');
            $('#modal').html(data).modal('show');
        });
    });

    $(document).on('submit', '#update-user-form', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{$updateUrl}' + '/' + id,
            type: 'POST',
            data: $(this).serialize(),
            success: function() {
                $('#modal').modal('hide');
                $.pjax.reload({container:'#items-grid-view'});
            },
            error: function() {
                alert('An error occurred while saving the item.');
            }
        });
        return false;
    });"
    );
?>
```

5. Add Pjax
Pjax is a widget for Yii 2 that allows us to update parts of a page via AJAX without refreshing the whole page. Here is how to add Pjax:

* Add Pjax extension to your app. Update your `composer.json`  and run `composer update` to download the latest PHP extension `yiisoft/yii2-pjax`:

```json
{
    "require": {
        "yiisoft/yii2-pjax": "^2.0"
    }
}
```

* Update your layout to include jQuery and the Pjax script:

```php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->registerJsFile('@web/js/jquery.min.js');
$this->registerJsFile('@web/js/jquery.pjax.min.js');
?>
```

* Add the Pjax container to your views:

```php
<?php Pjax::begin(['id' => 'items-grid-view']); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        // ...
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
                        'class' => 'update-btn',
                        'title' => Yii::t('yii', 'Update'),
                        'data-pjax' => '0',
                        'data-id' => $model->id
                    ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'title' => Yii::t('yii', 'Delete'),
                        'data' => [
                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]);
                },
            ],
        ],
    ],
]); ?>

<?php Pjax::end(); ?>
```

6. Test your modals
At this point, you should be able to test your app by clicking on the Create, Update and Delete buttons inside the GridView. When you click "Create", you should see a modal containing a form to create a new user. When you click "Update" next to a user in the GridView, you should see a modal containing a form prefilled with the user's data. When you click "Delete" next to a user, the user should be deleted from the database.

## Message From You:
how to use renderAjax to show modal show me the full code CRUD 

## Message From ChatGPT:
Certainly! Here is an example of using `renderAjax` in a CRUD modal in Yii2:

1. Create a model that represents the data you want to manipulate. For example, let's say we're managing users:

```php
<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public static function tableName()
    {
        return 'users';
    }
}

```

2. Generate CRUD via Gii and customize generated code if needed.

3. In the `index` action of your controller, add the following code to load and return the partial view `_userModal` as AJAX content when the `data-target` attribute of the "Create User" button is clicked:

```php
public function actionIndex()
{
    $model = new User();
 
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['index']);
    }
 
    return $this->render('index', [
        'model' => $model,
    ]);
}

public function actionUserModal()
{
    $model = new User();
    return $this->renderAjax('_userModal', [
        'model' => $model,
    ]);
}
```

4. In the `index` view, wrap a `GridView` widget and the "Create User" button in a `Pjax` widget container. The data-target attribute is used to identify the modal target. Here is an example:

```php
<?php
    use yii\widgets\Pjax;
    use yii\helpers\Html;
    use yii\grid\GridView;
?>

<?php Pjax::begin(); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    ...
    'columns' => [
        ...
        ['class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
                        'class' => 'btn btn-xs btn-success', 
                        'data-toggle' => 'modal',
                        'data-target' => '#user-modal',
                        'title' => 'Update User',
                        'data-id' => $key,
                        'data-pjax' => '0'
                    ]);
                },
                'delete' => function($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'title' => 'Delete User',
                        'class' => 'btn btn-xs btn-danger',
                        'data-confirm' => 'Are you sure you want to delete this user?',
                        'data-method' => 'post',
                        'data-pjax' => '0'
                    ]);
                }
            ]
        ],
    ],
]); ?>

<?= Html::button('Create User', ['value'=>Url::to(['user-modal']), 'class' => 'btn btn-success', 'id'=>'userModalButton', 'data-toggle' => 'modal', 'data-target' => '#user-modal']) ?>

<?php Pjax::end(); ?>
```

5. Create a new view `_userModal.php` with the following code for the modal:

```php
<?php 
    use yii\bootstrap\Modal;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
 
    Modal::begin([
        'header' => '<h2>Create User</h2>',
        'id' => 'user-modal',
    ]);
?>

<?php $form = ActiveForm::begin(['id' => 'create-user-form']); ?>
 
    <?= $form->field($model, 'username')->textInput() ?>
 
    <?= $form->field($model, 'email')->textInput() ?>
 
    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>
    
<?php ActiveForm::end(); ?>

<?php Modal::end(); ?>
```

6. Add this JavaScript code at the bottom of the view to handle AJAX calls and update the modal content:

```javascript
<?php 
    $this->registerJs("
        $('#user-modal').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
        });
        
        $('#user-modal').on('submit', 'form#create-user-form', function(e){
            e.preventDefault();
            var form = $(this);
            
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response){
                    $('#user-modal').modal('hide');
                    $('#users-container').html(response);
                },
            });
        });
    ");
?>
```

That's it! Now you have a CRUD modal in Yii2 using `renderAjax`.