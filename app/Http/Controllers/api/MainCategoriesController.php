<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainCategory;
use App\Traits\GeneralTrait;
class MainCategoriesController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        $data=MainCategory::select('id','name_'.app()->getlocale() .' as name')->get();
        return response()->json($data);
    }
    public function main_category_ById(Request $req)
    {
        $data=MainCategory::select('id','name_'.app()->getlocale() .' as name')->where('id',$req->id)->first();
        if(!$data)
        {
            return $this->returnError('001','هذا القسم غير موجود');
        }
        return $this->returnData('category',$data,'تم جلب البيانات بنجاح');
    }

    public function main_category_active(Request $req,$id)
    {
        $data=MainCategory::where('id',$id)->update(['active'=>$req->active]);

        return $this->returnSuccessMessage('تم تغيير الحالة بنجاح');
    }
}
