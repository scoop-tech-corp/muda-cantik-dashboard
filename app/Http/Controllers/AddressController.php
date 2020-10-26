<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role == 'user' || $request->user()->role == 'admin') {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => [
                    'user' => ['Access is not allowed!'],
                ]], 403);
        }
        $address = Address::all();

        return response()->json($address, 200);
    }

    public function getByUser(Request $request, $id)
    {
        if ($request->user()->role == 'admin' || $request->user()->role == 'user') {

            if ($request->user()->id != $id) {

                return response()->json([
                    'message' => 'The user role was invalid.',
                    'errors' => [
                        'user' => ['Access is not allowed!'],
                    ]], 403);
                    
            } else {

                $address = Address::find($id);

                if (is_null($address)) {
                    return response()->json([
                        'message' => 'The data was invalid.',
                        'errors' => [
                            'data' => ['Data not found!'],
                        ]], 404);
                }

                return response()->json($address, 200);
            }

        }

        $address = Address::find($id);

        if (is_null($address)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'data' => ['Data not found!'],
                ]], 404);
        }

        return response()->json($address, 200);
    }

    public function create(request $request)
    {

        $this->validate($request, [

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
                'message' => 'Success Create Address!',
            ], 200
        );
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
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
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'data' => ['Data not found!'],
                ]], 404);
        }

        if ($request->user()->id != $address->user_id) {
            return response()->json([
                'message' => 'The user role was invalid.',
                'errors' => [
                    'user' => ['Access is not allowed!'],
                ]], 403);
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
                'message' => 'Success Update Address!',
            ], 200
        );
    }

    public function delete(Request $request, $id)
    {
        $address = Address::find($id);

        if (is_null($address)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'data' => ['Data not found!'],
                ]], 404);
        }

        if($request->user()->role != 'superadmin')
        {
            if ($request->user()->id != $address->user_id) {
                return response()->json([
                    'message' => 'The user role was invalid.',
                    'errors' => [
                        'user' => ['Access is not allowed!'],
                    ]], 403);
            }

        }        

        $address->isDeleted = $request->isDeleted;
        $address->deleted_by = $request->deleted_by;
        $address->save();

        $address->delete();

        return response()->json(
            [
                'message' => 'Success Delete Address!',
            ], 200
        );
    }

    public function getProvince()
    {
        $client = new Client();
        $request = $client->get('https://dev.farizdotid.com/api/daerahindonesia/provinsi');
        $response = $request->getBody()->getContents();

        $provinsi = json_decode($response, true);

        if (is_null($provinsi)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'provinsi' => ['Data not found!'],
                ]], 404);
        }

        return response()->json($kabupaten, 200);
    }

    public function getKabupaten($id)
    {
        $client = new Client();
        $request = $client->get('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=' . $id);
        $response = $request->getBody()->getContents();

        $kabupaten = json_decode($response, true);

        if (is_null($kabupaten)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'kabupaten' => ['Data not found!'],
                ]], 404);
        }

        return response()->json($kabupaten, 200);
    }

    public function getKecamatan($id)
    {
        $client = new Client();
        $request = $client->get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=' . $id);
        $response = $request->getBody()->getContents();

        $kecamatan = json_decode($response, true);

        if (is_null($kecamatan)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'kecamatan' => ['Data not found!'],
                ]], 404);
        }

        return response()->json($kecamatan, 200);
    }

    public function getKelurahan($id)
    {
        $client = new Client();
        $request = $client->get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan=' . $id);
        $response = $request->getBody()->getContents();

        $kelurahan = json_decode($response, true);

        if (is_null($kelurahan)) {
            return response()->json([
                'message' => 'The data was invalid.',
                'errors' => [
                    'kelurahan' => ['Data not found!'],
                ]], 404);
        }

        return response()->json($kelurahan, 200);
    }
}
