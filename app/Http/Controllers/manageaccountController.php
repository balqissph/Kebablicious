<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class manageaccountController extends Controller
{
    public function tampildata()
    {

        $posts = User::paginate(5);

        return view('admin.admin-dashboard-manage-account', compact('posts'));
    }

    public function tambahrole(Request $request)
    {
        $request->validate([
            'model_id' => 'required|integer|unique:model_has_roles,model_id',
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'App\Models\User',
            'model_id' => $request->model_id,
        ]);

        return redirect()->route('user');
    }

    public function hapusrole(Request $request)
    {
        $request->validate([
            'model_id' => 'required|integer|exists:model_has_roles,model_id',
        ]);

        $defaultRoleId = 1;
        $defaultModelType = 'App\Models\User';

        DB::table('model_has_roles')
            ->where('model_id', $request->model_id)
            ->where('role_id', $defaultRoleId)
            ->where('model_type', $defaultModelType)
            ->delete();

        return redirect()->route('user')->with('success', 'Role terkait model_id berhasil dihapus.');
    }

}
