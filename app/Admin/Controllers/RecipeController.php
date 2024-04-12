<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Recipe;
use App\Models\Category;
use App\Models\User;

class RecipeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Recipe';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Recipe());

        $grid->column('id', __('Id'));
        //$grid->column('creator_id', __('Creator id'));
        $grid->column('user.name', __('CreatorName'));
        $grid->column('title', __('Title'));
        $grid->column('category.name', __('Category')); // Accessing category name through the relationship
        //$grid->column('category_id', __('Category id'));
        $grid->column('description', __('Description'));
        $grid->column('image_id', __('Image id'));
        //$grid->column('image.image', __('Image')); 
        $grid->column('preparationTime', __('PreparationTime'));
        $grid->column('comment', __('Comment'));
        $grid->column('totalLikes', __('TotalLikes'));
        $grid->column('avrgRating', __('AvrgRating'));

        $grid->column('isActive', __('IsActive'))->display(function ($isVerified) {
            return $isVerified ? 'Yes' : 'No';
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));


        $grid->filter(function($filter) {
            $filter->equal('category_id', 'Category')->select(Category::pluck('name', 'id'));
        });

        // Filter by creator id
        $grid->filter(function($filter) {
            $filter->equal('creator_id', 'Creator ID')->select(User::pluck('name', 'id'));
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
        $show = new Show(Recipe::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('creator_id', __('Creator id'));
        $show->field('title', __('Title'));
        $show->field('category_id', __('Category id'));
        $show->field('description', __('Description'));
        $show->field('image_id', __('Image id'));
        $show->field('preparationTime', __('PreparationTime'));
        $show->field('comment', __('Comment'));
        $show->field('totalLikes', __('TotalLikes'));
        $show->field('avrgRating', __('AvrgRating'));
        $show->field('isActive', __('isActive'));

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
        $form = new Form(new Recipe());

        $form->number('creator_id', __('Creator id'));
        $form->text('title', __('Title'));
        $form->number('category_id', __('Category id'));
        $form->textarea('description', __('Description'));
        $form->number('image_id', __('Image id'));
        $form->number('preparationTime', __('PreparationTime'));
        $form->textarea('comment', __('Comment'));
        $form->number('totalLikes', __('TotalLikes'));
        $form->decimal('avrgRating', __('AvrgRating'))->default(0.00);
        $form->select('isActive', __('Is Active'))->options([0 => 'No', 1 => 'Yes']);

        return $form;
    }
}
