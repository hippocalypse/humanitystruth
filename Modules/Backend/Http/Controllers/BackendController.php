<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
use App\Affiliate;
use Illuminate\Support\Facades\DB;

class BackendController extends Controller
{
    
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admins');
        //ensure that logged in user is of type 'admin' or 'super_admin'
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = "dashboard";
        return view('backend::dashboard', compact('menu'));
    }

    public function affiliatesView() {
        $menu = "affiliates";
        $affiliates = Affiliate::All();
        return view('backend::affiliates', compact('menu', 'affiliates'));
    }

    public function affiliatesSave(Request $request) {
        if($request->input('mode') == 'save') {
            $this->validate($request, [
                'name' => 'required',
                'logo' => 'required',
                'website' => 'required'
            ]);
    
            if ($request->hasFile('logo')) {
                $imageName = time().'.'.$request->logo->getClientOriginalExtension();
                $request->logo->move(public_path('uploads'), $imageName);
                DB::table('affiliates')->insert(
                    ['name' => $request->input('name'), 'logo' => $imageName, 'website' => $request->input('website')]
                );
            }
        } else {
            if ($request->hasFile('logo')) {
                $imageName = time().'.'.$request->logo->getClientOriginalExtension();
                $request->logo->move(public_path('uploads'), $imageName);
                DB::table('affiliates')
                ->where('id', $request->input('aff_id'))
                ->update(['logo' => $imageName, 'name' => $request->input('name'), 'website' => $request->input('website')] );
            } else {
                DB::table('affiliates')
                ->where('id', $request->input('aff_id'))
                ->update(['name' => $request->input('name'), 'website' => $request->input('website')] );
            }
        }
        
        return back();
    }

    public function affiliatesRemove($id) {
        DB::table('affiliates')->where('id', $id)->delete();
        return back();
    }

}
