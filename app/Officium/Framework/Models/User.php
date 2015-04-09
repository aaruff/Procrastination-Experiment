<?php
namespace Officium\Framework\Models;

use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator as Validator;
use Illuminate\Database\Eloquent\Model as Model;

class User extends Model
{
    public $timestamps = false;
    public static $SUBJECT = 1;
    public static $EXPERIMENTER = 2;

    protected $table = 'users';

    /**
     * Returns error messages if the validation failed.
     *
     * @param $credentials
     * @return Validator
     */
    public static function validate($credentials)
    {
        $errorMessages = [];

        // Validate input
        try {
            Validator::arr()
                ->key('login', Validator::notEmpty()->length(3, 100)->alpha())
                ->key('password', Validator::notEmpty()->alnum()->length(3, 40))
                ->assert($credentials);
        }
        // Handle authentication errors
        catch (ValidationException $e) {
            $errorMessages = $e->findMessages([
                'login' => 'Invalid Login',
                'password' => 'Invalid Password'
            ]);
        }

        // Check if account exists
        if (empty($errorMessages)) {
            $experimenter = User::where('login', '=', $credentials['login'])
                ->where('password', '=', sha1($credentials['password']))->first();

            if ( ! $experimenter) {
                $errorMessages['login'] = 'Invalid Login or Password';
            }
        }

        return $errorMessages;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subject()
    {
        return $this->hasOne('Officium\Subject\Models\Subject', 'user_id');
    }
}