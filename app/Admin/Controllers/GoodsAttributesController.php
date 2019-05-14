<?php

namespace App\Admin\Controllers;

use App\Models\GoodsAttribute;
use App\Http\Controllers\Controller;
use App\Models\GoodsCategory;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodsAttributesController extends Controller
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
        $grid = new Grid(new GoodsAttribute);

        $grid->id('Id');
        $grid->category_id('分类')->display(function ($value){
            return GoodsCategory::find($value)->full_name;
        });
        $grid->name('属性名');
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
        $show = new Show(GoodsAttribute::findOrFail($id));

        $show->id('Id');
        $show->category_id('Category id');
        $show->name('Name');
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
        $form = new Form(new GoodsAttribute);

        $form->select('category_1', 'Category id')
        ->options(url('/admin/api/goods_category'))
            ->load('category_2',url('/admin/api/goods_category'));
        $form->select('category_2', 'Category id')
            ->load('category_id',url('/admin/api/goods_category'));
        $form->select('category_id', 'Category id');
        $form->text('name', 'Name');

        $form->hasMany('value', '属性值', function (Form\NestedForm $form) {
            $form->text('name', '属性名称')
                ->rules('required');
        });
        $form->ignore(['category_1','category_2']);
        return $form;
    }
    public function apiShow(Request $request){
        $category_id = (empty($request->input('q'))) ? 0 : $request->input('q');
        $attrs = $this->getAttribute($category_id);
        return empty($attrs)?$this->getAttribute(0):$attrs;
    }

    public function getAttribute($category_id){
        return GoodsAttribute::with([
            'value'=>function ($value) {
                $value->select('id','attribute_id','name as text');
            }
        ])->where('category_id',$category_id)->get()->toArray();
    }

}
