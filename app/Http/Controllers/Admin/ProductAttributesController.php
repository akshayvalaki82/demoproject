<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $productattributes = ProductAttribute::where('name', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->orWhere('updated_by', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $productattributes = ProductAttribute::latest()->paginate($perPage);
        }

        return view('admin.product-attributes.index', compact('productattributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.product-attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // dd(auth()->user()->id);
        $productattribute = new productattribute;
        // $productattributeatv = request('atv');
        // dd($productattributeatv);
        $productattribute->name = request('name');
        $productattribute->created_by = auth()->user()->id;
        $productattribute->updated_by = auth()->user()->id;
        $productattribute->save();

        // $requestData = $request->all();
        
        // ProductAttribute::create($requestData);

        return redirect('admin/product-attributes')->with('flash_message', 'ProductAttribute added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $productattribute = ProductAttribute::findOrFail($id);

        return view('admin.product-attributes.show', compact('productattribute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $productattribute = ProductAttribute::findOrFail($id);

        return view('admin.product-attributes.edit', compact('productattribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $productattribute = ProductAttribute::findOrFail($id);
        $productattribute->name = request('name');
        $productattribute->updated_by = auth()->user()->id;
        $productattribute->save();
        
        // $productattribute->update($requestData);

        return redirect('admin/product-attributes')->with('flash_message', 'ProductAttribute updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        ProductAttribute::destroy($id);

        return redirect('admin/product-attributes')->with('flash_message', 'ProductAttribute deleted!');
    }
}