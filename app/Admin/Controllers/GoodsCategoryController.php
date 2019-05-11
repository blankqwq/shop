<?php

namespace App\Admin\Controllers;

use App\Models\GoodsCategory;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodsCategoryController extends Controller
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
            ->header('编辑')
            ->description('编辑商品分类')
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
            ->header('创建')
            ->description('创建商品分类')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GoodsCategory);

        $grid->id('Id');
        $grid->name('分类名');
        $grid->parent_id('父级id');
        $grid->image('图片')->image( config('app.url').'/storage/',50, 50);
        $grid->levels('等级');
        $grid->sort('排序级别');
        $grid->possess('路径');
        $grid->model()->orderby('level','asc');
        $grid->model()->orderby('sort','desc');
        $grid->model()->orderby('id','asc');

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
        $show = new Show(GoodsCategory::findOrFail($id));

        $show->id('Id');
        $show->name('分类名');
        $show->parent_id('父级');
        $show->image('图片')->image( config('app.url').'/storage/');
        $show->levels('排序等级');
        $show->sort('排序等级');
        $show->full_name('路径');
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
        $category=new GoodsCategory();
        $form = new Form($category);

        $form->text('name', '分类名');
        $form->select('parent_id','上级')
            ->options($category::selectOptions(function ($category) {
                return $category->where('level','<>',2);
            }));
        $form->image('image', '图片');
        $form->number('sort', '排序级别')->default(0);

        return $form;
    }

    public function apiShow(Request $request){
        $parent_id = (empty($request->input('q'))) ? 0 : $request->input('q');
        $category = GoodsCategory::where('parent_id', $parent_id)->get(['id', DB::raw('name as text'), 'level']);

        return $category;
    }
}
