<?php

namespace Modules\Products\Controllers;

use Illuminate\Http\Request;
use Main\Admin\Controllers\BaseController;
use Modules\Products\Models\Product;

class ProductController extends BaseController
{
    protected $model = Product::class;
    protected $model_titles = [
        'singular' => 'Producto',
        'plural' => 'Productos',
    ];

    protected $validation_fields = ['name' => 'required'];
    protected $message_fields = [];
    protected $names_fields = ['name' => 'Nombre'];

    protected $routes = [
        'list' => 'products.products.list',
        'create' => 'products.products.create',
        'edit' => 'products.products.edit',
        'editurl' => 'editar/producto/',
        'save' => 'products.products.save',
        'delete' => 'products.products.delete',
        'getdata' => 'products.products.getdata',
        'sort' => 'products.products.sort',
        'sheet' => 'products.products.sheet'
    ];

    protected $view_main = 'Products.Views.products.list';
    protected $view_edit = 'Products.Views.products.edit';

    protected $paginate = 20;

    protected $showExportBtn = false;

    public function save(Request $request)
    {
        $this->validateFields($request);

        if ($request->filled('id')) {
            $data = $this->validateData($request);
        } else {
            $data = new Product();
        }

        $this->processCommonFields($request, $data);

        $data->name = $request->name;

        return parent::store($data);
    }

    public function sheet()
    {
        return false;
    }
}
