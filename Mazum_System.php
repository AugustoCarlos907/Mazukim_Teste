<?php 

class Mazukim_System {


    //Método Antigo com problemas de consultas 

    // public function index(Request $request)
    // {
    // $leads = DB::table('leads')->get();

    // return response()->json($leads);
    
    // }



    //Metódo novo com busca  dos leads do usuário , validação , pesquisa e páginação
    public function index(Request $request)
    {

    $request->validate([
        'name' => 'nullable|string|max:100',
    ]);

    $user  = $request->user()->account_id;



    $leads = DB::table('leads')->where('account_id', $user);

    if($request->has('name') && !empty($request->input('name'))) {
        $leads->where('name', 'like', '%' . $request->input('name') . '%');
    }

    $leads->orderBy('id', 'desc')->paginate(20);


    return response()->json($leads);
    
    }

}