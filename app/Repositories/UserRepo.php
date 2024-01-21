<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepo
{
    public function listing($req){

        $query = User::whereNull("deleted_at")->where("role", "!=", "SUPER ADMIN");

        $pencarian = $req->pencarian;
        if ($pencarian) {
            $query->where("fullname", "like", "%$pencarian%");
        }
        $query->orderBy('created_at', 'DESC');
        return $query->get();
    }

    public function getByUsername($username){
        return User::where("username", $username)->first();
    }

    public function save($data){
        if($data['username']){
            User::where("username", $data['username'])->update($data);
            return User::where('username', $data['username'])->first();
        }

        DB::raw('lock tables users write');

        $count = User::count();
        $username = $this->generateUsername($count + 1, $data['role']);
        $data = User::create([
                    "username" => $username,
                    "password" => Hash::make($username),
                    "fullname" => $data['fullname'],
                    "role" => $data['role']
                ]);
        DB::raw('unlock tables');

        return $data;

    }

    public function resetPassword($username){
        User::where("username", $username)->update([
            "password" => Hash::make($username)
        ]);
    }

    private function generateUsername($id, $role){
        return strtoupper(substr($role, 0, 3) . $id);
    }

    public function delete($username){
        User::where("username", $username)->update(["deleted_at" => now()]);
    }


}
