<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressRequest;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAddressesController extends Controller
{
    public function index()
    {
        return view('user.address.index', ['addresses' => Auth::user()->addresses]);
    }

    public function create()
    {
        return view('user.address.create_and_edit', ['address' => new UserAddress()]);
    }

    public function edit($id)
    {
        $user_address = UserAddress::find($id);
        $this->authorize('own', $user_address);
        return view('user.address.create_and_edit', ['address' => $user_address]);
    }

    public function store(UserAddressRequest $request)
    {
        $request->user()->addresses()->create($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));
        return redirect()->route('user.addresses.index')->with('success', '保存成功');
    }

    public function update(UserAddressRequest $request, $id)
    {
        $user_address = UserAddress::find($id);
        $this->authorize('own', $user_address);
        $user_address->update($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));
        return redirect()->route('user.addresses.index')->with('success', '修改成功');
    }

    public function delete($id)
    {
        $user_address=  UserAddress::find($id);
        $this->authorize('own', $user_address);
        $user_address->delete();
        return [];
    }
}
