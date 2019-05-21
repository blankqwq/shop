<?php

namespace App\Admin\Controllers;

use App\Exceptions\InternalException;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class OrdersController extends Controller
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
     * @param mixed $order
     * @param Content $content
     * @return Content
     */
    public function show(Order $order, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body(view('admin.orders.show', ['order' => $order]));
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
        $grid = new Grid(new Order);
        $grid->model()->whereNotNull('paid_at')->orderBy('paid_at', 'desc');
        $grid->id('Id');
        $grid->no('订单号');
        $grid->user_id('用户名')->display(function ($value) {
            return User::find($value)->name;
        });
//        $grid->address('地址')->display(function ($value){
//            return User::find($value)->name;
//        });;
        $grid->total_amount('总金额');
        $grid->paid_at('支付时间');
        $grid->payment_method('支付方式');
        $grid->ship_status('物流状态')->display(function ($value) {
            return Order::$shipStatusMap[$value];
        });
        $grid->refund_status('退款状态')->display(function ($value) {
            return Order::$refundStatusMap[$value];
        });
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            // 禁用删除和编辑按钮
            $actions->disableDelete();
            $actions->disableEdit();
        });
        $grid->tools(function ($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });
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
        $show = new Show(Order::findOrFail($id));

        $show->id('Id');
        $show->no('No');
        $show->user_id('User id');
        $show->address('Address')->display(function ($value) {
            return join('', $value);
        });
        $show->total_amount('Total amount');
        $show->remark('Remark');
        $show->paid_at('Paid at');
        $show->payment_method('Payment method');
        $show->payment_no('Payment no');
        $show->refund_no('Refund no');
        $show->refund_status('Refund status');
        $show->closed('Closed');
        $show->reviewed('Reviewed');
        $show->ship_status('Ship status');
        $show->ship_data('Ship data');
        $show->extra('Extra');
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
        $form = new Form(new Order);

        $form->text('no', 'No');
        $form->number('user_id', 'User id');
        $form->textarea('address', 'Address');
        $form->decimal('total_amount', 'Total amount');
        $form->textarea('remark', 'Remark');
        $form->datetime('paid_at', 'Paid at')->default(date('Y-m-d H:i:s'));
        $form->text('payment_method', 'Payment method');
        $form->text('payment_no', 'Payment no');
        $form->text('refund_no', 'Refund no');
        $form->text('refund_status', 'Refund status')->default('pending');
        $form->switch('closed', 'Closed');
        $form->switch('reviewed', 'Reviewed');
        $form->text('ship_status', 'Ship status')->default('pending');
        $form->textarea('ship_data', 'Ship data');
        $form->textarea('extra', 'Extra');

        return $form;
    }

    public function ship(Order $order, Request $request)
    {
        if (!$order->paid_at) {
            throw new InternalException('该订单未完成支付');
        }
        if ($order->ship_status !== Order::SHIP_STATUS_PENDING) {
            throw new InternalException('该订单已支付');
        }

        $data = $this->validate($request, [
            'express_company' => ['required'],
            'express_no' => ['required']
        ], [], [
            'express_company' => '物流公司',
            'express_no' => '物流订单'
        ]);

        $order->update([
            'ship_status' => Order::SHIP_STATUS_DELIVERED,
            'ship_data' => $data
        ]);
        return redirect()->back();
    }




}
