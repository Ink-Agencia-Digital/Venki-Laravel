<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\user_course_lesson;
use App\User;
use App\Course;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCourseLessonResource;
use App\Http\Requests\StoreUserCourseLessonRequest;
use App\Http\Requests\UpdateUserCourseLessonRequest;

class UserCourseLessonController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($iduser, $idcourse)
    {
        $lessons = user_course_lesson::join('users','users.id','=','users_courses_lessons.id_user')
                    ->join('courses','courses.id','=','users_courses_lessons.id_course')
                    ->join('lessons','lessons.id','=','users_courses_lessons.id_lesson')
                    ->where('id_user',$iduser)->where('id_course',$idcourse)->get();
        //return $this->collectionResponse(UserCourseLessonResource::collection($this->getModel(new user_course_lesson,[],$usercourse)));
        return response()->json([
            'data'=>$lessons
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserCourseLessonRequest $request)
    {
        $usercourselesson = new user_course_lesson();
        $usercourselesson->fill($request->all());
        $usercourselesson->saveOrFail();
        return $this->api_success([
            'data' => new UserCourseLessonResource($usercourselesson),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserCourseLessonRequest $request, user_course_lesson $usercourselesson)
    {
        if ($request->has("id_user")) {
            $usercourselesson->id_user = $request->id_user;
        }
        if ($request->has("id_course")) {
            $usercourselesson->id_course = $request->id_course;
        }
        if ($request->has("id_lesson")) {
            $usercourselesson->id_lesson = $request->id_lesson;
        }
        if ($request->has("estado")) {
            $usercourselesson->estado = $request->estado;
        }

        if (!$usercourselesson->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $usercourselesson->saveOrFail();

        return $this->api_success([
            'data'      =>  new UserCourseLessonResource($usercourselesson),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        
    }
}
