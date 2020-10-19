<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;

use GuzzleHttp\Client;

class AddressController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);

        if($user->role != 'superadmin' || $user->role != 'admin')
        {
            return response()->json(["message" => "Access Not Allowed!"], 403);
        }

        return Address::all();
    }

    public function getByUser($id)
    {
        $address =  Address::find($id);

        if (is_null($address)) {
            return response()->json(["message" => "Record not found!"], 404);
        }

        return $address;
    }

    public function create(request $request)
    {

        $this->validate($request,[

            'name' => 'required|min:3|max:25',
            'phone' => 'required|numeric|digits_between:10,12',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'detailAddress' => 'required|min:10|max:200',
        ]);

        $address = $request->user()->addresses()->create([
            'name' => $request->json('name'),
            'phone' => $request->json('phone'),
            'provinsi' => $request->json('provinsi'),
            'kota' => $request->json('kota'),
            'kecamatan' => $request->json('kecamatan'),
            'kabupaten' => $request->json('kabupaten'),
            'detailAddress' => $request->json('detailAddress'),
            'created_by' => $request->json('created_by'),
        ]);

        return response()->json(
            [
                'Status' => 'Success Create Address!',
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|min:3|max:25',
            'phone' => 'required|numeric|digits_between:10,12',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'detailAddress' => 'required|min:10|max:200',
        ]);

        $address = Address::find($id);

        if (is_null($address)) {
            return response()->json(["message" => "Record not found!"], 404);
        }

        if($request->user()->id != $address->user_id)
        {
            return response()->json(["message" => "Cannot edit this data!"], 403);
        }

        $address->name = $request->name;
        $address->phone = strval($request->phone);
        $address->provinsi = $request->provinsi;
        $address->kota = $request->kota;
        $address->kecamatan = $request->kecamatan;
        $address->kabupaten = $request->kabupaten;
        $address->detailAddress = $request->detailAddress;
        $address->update_by = $request->update_by;
        $address->updated_at = $request->updated_at;
        $address->save();

        return response()->json(
            [
                'Status' => 'Success Update Address!',
            ]
        );
    }

    public function delete(Request $request,$id)
    {
        $address = Address::find($id);

        if(is_null($address))
        {
            return response()->json(["message" => "Record not found!"], 404);
        }

        if($request->user()->id != $address->user_id)
        {
            return response()->json(["message" => "Cannot delete this data!"], 403);
        }

        $address->isDeleted = $request->isDeleted;
        $address->deleted_by = $request->deleted_by;
        $address->save();

        $address->delete();

        return response()->json(
            [
                'Status' => 'Success Delete Address!',
            ]
        );
    }

    public function getProvince()
    {
        $client = new Client();
        $request = $client->get('https://dev.farizdotid.com/api/daerahindonesia/provinsi');
        $response = $request->getBody()->getContents();

        $provinsi = json_decode($response, true);

        if(is_null($provinsi))
        {
            return response()->json(["message" => "Data not found!"], 404);
        }

        return $provinsi;
    }

    public function getKabupaten($id)
    {
        $client = new Client();
        $request = $client->get('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi='.$id);
        $response = $request->getBody()->getContents();

        $kabupaten = json_decode($response, true);

        if(is_null($kabupaten))
        {
            return response()->json(["message" => "Data not found!"], 404);
        }

        return $kabupaten;
    }

    public function getKecamatan($id)
    {
        $client = new Client();
        $request = $client->get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota='.$id);
        $response = $request->getBody()->getContents();

        $kecamatan = json_decode($response, true);

        if(is_null($kecamatan))
        {
            return response()->json(["message" => "Data not found!"], 404);
        }

        return $kecamatan;
    }

    public function getKelurahan($id)
    {
        $client = new Client();
        $request = $client->get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan='.$id);
        $response = $request->getBody()->getContents();

        $kelurahan = json_decode($response, true);

        if(is_null($kelurahan))
        {
            return response()->json(["message" => "Data not found!"], 404);
        }

        return $kelurahan;
    }
}
