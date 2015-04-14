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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subject()
    {
        return $this->hasOne('Officium\Subject\Models\Subject', 'user_id');
    }

    //--------------------------------------------------------------------

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
     * Returns a uniquely random subject name.
     *
     * @return string
     */
    public function generateLogin()
    {
        $login = $this->getLoginName();
        do {
            $subject = Subject::where('login', '=', $login)->first();
        } while ($subject);

        return $login;
    }

    /**
     * Returns a randomly generated subject name.
     *
     * @param int $syllables
     * @return string
     */
    private function getLoginName($syllables = 3)
    {
        /**
         * TODO: Improve legacy scheme if time permits.
         */
        // 10 random suffixes
        $suffix = array('dom', 'ity', 'ment', 'sion', 'ness',
            'ence', 'er', 'ist', 'tion', 'or');

        // 8 vowel sounds
        $vowels = array('a', 'o', 'e', 'i', 'y', 'u', 'ou', 'oo');

        // 20 random consonants
        $consonants = array('w', 'r', 't', 'p', 's', 'd', 'f', 'g', 'h', 'j',
            'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'q');

        // get a random suffix
        $login_suffix = $suffix[rand(0, (count($suffix)-1))];

        // for each number of sylllables
        for($i=0; $i<$syllables; $i++) {
            $doubles = array('n', 'm', 't', 's');

            // select a random consonant
            $consonant = $consonants[rand(0, (count($consonants)-1))];

            // If the constonant is in the doubles array double it with 1/3 probability
            if (in_array($consonant, $doubles)&&($i!=0)) { // maybe double it
                if (rand(0, 2) == 1) // 33% probability
                    $consonant .= $consonant;
            }

            // append the consonant to the login
            $login = '';
            $login .= $consonant;

            // selecting random vowel
            $login .= $vowels[rand(0, (count($vowels)-1))];

            if ($i == $syllables - 1){ // if suffix begin with vovel
                if (in_array($login_suffix[0], $vowels)){ // add one more consonant
                    $login .= $consonants[rand(0, (count($consonants)-1))];
                }
            }

        }

        // selecting random suffix
        $login .= $login_suffix;

        return $login;

   }
}