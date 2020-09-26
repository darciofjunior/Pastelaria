<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pastel;
use App\Http\Requests\PastelStoreUpdateFormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PastelController extends Controller
{
    private $pastel;

    public function __construct(Pastel $pastel)
    {
        $this->pastel = $pastel;
    }

    public function index()
    {
        if(!$pastels = $this->pastel->orderBy('nome', 'ASC')->get())
            return response()->json(['mensagem' => 'Not Found Pastel(s) !'], 404);

        return response()->json($pastels);
    }

    public function show($id)
    {
        if(!$pastel = $this->pastel->find($id))
            return response()->json(['mensagem' => 'Not Found Pastel !'], 404);

        return response()->json($pastel);
    }

    public function store(PastelStoreUpdateFormRequest $request)
    {
        $data           = $request->all();
        $data['preco']  = $this->pastel->formatar_moeda($request->preco);

        /******************Imagem******************/
        if($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $nomeFile           = Str::kebab($request->nome);
            $extension          = $request->foto->extension();
            $Foto               = "{$nomeFile}.{$extension}";

            //Atribuindo o nome da Foto no campo ...
            $data['foto']       = $Foto;
            
            //Fazendo o Upload da Foto ...
            $request->file('foto')->storeAs('fotos', $Foto);
        }
        /******************************************/
        $pastel = $this->pastel->create($data);

        return response()->json($pastel, 201);
    }

    public function update(PastelStoreUpdateFormRequest $request, $id)
    {
        if(!$pastel = $this->pastel->find($id))
            return response()->json(['mensagem' => 'Not Found Pastel !'], 404);

        $data           = $request->all();
        $data['preco']  = $this->pastel->formatar_moeda($request->preco);

        /******************Imagem******************/
        if($request->hasFile('foto') && $request->file('foto')->isValid()) {
            //Deleta o pastel da galeria de fotos ...
            Storage::delete("fotos/{$pastel->foto}");

            $nomeFile           = Str::kebab($request->nome);
            $extension          = $request->foto->extension();
            $Foto               = "{$nomeFile}.{$extension}";

            //Atribuindo o nome da Foto no campo ...
            $data['foto']       = $Foto;
            
            //Fazendo o Upload da Foto ...
            $request->file('foto')->storeAs('fotos', $Foto);
        }
        /******************************************/
        $pastel->update($data);

        return response()->json($pastel);
    }

    public function destroy($id)
    {
        if(!$pastel = $this->pastel->find($id))
            return response()->json(['mensagem' => 'Not Found Pastel !'], 404);

        //Deleta o pastel da galeria de fotos ...
        Storage::delete("fotos/{$pastel->foto}");

        //Delete o Registro em si ...
        $pastel->delete();

        return response()->json($pastel, 204);
    }
}
