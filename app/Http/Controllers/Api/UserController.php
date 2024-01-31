<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Repositories\UserRepo;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController {

    public function listing(Request $req){
        $data = (new UserRepo)->listing($req);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $username = $row['username'];
                $edit = "form.edit('$username')";
                $hapus = "form.hapus('$username')";
                $resetPassword = "form.resetPassword('$username')";

                $action = '<span onclick="'.$edit.'" class="badge badge-button badge-warning">Edit</span>
                            <span onclick="'.$resetPassword.'" class="badge badge-button badge-success">Reset password</span>
                            <span onclick="'.$hapus.'" class="badge badge-button badge-danger">Delete</span>';
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show(Request $req){
        $data = (new UserRepo)->getByUsername($req->username);
        if(!$data){
            return Helper::jsonResponse(404, "Data tidak ditemukan");
        }
        return Helper::jsonResponse(200, "Data ditemukan", $data);
    }
    public function save(Request $req){
        if(!$req->fullname){
            return Helper::jsonResponse(422, "Fullname harus diisi");
        }
        if(!$req->role){
            return Helper::jsonResponse(422, "Role harus diisi");
        }

        $data = [
            "username" => $req->username,
            "fullname" => $req->fullname,
            "role" => $req->role,
        ];
        DB::connection("main")->beginTransaction();
        try{
            $data = (new UserRepo)->save($data);
            DB::connection("main")->commit();
            return Helper::jsonResponse(200, "Data berhasil disimpan", $data);
        }catch(\Exception $e){
            DB::connection("main")->rollback();
            return Helper::jsonResponse(500, "Data gagal disimpan");
        }
    }

    public function resetPassword(Request $req){
        if(!$req->username){
            return Helper::jsonResponse(422, "Data tidak ditemukan");
        }

        (new UserRepo)->resetPassword($req->username);
        return Helper::jsonResponse(200, "Password berhasil direset");
    }

    public function delete(Request $req){
        if(!$req->username){
            return Helper::jsonResponse(422, "Username tidak ditemukan");
        }
        (new UserRepo)->delete($req->username);
        return Helper::jsonResponse(200, "Data berhasil dihapus");
    }
}
