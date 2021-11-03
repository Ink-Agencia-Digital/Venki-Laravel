<?php

namespace App;

use App\Http\Resources\AchievementResource;
use App\Notifications\UserRegistration;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes, HasRoles, MustVerifyEmail;

    public const SURVEY = [
        0 => "nuevo",
        1 => "evaluado",
        2 => "reevaluar"
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'lastname',
        'password',
        'birthday',
        'phone',
        'profile_id',
        'premium',
        'surveyed',
        'cognitivo',
        'emocional',
        'conductual',
        'fortaleza_mental',
        'description',
        'institution',
        'status',
        'city',
        'confirmed',
        'confirmation_code',
        'gender',
        'register_social',
        'placeOfBirth',
        'height',
        'weight',
        'dominantFoot',
        'dominantHand',
        'graduationYear',
        'highSchoolAverage',
        'gpa',
        'sat',
        'toef',
        'mainSport',
        'playingPosition',
        'events',
        'time',
        'records',
        'route',
        'rankings',
        'recognitions',
        'press',
        'differences',
        'competencies',
        'goals',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /** Mutators */

    public function setPasswordAttribute($value)
    {
        $this->attributes["password"] = Hash::make($value);
    }

    /** Accesors */


    public function getAprovedAttribute()
    {
        return self::SURVEY[$this->attributes["surveyed"]];
    }


    /** Relationships */

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'users_courses')->withPivot(['progress', 'complete']);
    }
    
    public function lessonscourses()
    {
        return $this->hasMany(user_course_lesson::class,'id_user');
    }
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'receiver_id')->orWhere('chats.transmitter_id', $this->id);
    }

    public function linkedSocialAccounts()
    {
        return $this->hasMany(LinkedSocialAccount::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function recomendations()
    {
        return $this->hasMany(Recomendation::class);
    }

    public function recomendation()
    {
        return $this->hasOne(Recomendation::class);
    }

    public function timelines()
    {
        return $this->hasMany(Timeline::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function feelings()
    {
        return $this->hasMany(Feeling::class);
    }

    public function coins()
    {
        return $this->hasMany(Coin::class);
    }

    public function competences()
    {
        return $this->hasMany(Competence::class);
    }

    /** Overrided Functions */


    public function sendEmailVerificationNotification()
    {
        $this->notify(new UserRegistration);
    }

    public function quizzes()
    {
        return $this->hasMany(quiz::class,'id_user');
    }

    public function respuestas_examenes()
    {
        return $this->hasMany(respuesta_examen::class,'id_user');
    }

    public function resultados_examen()
    {
        return $this->hasMany(resultado_examen::class,'id_user');
    }

    public function roles(){
        return $this->belongsTo(roles::class,'role_id');
    }

    public function Pagos(){
        return $this->hasMany(pago::class,'user_id');
    }
}
