<?php

namespace App\Admin\Controllers;

use App\Models\Goods;
use App\Http\Controllers\Controller;
use App\Models\GoodsCategory;
use App\Models\Picture;
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
            ->body($this->editform()->edit($id));
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
            ->body($this->newform());
    }


    public function editform(){
        $form = new Form(new Goods());
        $form->select('category_1', '商品分类一级')
            ->options(url('admin/api/goods_category'))
            ->load('category_2', url('admin/api/goods_category'));

        $form->select('category_2', '商品分类第二级')
            ->load('category_id', url('admin/api/goods_category'));

        $form->select('category_id', '商品分类第三级')->loadEmbeds(url('admin/api/goods_attribute'),
            function (){
                return <<<EOF
        $(".has-many-skus-form").each(function(index, skus_div) {
        let skus =$(skus_div);
        let new_ = 'new_'+(index + 1);
        skus.find("select[data-attr='skus-attr']").parent().parent().remove();
        skus.find("input[data-attr='skus-attr']").remove();
        let html = '';
        for (i=0; i<data.length; i++) {
            //添加隐藏的input属性 
            html += `<input type="hidden" name="skus[\${new_}][attribute_id-\${data[i]['id']}]" value="\${data[i]['id']}" class="skus attribute_id-\${data[i]['id']}" data-attr="skus-attr">`;
            //添加显示的属性
            html += `<div class="form-group  ">
                <label for="attribute_value_id-\${data[i]['id']}" class="col-sm-2  control-label">商品\${data[i]['name']}的属性值</label>
                <div class="col-sm-8">
                  <input type="hidden" name="skus[\${new_}][attribute_value_id-\${data[i]['id']}]">
                  <select class="form-control skus attribute_value_id-\${data[i]['id']} select2-hidden-accessible" style="width: 100%;" name="skus[\${new_}][attribute_value_id-\${data[i]['id']}]" data-attr="skus-attr" data-value="" tabindex="-1" aria-hidden="true">
                    <option value=""></option>`;
        for (j=0; j < data[i]['value'].length; j++) {
            html += `<option value="\${data[i]['value'][j]['id']}">\${data[i]['value'][j]['text']}</option>`;
        }
        html += `</select>
        </div>
      </div>`;
        }
        skus.prepend(html).trigger('change');
        });
    for(i=0; i<data.length; i++) {
    $(".skus.attribute_value_id-"+data[i]['id']).select2({
    "allowClear":true,"placeholder":{"id":"","text":"\u5546\u54c1\u989c\u8272\u7684\u5c5e\u6027\u503c"}});
    }
EOF;
            });

        //富文本
        $form->text('name', '商品名');
        $form->editor('desc', '商品简介');

        $form->datetime('state_date')->default(now());
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
            $this->pictures($form);
            $this->skus($form);
        });
        return $form;
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
        $grid->category_id('Category id')->display(function ($value){
            return GoodsCategory::find($value)->full_name;
        });;
        $grid->name('商品名');
        $grid->image('商品图片')->image(config('app.url').'/storage/',50,50);
        $grid->desc('Desc');
        $grid->state('是否上架')->display(function ($value){
            $data = [
                '0'=>'否',
                '1'=>'是'
            ];
            return $data[$value];
        });
        $grid->state_date('State date');
        $grid->pv('点击量');
        $grid->sale('销售量');
        $grid->sort('排序级别');
        $grid->deleted_at('删除?')->display(
            function ($value){
                return is_null($value)?'否':'是';
            }
        );
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        return $grid;
    }

    /**i
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Goods::findOrFail($id));

        $show->id('商品Id');
        $show->category_id('商品分类')->display(function ($value){
            return GoodsCategory::find($value)->full_name;
        });
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
    protected function newform()
    {
        $form = new Form(new Goods());
        $form->select('category_1', '商品分类一级')
            ->options(url('admin/api/goods_category'))
            ->load('category_2', url('admin/api/goods_category'));

        $form->select('category_2', '商品分类第二级')
            ->load('category_id', url('admin/api/goods_category'));

        $form->select('category_id', '商品分类第三级')->loadEmbeds(url('admin/api/goods_attribute'),
            function (){
                return <<<EOF
        $(".has-many-skus-form").each(function(index, skus_div) {
        let skus =$(skus_div);
        let new_ = 'new_'+(index + 1);
        skus.find("select[data-attr='skus-attr']").parent().parent().remove();
        skus.find("input[data-attr='skus-attr']").remove();
        let html = '';
        for (i=0; i<data.length; i++) {
            //添加隐藏的input属性 
            html += `<input type="hidden" name="skus[\${new_}][attribute_id-\${data[i]['id']}]" value="\${data[i]['id']}" class="skus attribute_id-\${data[i]['id']}" data-attr="skus-attr">`;
            //添加显示的属性
            html += `<div class="form-group  ">
                <label for="attribute_value_id-\${data[i]['id']}" class="col-sm-2  control-label">商品\${data[i]['name']}的属性值</label>
                <div class="col-sm-8">
                  <input type="hidden" name="skus[\${new_}][attribute_value_id-\${data[i]['id']}]">
                  <select class="form-control skus attribute_value_id-\${data[i]['id']} select2-hidden-accessible" style="width: 100%;" name="skus[\${new_}][attribute_value_id-\${data[i]['id']}]" data-attr="skus-attr" data-value="" tabindex="-1" aria-hidden="true">
                    <option value=""></option>`;
        for (j=0; j < data[i]['value'].length; j++) {
            html += `<option value="\${data[i]['value'][j]['id']}">\${data[i]['value'][j]['text']}</option>`;
        }
        html += `</select>
        </div>
      </div>`;
        }
        skus.prepend(html).trigger('change');
        });
    for(i=0; i<data.length; i++) {
    $(".skus.attribute_value_id-"+data[i]['id']).select2({
    "allowClear":true,"placeholder":{"id":"","text":"\u5546\u54c1\u989c\u8272\u7684\u5c5e\u6027\u503c"}});
    }
EOF;
            });

        $form->image('picture.url', '商品主图');
        $form->hidden('picture.is_main')->value(1);
        //多图上传
        $form->multipleImage('pictures', '商品的其他图片');
        //富文本
        $form->text('name', '商品名');
        $form->editor('desc', '商品简介');

        $form->datetime('state_date')->default(now());
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
            $this->pictures($form);
            $this->skus($form);
            $form->input('image',$form->input('picture.url'));
        });
        return $form;
    }
    //商品多图处理
    private function pictures($form)
    {
        $pictures = $form->input('pictures');
        $pictures['__extend__'] = function ($model, &$array) {
            $data = [];
            foreach ($array as $value) {
                $data[] = [
                    'url' => $value,
                    'is_main' => 0,
                ];
            }
            $array = $data;
        };
        $form->input('pictures', $pictures);
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
        $skus['__extend__'] = function ($model, &$array)  {
            $pictures = new \App\Models\Picture;
            $picture_id = $pictures->where([
                'goods_id' => $model->id,
                'is_main' => 1,
            ])->value('id');
            foreach ($array as $key => $value) {
                $array[$key]['picture_id'] = $picture_id;
                $array[$key]['category_id'] = $model->category_id;
            }
        };
        $form->input('skus', $skus);
    }

    public function store()
    {
        return $this->newform()->store();
    }
}
