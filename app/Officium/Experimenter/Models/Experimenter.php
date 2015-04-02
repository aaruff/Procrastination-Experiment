<?php
namespace Officium\Experimenter\Models;

use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator as Validator;
use Illuminate\Database\Eloquent\Model as Model;

class Experimenter extends Model
{
    public $timestamps = false;

    protected $table = 'experimenters';

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
            $experimenter = Experimenter::where('login', '=', $credentials['login'])
                ->where('password', '=', sha1($credentials['password']))->first();

            if ( ! $experimenter) {
                $errorMessages['login'] = 'Invalid Login or Password';
            }
        }

        return $errorMessages;
    }
}