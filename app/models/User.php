<?php

require_once 'core/Model.php';

class User extends Model
{
    protected $table = 'users';
    
    /**
     * Fillable fields
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];
    
    /**
     * Guarded fields
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
    
    /**
     * Hash password sebelum disimpan
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
    }
    
    /**
     * Verify password
     */
    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }
    
    /**
     * Find user by email
     */
    public static function findByEmail($email)
    {
        $users = static::where('email', $email);
        return !empty($users) ? $users[0] : null;
    }
    
    /**
     * Create user dengan password yang di-hash
     */
    public static function createUser($data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        return static::create($data);
    }
    
    /**
     * Check if email already exists
     */
    public static function emailExists($email)
    {
        $user = static::findByEmail($email);
        return $user !== null;
    }
    
    /**
     * Get user's display name
     */
    public function getDisplayName()
    {
        return $this->name ?: $this->email;
    }
    
    /**
     * Hide password dari output
     */
    public function toArray()
    {
        $array = parent::toArray();
        unset($array['password']);
        return $array;
    }
    
    /**
     * Authenticate user
     */
    public static function authenticate($email, $password)
    {
        $user = static::findByEmail($email);
        
        if ($user && $user->verifyPassword($password)) {
            return $user;
        }
        
        return false;
    }
    
    /**
     * Update password
     */
    public function updatePassword($newPassword)
    {
        $this->password = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->save();
    }
    
    /**
     * Get formatted created date
     */
    public function getCreatedAtFormatted()
    {
        if ($this->created_at) {
            return date('d M Y H:i', strtotime($this->created_at));
        }
        return null;
    }
    
    /**
     * Get formatted updated date
     */
    public function getUpdatedAtFormatted()
    {
        if ($this->updated_at) {
            return date('d M Y H:i', strtotime($this->updated_at));
        }
        return null;
    }
}

?>
