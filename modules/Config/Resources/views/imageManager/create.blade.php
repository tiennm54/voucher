@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <h1>IMAGE MANAGER</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ URL::route('admin.index') }}">Home</a>
            </li>
            <li>
                <a>Image manager</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    @include('validator.flash-message')
    <div class="alert alert-success" style="display: none">

    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>Image Management</h3>
        </div>
        <div class="panel-body">
            <div class="well">
                <div class="row">
                    <form action="<?php echo URL::route('config.image.postCreate');?>" method="post" enctype="multipart/form-data">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Title</label>
                                <input type="text" class="form-control border-input" name="title" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Image</label>
                                <input type="file" class="form-control border-input" name="image">
                                {!! $errors->first('image','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label class="control-label">Create</label>
                                <div>
                                    <button type="submit" class="btn btn-primary pull-right">Create</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td width="20%">Title</td>
                            <td width="20%">Image</td>
                            <td>Link</td>
                            <td width="12%">Action</td>
                        </tr>
                        <tr>
                            <form action="" method="get">
                                <td>
                                    <input class="form-control" name="search_title" value="<?php (Request::get('search_title') != "") ? Request::get('search_title') : "" ?>"/>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <button type="submit" class="btn btn-primary btn-xs">Search</button>
                                    <a href="<?php echo URL::route('config.image.getCreate'); ?>" class="btn btn-default pull-right btn-xs">Reset</a>
                                </td>
                            </form>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($model) == 0): ?> 
                            <tr>
                                <td colspan="8">Không có bản ghi nào</td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($model as $key => $item): ?>
                            <tr>
                                <td>
                                    {{ $item->title }} <br> <span>({{ $item->created_at }})</span>
                                </td>
                                <td class="text-center"><img src="<?php echo url('images/news/' . $item->image); ?>" width="150px"></td>
                                <td class="text-center">
                                    <input value="<?php echo url('images/news/' . $item->image); ?>" class="form-control">
                                </td>
                                
                                <td class="text-center">
                                    <a class="btn btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this item?');"
                                       href="<?php echo URL::route('config.image.delete', ['id' => $item->id]); ?>">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                </table>
                <?php echo $model->appends(['search_title' => Request::get('search_title')])->render(); ?>
            </div>
        </div>
    </div>
</div>
@stop