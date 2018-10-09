<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Articles;
use App\Models\ArticlesType;
use App\Models\Category;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\ArticlesRequest;
use Pingpong\Modules\Routing\Controller;
use Input;
use DB;
use Log;

class BackendArticlesController extends Controller {

    public function __construct() {
        $this->middleware("editor");
    }

    public function index(Request $request) {

        $model = new Articles();

        if (isset($request->txt_title) && $request->txt_title != "") {
            $model = $model->where("title", "LIKE", "%" . $request->txt_title . "%");
        }

        if (isset($request->txt_code) && $request->txt_code != "") {
            $model = $model->where("code", "LIKE", "%" . $request->txt_code . "%");
        }

        if (isset($request->txt_brand) && $request->txt_brand != "") {
            $model = $model->where("brand", "LIKE", "%" . $request->txt_brand . "%");
        }

        if (isset($request->int_status_stock) && $request->int_status_stock != "") {
            $model = $model->where("status_stock", "=", $request->int_status_stock);
        }
        
        if (isset($request->reseller_status ) && $request->reseller_status  != "") {
            $model = $model->where("reseller_status", "=", $request->reseller_status);
        }

        $model = $model
                ->orderBy('status_stock',"DESC")
                ->orderBy('reseller_status',"DESC")
                ->orderBy('order_count',"DESC")
                ->paginate(NUMBER_PAGE);
        return view('admin::articles.index', compact('model'));
    }

    public function getCreate() {
        $model_cate = Category::get();
        return view('admin::articles.create', compact('model_cate'));
    }

    public function postCreate(ArticlesRequest $request) {
        if (isset($request)) {
            DB::beginTransaction();

            $model = new Articles();
            $model->title = $request->txt_title;
            $model->code = $request->txt_code;
            $model->url_title = str_slug($request->txt_title, '-') . '-' . 'premium-key-reseller';
            $model->status_stock = $request->int_instock;
            $model->status_disable = $request->status_disable;

            if (isset($request->txt_brand)) {
                $model->brand = $request->txt_brand;
            }

            if (isset($request->txt_description)) {
                $model->description = $request->txt_description;
            }

            if (isset($request->txt_seo_title)) {
                $model->seo_title = $request->txt_seo_title;
            }

            if (isset($request->txt_seo_description)) {
                $model->seo_description = $request->txt_seo_description;
            }

            if (isset($request->txt_seo_keyword)) {
                $model->seo_keyword = $request->txt_seo_keyword;
            }

            if (isset($request->site_official)) {
                $model->site_official = $request->site_official;
            }

            if (isset($request->txt_image)) {
                if ($request->hasFile('txt_image')) {
                    $image = $request->file('txt_image');
                    $input['image_name'] = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/images');
                    $image->move($destinationPath, $input['image_name']);
                    $model->image = $input['image_name'];
                }
            }

            $model->save();
            DB::commit();
            return redirect()->route('articles.getEdit', ['id' => $model->id]);
        }
    }

    public function getEdit($id) {
        $model = Articles::find($id);
        $model_cate = Category::get();
        if ($model != null) {
            return view('admin::articles.edit', compact('model', 'model_cate'));
        } else {
            return view('errors.503');
        }
    }

    public function postEdit(ArticlesRequest $request, $id) {
        if (isset($request)) {
            DB::beginTransaction();
            $model = Articles::find($id);
            if ($model != null) {
                $old_image = $model->image;
                $old_image_seo = $model->image_seo;
                

                $model->title = $request->txt_title;
                $model->code = $request->txt_code;
                $model->status_stock = $request->int_instock;
                $model->status_disable = $request->status_disable;

                if (isset($request->txt_brand)) {
                    $model->brand = $request->txt_brand;
                }

                if (isset($request->txt_description)) {
                    $model->description = $request->txt_description;
                }

                if (isset($request->txt_seo_title)) {
                    $model->seo_title = $request->txt_seo_title;
                }

                if (isset($request->txt_seo_description)) {
                    $model->seo_description = $request->txt_seo_description;
                }

                if (isset($request->txt_seo_keyword)) {
                    $model->seo_keyword = $request->txt_seo_keyword;
                }

                if (isset($request->site_official)) {
                    $model->site_official = $request->site_official;
                }
                
                if (isset($request->view_count)) {
                    $model->view_count = $request->view_count;
                }
                if (isset($request->order_count)) {
                    $model->order_count = $request->order_count;
                }
                
                if (isset($request->reseller_page) && $request->reseller_page != "") {
                    $model->reseller_page = $request->reseller_page;
                    $model->reseller_status = 1;
                }else{
                    $model->reseller_page = $request->reseller_page;
                    $model->reseller_status = 0;
                }


                if (isset($request->txt_image)) {
                    if ($request->hasFile('txt_image')) {
                        $image = $request->file('txt_image');
                        $input['image_name'] = time() . '.' . $image->getClientOriginalExtension();
                        $destinationPath = public_path('/images');
                        $image->move($destinationPath, $input['image_name']);
                        $model->image = $input['image_name'];

                        if ($old_image && file_exists('images/' . $old_image)) {
                            unlink('images/' . $old_image);
                        }
                    }
                }
                
                
                if (isset($request->image_seo)) {
                    if ($request->hasFile('image_seo')) {
                        $image = $request->file('image_seo');
                        $input['image_name_seo'] = time() . '.' . $image->getClientOriginalExtension();
                        $destinationPath = public_path('/images/productSeo');
                        $image->move($destinationPath, $input['image_name_seo']);
                        $model->image_seo = $input['image_name_seo'];

                        if ($old_image_seo && file_exists('images/productSeo/' . $old_image_seo)) {
                            unlink('images/productSeo/' . $old_image_seo);
                        }
                    }
                }

                $model->save();

                if ($model->status_stock == 0) {//Neu het hang thi update toan bo het hang
                    ArticlesType::where("articles_id", "=", $model->id)->update(['status_stock' => 0]);
                }

                DB::commit();
                $request->session()->flash('alert-success', 'Success: Update Completed!');
                return back();
            }
        } else {

            DB::rollback();
            return view('errors.503');
        }
    }

    public function view($id) {
        $model = Articles::find($id);
        if ($model != null) {
            $model->getCategory;
            $model_children = ArticlesType::where("articles_id", "=", $model->id)->orderBy("price_order", "ASC")->get();

            return view('admin::articles.view', compact('model', 'model_children'));
        } else {
            return view('errors.503');
        }
    }
    
    public function autoComplete(Request $request){
        if (isset($request)) {
            $data = Articles::select(
                "id",
                "title as name"
            )->where("title", "LIKE", "%{$request->input('query')}%")->get();
            return response()->json($data);
        }
    }

}

?>