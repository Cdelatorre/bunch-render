<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category as Activity;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Activities';
        $emptyMessage = 'No activity found';
        $categories = Activity::paginate(getPaginate());

        return view('admin.category.index', compact('pageTitle', 'emptyMessage', 'categories'));
    }

    public function categoryStore(Request $request, $id=0)
    {
        if($id == 0)
        {
            $request->validate([
                'name' => 'required|string||unique:categories',
                'icon' => 'required'
            ]);
        }else{
            $request->validate([
                'name' => 'required',
                'icon' => 'required'
            ]);
        }

        $activity = new Activity();
        $message =  'Activity created successfully';

        if($id){

            $check = Activity::whereNot('id', $id)->where('name', $request->name)->count();

            if($check > 0)
            {
                $notify[] = ['error', 'Activity name already exists'];
                return redirect()->back()->withNotify($notify);
            }

            $activity = Activity::findOrFail($id);
            $activity->status = $request->status ? 1 : 0;
            $message = 'Activity updated successfully';
        }

        if ($request->image) {
            try {
                $directory = date("Y")."/".date("m");
                $path       = getFilePath('activity').'/'.$directory;
                $image = fileUploader($request->image, $path, getFileSize('activity'));
                $activity->banner = $directory.'/'.$image;
            } catch (\Exception $exp) {
                $notify[]       = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $activity->name = $request->name;
        $activity->icon = $request->icon;
        $activity->status = $request->status ? 1 : 0;
        $activity->save();

        $notify[] = ['success', $message];
        return redirect()->back()->withNotify($notify);

    }
}
