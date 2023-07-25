<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function getAllData()
    {
        $data = MahasiswaModel::all();
        return response()->json([
            'data' => $data
        ]);
    }

    public function createData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nama' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'check your validation',
                'errors' => $validation->errors()
            ]);
        }

        try {
            $data = new MahasiswaModel;
            $data->nama = $request->input('nama');
            $data->save();
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->getMessage()
            ]);
        }

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function getDataById($id)
    {
        $data = MahasiswaModel::where('id', $id)->first();
        return response()->json([
            'message' => 'success get data by id',
            'data' => $data
        ]);
    }

    public function updateData(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'nama' => 'required'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'message' => 'check your validation',
                'errors' => $validation->errors()
            ]);
        }
        try {
            $data = MahasiswaModel::where('id', $id)->first();
            $data->nama = $request->input('nama');
            $data->save();
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->getMessage()
            ]);
        }
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }
}
