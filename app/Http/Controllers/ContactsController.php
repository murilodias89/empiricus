<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactsController extends Controller
{
    public function index()
    {
        //Selecioando todos os contato da base de dados!
        $contacts = Contact::all();
        
        return response()->json([
            'contacts' => $contacts,
            'res'=>'Contatos recuperados com sucesso!'
        ], 200);

    }

    public function store(Request $request)
    {
        //Verifica se os campos não estão vazios
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'city' => 'required'
        ]);

        $data = $request->all();
        $img = $request->file('avatar');
        
        if($img) {
            $path = $img->store('avatar', 'public');
        }else {
            $path = '';
        }
        // grava na tabela os dados informados


        $contact = new Contact();
        $contact->name = $data["name"];
        $contact->avatar = $path;
        $contact->email = $data["email"];
        $contact->city = $data["city"];
        $contact->save();

        return response()->json([
            'res'=>'Contato criado com sucesso!'
        ], 201);

    }

    public function show($id)
    {
        //recupera o usuário pelo ID e apresenta os detalhes
        $contact = Contact::find($id);

        return response()->json([
            'contact' => $contact,
            'res'=>'Contatos recuperados com sucesso!'
        ], 200);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'city' => 'required'
        ]);

        // recupera os valores dos campo e atualiza no banco
        $contact = Contact::find($id);
        $contact->update($request->all());

        return response()->json([
            'res'=>'Contato atualizado com sucesso!'
        ], 201);
    }

    public function updateAvatar(Request $request)
    {
        $id = $request->id;
        $img = $request->file('avatar');

        $contact = Contact::find($id);
        
        if($img) {
            $path = $img->store('avatar', 'public');
        }else {
            $path = '';
        }

        $contact->avatar = $path;
        $contact->save();

        return response()->json([
            'res'=>'Avatar atualizado com sucesso!'
        ], 201);
    }

    public function destroy($id)
    {
        //seleciona no banco o usuário pelo ID e deleta!
        Contact::destroy($id);

        return response()->json([
            'res'=>'Conato deletado com sucesso!'
        ], 200);
    }
}
