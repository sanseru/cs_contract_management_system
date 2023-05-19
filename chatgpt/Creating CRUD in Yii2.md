# Creating CRUD in Yii2

## Message From You:
How to create CRUD in yii 2 using Modals form and use Gii andtehn use RenderAjax



## Message From ChatGPT:
To create CRUD in Yii2 using Modals form and RenderAjax, follow the steps below:

1. Install Yii2 in your system and create a new project using the basic template.

2. Log in to your Yii2 application and create a new database for your project.

3. Create a new model and ActiveRecord in your project using Gii. Follow the steps below:

- Open your command prompt or terminal and navigate to your Yii2 application directory.
- Run the command `./yii gii/model` to open the Gii tool for generating a new model and ActiveRecord.
- Enter your model's class name and the database table name.
- Click on Preview to view the generated model and ActiveRecord code.
- Click on Generate to create the new model and ActiveRecord.

4. Create a new controller for your CRUD operations using Gii. Follow the steps below:

- Open your command prompt or terminal and navigate to your Yii2 application directory.
- Run the command `./yii gii/controller` to open the Gii tool for generating a new controller.
- Enter your controller's class name and select the model that you created earlier.
- Click on Preview to view the generated controller code.
- Click on Generate to create the new controller.

5. Modify the controller to implement the CRUD operations using Modal form and RenderAjax.

- Replace the `actionIndex()` method with the following code:

```
public function actionIndex()
{
    $searchModel = new YourModelSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}
```

- Create a new view file `index.php` with the following code:

```
<?= yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'description',
            'created_at',
            'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::button('<i class="glyphicon glyphicon-pencil"></i> Edit', [
                                'class' => 'btn btn-xs btn-info',
                                'value' => Url::to(['update', 'id' => $model->id]),
                                'onclick' => "$('#myModal').modal('show').find('#modalContent').load($(this).attr('value'))",
                            ]);
                         },
                         'view' => function ($url, $model) {
                            return Html::button('<i class="glyphicon glyphicon-eye-open"></i> View', [
                                'class' => 'btn btn-xs btn-primary',
                                'value' => Url::to(['view', 'id' => $model->id]),
                                'onclick' => "$('#myModal').modal('show').find('#modalContent').load($(this).attr('value'))",
                            ]);
                         },
                         'delete' => function ($url, $model) {
                            return Html::a('<i class="glyphicon glyphicon-trash"></i> Delete', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-xs btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]);
                        },
                ],
            ],
    ],
]); ?>

<?= Html::button('<i class="glyphicon glyphicon-plus"></i> Create', [
        'value' => Url::to(['create']),
        'class' => 'btn btn-success',
        'onclick' => "$('#myModal').modal('show').find('#modalContent').load($(this).attr('value'))",
]); ?>

<?php Modal::begin([
    'header' => '<h4>Modal</h4>',
    'id' => 'myModal',
]); ?>

<div id='modalContent'></div>

<?php Modal::end(); ?>
```

- Replace the `actionCreate()` method with the following code:

```
public function actionCreate()
{
    $model = new YourModel();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', 'Data has been saved successfully.');
        return $this->redirect(['index']);
    } else {
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }
}
```

- Create a new view file `create.php` with the following code:

```
<?= $this->render('_form', [
    'model' => $model,
]) ?>
```

- Replace the `actionUpdate()` method with the following code:

```
public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', 'Data has been updated successfully.');
        return $this->redirect(['index']);
    } else {
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }
}
```

- Create a new view file `update.php` with the following code:

```
<?= $this->render('_form', [
        'model' => $model,
]) ?>
```

- Replace the `actionView()` method with the following code:

```
public function actionView($id)
{
    return $this->renderAjax('view', [
        'model' => $this->findModel($id),
    ]);
}
```

- Create a new view file `view.php` with the following code:

```
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
    ],
]) ?>
```

- Modify the `_form` partial view to display the form with the required input fields and submit button.

6. That's it! You can now run your Yii2 application and test the CRUD operations with Modal form and RenderAjax.

Note: Make sure to include the required Yii2 classes and use statements at the beginning of each file.