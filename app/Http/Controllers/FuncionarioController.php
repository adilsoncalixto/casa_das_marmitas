<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Funcionario;
use App\User;

class FuncionarioController extends Controller
{
    //private $funcionario;
    private static $TOTAL_PAGINACAO = 10;

    /*public function __construct(Funcionario $funcionario)  
    {
        $this->funcionario = $funcionario;
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $funcionarios = Funcionario::getPaginacaoByQuery(self::$TOTAL_PAGINACAO);
        return view('funcionario.index')->with('funcionarios', $funcionarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('funcionario.create')->with('funcionario', null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        
        $this->validate($request, $this->getRoles());
            
        // store        
        $user = new User;

        $this->setUser($request, $user);

        DB::beginTransaction();

        $user->save(); 

        $userId = DB::table('users')->max('id');

        $funcionario = new Funcionario;
        $funcionario->id = $userId;

        $this->setFuncionario($request, $funcionario);             

        $funcionario->save();

        $message = "";

        if($user->email !== "roolback@teste.com")
        {
            DB::commit();
            $message = "O funcionario foi cadastrado com sucesso!";
        } else 
        {
            DB::rollBack();
            $message = "Ocorreu um erro ao tentar cadastrar o funcionario!";
        }

        return redirect('funcionario')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get the funcionario
        $funcionario = Funcionario::find($id);
        //$user = $funcionario->user;

        //$funcionario->setNome($user->name);
        //$funcionario->setEmail($user->email);

        return view('funcionario.show')->with('funcionario', $funcionario);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the funcionario
        $funcionario = Funcionario::find($id);
        //$user = $funcionario->user;

        /*$funcionario->nome = $user->name;
        $funcionario->email = $user->email;*/

        return view('funcionario.edit')->with('funcionario', $funcionario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        
        $this->validate($request, $this->getRoles());

        $funcionario = Funcionario::find($id);
        $user = $funcionario->user;

        $this->setUser($request, $user);

        DB::beginTransaction();

        $user->save();

        $this->setFuncionario($request, $funcionario);

        $funcionario->save();

        $message = "";

        if($user->email !== "roolback@teste.com")
        {
            DB::commit();
            $message = "O funcionario foi atualizado com sucesso!";
        } else
        {
            DB::rollBack();
            $message = "Ocorreu um erro ao tentar atualizar o funcionario!";   
        }

        return redirect('funcionario')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete
        $funcionario = Funcionario::find($id);
        $user = $funcionario->user;

        DB::beginTransaction();

        $funcionario->delete();
        $user->delete();

        $message = "";

        if($user->id !== 1)
        {             
            DB::commit();
            $message = "O funcionario foi excluído com sucesso!";
        } else
        {
            DB::rollBack();
            $message = "Ocorreu um erro ao tentar remover o funcionario!";    
        }

        // redirect
        return redirect('funcionario')->with('message', $message);
    }

    public function getPaginacao(Request $request)
    {
        if($request->ajax())
        {
            $query = $request->get('q');

            $funcionarios = Funcionario::getPaginacaoByQuery(self::$TOTAL_PAGINACAO, $query);

            return view('funcionario.paginacao')->with('funcionarios', $funcionarios)->render();
        } 
            
        return response()->json(['message' => 'Método não permitido'], 405);
    }

    private function getRoles()
    {
        return array(
            'nome' => 'required|max:60',
            'email' => 'required|email|max:50',
            'senha' => 'required|max:20',
            'senha_confirmacao' => 'required|max:20',  
            'cargo' => 'required|integer|between:1,2'
        );
    }
    
    private function setUser(Request &$request, User &$user)
    {
        $user->name  = $request->input('nome');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('senha'));  
    }

    private function setFuncionario(Request &$request, Funcionario &$funcionario)
    {   
        $funcionario->cargo = $request->input('cargo');       
    }
}