<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\User;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
       // $grid->column('email_verified_at', __('Email verified at'));
       // $grid->column('password', __('Password'));
        $grid->column('username', __('Username'));
        $grid->column('bio', __('Bio'));
       // $grid->column('image_id', __('Image id'));
       // $grid->column('isVerified', __('IsVerified'));
       $grid->column('isVerified', __('IsVerified'))->display(function ($isVerified) {
        return $isVerified ? 'Yes' : 'No';
    });

      //  $grid->column('image.image', __('Image')); 
       // $grid->column('remember_token', __('Remember token'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));


        // Adding filter for the 'name' column
        $grid->filter(function($filter) {
            $filter->equal('name', __('Name'))->select(User::pluck('name', 'name'));
        });

        $grid->filter(function($filter) {
            $filter->equal('isVerified', __('Is Verified'))->select([0 => 'No', 1 => 'Yes']);
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('username', __('Username'));
        $show->field('bio', __('Bio'));
        $show->field('image_id', __('Image id'));
       // $show->field('isVerified', __('IsVerified'));
       $show->field('isVerified', __('Is Verified'))->as(function ($isVerified) {
        return $isVerified ? 'Yes' : 'No';
    });
        // $show->field('remember_token', __('Remember token'));
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
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->text('username', __('Username'));
        $form->text('bio', __('Bio'));
        $form->number('image_id', __('Image id'));

        $form->select('isVerified', __('Is Verified'))->options([0 => 'No', 1 => 'Yes']);
        //$form->select('isVerified', __('Is isVerified'))->options(['No' => 'No', 'Yes' => 'Yes']);

        //$form->text('remember_token', __('Remember token'));

        return $form;
    }
}
