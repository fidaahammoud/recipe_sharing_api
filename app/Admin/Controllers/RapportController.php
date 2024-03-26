<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Layout\Content;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Rapport;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;


class RapportController extends AdminController
{

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Rapport';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Rapport());
    
        $grid->column('id', __('Id'));
        $grid->column('creator_id', __('Creator id'));
        $grid->column('category_id', __('Category id'));
        $grid->column('startDate', __('StartDate'));
        $grid->column('endDate', __('EndDate'));
        //$grid->column('guid', __('Guid'));
        $grid->column('url', __('Url'))->display(function ($url) {
            return "<a href='{$url}' class='btn btn-primary' target='_blank'>View</a>";
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
    
        $grid->disableActions(); // Disables actions (Edit, Delete) for the grid
    
        $grid->filter(function($filter) {
            $filter->equal('category_id', 'Category')->select(Category::pluck('name', 'id'));
        });
    
        // Filter by creator id
        $grid->filter(function($filter) {
            $filter->equal('creator_id', 'User')->select(User::pluck('name', 'id'));
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
        $show = new Show(Rapport::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('creator_id', __('Creator id'));
        $show->field('category_id', __('Category id'));
        $show->field('startDate', __('StartDate'));
        $show->field('endDate', __('EndDate'));
        $show->field('guid', __('Guid'));
        $show->field('url', __('Url'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Rapport());

        $form->select('creator_id', __('Creator'))->options(User::pluck('name', 'id'));
        $form->select('category_id', __('Category'))->options(Category::pluck('name', 'id'));
        $form->date('startDate', __('StartDate'))->default(date('Y-m-d'));
        $form->date('endDate', __('EndDate'))->default(date('Y-m-d'));

        $guidWithoutDashes = Str::orderedUuid();
        $form->text('guid', __('Guid'))->value($guidWithoutDashes)->readonly(true);

        $url= "http://". "" . env('SERVER_IP'). "" ."/admin/pdf?guid=$guidWithoutDashes";
        $form->text('url', __('Url'))->value($url)->readonly(true);
        
        
        return $form;
    }


    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        $form = $this->form();
        if ($this->hasHooks('alterForm')) {
            $form = $this->callHooks('alterForm', $form);
        }
        
        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($form);
    }
}
