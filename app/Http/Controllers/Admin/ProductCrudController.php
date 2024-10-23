<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb();
        $this->crud->removeColumn('description');
        $this->crud->removeColumn('status');
        $this->crud->removeColumn('image');
        $this->crud->addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'custom_html',  // Sử dụng custom_html để cho phép HTML
            'value' => function($entry) {
                switch ($entry->status) {
                    case 'pending':
                        return '<span class="text-warning">' . ucfirst($entry->status) . '</span>';
                    case 'approved':
                        return '<span class="text-success" ">' . ucfirst($entry->status) . '</span>';
                    case 'rejected':
                        return '<span class="text-danger">' . ucfirst($entry->status) . '</span>';
                    default:
                        return $entry->status;  // Trả về trạng thái nếu không thuộc ba trạng thái
                }
            },
            'orderable' => false,  // Tắt sắp xếp theo cột này nếu không cần
        ]);
        $this->crud->addColumn([
            'name' => 'image',  // Tên cột trong cơ sở dữ liệu
            'label' => 'Image',  // Tiêu đề cột
            'type' => 'image',  // Kiểu cột
            'height' => '100px',  // Chiều cao hiển thị
            'width' => '100px',   // Chiều rộng hiển thị (tuỳ chọn)
            'disk' => 'public',   // Tên disk nếu bạn đã cấu hình
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);
        CRUD::setFromDb(); // set fields from db columns.
        $this->crud->addField([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select_from_array',
            'options' => [
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
            ],
            'allows_null' => false, // Không cho phép giá trị null
            'default' => 'pending', // Giá trị mặc định
        ]);
        $this->crud->addField([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'summernote',  // Sử dụng ckeditor cho mô tả
            'placeholder' => 'Enter a detailed description here...',
            'visibleInTable' => false,
            'options' => [
                'height' => 400,  // Điều chỉnh chiều cao của editor
            ],
        ]);
        $this->crud->addField([   // Number
            'name' => 'price',
            'label' => 'Price',
            'type' => 'number',
             'attributes' => ["step" => "any"], // allow decimals
             'prefix'     => "VND",
             'suffix'     => ".000",
        ]);
        $this->crud->addField([   // Number
            'name' => 'qty',
            'label' => 'QTY',
            'type' => 'number'
        ]);
        $this->crud->addField([
            'name'      => 'image',
            'label'     => 'Image',
            'type'      => 'upload',
            'withFiles' => true
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
