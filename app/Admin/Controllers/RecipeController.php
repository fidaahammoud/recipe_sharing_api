<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Recipe;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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
        $grid->column('user.name', __('CreatorName'));
        $grid->column('title', __('Title'));
        $grid->column('category.name', __('Category'));
       // $grid->column('description', __('Description'));
       // $grid->column('image_id', __('Image id'));
        
        $grid->column('preparationTime', __('PreparationTime'));
       // $grid->column('comment', __('Comment'));
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

        $grid->filter(function($filter) {
            $filter->equal('creator_id', 'Chef')->select(User::pluck('name', 'id'));
        });

        $grid->filter(function($filter) {
            $filter->equal('isActive', __('Is Active'))->select([0 => 'No', 1 => 'Yes']);
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
        $recipe = Recipe::with('ingredients', 'steps')->findOrFail($id);
     
        $show = new Show($recipe);
    
        $show->field('id', __('Id'));
        $show->field('user.name', __('Creator Name'));
        $show->field('title', __('Title'));
        $show->field('category.name', __('Category'));
        $show->field('description', __('Description'));
        $show->field('image_id', __('Image id'));
        $show->field('preparationTime', __('PreparationTime'));
        $show->field('comment', __('Comment'));
        $show->field('totalLikes', __('TotalLikes'));
        $show->field('avrgRating', __('AvrgRating'));
       // $show->field('isActive', __('isActive'));
        $show->field('isActive', __('Is Active'))->as(function ($isVerified) {
            return $isVerified ? 'Yes' : 'No';
        });
        // Display ingredients
        $show->field('ingredients', __('Ingredients'))->as(function () use ($recipe) {
            $ingredients = '';
            foreach ($recipe->ingredients as $ingredient) {
                $ingredients .= $ingredient->ingredientName . ' - ' . $ingredient->measurementUnit . '<br>';
            }
            return $ingredients;
        })->unescape();
    
        // Display steps
        $show->field('steps', __('Steps'))->as(function () use ($recipe) {
            $steps = '';
            foreach ($recipe->steps as $step) {
                $steps .= $step->stepDescription . '<br>';
            }
            return $steps;
        })->unescape();
    
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
