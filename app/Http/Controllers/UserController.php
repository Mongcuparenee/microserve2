<?php

    
    namespace App\Http\Controllers;

    use App\Models\User;
    use App\Models\UserJob;

    use Illuminate\Http\Response;
    use App\Traits\ApiResponser;
    use Illuminate\Http\Request;
    use DB;
    Class UserController extends Controller {

        use ApiResponser;

        private $request;

        public function __construct(Request $request){
            $this->request = $request;
        }
        
        public function getUsers(){
            $users = DB::connection('mysql')->select('Select * from tbluser');

            return $this->successResponse($users);
        }

        /**
         * Return the list of users
         * @return Illuminate\Http\Response
         */

        public function index(){
            $users = User::all();
            return $this->successResponse($users);
        }

    

        public function add(Request $request){
            $rules = [
                'username' => 'required|max:20',
                'password' => 'required|max:20',
                'gender' => 'required|in:Male,Female',
                'jobid' => 'required|numeric|min:1|not_in:0',
            ];

            $this->validate($request, $rules);
            $user = User::create($request->all());
            $userjob = UserJob::findOrFail($request->jobid);
            return $this->successResponse($user, Response::HTTP_CREATED);
        }

        /**
        * Obtains and show one user
        * @return Illuminate\Http\Response
        */
        
        public function show($id){
            $user = User::where('userid', $id)->first();
            if ($user){
                return $this->successResponse($user);
            }
            {
            return $this->errorResponse('User ID Does Not Exist', Response::HTTP_NOT_FOUND);
            }
        }

        /**
        * Update an existing author
        * @return Illuminate\Http\Response
        */
        public function update(Request $request, $id){
            $rules = [
                'username' => 'max:20',
                'password' => 'max:20',
                'gender' => 'in:Male,Female',
                'jobid' => 'required|numeric|min:1|not_in:0',
            ];

            $this->validate($request, $rules);

            $user = User::where('userid', $id)->first();
            $userjob = UserJob::findOrFail($request->jobid);
            

            if ($user){
            $user->fill($request->all());
            // if no changes happen
            if ($user->isClean()) {
                return $this->errorResponse('At least one value must change', 
                Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $user->save();
            return $this->successResponse($user);
        }
        {
            return $this->errorResponse('User ID Does Not Exists', Response::HTTP_NOT_FOUND);
        }
    }

}

?>