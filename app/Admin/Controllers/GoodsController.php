<?php

namespace App\Admin\Controllers;

use App\Models\Goods;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class GoodsController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Goods);

        $grid->id('Id');
        $grid->category_id('Category id');
        $grid->image('Image');
        $grid->desc('Desc');
        $grid->state('State');
        $grid->state_date('State date');
        $grid->pv('Pv');
        $grid->sale('Sale');
        $grid->sort('Sort');
        $grid->deleted_at('Deleted at');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Goods::findOrFail($id));

        $show->id('Id');
        $show->category_id('Category id');
        $show->image('Image');
        $show->desc('Desc');
        $show->state('State');
        $show->state_date('State date');
        $show->pv('Pv');
        $show->sale('Sale');
        $show->sort('Sort');
        $show->deleted_at('Deleted at');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Goods);

        $form->select('category_1', '商品分类一级')
            ->options(url('admin/api/goods_category'))
            ->load('category_2', url('admin/api/goods_category'));

        $form->select('category_2', '商品分类第二级')
            ->load('category_id', url('admin/api/goods_category'));



        $form->image('prcture.url', '商品主图');
        //多图上传
        $form->multipleImage('prctures', '商品的其他图片');
        $form->hidden('prcture.is_main')->value(1);
        //富文本
        $form->editor('desc', '商品描述');
        $form->radio('state', '上架')->options(['1' => '是', '0' => '否'])->default(0);

        $form->ignore(['category_1', 'category_2', 'category']);

        $form->hasMany('skus', 'SKU列表', function (Form\NestedForm $form) {
            $form->hidden('attrs');
            $form->decimal('price', '价格')
                ->default(0.00)->rules('required');
            $form->number('stock', '库存')->default(0)
                ->rules('required');
        });
        //动态sku属性，回调处理sku
        $form->saving(function (Form $form) {
            $this->prctures($form);
            $this->skus($form);
        });
        return $form;
    }

    //商品多图处理
    private function prctures($form)
    {
        $prctures = $form->input('prctures');
        $prctures['__extend__'] = function ($model, &$array) {
            $data = [];
            foreach ($array as $value) {
                $data[] = [
                    'url' => $value,
                    'is_main' => 0,
                ];
            }
            $array = $data;
        };
        $form->input('prctures', $prctures);
    }

    //商品sku
    private function skus($form)
    {
        //处理sku商品的属性值
        $skus = $form->input('skus');
        if (empty($skus)) {
            return;
        }
        foreach ($skus as $keys => $sku) {
            $data = '';
            foreach ($sku as $key => $value) {
                if (strstr($key, 'attribute_id')) {
                    $data .= ',' . $value . ':' . $sku['attribute_value_id-' . $value];
                }
            }
            $skus[$keys]['attrs'] = substr($data, 1);
        }
        //通过闭包方式 设置 sku的默认图片 ---->默认图片就是商品的主图
        $skus['__extend__'] = function ($model, &$array) {
            $prcture = new \App\Models\Prcture;
            $prcture_id = $prcture->where([
                'goods_id' => $model->id,
                'is_main' => 1,
            ])->value('id');
            foreach ($array as $key => $value) {
                $array[$key]['prcture_id'] = $prcture_id;
                $array[$key]['category_id'] = $model->category_id;
            }
        };
        $form->input('skus', $skus);
    }
}
