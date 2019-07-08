<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client\ClientModel;

class ClientController extends Controller
{
    protected $view_path = "users";

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data['content'] = ClientModel::all()->toJson();
        $data['model'] = new ClientModel();
        return view($this->view_path.".index",compact('data'));
    }

    /**
     * @param $id
     * @return false|string
     */
    public function delete($id){
        $job = ClientModel::find($id)->delete();
        if ($job){
            $data["message"] = "Data successfully deleted..";
        }else{
            $data['message'] = 'Whoops! there is something wrong.';
        }
        return json_encode($data);
    }

    public function store(Request $request){
        $request->validate([
            "name"=>"required",
            "address"=>"required",
            "email"=>"required",
            "contact_number"=>"required",
        ]);

        $job = ClientModel::create($request->all());
        return json_encode($job);
    }
}
