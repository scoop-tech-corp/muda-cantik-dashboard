<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Address;

class AddressController extends Controller
{
    public function getAddress()
    {
        return Address::all();
    }

    public function create(request $request)
    {
        $cat = new Address;
        $cat->CategoriesName = $request->catname;
        $cat->Description = $request->desc;
        $cat->Slug = $request->slg;
        $cat->Message = $request->msg;
        $cat->created_by = "agus";
        $cat->update_by = "";
        $cat->deleted_by = "";

        $cat->save();

        return "Success Create";
    }

    public function getProvince()
    {
        $client = new Client();
        $request = $client->get('https://dev.farizdotid.com/api/daerahindonesia/provinsi');
        $response = $request->getBody()->getContents();

        $provinsi = json_decode($response, true);

        return $provinsi;
    }

    public function getKabupaten($id)
    {
        $client = new Client();
        $request = $client->get('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi='.$id);
        $response = $request->getBody()->getContents();

        $kabupaten = json_decode($response, true);

        return $kabupaten;
    }

    public function getKecamatan($id)
    {
        $client = new Client();
        $request = $client->get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota='.$id);
        $response = $request->getBody()->getContents();

        $kecamatan = json_decode($response, true);

        return $kecamatan;
    }

    public function getKelurahan($id)
    {
        $client = new Client();
        $request = $client->get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan='.$id);
        $response = $request->getBody()->getContents();

        $kelurahan = json_decode($response, true);

        return $kelurahan;
    }
}
