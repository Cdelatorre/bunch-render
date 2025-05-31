<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Services';
        $emptyMessage = 'No service found';
        $services = Services::where('parent', 0)->paginate(getPaginate());
        $rootServices = Services::with('children')->where('parent', 0)->get();

        return view('admin.service.index', compact('pageTitle', 'emptyMessage', 'services', 'rootServices'));
    }

    public function edit($parentId)
    {
        $p_service = Services::where('id', $parentId)->get()->first();
        $services = Services::with('children')->where('parent', $parentId)->paginate(getPaginate());
        $pageTitle = $p_service->name;

        return view('admin.service.edit', compact('services', 'p_service', 'pageTitle'));
    }

    public function serviceStore(Request $request, $id=0)
    {
        if($id == 0)
        {
            $request->validate([
                'name' => 'required|string||unique:services',
                'parent' => 'required'
            ]);
        }else{
            $request->validate([
                'name' => 'required',
                'parent' => 'required'
            ]);
        }

        $service = new Services();
        $message =  'Services created successfully';

        if($id){

            $check = Services::whereNot('id', $id)->where('name', $request->name)->count();

            if($check > 0)
            {
                $notify[] = ['error', 'Services name already exists'];
                return redirect()->back()->withNotify($notify);
            }

            $service = Services::findOrFail($id);
            $service->status = $request->status ? 1 : 0;
            $message = 'Services updated successfully';
        }

        $service->name = $request->name;
        $service->parent = $request->parent;
        $service->status = $request->status ? 1 : 0;
        $service->save();

        $notify[] = ['success', $message];
        return redirect()->back()->withNotify($notify);

    }
}
